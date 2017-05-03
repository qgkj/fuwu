<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class index extends ecjia_api {
	public function __construct() {
		parent::__construct();
	}

	/**
	 * 首页信息
	 */
	public function init() {
	   $request = Component_HttpFoundation_Request::createFromGlobals();
       $uuid = $request->get('uuid');

       RC_Loader::load_app_class('platform_account', 'platform', false);
       $platform_account = platform_account::make($uuid);
       $platform = $platform_account->getPlatform();
       if (!is_ecjia_error($platform)) {
           Royalcms\Component\Foundation\Api::api($platform, 'platform_response', $platform_account->getAccount());           
       } else {
           echo 'NO ACCESS';
       }
	}
}

// end