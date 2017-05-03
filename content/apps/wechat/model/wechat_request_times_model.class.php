<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_request_times_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'wechat_request_times';
		parent::__construct();
	}

}

// end