<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class plugin extends ecjia_front {
	public function __construct() {
		parent::__construct();
	}

	/**
	 * 首页信息
	 */
	public function init() {

	}
	
	/**
	 * 插件页面输出调用
	 */
	public function show() {
	    $action = rc_addslashes(trim($_GET['handle']));
	
	    if (file_exists(SITE_PLUGIN_PATH . $action . '.php')) {
	        $file = SITE_PLUGIN_PATH . $action . '.php';
	    } elseif (file_exists(RC_PLUGIN_PATH . $action . '.php')) {
	        $file = RC_PLUGIN_PATH . $action . '.php';
	    } else {
	        _404();
	    }
	
	    require_once $file;
	
	    $action_class = str_replace('/', '_', $action);
	
	    $handle = new $action_class();
	
	    if ($handle && is_a($handle, $action_class)) {
	        $handle->action();
	    }
	}
}

// end