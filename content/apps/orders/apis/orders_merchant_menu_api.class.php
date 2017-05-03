<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 后台订单菜单API
 * @author royalwang
 */
class orders_merchant_menu_api extends Component_Event_Api {
	
	public function call(&$options) {	
		$menus = ecjia_merchant::make_admin_menu('04_order', __('订单管理'), '', 2)->add_icon('fa-list')->add_purview(array('order_view','order_os_edit','delivery_view','back_view','remind_order_view'))->add_base('order');
		$submenus = array(
			ecjia_merchant::make_admin_menu('02_order_list', __('订单列表'), RC_Uri::url('orders/merchant/init'), 1)->add_purview('order_view')->add_icon('fa-list-alt'),
			ecjia_merchant::make_admin_menu('03_order_query', __('订单查询'), RC_Uri::url('orders/merchant/order_query'), 2)->add_purview('order_view')->add_icon('fa-list-ul'),
			ecjia_merchant::make_admin_menu('04_merge_order', __('合并订单'), RC_Uri::url('orders/merchant/merge'), 3)->add_purview('order_os_edit')->add_icon('fa-columns'),
			ecjia_merchant::make_admin_menu('09_delivery_order', __('发货单列表'), RC_Uri::url('orders/mh_delivery/init'), 6)->add_purview('delivery_view')->add_icon('fa-check-square'),
			ecjia_merchant::make_admin_menu('10_back_order', __('退货单列表'), RC_Uri::url('orders/mh_back/init'), 7)->add_purview('back_view')->add_icon('fa-undo'),
		    ecjia_merchant::make_admin_menu('11_back_order', __('催单提醒'), RC_Uri::url('orders/mh_reminder/init'), 7)->add_purview('remind_order_view')->add_icon('fa-file-o'),
		);
		$menus->add_submenu($submenus);
		
		return $menus;
	}
}

// end