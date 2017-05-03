<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class store_admin_hooks {
	
	static public function store_admin_menu_api($menus) {
		$menu = ecjia_admin::make_admin_menu('06_notice_list', '商家公告', RC_Uri::url('store/admin_notice/init'), 7)->add_purview('notice_manage');
	    $menus->add_submenu($menu);
	    return $menus;
	}
	
	public static function append_admin_setting_group($menus)
	{
	    $setting = ecjia_admin_setting::singleton();
	     
	    $menus[] = ecjia_admin::make_admin_menu('nav-header', '入驻商', '', 20)->add_purview(array('mobile_config_manage'));
	    $menus[] = ecjia_admin::make_admin_menu('store', '商家后台设置', RC_Uri::url('store/admin_config/init'), 21)->add_purview('store_config_manage');
	     
	    return $menus;
	}
}

RC_Hook::add_filter( 'article_admin_menu_api', array('store_admin_hooks', 'store_admin_menu_api') );
RC_Hook::add_action( 'append_admin_setting_group', array('store_admin_hooks', 'append_admin_setting_group') );

// end