<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class seller_category_shopinfo_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view = array();
	public function __construct() {
		$this->table_name = 'seller_category';
		$this->table_alias_name = 'c';
		
		$this->view = array(
				'seller_shopinfo' => array(
						'type'  =>	Component_Model_View::TYPE_LEFT_JOIN,
						'alias' =>	's',
						'field' =>	'',
						'on'   	=>	's.cat_id = c.cat_id'
				)				
		);
		parent::__construct();
	}
}

// end