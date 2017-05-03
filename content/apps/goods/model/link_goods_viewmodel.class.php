<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class link_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'link_goods';
		$this->table_alias_name = 'lg';
		
		$this->view = array(
			'goods' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
// 				'field' => "g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price AS org_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price,g.market_price, g.promote_price, g.promote_start_date, g.promote_end_date",
				'on' 	=> 'g.goods_id = lg.link_goods_id'
			),
			'member_price' 	=> array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'mp',
				'on' 	=> 'mp.goods_id = g.goods_id and mp.user_rank = '.$_SESSION['user_rank'].''
			)
		);		
		parent::__construct();
	}
}

// end