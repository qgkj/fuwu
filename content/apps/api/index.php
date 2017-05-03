<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class index {
    public function __construct() {

        ini_set('memory_limit', -1);

        RC_Loader::load_app_func('functions');
        RC_Loader::load_app_func('global');
        RC_Loader::load_sys_func('global');
        spl_autoload_register('em_autoload');
        
        EM_Api::init();
    }

    public function init() {        
        $request = royalcms('request');

        $url = $request->query('url');

        if (empty($url)) {
            exit("NO ACCESS");
        }
        
        $router = new api_router($url);
        if (! $router->hasKey()) {
            echo 'Api Error: ' . $url . ' does not exist.';
            exit(0);
        }
        
        $router->parseKey();

        if ($router->getApp() == 'system') {
            $handle = RC_Loader::load_module($router->getClassPath().'.'.$router->getClassName());
        } else {
            $handle = RC_Loader::load_app_module($router->getClassPath().'.'.$router->getClassName(), $router->getApp());
        }
        
        if ($handle && is_a($handle, $router->getClassName())) {
            $data = $handle->handleRequest($request);
            with(new api_response($data))->send();
        } else {
            echo 'Api Error: ' . $url . ' does not exist.';
            exit(0);
        }
    }
}

// end