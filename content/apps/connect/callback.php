<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 第三方登录回调处理
 */
class callback extends ecjia_front {
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * 返回值参考
     * open_id       唯一标示
     * username     昵称
     */
    public function init() {
        $connect_code = $_GET['connect_code'];
        unset($_GET['connect_code']);
        if (empty($connect_code)) {
            $link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
            return $this->showmessage(RC_Lang::get('connect::connect.not_found'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $link));
        }
        $connect_method = RC_Loader::load_app_class('connect_method', 'connect');
        $connect_handle = $connect_method->get_connect_instance($connect_code);
        $result         = $connect_handle->callback();
        
        if (!is_ecjia_error($result)) {
            RC_Loader::load_app_class('connect_user', 'connect', false);
            $connect_user = new connect_user($result['connect_code'], $result['open_id']);
            if ($connect_user->check_openid_exist() && $connect_user->user_id) {
                if ($connect_user->is_admin == 1) {
                    RC_Hook::do_action('connect_callback_admin_signin', $connect_user->user_id);
                } else {
                    //普通用户登录
                    RC_Hook::do_action('connect_callback_user_signin', $connect_user->user_id);
                }
            } else {
                //绑定账号
                $result['bind_url']  = RC_Uri::url('connect/callback/bind_login', array('connect_code' => $connect_code, 'open_id' => $result['open_id']));
                //注册登录
                $result['login_url'] = RC_Uri::url('connect/callback/bind_signup', array('connect_code' => $connect_code, 'open_id' => $result['open_id']));
                
                $string = RC_Hook::apply_filters('connect_callback_template', $result);
                echo $this->fetch_string($string);
            } 
        } else {
            $string = RC_Hook::apply_filters('connect_callback_template', $result);
            echo $this->fetch_string($string);
        }
    }
    
    /**
     * 绑定注册
     */
    public function bind_signup() {
        $connect_code   = $_GET['connect_code'];
        $open_id        = $_GET['open_id'];
        RC_Loader::load_app_class('connect_user', 'connect', false);
        $connect_user = new connect_user($connect_code, $open_id);
        //判断已绑定授权登录用户 直接登录
        if ($connect_user->check_openid_exist() && $connect_user->user_id) {
            if ($connect_user->is_admin == 1) {
                RC_Hook::do_action('connect_callback_admin_signin', $connect_user->user_id);
            } else {
                //普通用户登录
                RC_Hook::do_action('connect_callback_user_signin', $connect_user->user_id);
            }
        } else {
            //新用户注册并登录
            $username = $connect_user->get_username();
            $password = md5(rc_random(9, 'abcdefghijklmnopqrstuvwxyz0123456789'));
            $email    = $connect_user->get_email();
            $user_id = RC_Hook::apply_filters('connect_callback_bind_signup', 0, $username, $password, $email);
            $result  = $connect_user->bind_user($user_id, 0);
            if ($result) {
              return $this->redirect(RC_Uri::url('touch/my/init'));
            } else {
                $link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
                return $this->showmessage(RC_Lang::get('connect::connect.regist_fail'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $link));
            }
        }
    }
    
    /**
     * 绑定登录界面
     */
    public function bind_login() {
        $action_link = RC_Uri::url('connect/callback/bind_signin', array('connect_code' => $_GET['connect_code'], 'open_id' => $_GET['open_id']));
        $this->assign('action_link', $action_link);
        $this->assign('action_link_ajax', $action_link . '&return=ajax');
        $string = RC_Hook::apply_filters('connect_callback_signin_template', $_GET);
        echo $this->fetch_string($string);
    }
    
    /**
     * 绑定登录
     */
    public function bind_signin() {
        $return         = $_GET['return'];
        $connect_code   = $_GET['connect_code'];
        $open_id        = $_GET['open_id'];
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        RC_Loader::load_app_class('connect_user', 'connect', false);
        $connect_user = new connect_user($connect_code, $open_id);

        //判断已绑定授权登录用户 直接登录
        if ($connect_user->check_openid_exist() && $connect_user->user_id) {
            if ($connect_user->is_admin == 1) {
                RC_Hook::do_action('connect_callback_admin_signin', $connect_user->user_id);
            } else {
                //普通用户登录
                RC_Hook::do_action('connect_callback_user_signin', $connect_user->user_id);
            }
        } else {
            $user_id = RC_Hook::apply_filters('connect_callback_bind_signin', 0, $username, $password);
            if ($user_id) {
                $result = $connect_user->bind_user($user_id, 0);
            } else {
                $result = false;
            }

            if ($return == 'ajax') {
                if ($result) {
                    $link[] = array(RC_Lang::get('connect::connect.back_member'), 'href' => RC_Uri::url('touch/my/init'));
                    return $this->showmessage(RC_Lang::get('connect::connect.bind_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $link));
                } else {
                    $link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
                    return $this->showmessage(RC_Lang::get('connect::connect.bind_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $link));
                }
            } else {
                if ($result) {
                   return $this->redirect(RC_Uri::url('touch/my/init'));
                } else {
                    $link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
                    return $this->showmessage(RC_Lang::get('connect::connect.bind_fail'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $link));
                }
            }
        }
    }
}

// end