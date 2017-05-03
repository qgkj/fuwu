<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 用户信息
 * @author royalwang
 */
class info_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
        //如果用户登录获取其session
        $user_id = $_SESSION['user_id'];
    	if ($user_id <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
    	
		RC_Loader::load_app_func('admin_user', 'user');
		$user_info = EM_user_info($_SESSION['user_id']);
		
		return $user_info;
	}
}

// end