<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class platform_account_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'platform_account';
		$this->table_alias_name = 'a';
		
		$this->view = array(
			'wechat_menu' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 	'm',
				'on'   	=> 	'm.wechat_id = a.id'
			),
		);
		
		parent::__construct();
	}
}

// end