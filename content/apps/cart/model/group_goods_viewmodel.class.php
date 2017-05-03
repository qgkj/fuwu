<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class group_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'group_goods';
		$this->table_alias_name	= 'gg';
		
		$this->view = array(
			'goods ' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'g',
				'field'	=> "gg.parent_id, ggg.goods_name AS parent_name, gg.goods_id, gg.goods_price, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price AS org_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price",
				'on'	=> 'g.goods_id = gg.goods_id'
			),
			'member_price' 	=> array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'mp',
				'on' 	=> "mp.goods_id = gg.goods_id AND mp.user_rank = '$_SESSION[user_rank]'",
			),
			'goods' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'ggg',
				'on'	=> 'ggg.goods_id = gg.parent_id'
			)
		);		
		parent::__construct();
	}
}

// end