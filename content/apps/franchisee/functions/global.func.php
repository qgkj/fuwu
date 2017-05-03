<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/*
 * 管理员操作对象和动作
*/
function assign_adminlog_content(){
	ecjia_admin_log::instance()->add_object('apply_franchisee', '申请入驻');
	ecjia_admin_log::instance()->add_action('cancel', '撤销');
}

//end