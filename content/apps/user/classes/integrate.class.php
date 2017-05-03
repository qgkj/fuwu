<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 插件使用方法
 * @author royalwang
 */
class integrate  {
    
    /**
     *  返回字符集列表数组
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public static function charset_list()
    {
        $charset_list = array(
            'UTF8'   => 'UTF-8',
            'GB2312' => 'GB2312/GBK',
            'BIG5'   => 'BIG5',
        );
        return RC_Hook::apply_filters('user_integrate_charset_list', $charset_list);
    }
    
    
    private static $instance = null;
    
    /**
     * 初始化会员数据整合类
     *
     * @access public
     * @return object
     */
    public static function init_users() {
        if (self::$instance != null) {
            return self::$instance;
        }
         
        $cfg = unserialize(ecjia::config('integrate_config'));
    
        if (ecjia::config ('integrate_code') == 'ecjia' || ecjia::config ('integrate_code') == 'ecshop') {
            RC_Loader::load_app_class('integrate_ecjia', 'user', false);
            self::$instance = new integrate_ecjia($cfg);
        } else {
            RC_Loader::load_app_class('integrate_factory', 'user', false);
            self::$instance = new integrate_factory(ecjia::config ('integrate_code'), $cfg);
        }
    
        return self::$instance;
    }
	
	public function __construct() {
		
	}

	/**
	 * 获取所有可用的验证码
	 */
	public function integrate_list() {
		$plugins = RC_Plugin::get_plugins();
		$captcha_plugins = ecjia_config::instance()->get_addon_config('user_integrate_plugins', true);
		
		$list = array();
		foreach ($captcha_plugins as $code => $plugin) {
		    if (isset($plugins[$plugin])) {
		        $list[$code] = $plugins[$plugin];
		        
		        $list[$code]['code'] = $code;
		        $list[$code]['format_name'] = $list[$code]['Name'];
		        $list[$code]['format_description'] = $list[$code]['Description'];
		    }
		}

		return $list;
	 }
	 
	 /**
	  *
	  *
	  * @access  public
	  * @param
	  *
	  * @return void
	  */
	 function save_integrate_config($code, $cfg) {
	     ecjia_config::instance()->write_config('integrate_code', $code);
	 
	     /* 当前的域名 */
	     if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
	         $cur_domain = $_SERVER['HTTP_X_FORWARDED_HOST'];
	     } elseif (isset($_SERVER['HTTP_HOST'])) {
	         $cur_domain = $_SERVER['HTTP_HOST'];
	     } else {
	         if (isset($_SERVER['SERVER_NAME'])) {
	             $cur_domain = $_SERVER['SERVER_NAME'];
	         } elseif (isset($_SERVER['SERVER_ADDR'])) {
	             $cur_domain = $_SERVER['SERVER_ADDR'];
	         }
	     }
	 
	     /* 整合对象的域名 */
	     $int_domain = str_replace(array('http://', 'https://'), array('', ''), $cfg['integrate_url']);
	     if (strrpos($int_domain, '/')) {
	         $int_domain = substr($int_domain, 0, strrpos($int_domain, '/'));
	     }
	 
	     if ($cur_domain != $int_domain) {
	         $same_domain    = true;
	         $domain         = '';
	 
	         /* 域名不一样，检查是否在同一域下 */
	         $cur_domain_arr = explode(".", $cur_domain);
	         $int_domain_arr = explode(".", $int_domain);
	 
	         if (count($cur_domain_arr) != count($int_domain_arr) || $cur_domain_arr[0] == '' || $int_domain_arr[0] == '') {
	             /* 域名结构不相同 */
	             $same_domain = false;
	         } else {
	             /* 域名结构一致，检查除第一节以外的其他部分是否相同 */
	             $count = count($cur_domain_arr);
	 
	             for ($i = 1; $i < $count; $i++) {
	                 if ($cur_domain_arr[$i] != $int_domain_arr[$i]) {
	                     $domain         = '';
	                     $same_domain    = false;
	                     break;
	                 } else {
	                     $domain .= ".$cur_domain_arr[$i]";
	                 }
	             }
	         }
	 
	         if ($same_domain == false) {
	             /* 不在同一域，设置提示信息 */
	             $cfg['cookie_domain']   = '';
	             $cfg['cookie_path']     = '/';
	         } else {
	             $cfg['cookie_domain']   = $domain;
	             $cfg['cookie_path']     = '/';
	         }
	     } else {
	         $cfg['cookie_domain']   = '';
	         $cfg['cookie_path']     = '/';
	     }
	     
