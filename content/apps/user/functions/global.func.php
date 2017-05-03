<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
* 添加管理员记录日志操作对象
*/
function assign_adminlog() {
	ecjia_admin_log::instance()->add_object('usermoney', RC_Lang::get('user::users.usermoney'));
	ecjia_admin_log::instance()->add_object('user_account', RC_Lang::get('user::users.user_account'));

	ecjia_admin_log::instance()->add_object('withdraw_apply', RC_Lang::get('user::user_account.withdraw_apply'));
	ecjia_admin_log::instance()->add_object('pay_apply', RC_Lang::get('user::user_account.pay_apply'));
	
	ecjia_admin_log::instance()->add_action('check', RC_Lang::get('user::users.check'));
}
	
//end