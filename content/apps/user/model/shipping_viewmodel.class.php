<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class shipping_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	
	public function __construct() {
		$this->table_name = 'shipping';
		$this->table_alias_name	= 's';
		
		$this->view = array(
			'shipping_area' => array(
				'type'  =>Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'sa',
				'on'    => 'sa.shipping_id = s.shipping_id ', 
			),
			'area_region' => array(
				'type'  =>Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'ar',
				'on'    => 'sa.shipping_area_id = ar.shipping_area_id ', 
			)
		);
		parent::__construct();
	}
}

// end