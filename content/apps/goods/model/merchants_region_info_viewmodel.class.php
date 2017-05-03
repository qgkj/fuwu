<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class merchants_region_info_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'merchants_region_info';
		$this->table_alias_name = 'mr';
		
		$this->view = array(
				'region_warehouse' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'rw',
						'on'    => 'mr.region_id = rw.regionId'
				)
		);
		parent::__construct();
	}
}

// end