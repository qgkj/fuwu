<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class cart_good_member_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view =array();
	public function __construct() {
		$this->table_name = 'cart';
		$this->table_alias_name = 'c';
		
		//定义视图选项
		$this->view =array(
			'goods' => array(
				'type'  =>Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'field' => "c.rec_id, c.goods_id, c.goods_attr_id, g.promote_price, g.promote_start_date, c.goods_number,g.promote_end_date, IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS member_price",
				'on'    => 'g.goods_id = c.goods_id'
			),
			'member_price' => array(
				'type'  =>Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'mp',
				'on'    => 'mp.goods_id = g.goods_id AND mp.user_rank = "'. $_SESSION['user_rank'] . '"'
			)
		);
		parent::__construct();
	}
}

// end