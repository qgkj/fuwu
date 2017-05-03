<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_attr_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'goods_attr';
		parent::__construct();
	}
	
	public function goods_attr_delete($where) {
		return $this->where($where)->delete();
	}
	
	public function goods_attr_select($where) {
		return $this->where($where)->select();
	}
	
	public function goods_attr_update($where, $data) {
		return $this->where($where)->update($data);
	}
}

// end