<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_user_rank_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'user_rank';
		parent::__construct();
	}
}

// end