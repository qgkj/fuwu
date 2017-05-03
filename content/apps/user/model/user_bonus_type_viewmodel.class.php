<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class user_bonus_type_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view =array();
	public function __construct() {
		$this->table_name = 'user_bonus';
		$this->table_alias_name = 'ub';

		$this->view = array(
			'bonus_type' => array(
		   		'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			 	'alias'	=> 'bt',
			 	'on'   	=> 'ub.bonus_type_id = bt.type_id'				
			),
			'store_franchisee' => array(
		   		'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			 	'alias'	=> 's',
			 	'on'   	=> 'bt.store_id = s.store_id',				
			),
		);
		parent::__construct();
	}
}

// end