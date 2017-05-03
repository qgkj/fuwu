<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class users_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'users';
		parent::__construct();
	}
	
	public function get_one_field($where, $field='*') {
		$field = $this->where($where)->get_field($field);
		return $field;
	}
}

// end