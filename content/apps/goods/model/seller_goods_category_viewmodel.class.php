<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class seller_goods_category_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view = array();
	public function __construct() {
		$this->table_name = 'seller_goods_category';
		$this->table_alias_name = 'c';
		
		$this->view = array(
				'seller_goods_category' => array(
						'type'  =>	Component_Model_View::TYPE_LEFT_JOIN,
						'alias' =>	's',
						'field' =>	'c.cat_id, c.cat_name, c.measure_unit, c.parent_id, c.is_show, c.show_in_nav, c.grade, c.sort_order, COUNT(s.cat_id) AS has_children',
						'on'   	=>	's.parent_id = c.cat_id'
				),
				'goods' => array(
						'type'  =>	Component_Model_View::TYPE_LEFT_JOIN,
						'alias' =>	'g',
						'on'   	=>	'g.cat_id = c.cat_id'
				),
				'seller_shopinfo' => array(
						'type'  =>	Component_Model_View::TYPE_LEFT_JOIN,
						'alias' =>	'ssi',
						'on'   	=>	'ssi.id = g.seller_id'
				),
		);
		parent::__construct();
	}
}

// end