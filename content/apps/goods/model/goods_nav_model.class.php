<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_nav_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'nav';
		parent::__construct();
	}
	
	public function nav_update($where, $data) {
		return $this->where($where)->update($data);
	}
	
	public function nav_insert($data) {
		return $this->insert($data);
	}
	
	public function nav_find($field = '*', $where) {
		return $this->field($field)->where($where)->find();
	}
	
	public function nav_max($where, $field) {
		return $this->where($where)->max($field);
	}
	
	public function nav_delete($where) {
		return $this->where($where)->delete();
	}
}

// end