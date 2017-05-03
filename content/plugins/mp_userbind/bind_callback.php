<?php
  
RC_Loader::load_app_class('platform_interface', 'platform', false);
class mp_userbind_bind_callback implements platform_interface {
    
    public function action() {
    	$wecaht_user_db = RC_Loader::load_app_model('wecaht_user', 'wechat');
    	$code = $_GET['code'];
    	$uuid = $_GET['uuid'];
    	RC_Loader::load_app_class('wechat_method', 'wechat', false);
    	$wechat = wechat_method::wechat_instance($uuid);
    	
    	$WebAccessToken = $wechat->getWebToken($code);//通过code换取网页授权access_token
    	$openid = $WebAccessToken['openid'];
    	$wechat->refreshWebToken($WebAccessToken);//刷新access_token
    	$wechat->getWebUserInfo($openid, $WebAccessToken);//获取用户信息
    	$wechat->authWebToken($openid, $WebAccessToken);//检验授权凭证（access_token）是否有效
   
    	$wecaht_user_db = RC_Loader::load_app_model('wechat_user_model', 'wechat');
    	$user_db = RC_Loader::load_app_model('users_model', 'user');
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	$account = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	$ect_uid  = $wecaht_user_db->where(array('wechat_id' => $wechat_id,'openid' => $openid))->get_field('ect_uid');
    	if (!empty($ect_uid)) {
    		$user_info = $user_db->field('user_name, email, user_id')->find(array('user_id' => $ect_uid));
    	} else {
    		RC_Loader::load_app_class('wechat_user', 'wechat', false);
    		$wechat_user = new wechat_user($wechat_id, $openid);
    		$username  = $wechat_user->getNickname();
    		$password  = wechat_user::generate_password();
    		$email     = wechat_user::generate_email();
    		$sex       = $wechat_user->sex();
    		$reg_time  = RC_Time::gmtime();
    		$user      = RC_Api::api('user', 'init_user');
    		if ($user && $user->check_user($username)) {
    			$username = $username . rc_random(4, 'abcdefghijklmnopqrstuvwxyz0123456789');
    		}
    		$user_info = RC_Api::api('user', 'add_user', array('username' => $username, 'password' => $password, 'email' => $email, 'sex'=>$sex, 'reg_time'=>$reg_time));
    		$user_id = $user_info['user_id'];
    		$wechat_user->setUserId($user_id);
    	}
 
    	$_SESSION['user_id']   = $user_info['user_id'];
    	$_SESSION['user_name'] = $user_info['user_name'];
    	$_SESSION['email']     = $user_info['email'];
    	$_SESSION['last_ip']   = RC_Ip::client_ip();
    	$_SESSION['last_time'] = RC_Time::gmtime();
    	$user_db->where(array('user_id' => $user_info['user_id']))->update(array('last_login' => RC_Time::gmtime(), 'last_ip'=>RC_Ip::client_ip()));
    	$session_id = RC_Session::session_id();
    	header("Location: http://test.b2c.ecjia.com/sites/weshop/index.php?m=touch&c=index&a=init&token=".$session_id);
    	exit;
    }
}

// end