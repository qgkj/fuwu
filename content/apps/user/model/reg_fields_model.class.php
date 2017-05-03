<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class reg_fields_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'reg_fields';
		parent::__construct();
	}
}

// end