<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class sys_package_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view =array();
	public function __construct() {
		$this->table_name = 'package_goods';
		$this->table_alias_name = 'pg';
		
		$this->view =array(
				'goods' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'g',
						'field' => "pg.package_id, pg.goods_id, pg.goods_number, pg.admin_id,g.goods_sn, g.goods_name, g.market_price, g.goods_thumb, g.is_real,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS rank_price",
						'on'   	=> 'g.goods_id = pg.goods_id'
				),
				'member_price' 	=> array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'mp',
						'on'   	=> "mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]'"
				),
		);
		parent::__construct();
	}
}

// end