<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_message_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'mobile_message';
		parent::__construct();
	}
}

// end