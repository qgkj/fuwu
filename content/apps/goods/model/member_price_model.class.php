<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class member_price_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'member_price';
		parent::__construct();
	}
}

// end