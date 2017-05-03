<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class platform_account_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'platform_account';
		parent::__construct();
	}

}

// end