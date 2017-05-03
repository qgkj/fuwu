<?php
  

use \Royalcms\Component\Support\Facades\Response as RC_Response;

defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 控制器基础类
 */
abstract class ecjia_base extends Royalcms\Component\Routing\Controller {
    /**
     * 模板视图对象
     *
     * @var view
     */
    protected $view;
    
    /**
     * HTTP请求对象
     * @var \Royalcms\Component\HttpKernel\Request
     */
    protected $request;

    public static $view_object;
    public static $controller;


    /**
     * 构造函数
     *
     * @access  public
     * @param   string      $ver        版本号
     *
     * @return  void
     */
    public function __construct() {
        $this->request = royalcms('request');
        
        $this->session_start();
        
        $this->view = $this->create_view();
        
        static::$controller = & $this;
        static::$view_object = & $this->view;

        $this->load_hooks();
    }
    
    
    public function __call($method, $parameters) 
    {
        if (in_array($method, array('display', 'fetch', 'fetch_string', 'is_cached', 'clear_cache', 'clear_all_cache', 'assign', 'assign_lang', 'clear_compiled_files', 'clear_cache_files'))) {
            return call_user_func_array(array($this->view, $method), $parameters);
        }
        
        return parent::__call($method, $parameters);
    }

    /**
     * Ajax输出
     *
     * @param $data 数据
     * @param string $type 数据类型 text html xml json
     */
    protected function ajax($data, $type = ecjia::DATATYPE_JSON)
    {
        $type = strtoupper($type);
        switch ($type) {
        	case ecjia::DATATYPE_HTML:
        	case ecjia::DATATYPE_TEXT:
        	    return royalcms('response')->setContent($data)->send();
        	    break;

        	// XML处理
        	case ecjia::DATATYPE_XML:
        	    return $this->xml($data);
        	    break;

        	// JSON处理
        	case ecjia::DATATYPE_JSON:
        	default:
        	    return $this->json($data);
        }
    }
    
    /**
     * 以XML格式输出内容
     * 
     * @param string|array $data
     */
    protected function xml($data)
    {
        $cookies = royalcms('response')->headers->getCookies();
        $response = RC_Response::xml($data);
        foreach ($cookies as $cookie)
        {
            $response->withCookie($cookie);
        }
        return $response->send();
    }
    
    /**
     * 以JSON格式输出内容
     *
     * @param string|array $data
     */
    protected function json($data)
    {
        $cookies = royalcms('response')->headers->getCookies();
        $response = RC_Response::json($data);
        foreach ($cookies as $cookie)
        {
            $response->withCookie($cookie);
        }
        return $response->send();
    }

    /**
     * 自定义header内容
     *
     * @param string $string 内容
     * @return void
     *
     */
    protected function header($key, $value, $replace = true)
    {
        return RC_Response::header($key, $value, $replace);
    }

    /**
     * 弹出信息
     *
     * @param string $msg
     * @param string $url
     * @param string $parent
     */
    protected function alert($msg, $url = null, $parent = false)
    {
        header("Content-type: text/html; charset=utf-8");
        $alert_msg = "alert('$msg');";
        if (empty($url)) {
            $gourl = 'history.go(-1);';
        } else {
            $gourl = ($parent ? 'parent' : 'window') . ".location.href = '{$url}'";
        }
        
        $script = "<script>" . PHP_EOL;
        $script .= $alert_msg . PHP_EOL;
        $script .= $gourl . PHP_EOL;
        $script .= "</script>" . PHP_EOL;

        $cookies = royalcms('response')->headers->getCookies();
        $response = RC_Response::make($script);
        foreach ($cookies as $cookie)
        {
            $response->withCookie($cookie);
        }
        return $response->send();
    }

