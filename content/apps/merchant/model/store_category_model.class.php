<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class store_category_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'store_category';
		parent::__construct();
	}
}

// end
