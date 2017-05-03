<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class shopguide_merchant_hook {
	
	static public function shopguide_merchant_menu_api($menus) {
	    $menu = array(
	    	ecjia_merchant::make_admin_menu('divider', '', '', 4)->add_purview('shopguide_setup'),
	    	ecjia_merchant::make_admin_menu('03_shop_guide', __('店铺向导'), RC_Uri::url('shopguide/merchant/init'), 5)->add_purview('shopguide_setup')->add_icon('fa-paper-plane'),
	    );
	    $menus->add_submenu($menu);
	    return $menus;
	}
}

RC_Hook::add_filter( 'merchant_merchant_menu_api', array('shopguide_merchant_hook', 'shopguide_merchant_menu_api') );

// end