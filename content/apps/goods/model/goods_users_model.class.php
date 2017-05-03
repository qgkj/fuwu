<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_users_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'users';
		parent::__construct();
	}
}

// end