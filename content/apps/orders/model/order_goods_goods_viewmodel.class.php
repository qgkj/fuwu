<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class order_goods_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'order_goods';
		$this->table_alias_name = 'o';
		
		$this->view = array(			
		    'goods' 	=> array(
		        'type' 		=> Component_Model_View::TYPE_LEFT_JOIN,
		        'alias' 	=> 'g',
		        'field'     => 'o.*,o.goods_price * o.goods_number AS subtotal,g.goods_thumb,g.original_img,g.goods_img',
		        'on' 		=> 'o.goods_id = g.goods_id'
		    )
		);	
		parent::__construct();
	}
}

// end