<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_customer_log_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'wechat_customer_log';
		parent::__construct();
	}

}

// end