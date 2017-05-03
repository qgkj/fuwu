<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台工具菜单API
 * @author songqian
 */
class setting_setting_menu_api extends Component_Event_Api {
	
	public function call(&$options) {	
		$menus 	 = ecjia_admin::make_admin_menu('01_setting_manage', __('商店设置'), RC_Uri::url('setting/shop_config/init',array('code' => 'shop_info')), 1)->add_purview('shop_config');
		$mymenus = ecjia_admin::make_admin_menu('02_setting_area_manage', __('地区设置'), RC_Uri::url('setting/admin_area_manage/init'), 2)->add_purview('area_manage');
		
		return array($menus, $mymenus);;
	}
}

// end
