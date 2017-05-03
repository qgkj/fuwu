<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_activity_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view = array();
	public function __construct() {
		$this->table_name       = 'mobile_activity';
		$this->table_alias_name = 'ma';
		
		//定义视图选项
		$this->view = array(
			'mobile_activity_prize' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'map',
				'on'    => 'ma.activity_id = map.activity_id'
			),
			'mobile_activity_log' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'mal',
				'on'    => 'ma.activity_id = mal.activity_id'
			),
		);
		parent::__construct();
	}
}

// end