<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class products_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'products';
		parent::__construct();
	}
}

// end