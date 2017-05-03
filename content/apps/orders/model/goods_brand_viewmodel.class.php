<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_brand_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'goods';
		$this->table_alias_name	= 'g';

		$this->view = array(
			'brand' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'b',
				'field' => 'goods_id, c.cat_name, goods_sn, goods_name,goods_img, b.brand_name,goods_number, market_price, shop_price, promote_price,promote_start_date, promote_end_date, goods_brief, goods_type, is_promote',
				'on'    => 'g.brand_id  = b.brand_id',
			),
			'category' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'c',
				'on'    => 'g.cat_id = c.cat_id ',
			)
		);
		parent::__construct();
	}
}

// end