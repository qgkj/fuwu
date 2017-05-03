<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class api extends ecjia_api {
    public function __construct() {
        parent::__construct();

//        define('DEBUG_MODE', DM_OUTPUT_ERROR | DM_DISABLED_CACHE | DM_SHOW_DEBUG);
        
        RC_Loader::load_app_func('global');
        
        spl_autoload_register('em_autoload');
    }
    
    
    public function init() {
        
    }
    
    /**
     * 插件远程调用Api控制器处理
     */
    public function plugin() {
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
            $handle->run($this);
        }
    }
}

// end