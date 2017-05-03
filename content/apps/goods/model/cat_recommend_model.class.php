<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class cat_recommend_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'cat_recommend';
		parent::__construct();
	}
	
	public function cat_recommend_select($field = '*', $where = array()) {
		return $this->field($field)->where($where)->select();
	}
}

// end