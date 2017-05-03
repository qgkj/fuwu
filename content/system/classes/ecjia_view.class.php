<?php
  
/**
 * ecjia 模板视图类
 * @author royalwang
 *
 */
class ecjia_view {
    
    /**
     * 模板视图对象
     *
     * @var view
     * @access private
     */
    protected $smarty;
    
    protected $isAdminView = true;
    
    protected $fileloader;
    
    public function __construct(ecjia_template_fileloader $fileloader) {
        $this->fileloader = $fileloader;
        
        $this->smarty = royalcms('view')->getSmarty();
        
        $filters = array('ecjia_tag');
        
        if (ROUTE_M != 'installer') {
            $filters[] = 'library_item';
        }
        // 模板配置
        $this->smarty->autoload_filters = array('pre' => $filters);
        
        // 默认标签处理
        RC_Loader::load_sys_func('smarty_handler');
        if (function_exists('smarty_plugin_handler')) {
            $this->smarty->registerDefaultPluginHandler('smarty_plugin_handler');
        }
    }
    
    /**
     * 获取视图对象
     * @return view
     */
    public function getSmarty() {
        return $this->smarty;
    }
    
    public function getFileloader() {
        return $this->fileloader;
    }
 
    /**
     * 显示视图
     *
     * @access protected
     * @param string   $tpl_file       模板文件
     * @param null     $cache_id       缓存id
     * @param string   $cache_path     缓存目录
     * @param bool     $stat           是否返回解析结果
     * @param string   $content_type   文件类型
     * @param string   $charset        字符集
     * @param bool     $show           是否显示
     * @return mixed $stat = false, $content_type = 'text/html', $charset = ''
     */
    public function display($resource_name, $cache_id = null, $show = true, $options = array())
    {
        if (strpos($resource_name, 'string:') !== 0) {
            $this->fileloader->get_template_file($resource_name);
        }
        
        $content_type = isset($options['content_type']) ? $options['content_type'] : 'text/html';
        $charset = isset($options['charset']) ? $options['charset'] : '';
        $compile_id = isset($options['compile_id']) ? $options['compile_id'] : null;
        $parent = isset($options['parent']) ? $options['parent'] : null;
        $display = isset($options['display']) ? $options['display'] : false;
        $merge_tpl_vars = isset($options['merge_tpl_vars']) ? $options['merge_tpl_vars'] : true;
        $no_output_filter = isset($options['no_output_filter']) ? $options['no_output_filter'] : false;

        $content = $this->smarty->fetch($resource_name, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
    
        if ($show) {
            $charset = strtoupper(RC_CHARSET) == 'UTF8' ? "UTF-8" : strtoupper(RC_CHARSET);
            if (! headers_sent()) {
                header("Content-type:" . $content_type . ';charset=' . $charset);
            }
            echo $content;
        } else {
            return $content;
        }
    }
    
    
    /**
     * 获得视图显示内容 用于生成静态或生成缓存文件
     *
     * @param string   $tplFile        模板文件
     * @param null     $cache_id       缓存id
     * @param string   $cachePath      缓存目录
     * @param string   $contentType    文件类型
     * @param string   $charset        字符集
     * @param bool     $show           是否显示
     * @return mixed
     */
    public function fetch($tpl_file = null, $cache_id = null, $options = array())
    {
        return $this->display($tpl_file, $cache_id, false, $options);
    }
    
    
    /**
     * 使用字符串作为模板，获取解析后输出内容
     * @param string   $tpl_string
     * @param string   $cache_time
     * @param array    $options
     * @return mixed
     */
    public function fetch_string($tpl_string = null, $cache_id = null, $options = array()) {
        $tpl_file = null;
    
        if ($tpl_string) {
            $tpl_file = 'string:' . $tpl_string;
        }
        return $this->fetch($tpl_file, $cache_id, $options);
    }
    
    
    /**
     * 模板缓存是否过期
     *
     * @param string $cachePath 缓存目录
     * @access protected
     * @return mixed
     */
    public function is_cached($resource_name, $cache_id = null, $options = array())
    {
        if (strpos($resource_name, 'string:') !== 0) {
            $this->fileloader->get_template_file($resource_name);
        }
    
        $compile_id = isset($options['compile_id']) ? $options['compile_id'] : null;
        $parent = isset($options['parent']) ? $options['parent'] : null;
    
        return $this->smarty->isCached($resource_name, $cache_id, $compile_id, $parent);
    }
    
    
    /**
     * 清除单个模板缓存
     */
    public function clear_cache($resource_name, $cache_id = null, $options = array())
    {
        if (strpos($resource_name, 'string:') !== 0) {
            $this->fileloader->get_template_file($resource_name);
        }
    
        $cache_time = isset($options['cache_time']) ? $options['cache_time'] : null;
        $compile_id = isset($options['compile_id']) ? $options['compile_id'] : null;
        $type       = isset($options['type']) ? $options['type'] : null;
    
        return $this->smarty->clearCache($resource_name, $cache_id, $compile_id, $cache_time, $type);
    }
    
    
    /**
     * 清除全部缓存
     */
    public function clear_all_cache($cache_time = null, $options = array())
    {
        $type = isset($options['type']) ? $options['type'] : null;
        return $this->smarty->clearAllCache($cache_time, $type);
    }
    
    
    /**
     * 向模版注册变量
     * @see Component_Control_Control::assign()
     */
    public function assign($name, $value = null)
    {
        return $this->smarty->assign($name, $value);
    }
    
    
    /**
     * 重新向模版注册语言包
     */
    public function assign_lang($lang = array()) {
        if (!empty($lang)) {
            // 载入语言包
            $this->smarty->assign('lang', $lang);
        } else {
            // 载入语言包
            $this->smarty->assign('lang', RC_Lang::lang());
        }
    }
    
    
    /**
     * 清除模版编译文件
     *
     * @access  public
     * @return  void
     */
    public function clear_compiled_files() {
        if (royalcms('files')->isDirectory(TEMPLATE_COMPILE_PATH)) {
            // 清除整个编译目录的文件
            $this->smarty->clearCompiledTemplate();
        }
    }
    
    
    /**
     * 清除缓存文件
     *
     * @access  public
     * @return  void
     */
    public function clear_cache_files() {
        if (royalcms('files')->isDirectory(TEMPLATE_CACHE_PATH)) {
            // 清除全部缓存
            $this->smarty->clearAllCache();
        }
    }
    
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->smarty, $method), $parameters);
    }
    
    public function __set($name, $value) 
    {
        return $this->smarty->$name = $value;
    }
    
    public function __get($name) 
    {
        return $this->smarty->$name;
    }
    
    public function __isset($name)
    {
        return isset($this->smarty->$name);
    }
    
    public function __unset($name)
    {
        unset($this->smarty->$name);
    }
    
    
}

// end