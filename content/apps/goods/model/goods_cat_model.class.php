<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_cat_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'goods_cat';
		parent::__construct();
	}
	
	public function goods_cat_select($where = array(), $field = '*') {
		return $this->where($where)->field($field)->select();
	}
}

// end
