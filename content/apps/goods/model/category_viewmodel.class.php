<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class category_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'category';
		$this->table_alias_name = 'c';
		
		$this->view =array(
			'goods' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
// 				'field' => 'c.cat_id, c.cat_name, COUNT(g.goods_id) AS goods_count',
				'on' 	=> 'c.cat_id = g.cat_id '
			),
			'category' => array(
				'type'  =>	Component_Model_View::TYPE_LEFT_JOIN,
				'alias' =>	's',
// 				'field' =>	'c.cat_id, c.cat_name, c.measure_unit, c.parent_id, c.is_show, c.show_in_nav, c.grade, c.sort_order, COUNT(s.cat_id) AS has_children',
				'on'   	=>	's.parent_id = c.cat_id'
			)
		);
		
		parent::__construct();
	}
}

// end