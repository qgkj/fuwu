<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class platform_extend_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'platform_extend';
		parent::__construct();
	}
}

// end