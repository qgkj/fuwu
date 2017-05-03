<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class delivery_order_model extends Component_Model_View {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'delivery_order';
		parent::__construct();
	}
}

// end