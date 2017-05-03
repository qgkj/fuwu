<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class sms_admin_hooks {
	
   public static function append_admin_setting_group($menus) {
       $setting = ecjia_admin_setting::singleton();
       
       $menus[] = ecjia_admin::make_admin_menu('nav-header', '短信', '', 10)->add_purview(array('shop_config'));
       $menus[] = ecjia_admin::make_admin_menu('sms', $setting->cfg_name_langs('sms'), RC_Uri::url('sms/admin_config/init'), 6)->add_purview('shop_config')->add_icon('fontello-icon-chat-empty');
       
       return $menus;
   }
    
}

RC_Hook::add_action( 'append_admin_setting_group', array('sms_admin_hooks', 'append_admin_setting_group') );

// end