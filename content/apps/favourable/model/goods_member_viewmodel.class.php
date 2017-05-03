<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_member_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'goods';
		$this->table_alias_name = 'g';
		
		$this->view = array(
			'member_price' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'mp',
				'field' => "g.goods_id, g.goods_name, g.goods_name_style, g.market_price, g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, g.promote_price, g.goods_type,g.promote_start_date, g.promote_end_date, g.goods_brief, g.goods_thumb ,g.original_img ,g.goods_img",
				'on' 	=> "mp.goods_id = g.goods_id and mp.user_rank = '$_SESSION[user_rank]'"
			)
		);
		parent::__construct();
	}
}

// end