	     ecjia_config::instance()->write_config('integrate_config', serialize($cfg));
	     
	     return true;
	 }
	 
	 /**
	  * 用户注册
	  *
	  * @access public
	  * @param string $username
	  *            注册用户名
	  * @param string $password
	  *            用户密码
	  * @param string $email
	  *            注册email
	  * @param array $other
	  *            注册的其他信息
	  *
	  * @return bool $bool
	  */
    public function register($username, $password, $email, $other = array()) {
        $db_user = RC_Model::model('user/users_model');
        
        /* 检查注册是否关闭 */
        if (ecjia::config('shop_reg_closed', ecjia::CONFIG_EXISTS)) {
            return new ecjia_error('99999', '该网店暂停注册');
        }
        /* 检查username */
        if (empty($username)) {
            return new ecjia_error('200', '用户名不能为空');
        } else {
            if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username)) {
                return new ecjia_error('201', '用户名含有敏感字符');
            }
        }
        
        /* 检查email */
        if (empty($email)) {
            return new ecjia_error('203', 'email不能为空');
        } else {
            if (!is_email($email)) {
                return new ecjia_error('204', '不是合法的email地址');
            }
        }
        
        if ($this->check_admin_registered($username)) {
            return new ecjia_error('202', '用户名已经存在');
        }
        
        RC_Loader::load_app_class('integrate', 'user', false);
        $user = &integrate::init_users();
        if (!$user->add_user($username, $password, $email)) {
            if ($user->error == ERR_INVALID_USERNAME) {
                return new ecjia_error('username_invalid', sprintf("用户名 %s 含有敏感字符", $username));
            } elseif ($user->error == ERR_USERNAME_NOT_ALLOW) {
                return new ecjia_error('username_not_allow', sprintf("用户名 %s 不允许注册", $username));
            } elseif ($user->error == ERR_USERNAME_EXISTS) {
                return new ecjia_error('username_exist', sprintf("用户名 %s 已经存在", $username));
            } elseif ($user->error == ERR_INVALID_EMAIL) {
                return new ecjia_error('email_invalid', sprintf("%s 不是合法的email地址", $email));
            } elseif ($user->error == ERR_EMAIL_NOT_ALLOW) {
                return new ecjia_error('email_not_allow', sprintf("Email %s 不允许注册", $email));
            } elseif ($user->error == ERR_EMAIL_EXISTS) {
                return new ecjia_error('email_exist', sprintf("%s 已经存在", $email));
            } else {
                return new ecjia_error('unknown_error', '未知错误！');
            }
        } else {
            // 注册成功
            /* 设置成登录状态 */
            $user->set_session($username);
            $user->set_cookie($username);
            /* 注册送积分 */
            if (ecjia::config('register_points', ecjia::CONFIG_EXISTS)) {
                $options = array(
                     'user_id'		=> $_SESSION['user_id'],
                     'rank_points'	=> ecjia::config('register_points'),
                     'pay_points'	=> ecjia::config('register_points'),
                     'change_desc'	=> RC_Lang::get('user::user.register_points')
                );
                $result = RC_Api::api('user', 'account_change_log', $options);
            }
            
            RC_Loader::load_app_func('admin_user', 'user');
            update_user_info(); // 更新用户信息
            RC_Loader::load_app_func('cart', 'cart');
            recalculate_price(); // 重新计算购物车中的商品价格
            
            return true;
        }
    }
	 
	 /**
	  * 登录函数
	  *
	  * @access public
	  * @param string $username
	  *            注册用户名
	  * @param string $password
	  *            用户密码
	  *
	  * @return bool $bool
	  */
    public function login($username, $password) {
        /* 检查username */
        if (empty($username)) {
            return new ecjia_error('200', '用户名不能为空');
        } else {
            if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username)) {
                return new ecjia_error('201', '用户名含有敏感字符');
            }
        }
	 
        RC_Loader::load_app_class('integrate', 'user', false);
        $user = &integrate::init_users();
	 
        if (!$user->login($username, $password)) {
            return new ecjia_error('login_failure', '登录失败');
        }
	 
        RC_Loader::load_app_func('admin_user', 'user');
        update_user_info(); // 更新用户信息
        RC_Loader::load_app_func('cart', 'cart');
        recalculate_price(); // 重新计算购物车中的商品价格
        
        return true;
    }
    
    /**
     * 判断超级管理员用户名是否存在
     *
     * @param string $adminname
     *            超级管理员用户名
     * @return boolean
     */
    public function check_admin_registered($adminname) {
        return RC_DB::table('admin_user')->where('user_name', $adminname)->count();
    }
}

// end