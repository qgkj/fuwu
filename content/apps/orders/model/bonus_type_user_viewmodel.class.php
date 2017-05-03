<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class bonus_type_user_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name 		= 'bonus_type';
		$this->table_alias_name	= 'bt';
		
		 $this->view = array(
    		'user_bonus' => array(
    			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
    			'alias' => 'ub',
    			'on'    => 'bt.type_id = ub.bonus_type_id ',
    		)
    );	
		parent::__construct();
	}
}

// end