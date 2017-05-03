<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
RC_Loader::load_app_class('notification.IOSNotification', 'push', false);

class IOSBroadcast extends IOSNotification {
	function  __construct() {
		parent::__construct();
		$this->data["type"] = "broadcast";
	}
}

// end