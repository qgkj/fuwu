<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class affiliate_user_bonus_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'user_bonus';
		parent::__construct();
	}
}

// end