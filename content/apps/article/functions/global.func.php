<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 添加管理员记录日志操作对象
 */
function assign_adminlog_contents() {
	ecjia_admin_log::instance()->add_object('article_auto', RC_Lang::get('article::article.article_auto_release'));

	ecjia_admin_log::instance()->add_action('batch_setup', RC_Lang::get('article::article.batch_setup'));
	ecjia_admin_log::instance()->add_action('batch_start', RC_Lang::get('article::article.button_start'));
	ecjia_admin_log::instance()->add_action('batch_end', RC_Lang::get('article::article.button_end'));
	ecjia_admin_log::instance()->add_action('cancel', RC_Lang::get('article::article.delete'));
}

//end