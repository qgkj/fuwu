<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class affiliate_order_info_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'order_info';
		parent::__construct();
	}
	
	public function order_info_update($where, $data) {
		return $this->where($where)->update($data);
	}
	
	public function order_info_find($where, $field='*') {
		return $this->where($where)->field($field)->find();
	}
}

// end