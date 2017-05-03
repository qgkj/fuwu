<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class merchants_server_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'merchants_server';
		parent::__construct();
	}
}

// end