<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台菜单API
 * @author wutifang
 */
class affiliate_admin_menu_api extends Component_Event_Api {
	
	public function call(&$options) {
		$menus = ecjia_admin::make_admin_menu('11_affiliate', RC_Lang::get('affiliate::affiliate.affiliate_manage'), '', 11);
		
		$submenus = array(
			ecjia_admin::make_admin_menu('affiliate', RC_Lang::get('affiliate::affiliate.affiliate_percent'), RC_Uri::url('affiliate/admin/init'), 1)->add_purview('affiliate_percent_manage'),
			ecjia_admin::make_admin_menu('affiliate_ck', RC_Lang::get('affiliate::affiliate.sharing_management'), RC_Uri::url('affiliate/admin_separate/init'), 2)->add_purview('affiliate_ck_manage')
		);
		$menus->add_submenu($submenus);
		return $menus;
	}
}

// end