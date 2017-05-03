<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 管理员退出
 * @author will
 */
class signout_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	
		
		RC_Session::destroy();
		
		return array();
	}
}

// end