<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class reg_extend_info_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'reg_extend_info';
		parent::__construct();
	}
}

// end