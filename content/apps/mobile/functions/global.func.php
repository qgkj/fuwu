<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
* 添加管理员记录日志操作对象
*/
function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_object('mobile_shortcut', RC_Lang::get('mobile::mobile.shortcut'));
	ecjia_admin_log::instance()->add_object('mobile_shortcut_display', RC_Lang::get('mobile::mobile.mobile_shortcut_display'));
	ecjia_admin_log::instance()->add_object('mobile_shortcut_sort', RC_Lang::get('mobile::mobile.mobile_shortcut_sort'));
	
	ecjia_admin_log::instance()->add_object('mobile_discover', RC_Lang::get('mobile::mobile.discover'));
	ecjia_admin_log::instance()->add_object('mobile_discover_display', RC_Lang::get('mobile::mobile.mobile_discover_display'));
	ecjia_admin_log::instance()->add_object('mobile_discover_sort', RC_Lang::get('mobile::mobile.mobile_discover_sort'));
	
	ecjia_admin_log::instance()->add_object('mobile_device', RC_Lang::get('mobile::mobile.mobile_device'));
	
	ecjia_admin_log::instance()->add_object('mobile_cycleimage', RC_Lang::get('mobile::mobile.cycleimage'));
	ecjia_admin_log::instance()->add_object('mobile_config', RC_Lang::get('mobile::mobile.mobile_config'));
	ecjia_admin_log::instance()->add_object('mobile_news', RC_Lang::get('mobile::mobile.mobile_news'));
	ecjia_admin_log::instance()->add_object('mobile_manage', RC_Lang::get('mobile::mobile.mobile_app_manage'));
	ecjia_admin_log::instance()->add_object('mobile_toutiao', RC_Lang::get('mobile::mobile.mobile_headline'));
	ecjia_admin_log::instance()->add_object('mobile_activity', RC_Lang::get('mobile::mobile.activity'));
}

//end