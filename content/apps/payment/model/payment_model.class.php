<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class payment_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'payment';
		parent::__construct();
	}
}

// end