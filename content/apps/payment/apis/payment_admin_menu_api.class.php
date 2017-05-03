<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台菜单API
 * @author royalwang
 */
class payment_admin_menu_api extends Component_Event_Api {
	
	public function call(&$options) {	
		$menus = ecjia_admin::make_admin_menu('15_payment_manage', '支付管理', '', 15);
		$submenus = array(
			ecjia_admin::make_admin_menu('01_payment_list', RC_Lang::get('payment::payment.payment'), RC_Uri::url('payment/admin/init'), 1)->add_purview('payment_manage'),
			ecjia_admin::make_admin_menu('payment_record', RC_Lang::get('payment::payment.transaction_flow_record'), RC_Uri::url('payment/admin_payment_record/init'), 2)->add_purview(array('payment_manage')),
		);
		
        $menus->add_submenu($submenus);
        return $menus;
	}
}

// end