<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_object('config','配置');
	ecjia_admin_log::instance()->add_object('message_template','消息模板');
	ecjia_admin_log::instance()->add_object('push_evnet', '消息事件');
}

//end