<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class seller_category_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'seller_category';
		parent::__construct();
	}
}

// end