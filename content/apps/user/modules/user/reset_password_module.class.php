<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 找回密码，重新设置
 * @author will
 */
class reset_password_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
        $type     = $this->requestData('type');
        $value    = $this->requestData('value');
		$password = $this->requestData('password');
        if (empty($type) || empty($value) || empty($password)) {
        	return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
        }
        
        $db = RC_Model::model('user/users_model');
        
        if ($type == 'mobile') {
        	$user_count = $db->where(array('mobile_phone' => $value))->count();
        	//如果用户数量大于1
        	if ($user_count > 1) {
        		return new ecjia_error('mobile_repeat_error', __('手机号重复，请与管理员联系！'));
        	}
        	$userinfo = $db->find(array('mobile_phone' => $value));
        }
        if ($type == 'email') {
        	$userinfo = $db->find(array('email' => $value));
        }
        
        if (empty($userinfo)) {
        	return new ecjia_error('user_error', __('用户信息错误！'));
        }
        
        /* 判断code有效期*/
        $time = RC_Time::gmtime();
        if ($_SESSION['forget_expiry'] < $time) {
        	return new ecjia_error('code_expiry_error', __('验证码过期，请重新获取验证码！'));
        }
        
        if (!isset($_SESSION['forget_code_validated']) || $_SESSION['forget_code_validated'] != 1) {
        	return new ecjia_error('code_validated_error', __('验证码验证失败！'));
        }
        
        RC_Loader::load_app_class('integrate', 'user', false);
        $user = integrate::init_users();
         
        if (strlen($password) < 6) {
        	return new ecjia_error('password_shorter', __('- 登录密码不能少于 6 个字符。'));
        }
        $user_id = $userinfo['user_id'];
        $user_info = $user->get_profile_by_id($user_id); //论坛记录
     
        if ($user->edit_user(array('username'=> $user_info['user_name'], 'old_password' => null, 'password' => $password), $forget_pwd = 1)) {
        	$db->where(array('user_id' => $user_id))->update(array('ec_salt' => 0));
			$session_db	= RC_Model::model('user/user_session_model');
			$session_db->delete(array('userid' => $user_id));
			$user->logout();
        }
		
        RC_Session::delete('forget_code');
        RC_Session::delete('forget_expiry');
        RC_Session::delete('forget_code_validated');
        
        return array();
	}
}

// end