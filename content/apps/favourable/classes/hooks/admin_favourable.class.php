<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class favourable_admin_plugin {
	
	static public function favourable_admin_menu_api($menus) {
	    $menu = ecjia_admin::make_admin_menu('08_favourable_list', RC_Lang::get('favourable::favourable.favourable'), RC_Uri::url('favourable/admin/init'), 8)->add_purview('favourable_manage');
	    $menus->add_submenu($menu);
	    return $menus;
	}
}

RC_Hook::add_filter( 'promotion_admin_menu_api', array('favourable_admin_plugin', 'favourable_admin_menu_api') );

// end