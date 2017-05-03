<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 添加管理员记录日志操作对象
 */
function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_object('affiliate', RC_Lang::get('affiliate::affiliate.affiliate'));
	ecjia_admin_log::instance()->add_object('config', RC_Lang::get('affiliate::affiliate.config'));

	ecjia_admin_log::instance()->add_action('do', RC_Lang::get('affiliate::affiliate.do'));
	ecjia_admin_log::instance()->add_action('cancel', RC_Lang::get('affiliate::affiliate.cancel'));
	ecjia_admin_log::instance()->add_action('rollback', RC_Lang::get('affiliate::affiliate.rollback'));
}

//end