<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class order_action_model extends Component_Model_View {
	public $table_name = '';
	public function __construct() {
		$this->table_name 	= 'order_action';
		parent::__construct();
	}
}

// end