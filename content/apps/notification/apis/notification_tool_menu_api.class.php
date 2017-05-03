<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台工具菜单API
 * @author wutifang
 */
class notification_tool_menu_api extends Component_Event_Api {
	
	public function call(&$options) {	
		$menus = ecjia_admin::make_admin_menu('07_notification_list', '通知', RC_Uri::url('notification/admin/init'), 7)->add_purview('notification_manage');
		return $menus;
	}
}

// end