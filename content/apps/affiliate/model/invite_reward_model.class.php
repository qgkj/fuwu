<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class invite_reward_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'invite_reward';
		parent::__construct();
	}
}

// end