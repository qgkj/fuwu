<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 添加管理员记录日志操作对象
 */
function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_object('promotion', RC_Lang::get('promotion::promotion.promotion'));
}

//end