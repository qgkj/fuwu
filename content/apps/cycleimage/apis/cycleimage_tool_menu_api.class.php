<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台工具菜单API
 * @author songqian
 */
class cycleimage_tool_menu_api extends Component_Event_Api {
	
	public function call(&$options) {	
		$menus = ecjia_admin::make_admin_menu('04_cycleimage_manage', RC_Lang::get('cycleimage::flashplay.cycle_image'), RC_Uri::url('cycleimage/admin/init'), 4)->add_purview('flash_manage');
		return $menus;
	}
}

// end