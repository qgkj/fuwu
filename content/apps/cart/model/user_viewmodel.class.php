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
			),
			'user_bonus' => array(
				'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'		=> 'ub',
				'on'		=> 'ub.user_id = u.user_id AND ub.used_time = 0'
			),
			'bonus_type' => array(
				'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'		=> 'b',
				'on'		=> "b.type_id = ub.bonus_type_id AND b.use_start_date <= '".RC_Time::gmtime()."' AND b.use_end_date >= '".RC_Time::gmtime()."'"
			),
			'user_address' => array(
				'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'		=> 'ua',
				'on'		=> "ua.address_id = u.address_id"
			)
		);
		parent::__construct();
	}
}

// end