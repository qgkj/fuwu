<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class collect_goods_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'collect_goods';
		parent::__construct();
	}
}

// end