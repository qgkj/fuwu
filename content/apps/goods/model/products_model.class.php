<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class products_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'products';
		parent::__construct();
	}
	
	public function products_delelte($where, $in = false) {
		if ($in) {
			return $this->in($where)->delete();
		}
		return $this->where($where)->delete();
	}
	
	public function products_select($where = array(), $filed = '*', $in = false) {
		if ($in) {
			return $this->field($field)->in($where)->select();
		}
		return $this->field($field)->where($where)->select();
	}
	
	public function products_update($where, $data) {
		return $this->where($where)->update($data);
	}
	
	public function products_find($field = '*', $where) {
		return $this->field($field)->where($where)->find();
	}
	
	/* 查询字段信息 */
	public function products_field($where, $field, $bool=false) {
		return $this->where($where)->get_field($field, $bool);
	}
	
}

// end