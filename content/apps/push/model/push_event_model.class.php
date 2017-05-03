<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class push_event_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'push_event';
		parent::__construct();
	}
	
}

// end