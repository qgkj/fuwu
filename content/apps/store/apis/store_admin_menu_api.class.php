<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台入驻商管理
 * @author songqian
 */
class store_admin_menu_api extends Component_Event_Api {

    public function call(&$options) {
        $menus = ecjia_admin::make_admin_menu('06_store', RC_Lang::get('store::store.store_manage'), '', 6);
        
        $submenus = array(
            ecjia_admin::make_admin_menu('01', RC_Lang::get('store::store.store_affiliate'), RC_Uri::url('store/admin/init'), 1)->add_purview('store_affiliate_manage'),
        	ecjia_admin::make_admin_menu('02', RC_Lang::get('store::store.preaudit'), RC_Uri::url('store/admin_preaudit/init'), 2)->add_purview('store_preaudit_manage'),
        	ecjia_admin::make_admin_menu('03', RC_Lang::get('store::store.category'), RC_Uri::url('store/admin_store_category/init'), 3)->add_purview('store_category_manage'),
        	ecjia_admin::make_admin_menu('05', RC_Lang::get('store::store.percent'), RC_Uri::url('store/admin_percent/init'), 5)->add_purview('store_percent_manage'),
//         	ecjia_admin::make_admin_menu('divider', '', '', 6)->add_purview('store_config_manage'),
//         	ecjia_admin::make_admin_menu('07', RC_Lang::get('store::store.config'), RC_Uri::url('store/admin_config/init'), 7)->add_purview('store_config_manage'),
        	//ecjia_admin::make_admin_menu('08', RC_Lang::get('store::store.mobileconfig'), RC_Uri::url('store/admin_mobileconfig/init'), 8)->add_purview('store_mobileconfig_manage'),
        );
        
        $menus->add_submenu($submenus);
        return $menus;
    }
}

// end