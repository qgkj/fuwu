<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class signout_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
		RC_Loader::load_app_class('integrate', 'user', false);
		$user = integrate::init_users();
		$user->logout();
		
		return array();
	}
}

// end