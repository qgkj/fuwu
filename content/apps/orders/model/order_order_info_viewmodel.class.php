<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class order_order_info_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'order_info';
		$this->table_alias_name = 'o';
		
		 $this->view = array(
    		'users' => array(
    			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
    			'alias'	=> 'u',
    			'field' => 'o.order_sn,u.user_name',
    			'on'    => 'o.user_id = u.user_id ',
    		) 	
    	);	
		parent::__construct();
	}
}

// end