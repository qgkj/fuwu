<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class user_account_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'users';
		$this->table_alias_name = 'u';

		$this->view = array(
			'user_account' 	=> array(
                'type' 	    => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' 	=> 'ua',
                'field' 	=> 'u.user_name',
                'on'   	    => 'u.user_id = ua.user_id'				
			)
		);
		parent::__construct();
	}
}

// end