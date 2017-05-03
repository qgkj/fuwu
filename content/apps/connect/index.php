<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class index extends ecjia_front {
    /**
     * 析构函数
     */
    public function __construct() {
        parent::__construct();
    }
    
    public function init() {
        $connect_code = $_GET['connect_code'];
        $login_type = $_GET['login_type'];
        if (empty($connect_code)) {
            $link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
            return $this->showmessage(RC_Lang::get('connect::connect.not_found'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $link));
        }
        $connect_account    = RC_Loader::load_app_class('connect_method', 'connect');
        $connect_handle     = $connect_account->get_connect_instance($connect_code);
        if ($login_type) {
            $connect_handle->set_login_type($login_type);
        }
        $code_url           = $connect_handle->authorize_url();
        header("Location:$code_url");
    }
}

// end