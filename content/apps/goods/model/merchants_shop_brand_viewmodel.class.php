<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class merchants_shop_brand_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'merchants_shop_brand';
		$this->table_alias_name = 'mb';
		
		$this->view = array(
// 			'merchants_shop_information' => array(
// 				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
// 				'alias' => 'ms',
// 				'on' 	=> 'mb.user_id = ms.user_id'
// 			),
			'seller_shopinfo' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'ssi',
				'on' 	=> 'ssi.id = mb.seller_id'
			),
		);
		
		parent::__construct();
	}
}

// end