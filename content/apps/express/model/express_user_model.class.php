<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class express_user_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'express_user';
		parent::__construct();
	}
}

// end