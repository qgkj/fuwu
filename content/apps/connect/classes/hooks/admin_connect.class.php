<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class connect_admin_plugin {
	
	static public function connect_admin_menu_api($menus) {
	    $menu = ecjia_admin::make_admin_menu('menu_user_connect', RC_Lang::get('connect::connect.connect'), RC_Uri::url('connect/admin/init'), 52)->add_purview('connect_users_manage');
	    $menus->add_submenu($menu);
	    return $menus;
	}
	
}

RC_Hook::add_filter( 'user_admin_menu_api', array('connect_admin_plugin', 'connect_admin_menu_api') );

ecjia_admin_log::instance()->add_object('connect', '帐号连接');

// end