<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台菜单API
 * @author royalwang
 */
class shipping_admin_menu_api extends Component_Event_Api {
	public function call(&$options) {
		$menus = ecjia_admin::make_admin_menu('16_shipping_manage', '配送方式', '', 16);
		$submenus = array(
				ecjia_admin::make_admin_menu('01_shipping_list', RC_Lang::get('shipping::shipping.shipping'), RC_Uri::url('shipping/admin/init'), 1)->add_purview('ship_manage'),
				ecjia_admin::make_admin_menu('02_express_order_list', RC_Lang::get('shipping::shipping.express_order_list'), RC_Uri::url('shipping/admin_express_order/init'), 2)->add_purview(array('ship_manage')),
		);
	
		$menus->add_submenu($submenus);
		return $menus;
	}
}

// end