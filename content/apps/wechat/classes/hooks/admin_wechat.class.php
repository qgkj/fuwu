<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_admin_plugin {
	static public function api_request_record($api_name) {
	    RC_Loader::load_app_class('wechat_request_times', 'wechat', false);
	    
	    $platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
	    $wechat_id = $platform_account->getAccountID();
	    if ($wechat_id) {
	       $request_times = new wechat_request_times($wechat_id);
	       $request_times->record($api_name);
	    }
	}
}

RC_Hook::add_action( 'wechat_api_request_record', array('wechat_admin_plugin', 'api_request_record') );

// end