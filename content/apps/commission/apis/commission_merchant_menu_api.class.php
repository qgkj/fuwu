<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 商家结算菜单API
 * @author royalwang
 */
class commission_merchant_menu_api extends Component_Event_Api {
	
	public function call(&$options) {
	
		$menus = ecjia_merchant::make_admin_menu('07_commission', __('商家结算'), '', 7)->add_icon('fa-money')->add_purview(array('commission_manage','commission_order','commission_count'))->add_base('commission');
		
		$submenus = array(
			ecjia_merchant::make_admin_menu('01_commission_list', __('结算账单'), RC_Uri::url('commission/merchant/init'), 1)->add_purview()->add_icon('fa-money'), //order_view
			ecjia_merchant::make_admin_menu('02_commission_detail', __('订单分成'), RC_Uri::url('commission/merchant/record'), 2)->add_purview('commission_order')->add_icon('fa-list-alt'), // order_view
			ecjia_merchant::make_admin_menu('03_commission_count', __('结算统计'), RC_Uri::url('commission/merchant/count'), 3)->add_purview('commission_count')->add_icon('fa-bar-chart-o'), //order_os_edit
		);
		$menus->add_submenu($submenus);
		return $menus;
	}
}

// end