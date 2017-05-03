<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class attribute_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'attribute';
		$this->table_alias_name = 'a';
		
		$this->view =array(
			'goods_type' => array( 
				'type'  => Component_Model_View::TYPE_RIGHT_JOIN,
				'alias' => 'gt',
// 				'field' => 'gt.*,count(a.cat_id)|attr_count',
				'on'    => 'a.cat_id = gt.cat_id'				
			),
			'goods_attr' => array(
				'type'  => Component_Model_View::TYPE_RIGHT_JOIN,
				'alias' => 'ga',
// 				'field' => 'a.cat_id',
				'on'    => 'ga.attr_id = a.attr_id'
			),
			'goods' => array (
				'type' 	    => Component_Model_View::TYPE_LEFT_JOIN,
				'alias'     => 'g',
// 				'field'     => 'attr_group',
				'on' 	    => 'gt.cat_id = g.goods_type' 
			)
		);
		parent::__construct();
	}
}

// end