<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
RC_Loader::load_app_class('notification.IOSNotification', 'push', false);

class IOSUnicast extends IOSNotification {
	function __construct() {
		parent::__construct();
		$this->data["type"] = "unicast";
		$this->data["device_tokens"] = NULL;
	}
}

// end