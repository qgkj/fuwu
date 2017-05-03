<?php
  
/**
 * ECJia 权限管理类
 * @author royalwang
 *
 */
class ecjia_purview extends RC_Object {
    /**
     * 所有权限的数组
     * 
     * @var array
     */
    protected $purviews = array();
    
    /**
     * 获取安装的应用目录
     * 
     * @return array
     */
    protected function installedAppFloders() {
        $apps = ecjia_app::installed_app_floders();
        return $apps;
    }
    
    /**
     * 载入系统权限
     * 
     * @param string $priv_str
     */
    protected function loadSystemPurivew($priv_str)
    {
        $this->purviews[] = $this->requestSystemPurivewApi($priv_str);
    }
    
    /**
     * 请求系统权限API，获取配置数据
     * 
     * @param string $priv_str
     * @return array
     */
    private function requestSystemPurivewApi($priv_str = '') {
        $res = RC_Api::api('system', 'system_purview');
        if (!empty($priv_str)) {
            foreach ($res as $priv_key => $purview) {
                $res[$priv_key]['cando'] = ($this->checkPurivew($priv_str, $purview['action_code']) || $priv_str == 'all') ? 1 : 0;
            }
        }
    
        $app_priv_group = array(
            'group_name' => __('系统'),
            'group_code' => 'system',
            'group_purview' => $res
        );
    
        return $app_priv_group;
    }

    /**
     * 加载各应用权限
     * @return array
     */
    public function loadPurview($priv_str = '') {
        $this->loadSystemPurivew($priv_str);
        
        $apps = $this->installedAppFloders();
        foreach ($apps as $app) {
            $res = $this->loadAppPurview($app);
            if ($res) {
                if (!empty($priv_str)) {
                    foreach ($res['group_purview'] as $priv_key => $purview) {
                        $res['group_purview'][$priv_key]['cando'] = ($this->checkPurivew($priv_str, $purview['action_code']) || $priv_str == 'all') ? 1 : 0;
                    }
                }
                $this->purviews[] = $res;
            }
        }
        return $this->purviews;
    }
    
    /**
     * 加载应用权限具体操作
     * @param string $app_dir
     */
    protected function loadAppPurview($app_dir) {
        $res = $this->requestPurviewApi($app_dir);

        if ($res) {
            $appinfo = RC_App::get_app_package($app_dir);
            $app_name = $appinfo['format_name'] ? $appinfo['format_name'] : $appinfo['_name'];
            $app_priv_group = array(
                'group_name' => $app_name,
                'group_code' => $app_dir,
                'group_purview' => $res
            );
            return $app_priv_group;
        }
        return false;
    }
    
    /**
     * 请求权限API，获取配置数据
     * @param string $app_dir
     */
    protected function requestPurviewApi($app_dir)
    {
        $res = RC_Api::api($app_dir, 'admin_purview');
        return $res;
    }
    
    /**
     * 检测动作是否在权限字符串内
     * @param string $priv_str
     * @param string $action_code
     */
    public function checkPurivew($priv_str, $action_code) {
        $priv_arr = explode(',', $priv_str);
        if (in_array($action_code, $priv_arr)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 获取应用权限数组
     * @return array:
     */
    public function getPurviews() {
        return $this->purviews;
    }
    
    /**
     * 加载各应用权限
     *
     * @return array
     */
    public static function load_purview($priv_str = '') {
        return static::singleton()->loadPurview($priv_str);
    }
    
    /**
     * 检测动作是否在权限字符串内
     * @param string $priv_str
     * @param string $action_code
     */
    public static function check_purivew($priv_str, $action_code) {
        return static::singleton()->checkPurivew($priv_str, $action_code);
    }
}


// end