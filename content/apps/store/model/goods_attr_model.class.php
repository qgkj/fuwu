<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_attr_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'goods_attr';
		parent::__construct();
	}
}

// end