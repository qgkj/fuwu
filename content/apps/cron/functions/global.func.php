<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_action('enable', RC_Lang::get('cron::cron.enable'));
	ecjia_admin_log::instance()->add_action('disable', RC_Lang::get('cron::cron.disable'));
	ecjia_admin_log::instance()->add_action('run', RC_Lang::get('cron::cron.cron_do'));
	ecjia_admin_log::instance()->add_object('cron', RC_Lang::get('cron::cron.cron'));
}

//end