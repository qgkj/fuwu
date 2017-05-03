<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class order_info_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'order_info';
		$this->table_alias_name = 'o';
		
		$this->view =array(
			'users' => array(
					'type'  => Component_Model_View::TYPE_LEFT_JOIN,
					'alias' => 'u',
					'on'    => 'u.user_id=o.user_id'
			),
			'order_goods' => array( 
					'type'  => Component_Model_View::TYPE_LEFT_JOIN,
					'alias' => 'og',
					'field' => '',
					'on'    => 'o.order_id = og.order_id'				
			),
			'goods' => array(
					'type'  => Component_Model_View::TYPE_LEFT_JOIN,
					'alias' => 'g',
					'on'    => 'og.goods_id=g.goods_id'
			),
// 			'order_info' => array(
// 					'type'  => Component_Model_View::TYPE_LEFT_JOIN,
// 					'alias' => 'oi2',
// 					'on'    => 'oi2.main_order_id = o.order_id'
// 			)
		);
		
		parent::__construct();
	}
}

// end