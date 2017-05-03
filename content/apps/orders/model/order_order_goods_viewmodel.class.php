<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class order_order_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'order_goods';
		$this->table_alias_name	= 'o';

		$this->view = array(
			'products' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'p',
				'field' => "o.*, IF(o.product_id > 0, p.product_number, g.goods_number) AS storage, o.goods_attr, g.suppliers_id, IFNULL(b.brand_name, '') AS brand_name, p.product_sn",
				'on'    => 'p.product_id = o.product_id ',
			),
			'goods' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'on'    => 'o.goods_id = g.goods_id ',
			),
			'brand' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'b',
				'on'    => 'g.brand_id = b.brand_id ',
			),
		);	
		parent::__construct();
	}
}

// end