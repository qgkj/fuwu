<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 商家结算菜单API
 * @author royalwang
 */
class commission_admin_menu_api extends Component_Event_Api {
	
	public function call(&$options) {
	
		$menus = ecjia_admin::make_admin_menu('07_commission', __('商家结算'), '', 7);
		
		$submenus = array(
			ecjia_admin::make_admin_menu('01_commission_list', __('结算账单'), RC_Uri::url('commission/admin/init'), 1)->add_purview('commission_manage'), //order_view
		    ecjia_admin::make_admin_menu('02_commission_order_list', __('订单分成'), RC_Uri::url('commission/admin/order'), 2)->add_purview('commission_order'),
		);
		$menus->add_submenu($submenus);
		
		return $menus;
	}
}

// end