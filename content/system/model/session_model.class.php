<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class session_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'sessions';
		parent::__construct();
	}



}

// end