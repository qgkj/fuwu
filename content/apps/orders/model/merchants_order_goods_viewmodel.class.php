<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class merchants_order_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'order_goods';
		$this->table_alias_name = 'og';
		
		$this->view = array(	
			'order_info' => array(
				'type'  =>	Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=>	'o',
				'on'    =>	'o.order_id = og.order_id',
			),
			'seller_shopinfo' 	=> array(
				'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'ssi',
				'on' 	=> 'ssi.id = o.seller_id'
			),
		    'merchants_shop_information' 	=> array(
		        'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
		        'alias'	=> 'ms',
		        'on'	=> 'ssi.shop_id = ms.shop_id'
		    ),
			'users' => array(
				'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'u',
				'on'	=> 'u.user_id = o.user_id',
			)
		);	
		parent::__construct();
	}
}

// end