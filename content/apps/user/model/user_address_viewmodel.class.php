<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class user_address_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'user_address';
		$this->table_alias_name	= 'ua';
		
		$this->view = array(
			'region' => array(
				'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'		=> 'c',
				'on'		=> 'c.region_id = ua.country'
			),
			'region as p' => array(
				'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
				'on'		=> 'p.region_id = ua.province'
			),
			'region as t' => array(
				'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
				'on'		=> 't.region_id = ua.city'
			),
			'region as d' => array(
				'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
				'on'		=> 'd.region_id = ua.district'
			)
		);
		
		parent::__construct();
	}
}

// end