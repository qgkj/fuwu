<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class staff_log_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'staff_log';
		parent::__construct();
	}
}

// end
