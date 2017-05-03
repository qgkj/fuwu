<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class region_warehouse_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'region_warehouse';
		parent::__construct();
	}
}

// end