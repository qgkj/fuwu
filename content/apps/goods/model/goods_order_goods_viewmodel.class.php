<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_order_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'order_goods';
		$this->table_alias_name = 'og';
		$this->view = array(
			'order_info' => array(
				'type'		=> Component_Model_View::TYPE_INNER_JOIN,
				'alias'		=> 'o',
				'on'		=> 'og.order_id = o.order_id'
			),
			'goods' => array(
				'type'		=> Component_Model_View::TYPE_INNER_JOIN,
				'alias'		=> 'g',
				'on'		=> "og.goods_id = g.goods_id"
			),
		);
		parent::__construct();
	}

}

// end