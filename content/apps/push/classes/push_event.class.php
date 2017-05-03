<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class push_event {
    
    protected $event_code;
    protected $event_db;
    
    protected $user_ids = array();
    protected $admin_ids = array();
    
    protected $devices = array();
    
    public function __construct($event_code) {
        $this->event_code = $event_code;
    }
    
    /**
     * 获取激活过的客户端应用
     */
    public function getActivationApps() {
        $event_db = RC_Model::model('push/push_event_viewmodel');
        
        $rows = $event_db->where(array('event_code' => $this->event_code, 'is_open' => '1'))->select();
        
        foreach ($rows as $row) {
            $datas[] = array(
                'app_name'      => $row['app_name'],
                'bundle_id'     => $row['bundle_id'],
                'app_key'       => $row['app_key'],
                'app_secret'    => $row['app_secret'],
                'device_code'   => $row['device_code'],
                'device_client' => $row['device_client'],
                'platform'      => $row['platform'],
            );
        }
        return $datas;  
    }
    
    public function add_user($user_id) {
        if (is_array($user_id)) {
            $this->user_ids = $user_id;
        } else {
            $this->user_ids[] = $user_id;
        }
        
        $device_db = RC_Model::model('mobile/mobile_device_model');
        foreach ($this->user_ids as $uid) {
            $devices[] = $device_db->where(array('user_id' => $uid, 'user_type' => 'user'))->select();
        }
        
        if (!empty($devices)) {
            foreach ($devices as $device) {
                $this->devices[] = array(
                    'device_code'   => $device['device_code'],
                    'device_token'  => $device['device_token'],
                );
            }
        }
    }
    
    public function add_admin($admin_id) {
        if (is_array($admin_id)) {
            $this->admin_ids = $admin_id;
        } else {
            $this->admin_ids[] = $admin_id;
        }
        
        $device_db = RC_Model::model('mobile/mobile_device_model');
        foreach ($this->user_ids as $uid) {
            $devices[] = $device_db->where(array('user_id' => $uid, 'is_admin' => 'admin'))->select();
        }
        
        if (!empty($devices)) {
            foreach ($devices as $device) {
                $this->devices[] = array(
                    'device_code'   => $device['device_code'],
                    'device_token'  => $device['device_token'],
                );
            }
        }
    }
    public function send() {
        
    }
}

// end