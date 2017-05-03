<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class link_goods_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'link_goods';
		parent::__construct();
	}
	
	public function link_goods_select($where) {
		return $this->where($where)->select();
	}
	
	public function link_goods_delete($where) {
		return $this->where($where)->delete();
	}
	
	public function link_goods_update($where, $data) {
		return $this->where($where)->update($data);
	}
}

// end