<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class user_account_user_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'user_account';
		$this->table_alias_name = 'ua';

		$this->view = array(
			'users' => array(
				'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'		=> 'u',
				'field'		=> 'ua.*, u.user_name',
				'on'		=> 'ua.user_id = u.user_id'
			)
		);
		parent::__construct();
	}
}

// end