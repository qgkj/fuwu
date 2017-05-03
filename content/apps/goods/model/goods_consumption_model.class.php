<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_consumption_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'goods_consumption';
		parent::__construct();
	}
}

// end