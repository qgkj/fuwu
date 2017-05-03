<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

	function assign_adminlog_content() {
		ecjia_admin_log::instance()->add_object('platform_extend', RC_Lang::get('platform::platform.function_extension'));
		ecjia_admin_log::instance()->add_object('wechat', RC_Lang::get('platform::platform.platform_num'));
		ecjia_admin_log::instance()->add_object('platform_logo', RC_Lang::get('platform::platform.platform_num_log'));
		
		ecjia_admin_log::instance()->add_object('platform_extend_command', RC_Lang::get('platform::platform.function_extension_command'));
		ecjia_admin_log::instance()->add_object('wechat_extend', RC_Lang::get('platform::platform.platform_extension'));
		
		ecjia_admin_log::instance()->add_action('batch_insert', RC_Lang::get('platform::platform.bulk_add'));
		
		ecjia_admin_log::instance()->add_object('platform', RC_Lang::get('platform::platform.platform_plug'));
	}
	
//end