    /**
    * 信息提示
    *
    * @param string $msg 提示内容
    * @param string $url 跳转URL
    * @param int $time 跳转时间
    * @param null $tpl 模板文件
    */
    protected function message($msg = '操作成功', $url = null, $time = 2, $tpl = null)
    {
        $url = $url ? "window.location.href='" . $url . "'" : "window.history.back(-1);";
	    $content = ecjia_utility::message_template($msg, $url);
	    
	    $cookies = royalcms('response')->headers->getCookies();
	    $response = RC_Response::make($content);
	    foreach ($cookies as $cookie)
	    {
	        $response->withCookie($cookie);
	    }
	    return $response->send();
    }
    
    /**
     * 载入项目常量
     */
    public function load_constants() {}


    /**
     * 系统提示信息
     * @access      public
     * @param       string      $message      	消息内容
     * @param       int         $type        	消息类型， (0:html, 1:alert, 2:json, 3:xml)(0:错误，1:成功，2:消息, 3:询问)
     * @param		array		$options		消息可选参数
     * @return      void
     */
    public function showmessage($message, $type = ecjia::MSGTYPE_HTML, $options = array()) {
        $state = $type & 0x0F;
        $type = $type & 0xF0;
         
        if ($type === ecjia::MSGTYPE_JSON && !is_ajax()) {
            $type = ecjia::MSGTYPE_ALERT;
        }
         
        // HTML消息提醒
        if ($type === ecjia::MSGTYPE_HTML) {
            switch ($state) {
                case 1:
                    $this->assign('page_state', array('icon' => 'fontello-icon-ok-circled', 'msg' => __('操作成功'), 'class' => 'alert-success'));
                    break;
                case 2:
                    $this->assign('page_state', array('icon' => 'fontello-icon-info-circled', 'msg' => __('操作提示'), 'class' => 'alert-info'));
		              break;
		          case 3:
			         $this->assign('page_state', array('icon' => 'fontello-icon-attention-circled', 'msg' => __('操作警告'), 'class' => ''));
			         break;
			     default:
			         $this->assign('page_state', array('icon' => 'fontello-icon-cancel-circled', 'msg' => __('操作错误'), 'class' => 'alert-danger'));
            }

        	$this->assign('ur_here',     RC_Lang::get('system::system.system_message'));
        	$this->assign('msg_detail',  $message);
        	$this->assign('msg_type',    $state);

            if (!empty($options)) {
	           foreach ($options AS $key => $val) {
	               $this->assign($key,     $val);
		       }
            }

            $this->message($message, null, 3);
            exit(0);
        }
    		     
		// ALERT消息提醒
		elseif ($type === ecjia::MSGTYPE_ALERT) {
            //alert支持PJAXurl的跳转
            $url = '';
            if (!empty($options) && !empty($options['pjaxurl'])) {
                $url = $options['pjaxurl'];
            }
            $this->alert($message, $url);
            exit(0);
        }
 
        // JSON消息提醒
        elseif ($type === ecjia::MSGTYPE_JSON) {
            $res = array('message' => $message);
            if ($state === 0) {
                $res['state'] = 'error';
            } elseif ($state === 1) {
                $res['state'] = 'success';
            }
        
            if (!empty($options)) {
                foreach ($options AS $key => $val) {
                    $res[$key] = $val;
                }
            }

            $this->ajax($res);
            exit(0);
        }
 
        // XML消息提醒
        elseif ($type === ecjia::MSGTYPE_XML) {
            $this->ajax($message, 'xml');
            exit(0);
        }
             
    	exit(0);
    }
    
    /**
     * 直接跳转
     *
     * @param string $url
     * @param int $code
     */
    public function redirect($url, $code = 302)
    {
        $cookies = royalcms('response')->headers->getCookies();
        $response = RC_Redirect::away($url, $code);
        foreach ($cookies as $cookie)
        {
            $response->withCookie($cookie);
        }
    
        $response->send();
        exit(0);
    }

    /**
     * 创建视图对象
     */
    abstract public function create_view();
    
    /**
     * hooks载入抽象方法
     */
    abstract protected function load_hooks();
    
    /**
     * Session start
     */
    abstract protected function session_start();

}

// end