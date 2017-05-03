<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商家员工管理菜单
 * @author songqian
 */
class shipping_merchant_menu_api extends Component_Event_Api {

    public function call(&$options) {
        $menus = ecjia_merchant::make_admin_menu('shipping', '配送管理', '', 9)->add_purview('ship_merchant_manage')->add_icon('fa-truck')->add_base('shipping');

        
        $submenus = array(
        		ecjia_merchant::make_admin_menu('shipping_list', __('我的配送'), RC_Uri::url('shipping/merchant/init'), 1)->add_purview('ship_merchant_manage')->add_icon('fa-truck'), 
        		ecjia_merchant::make_admin_menu('express_list', __('配送信息'), RC_Uri::url('express/merchant/init'), 2)->add_purview('ship_merchant_manage')->add_icon('fa-inbox'), 
        		
        );
        
        $menus->add_submenu($submenus);
        return $menus;
    }
}

// end