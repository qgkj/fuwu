<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class delivery_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'delivery_goods';
		$this->table_alias_name	= 'dg';
		
		 $this->view = array(
	    	'goods' => array(
    			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
    			'alias' => 'g',
    			'field' => 'dg.goods_id, dg.is_real, dg.product_id, SUM(dg.send_number) AS sums, IF(dg.product_id > 0, p.product_number, g.goods_number) AS storage, g.goods_name, dg.send_number',
    			'on'    => 'dg.goods_id = g.goods_id ',
	    	),
		 	'products' => array(
	 			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
	 			'alias' => 'p',
	 			'on'    => 'dg.product_id = p.product_id ',
		 	)
    );	
		parent::__construct();
	}
}

// end