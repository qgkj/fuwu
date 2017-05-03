<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class cart_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'cart';
		parent::__construct();
	}

	/**
	 * 清空购物车
	 * @param   int	 $type   类型：默认普通商品
	 */
	public function clear_cart($type = CART_GENERAL_GOODS, $cart_id = array()) {
		$where = array('rec_type' => $type, 'user_id' => $_SESSION['user_id']);
		if (!empty($cart_id)) {
			$where['rec_id'] =  $cart_id;
		}
		$this->where($where)->delete();
		return true;
	}
	
}

// end