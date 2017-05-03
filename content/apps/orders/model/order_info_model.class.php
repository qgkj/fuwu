<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class order_info_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'order_info';
		parent::__construct();
	}
	
	/**
	 * 获取积分兑换订单ids
	 * @param array $where
	 * @param string $group
	 */
	public function get_exchange_order_ids($where, $field) {
		$res = $this->where($where)->get_field($field, true);
		return $res;
	}
}

// end