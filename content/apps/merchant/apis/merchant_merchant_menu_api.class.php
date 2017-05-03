<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商家员工管理菜单
 * @author songqian
 */
class merchant_merchant_menu_api extends Component_Event_Api {

    public function call(&$options) {
        $menus = ecjia_merchant::make_admin_menu('staff', '仪表盘', RC_Uri::url('merchant/dashboard/init'), 0)->add_icon('fa-dashboard')->add_base('dashboard');

        $mymenus = ecjia_merchant::make_admin_menu('14_merchant', __('我的店铺'), '', 10)->add_icon('fa-home')->add_base('store')->add_purview(array('merchant_manage', 'franchisee_manage', 'bank_manage', 'shopguide_manage'));
        $submenus = array(
            ecjia_merchant::make_admin_menu('01_merchant_setinfo', __('店铺设置'), RC_Uri::url('merchant/merchant/init'), 1)->add_purview('merchant_manage')->add_icon('fa-gears'), //'merchant_info'
            ecjia_merchant::make_admin_menu('02_merchant_showcase', __('入驻信息'), RC_Uri::url('merchant/mh_franchisee/init'), 2)->add_purview('franchisee_manage')->add_icon('fa-info-circle'), //'enter_info'
        	ecjia_merchant::make_admin_menu('03_merchant_Receipt', __('收款账号'), RC_Uri::url('merchant/mh_franchisee/receipt'), 3)->add_purview('bank_manage')->add_icon('fa-credit-card'), //'enter_info'
            ecjia_merchant::make_admin_menu('04_merchant_Receipt', __('店铺上下线'), RC_Uri::url('merchant/merchant/mh_switch'), 4)->add_purview('merchant_switch')->add_icon('fa-power-off'), 
        );
        
        $mymenus->add_submenu($submenus);
        $mymenus = RC_Hook::apply_filters('merchant_merchant_menu_api', $mymenus);
        
        if ($mymenus->has_submenus()) {
        	return array($menus, $mymenus);
        }
        return false;
    }
}

// end