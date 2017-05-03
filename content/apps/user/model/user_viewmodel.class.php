<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class user_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'users';
		$this->table_alias_name = 'u';

		$this->view = array(
			'users' => array(
    			'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
    			'alias'		=> 'u2',
    			'field'		=> 'u.user_name, u.sex, u.birthday, u.pay_points, u.rank_points, u.user_rank , u.user_money, u.frozen_money, u.credit_line, u.parent_id, u2.user_name as parent_username, u.qq, u.msn, u.office_phone, u.home_phone, u.mobile_phone',
    			'on'		=> 'u.parent_id = u2.user_id'
		    )
		);
		parent::__construct();
	}
}

// end