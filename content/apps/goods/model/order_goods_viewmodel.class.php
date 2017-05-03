<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class order_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'order_goods';
		$this->table_alias_name = 'a';
		
		$this->view = array(
				'order_goods' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'b',
						'field' => 'COUNT(b.goods_id ) AS num, g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price, g.promote_price, g.promote_start_date, g.promote_end_date',
						'on' 	=> 'b.order_id = a.order_id'
				),
				'goods' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'g',
						'on' 	=> 'g.goods_id = b.goods_id'
				),
		);		
		parent::__construct();
	}
}

// end