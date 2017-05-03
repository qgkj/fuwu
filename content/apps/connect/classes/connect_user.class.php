<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class connect_user {
    protected $db_connect_user;
    
    protected $connect_code;
    protected $open_id;
    protected $user_id;
    protected $is_admin;
    protected $access_token;
    protected $profile;
    protected $create_at;
    protected $expires_in;
    protected $expires_at;
    
    public function __construct($connect_code, $open_id) {
        $this->db_connect_user = RC_Loader::load_app_model('connect_user_model', 'connect');
        
        $this->connect_code = $connect_code;
        $this->open_id = $open_id;
        
        $this->get_openid();
    }
    
    public function __get($name) {
        if (in_array($name, array('connect_code', 'open_id', 'user_id', 'is_admin', 'access_token', 'profile', 'create_at', 'expires_in', 'expires_at'))) {
            return $this->$name;
        }
        return null;
    }
    
    /**
     * 检查用户是否存在
     */
    public function check_openid_exist() {
        $row = $this->db_connect_user->where(array('open_id' => $this->open_id, 'connect_code' => $this->connect_code))->find();
        if (!empty($row)) {
            return true;
        }
        return false;
    }
    
    public function save_openid($access_token, $user_profile, $expires_time) {
        $curr_time = RC_Time::gmtime();
        if ($this->check_openid_exist()) {
            $data = array(
                'access_token'	=> $access_token,
                'profile'       => $user_profile,
                'create_at'     => $curr_time,
                'expires_in'    => $expires_time,
                'expires_at'    => $curr_time + $expires_time,
            );
            return $this->db_connect_user->where(array('open_id' => $this->open_id, 'connect_code' => $this->connect_code))->update($data);
        } else {
            $data = array(
                'connect_code'	=> $this->connect_code,
                'open_id'		=> $this->open_id,
                'access_token'	=> $access_token,
                'profile'       => $user_profile,
                'create_at'     => $curr_time,
                'expires_in'    => $expires_time,
                'expires_at'    => $curr_time + $expires_time,
            );
            $user_id = RC_Hook::apply_filters('connect_openid_exist_userid', 0, $this->connect_code, $this->open_id);
            if (!empty($user_id)) {
                $data['user_id']  = $user_id;
                $data['is_admin'] = 0;
            }
            $this->db_connect_user->insert($data);
        }
    }
    
    public function get_openid() {
        $row = $this->db_connect_user->where(array('open_id' => $this->open_id, 'connect_code' => $this->connect_code))->find();
        if (!empty($row)) {
            $row['profile'] = unserialize($row['profile']);
            
            $this->user_id      = $row['user_id'];
            $this->is_admin     = $row['is_admin'];
            $this->access_token = $row['access_token'];
            $this->profile      = $row['profile'];
            $this->create_at    = $row['create_at'];
            $this->expires_in   = $row['expires_in'];
            $this->expires_at   = $row['expires_at'];
            
            return $row;
        }
        return false;
    }
    
    public function bind_user($user_id, $is_admin) {
        if ($this->check_openid_exist() && $user_id) {
            $data = array(
                'user_id' => $user_id,
                'is_admin' => $is_admin,
            );
            return $this->db_connect_user->where(array('open_id' => $this->open_id, 'connect_code' => $this->connect_code))->update($data);
        } else {
            return false;
        }
    }
    
    public function get_username() {
        $connect_account = RC_Loader::load_app_class('connect_method', 'connect');
        $connect_handle  = $connect_account->get_connect_instance($this->connect_code);
        $username        = $connect_handle->get_username($this->profile);
        
        RC_Loader::load_app_class('integrate', 'user', false);
        $user = integrate::init_users();
        if ($user->check_user($username)) {
            return $username . rc_random(4, 'abcdefghijklmnopqrstuvwxyz0123456789');
        } else {
            return $username;
        }
    }
    
    public function get_email() {
        $connect_account = RC_Loader::load_app_class('connect_method', 'connect');
        $connect_handle  = $connect_account->get_connect_instance($this->connect_code);
        $email           = $connect_handle->get_email($this->profile);
        
        RC_Loader::load_app_class('integrate', 'user', false);
        $user = integrate::init_users();
        if ($user->check_email($email)) {
            return 'a' . rc_random(2, 'abcdefghijklmnopqrstuvwxyz0123456789') . '_' . $email;
        } else {
            return $email;
        }
    }
     
}

// end