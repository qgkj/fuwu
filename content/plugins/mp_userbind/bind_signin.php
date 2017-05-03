<?php
  
RC_Loader::load_app_class('platform_interface', 'platform', false);
class mp_userbind_bind_signin implements platform_interface {
    
    public function action() {
    	$css_url = RC_Plugin::plugins_url('css/wechat_redirect.css', __FILE__);
    	$jq_url = RC_Plugin::plugins_url('js/jquery.js', __FILE__);
    	$tplpath = RC_Plugin::plugin_dir_path(__FILE__) . 'templates/wechat_bind_success.dwt.php';
    	
        $openid = trim($_GET['openid']);
        $uuid = trim($_GET['uuid']);
        
        RC_Loader::load_app_class('platform_account', 'platform', false);
        $account = platform_account::make($uuid);
        $wechat_id = $account->getAccountID();
        
        $user_name = trim($_POST['user_name']);
        $password = trim($_POST['password']);
        
        if (empty($user_name)) {
        	 ecjia_front::$controller->showmessage('用户名不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        if (empty($password)) {
        	 ecjia_front::$controller->showmessage('密码不能为空！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        //登录逻辑处理
        $user_db = RC_Loader::load_app_model('users_model','user');
        $wechat_user_db = RC_Loader::load_app_model('wechat_user_model', 'wechat');
        
        //判断已绑定用户
        $row = $user_db->where(array('user_name' => $user_name))->find();
        if ($row) {
        	if (!empty($row['ec_salt'])) {
        		if (!($row['user_name'] == $user_name && $row['password'] == md5(md5($password) . $row['ec_salt']))) {
        			 ecjia_front::$controller->showmessage('您输入账号信息不正确，绑定失败！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        		}
        	} else {
        		if (!($row['user_name'] == $user_name && $row['password'] == md5($password))) {
        			 ecjia_front::$controller->showmessage('您输入账号信息不正确，绑定失败！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        		}
        	}
        	RC_Loader::load_app_class('wechat_user', 'wechat', false);
        	$wechat_user = new wechat_user($wechat_id, $openid);
        	$wechat_user->setUserId($row['user_id']);
        	
        	$_SESSION['user_id']   = $row['user_id'];
        	$_SESSION['user_name'] = $row['user_name'];
        	$_SESSION['email']     = $row['email'];
        	$_SESSION['last_ip']   = RC_Ip::client_ip();
        	$_SESSION['last_time'] = RC_Time::gmtime();
        	$user_db->where(array('user_id' => $row['user_id']))->update(array('last_login' => RC_Time::gmtime(), 'last_ip'=>RC_Ip::client_ip()));
        		
        	ecjia_front::$controller->assign('username',$row['user_name']);
        	ecjia_front::$controller->assign('point_value',$row['rank_points']);
        	ecjia_front::$controller->assign('css_url',$css_url);
        	ecjia_front::$controller->assign('jq_url',$jq_url);
        	ecjia_front::$controller->assign('action','cancel');
        	ecjia_front::$controller->assign_lang();
        	ecjia_front::$controller->display($tplpath);
        } else {
        	ecjia_front::$controller->showmessage('您输入账号信息不正确，绑定失败！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
    
}

// end