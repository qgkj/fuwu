<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class seller_shopinfo_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'seller_shopinfo';
		parent::__construct();
	}
}

// end