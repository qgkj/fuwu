<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_activity_prize_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'mobile_activity_prize';
		parent::__construct();
	}
}

// end