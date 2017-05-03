<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class package_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'package_goods';
		$this->table_alias_name	= 'pg';
		
		 $this->view = array(
	 		'goods' => array(
 				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
 				'alias' => 'g',
 				'field' => 'pg.goods_id, g.goods_name, (CASE WHEN pg.product_id > 0 THEN p.product_number ELSE g.goods_number END) AS goods_number, p.goods_attr, p.product_id, pg.goods_number AS order_goods_number, g.goods_sn, g.is_real, p.product_sn',
 				'on'    => 'pg.goods_id = g.goods_id ',
	 		),
    		'products' => array(
    			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
    			'alias' => 'p',
    			'on'    => 'pg.product_id = p.product_id ',
    		)
    	);	
		parent::__construct();
	}
}

// end