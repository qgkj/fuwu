<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class orders_booking_goods_model extends Component_Model_View {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'booking_goods';
		parent::__construct();
	}
}

// end