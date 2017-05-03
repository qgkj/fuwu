<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class connect_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'connect';
		parent::__construct();
	}
}

// end