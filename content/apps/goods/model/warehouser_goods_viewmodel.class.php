<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class warehouser_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'warehouse_goods';
		$this->table_alias_name = 'wg';
		
		$this->view =array(
				'region_warehouse' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'rw',
						'on' 	=> 'wg.region_id = rw.region_id'
				)
		);
		
		parent::__construct();
	}
}

// end