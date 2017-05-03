<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class cart_cart_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'cart';
		$this->table_alias_name	= 'a';
		
		//定义视图选项
		$this->view = array(
			'cart' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'b',
				'field' => 'b.goods_number, b.rec_id',
				'on'    => 'b.parent_id = a.goods_id'
			)		
		);	
		parent::__construct();
	}
}

// end