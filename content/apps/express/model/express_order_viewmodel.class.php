<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class express_order_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'express_order';
		$this->table_alias_name = 'eo';
		
		$this->view = array(
			'store_franchisee'	=> array(
		        'type' 		=> Component_Model_View::TYPE_LEFT_JOIN,
		        'alias' 	=> 'sf',
		        'on' 		=> 'sf.store_id = eo.store_id'
		    ),
		    'delivery_order'	=> array(
		        'type' 		=> Component_Model_View::TYPE_LEFT_JOIN,
		        'alias' 	=> 'do',
		        'on' 		=> 'do.delivery_id = eo.delivery_id'
		    ),
			'delivery_goods'	=> array(
		        'type' 		=> Component_Model_View::TYPE_LEFT_JOIN,
		        'alias' 	=> 'dg',
		        'on' 		=> 'do.delivery_id = dg.delivery_id'
		    ),
			'order_info'	=> array(
		        'type' 		=> Component_Model_View::TYPE_LEFT_JOIN,
		        'alias' 	=> 'oi',
		        'on' 		=> 'eo.order_id = oi.order_id'
		    ),
		);	
		parent::__construct();
	}
}

// end