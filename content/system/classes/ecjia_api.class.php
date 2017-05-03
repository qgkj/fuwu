<?php
  
/**
 * ecjia api控制器父类
 */
defined('IN_ECJIA') or exit('No permission resources.');

abstract class ecjia_api extends ecjia_base implements ecjia_template_fileloader {
    
	public function __construct() {
		parent::__construct();
		
		self::$controller = static::$controller;
		self::$view_object = static::$view_object;
		
		if (defined('DEBUG_MODE') == false) {
		    define('DEBUG_MODE', 0);
		}
		
		//游客状态也需要设置一下session值
		if (empty($_SESSION['user_id'])) {
		    $_SESSION['user_id']     = 0;
		    $_SESSION['user_name']   = '';
		    $_SESSION['email']       = '';
		    $_SESSION['user_rank']   = 0;
		    $_SESSION['discount']    = 1.00;
		    if (!isset($_SESSION['login_fail'])) {
		        $_SESSION['login_fail'] = 0;
		    }
		}
		
		if (isset($_SERVER['PHP_SELF'])) {
		    $_SERVER['PHP_SELF'] = htmlspecialchars($_SERVER['PHP_SELF']);
		}
		
		if (RC_Config::get('system.debug')) {
		    error_reporting(E_ALL);
		} else {
		    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		}
		
		RC_Hook::do_action('ecjia_api_finish_launching');
	}
	
	protected function session_start()
	{
	    RC_Hook::add_filter('royalcms_session_name', function ($sessin_name) {
	        return RC_Config::get('session.session_name');
	    });
	         
        RC_Hook::add_filter('royalcms_session_id', function ($sessin_id) {
            return RC_Hook::apply_filters('ecjia_api_session_id', $sessin_id);
        });
	
        RC_Session::start();
	}
	
	public function create_view()
	{
	    return new ecjia_view($this);
	}
	
	protected function load_hooks() 
	{
	    $apps = ecjia_app::installed_app_floders();
	    if (is_array($apps)) {
	        foreach ($apps as $app) {
	            RC_Loader::load_app_class('hooks.api_' . $app, $app, false);
	        }
	    }
	}
	
	/**
	 * 获得模板目录
	 * @return string
	 */
	public function get_template_dir(){
	    
	}
	
	/**
	 * 获得模版文件
	*/
	public function get_template_file($file){
	    
	}
	
	
}

// end