<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class store_franchisee_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'store_franchisee';
		$this->table_alias_name = 'ssi';
		
		$this->view =array(
				'store_category' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'sc',
						'on'    => 'ssi.cat_id = sc.cat_id',
				),
				'collect_store' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'cs',
						'on'    => 'ssi.store_id = cs.store_id',
				),
				'term_relationship' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'tr',
						'on'    => 'tr.object_id = ssi.store_id and object_type="ecjia.merchant" and item_key1="merchant_adsense"',
				),
				'goods' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'g',
						'on'    => 'g.store_id = ssi.store_id',
				),
		);
		
		
		parent::__construct();
	}
}

// end