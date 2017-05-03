<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class platform_config_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'platform_config';
		$this->table_alias_name = 'c';
		
		$this->view = array(
			'platform_extend' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 	'e',
				'on'   	=> 	'e.ext_code = c.ext_code'
			),
			'platform_account' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 	'a',
				'on'   	=> 	'a.id = c.account_id'
			),
		);
		parent::__construct();
	}
}

// end