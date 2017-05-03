<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_manage {
    protected static $app_pools = array();
    
    protected $app_id;
    protected $row;

    public static function make($appid) {
        if (isset(self::$app_pools[$appid]) && self::$app_pools[$appid]) {
            return self::$app_pools[$appid];
        } else {
            return new static($appid);
        }
    }
    
    public function __construct($appid) {
        $this->app_id = $appid;
        $this->row = $this->getMobileApp();
        self::$app_pools[$appid] = $this;
    }
    
    protected function getMobileApp() {
        //查询数据库
        $db_mobile_manage = RC_Model::model('mobile/mobile_manage_model');
        $row = $db_mobile_manage->where(array('app_id' => $this->app_id))->find();
        if (empty($row)) {
            return new ecjia_error('mobile_manage_not_found_appid', RC_Lang::get('mobile::mobile.unknown_appid'));
        }
        return $row;
    }
    
    public function getAppKey() {
        if (is_ecjia_error($this->row)) {
            return $this->row;
        }
        return $this->row['app_key'];
    }
    
    public function getAppSecret() {
        if (is_ecjia_error($this->row)) {
            return $this->row;
        }
        return $this->row['app_secret'];
    }
    
    public function getClient() {
        if (is_ecjia_error($this->row)) {
            return $this->row;
        }
        return $this->row['device_client'];
    }
    
    public function getCode() {
    	if (is_ecjia_error($this->row)) {
    		return $this->row;
    	}
    	return $this->row['device_code'];
    }
    
    /**
     * 获取当前帐号的状态
     * @return unknown|boolean
     */
    public function getStatus() {
        if (is_ecjia_error($this->row)) {
            return $this->row;
        }
    
        if ($this->row['status']) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 获取指定平台的公众号列表
     * @param string $platform
     */
    public static function getMobileAppList($platform) {
        $db_mobile_manage   = RC_Model::model('mobile/mobile_manage_model');
        $applist            = $db_mobile_manage->where(array('platform' => $platform, 'status' => 1))->order('app_id ASC')->select();
        return $applist;
    }
    
}

// end
