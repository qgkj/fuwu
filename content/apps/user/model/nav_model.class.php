<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class nav_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'nav';
		parent::__construct();
	}
}

// end