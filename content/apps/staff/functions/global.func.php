<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 添加管理员记录日志操作对象
 */
function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_object('staff', RC_Lang::get('staff::staff.staff'));
	ecjia_admin_log::instance()->add_object('stafflog', RC_Lang::get('staff::staff.stafflog'));
	ecjia_admin_log::instance()->add_object('staff_profile', '个人资料');
	ecjia_admin_log::instance()->add_object('account_set', '个人账户');
	ecjia_admin_log::instance()->add_object('staff_group', '员工组');
}

//end