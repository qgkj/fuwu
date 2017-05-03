<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class bonus_admin_plugin {
	
	static public function bonus_admin_menu_api($menus) {
	    $menu = ecjia_admin::make_admin_menu('02_bonustype_list', RC_Lang::get('bonus::bonus.bonus_manage'), RC_Uri::url('bonus/admin/init'), 2)->add_purview('bonus_type_manage');
	    $menus->add_submenu($menu);
	    return $menus;
	}
}

RC_Hook::add_filter( 'promotion_admin_menu_api', array('bonus_admin_plugin', 'bonus_admin_menu_api') );

// end