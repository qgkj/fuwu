<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_object('email', RC_Lang::get('mail::email_list.email'));
	ecjia_admin_log::instance()->add_object('subscription_email', RC_Lang::get('mail::email_list.subscription_email'));
	ecjia_admin_log::instance()->add_object('email_template', RC_Lang::get('mail::email_list.mail_template'));

	ecjia_admin_log::instance()->add_action('batch_send', RC_Lang::get('mail::email_list.batch_send'));
	ecjia_admin_log::instance()->add_action('all_send', RC_Lang::get('mail::email_list.all_send'));
	
	ecjia_admin_log::instance()->add_action('batch_exit', RC_Lang::get('mail::email_list.batch_exit'));
	ecjia_admin_log::instance()->add_action('batch_ok', RC_Lang::get('mail::email_list.batch_ok'));
	
	ecjia_admin_log::instance()->add_action('batch_setup', RC_Lang::get('mail::email_list.batch_setup'));
}
	
//end