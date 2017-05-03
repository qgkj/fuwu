<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_cart_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'goods';
		$this->table_alias_name	 = 'g';
		
		$this->view = array(
			'cart' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'c',
				'field' => 'g.goods_name, g.goods_number',
				'on'   	=> 'g.goods_id = c.goods_id'
			)	
		);	
		parent::__construct();
	}
}

// end