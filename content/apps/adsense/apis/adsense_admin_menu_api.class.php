<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台广告菜单
 * @author songqian
 */
class adsense_admin_menu_api extends Component_Event_Api {
	public function call(&$options) {
		$menus = ecjia_admin::make_admin_menu('08_content', RC_Lang::get('adsense::adsense.ads_manage'), '', 8);
		$submenus = array(
			ecjia_admin::make_admin_menu('01_adsense_list', RC_Lang::get('adsense::adsense.ads_list'), RC_Uri::url('adsense/admin/init'), 1)->add_purview('adsense_manage'),
			ecjia_admin::make_admin_menu('02_adsense_position_list', RC_Lang::get('adsense::adsense.ads_position'), RC_Uri::url('adsense/admin_position/init'), 2)->add_purview('ad_position_manage') 
		);
		$menus->add_submenu($submenus);
		return $menus;
	}
}

// end