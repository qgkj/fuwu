<?php
  
use Royalcms\Component\Support\Facades\Redirect;
RC_Loader::load_app_class('platform_interface', 'platform', false);
class mp_userbind_bind_auth implements platform_interface {
    
    public function action() {
//     	本地测试使用
//     	$wecaht_user_db = RC_Loader::load_app_model('wecaht_user', 'wechat');
//     	$uuid = '8d8adb287d484506a000c8e211621cbc';
//     	$openid = 'oNelWuAzOoiuS9HIaD1NOQGKGxKU';
//     	RC_Loader::load_app_class('wechat_method', 'wechat', false);
//     	$wechat = wechat_method::wechat_instance($uuid);
    	    	 
//     	$wecaht_user_db = RC_Loader::load_app_model('wechat_user_model', 'wechat');
//     	$user_db = RC_Loader::load_app_model('users_model', 'user');
//     	RC_Loader::load_app_class('platform_account', 'platform', false);
//     	$account = platform_account::make($uuid);
//     	$wechat_id = $account->getAccountID();
//     	$ect_uid  = $wecaht_user_db->where(array('wechat_id' => $wechat_id,'openid' => $openid))->get_field('ect_uid');
//     	if (!empty($ect_uid)) {
//     		$user_info = $user_db->field('user_name, email, user_id')->find(array('user_id' => $ect_uid));
//     	} else {
//     		RC_Loader::load_app_class('wechat_user', 'wechat', false);
//     		$wechat_user = new wechat_user($wechat_id, $openid);
//     		$username  = $wechat_user->getNickname();
//     		$password  = wechat_user::generate_password();
//     		$email     = wechat_user::generate_email();
//     		$sex       = $wechat_user->sex();
//     		$reg_time  = RC_Time::gmtime();
//     		$user = RC_Api::api('user', 'init_user');
//     		if ($user && $user->check_user($username)) {
//     			$username = $username . rc_random(4, 'abcdefghijklmnopqrstuvwxyz0123456789');
//     		}
//     		$user_info = RC_Api::api('user', 'add_user', array('username' => $username, 'password' => $password, 'email' => $email, 'sex'=>$sex, 'reg_time'=>$reg_time));
//     		$user_id = $user_info['user_id'];
//     		$wechat_user->setUserId($user_id);
//     	}
    	
//     	$_SESSION['user_id']   = $user_info['user_id'];
//     	$_SESSION['user_name'] = $user_info['user_name'];
//     	$_SESSION['email']     = $user_info['email'];
//     	$_SESSION['last_ip']   = RC_Ip::client_ip();
//     	$_SESSION['last_time'] = RC_Time::gmtime();
    	
//     	$user_db->where(array('user_id' => $user_info['user_id']))->update(array('last_login' => RC_Time::gmtime(), 'last_ip'=>RC_Ip::client_ip()));
    	
//     	$session_id = RC_Session::session_id();
//     	header("Location: http://test.b2c.ecjia.com/sites/weshop/index.php?m=touch&c=index&a=init&token=".$session_id);
//     	exit;
    	
    	RC_Loader::load_app_class('wechat_method', 'wechat', false);
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	$oauth_db = RC_Loader::load_app_model('wechat_oauth_model', 'wechat');
    	
    	$uuid = $_GET['uuid'];
    	$account = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	$wechat = wechat_method::wechat_instance($uuid);
    	
    	$redirect_uri  = $oauth_db->where(array('wechat_id' => $wechat_id))->get_field('oauth_redirecturi');
    	$param =array(
    		'redirect_uri' => urlencode($redirect_uri),
    		'scope'        => 'snsapi_userinfo',
    		'state'        => 1,
    	);
    	$url = $wechat->getWebCodeUrl($param);
		header("Location: ".$url);
		exit;
    }
}

// end