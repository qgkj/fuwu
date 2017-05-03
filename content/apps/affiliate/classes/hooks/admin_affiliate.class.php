<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class affiliate_admin_hooks {
	
	public static function append_admin_setting_group($menus) {
		$menus[] = ecjia_admin::make_admin_menu('nav-header', '推荐好友', '', 40)->add_purview(array('affiliate_config_manage'));
		$menus[] = ecjia_admin::make_admin_menu('affiliate', '推荐邀请设置', RC_Uri::url('affiliate/admin_config/init'), 41)->add_purview('affiliate_config_manage');
		return $menus;
	}
}

RC_Hook::add_action( 'append_admin_setting_group', array('affiliate_admin_hooks', 'append_admin_setting_group') );

// end