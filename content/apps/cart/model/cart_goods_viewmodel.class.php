<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class cart_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'cart';
		$this->table_alias_name = 'c';
		
		//定义视图选项
		$this->view = array(
			'goods' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'on'    => 'c.goods_id = g.goods_id'
			)
		);
		parent::__construct();
	}
}

// end