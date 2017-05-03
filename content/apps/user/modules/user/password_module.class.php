<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 修改密码
 * @author royalwang
 */
class password_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
        //如果用户登录获取其session
        $this->authSession();
        $user_id = $_SESSION['user_id'];
    	if ($user_id <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
    	
 		RC_Loader::load_app_class('integrate', 'user', false);
 		$user = integrate::init_users();
 		
 		$old_password = $this->requestData('password', '');
 		$new_password = $this->requestData('new_password', '');
 		$code		  = $this->requestData('code', '');
		$user_id	  = $this->requestData('uid', $_SESSION['user_id']);
	    
		if (strlen($new_password) < 6) {
	    	$result = new ecjia_error('password_shorter', __('- 登录密码不能少于 6 个字符。'));
	    	return $result;
	    }
	
	    $user_info = $user->get_profile_by_id($user_id); //论坛记录
	   
	    if (($user_info && (!empty($code) && md5($user_info['user_id'] . ecjia::config('hash_code') . $user_info['reg_time']) == $code)) || ($_SESSION['user_id']>0 && $_SESSION['user_id'] == $user_id && $user->check_user($_SESSION['user_name'], $old_password))) {
			if ($user->edit_user(array('username'=> (empty($code) ? $_SESSION['user_name'] : $user_info['user_name']), 'old_password'=>$old_password, 'password'=>$new_password), empty($code) ? 0 : 1)) {
	        	$db = RC_Model::model('user/users_model');
	        	$db->where(array('user_id' => $user_id))->update(array('ec_salt' => 0));
	        	$session_db	= RC_Model::model('user/user_session_model');
	        	$session_db->delete(array('userid' => $user_id));
	        	$user->logout();
	            return array();
	        } else {
	        	$result = new ecjia_error('edit_password_failure', __('您输入的原密码不正确！'));
	        }
	    } else {
	    	$result = new ecjia_error('edit_password_failure', __('您输入的原密码不正确！'));
	    }
	    
		if (is_ecjia_error($result)) {
			return $result;
		}
	}
}

// end