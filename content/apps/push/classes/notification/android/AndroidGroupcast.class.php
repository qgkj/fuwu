<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
RC_Loader::load_app_class('notification.AndroidNotification', 'push', false);

class AndroidGroupcast extends AndroidNotification {
	function  __construct() {
		parent::__construct();
		$this->data["type"] = "groupcast";
		$this->data["filter"]  = NULL;
	}
}

// end