<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class account_log_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'account_log';
		parent::__construct();
	}
	
	public function get_integral_count ($options) {
		$count = $this->where($options['where'])->count();
		return $count;
	}
	
	public function get_integral_list ($options) {
		$list = $this->where($options['where'])->limit($options['limit'])->select();
		return $list;
	}
}

// end