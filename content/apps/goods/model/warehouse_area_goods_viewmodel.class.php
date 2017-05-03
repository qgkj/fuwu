<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class warehouse_area_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'warehouse_area_goods';
		$this->table_alias_name = 'wa';
		
		$this->view =array(
				'region_warehouse' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'rw',
						'on' 	=> 'wa.region_id = rw.regionId'
				)
		);
		
		parent::__construct();
	}
}

// end