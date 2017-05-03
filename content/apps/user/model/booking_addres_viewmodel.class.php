<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class booking_addres_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view = array();
	public function __construct() {
		$this->table_name 		= 'user_address';
		$this->table_alias_name = 'ua';
		
		$this->view = array(
		    'users' => array(
    			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
    			'alias'	=> 'u',
    			'on'   	=> 'u.address_id = ua.address_id AND u.user_id = "$_SESSION[user_id]"'
				)
		);
		parent::__construct();
	}
}

// end