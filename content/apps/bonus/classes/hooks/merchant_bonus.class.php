<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class bonus_merchant_hook {
	
	static public function bonus_merchant_menu_api($menus) {
	    $menu = ecjia_merchant::make_admin_menu('02_bonustype_list', __('红包类型'), RC_Uri::url('bonus/merchant/init'), 2)->add_purview('bonus_type_manage')->add_icon('fa-table');
	    $menus->add_submenu($menu);
	    return $menus;
	}
}

RC_Hook::add_filter( 'promotion_merchant_menu_api', array('bonus_merchant_hook', 'bonus_merchant_menu_api') );

// end