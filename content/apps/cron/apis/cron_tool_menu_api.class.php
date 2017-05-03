<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台工具菜单API
 * @author royalwang
 */
class cron_tool_menu_api extends Component_Event_Api {
	
	public function call(&$options) {	
		$menus = ecjia_admin::make_admin_menu('03_cron_list', RC_Lang::get('cron::cron.cron'), RC_Uri::url('cron/admin/init'), 3)->add_purview('cron_manage');
		return $menus;
	}
}

// end