<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class collect_store_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'collect_store';
		$this->table_alias_name = 'cs';

		$this->view = array(
// 				'merchants_shop_information' => array(
// 						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
// 						'alias' => 'msi',
// 						'on' 	=> 'cs.ru_id = msi.user_id'
// 				),
				'seller_shopinfo' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'ssi',
						'on'    => 'cs.seller_id = ssi.id ',
				),
				'seller_category' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'sc',
						'on'    => 'ssi.cat_id = sc.cat_id ',
				),

		);
		parent::__construct();
	}
}

// end
