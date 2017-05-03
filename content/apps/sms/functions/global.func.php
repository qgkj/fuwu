<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_object('sms_template', RC_Lang::get('sms::sms.sms_template'));
	ecjia_admin_log::instance()->add_object('sms_config', RC_Lang::get('sms::sms.sms_config'));
	ecjia_admin_log::instance()->add_object('sms_record', RC_Lang::get('sms::sms.sms_record'));

	ecjia_admin_log::instance()->add_action('batch_setup', RC_Lang::get('sms::sms.batch_setup'));
}
//end