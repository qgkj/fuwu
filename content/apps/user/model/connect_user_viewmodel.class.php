<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class connect_user_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'connect_user';
		$this->table_alias_name = 'cu';
		
		//添加视图选项，方便调用
		$this->view = array(
				'users' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'	=> 'u',
						'on'	=> 'cu.user_id = u.user_id',
				),
				'admin_user' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'	=> 'au',
						'on'	=> 'cu.user_id = au.user_id',
				)
		);
		
		parent::__construct();
	}
}

// end