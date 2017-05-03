<?php
  
/**
 * ECJia 缓存管理类
 * @author royalwang
 *
 */
class ecjia_cache {
    protected static $instance;
    
    /**
     * Create instance
     *
     * @return  void
     */
    public static function make()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    
    
    /**
     * 加载各应用缓存
     * @return array
     */
    public function load_cache() {
        $apps = ecjia_app::installed_app_floders();
        $caches = array();
        $caches[] = $this->load_sys_cache();
        foreach ($apps as $app) {
            $res = $this->load_app_cache($app);
            if ($res) {
                $caches[] = $res;
            }
        }
        return $caches;
    }
    
    /**
     * 加载应用缓存
     * @param string $app_dir
     */
    protected function load_app_cache($app_dir) {
        $res = RC_Api::api($app_dir, 'admin_cache');
        if ($res) {
            $appinfo = RC_App::get_app_package($app_dir);
            $app_name = $appinfo['format_name'] ? $appinfo['format_name'] : $appinfo['_name'];
            return $this->build_group_data($app_dir, $app_name, $res);;
        }
        return false;
    }
    
    protected function load_sys_cache() {
        $res = RC_Api::api('system', 'system_cache');        
        return $this->build_group_data('system', __('系统'), $res);
    }
    
    protected function build_group_data($code, $name, $resources) {
        $group_data = array(
            'group_name'        => $name,
            'group_code'        => $code,
            'group_resources'   => $resources,
        );
        
        return $group_data;
    }
}

// end