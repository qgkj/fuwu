<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class push_admin_hooks {
	
   public static function append_admin_setting_group($menus) {
       $setting = ecjia_admin_setting::singleton();
       
       $menus[] = ecjia_admin::make_admin_menu('nav-header', 'APP推送', '', 10)->add_purview(array('push_config_manage'));
       $menus[] = ecjia_admin::make_admin_menu('push', '推送配置', RC_Uri::url('push/admin_config/init'), 6)->add_purview('push_config_manage');
       
       return $menus;
   }
    
}

RC_Hook::add_action( 'append_admin_setting_group', array('push_admin_hooks', 'append_admin_setting_group') );

// end