<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class store_franchisee_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'store_franchisee';
		parent::__construct();
	}
}

// end
