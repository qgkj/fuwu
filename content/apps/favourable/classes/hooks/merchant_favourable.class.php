<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class favourable_merchant_hook {
	
	static public function favourable_merchant_menu_api($menus) {
	    $menu = ecjia_merchant::make_admin_menu('08_favourable_list', __('优惠活动'), RC_Uri::url('favourable/merchant/init'), 8)->add_purview('favourable_manage')->add_icon('fa-table');
	    $menus->add_submenu($menu);
	    return $menus;
	}
}

RC_Hook::add_filter( 'promotion_merchant_menu_api', array('favourable_merchant_hook', 'favourable_merchant_menu_api') );

// end