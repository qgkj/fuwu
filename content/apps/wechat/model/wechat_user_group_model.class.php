<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_user_group_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'wechat_user_group';
		parent::__construct();
	}

}

// end