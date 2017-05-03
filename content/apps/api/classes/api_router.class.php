<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class api_router {
    
    protected $key;
    
    protected $appModule;
    
    protected $classPath;
    
    protected $className;
    
    static protected $apiRoutes = array();
    
    public function __construct($name) {
        
        self::$apiRoutes = RC_Config::get('api');
        
        $this->key = $name;
    }
    
    public function hasKey() {
        if (isset(self::$apiRoutes[$this->key])) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getKey() {
        return $this->key;
    }
   
    public function parseKey() {
        $api_class = explode('::', self::$apiRoutes[$this->key]);
        $this->appModule = $api_class[0];

        $path = dirname($api_class[1]);
        $name = basename($api_class[1]);
        if ($path == '.') {
            $controller = null;
        } else {
            $controller = $path;
        }
        
        $this->classPath = $controller;
        
        $this->className = $name . '_module';
        
        return $this;
    }
    
    public function getApp() {
        return $this->appModule;
    }
    
    public function getClassName() {
        return $this->className;
    }
    
    public function getClassPath() {
        return $this->classPath;
    }
}

//end