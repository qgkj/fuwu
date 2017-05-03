<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_admin_hooks {
   public static function append_admin_setting_group($menus) 
   {
       $menus[] = ecjia_admin::make_admin_menu('nav-header', '移动应用', '', 10)->add_purview(array('mobile_config_manage'));
       $menus[] = ecjia_admin::make_admin_menu('basic_info', 'APP基本信息', RC_Uri::url('mobile/admin_config/basic_info_init', array('code' => 'basic_info')), 6)->add_purview('mobile_config_manage');
       $menus[] = ecjia_admin::make_admin_menu('app_download_url', 'APP下载地址', RC_Uri::url('mobile/admin_config/app_download_url', array('code' => 'app_download_url')), 6)->add_purview('mobile_config_manage');
       $menus[] = ecjia_admin::make_admin_menu('app_screenshots', 'APP应用截图', RC_Uri::url('mobile/admin_config/app_screenshots', array('code' => 'app_screenshots')), 6)->add_purview('mobile_config_manage');
       $menus[] = ecjia_admin::make_admin_menu('mobile_adsense_set', '移动广告位设置', RC_Uri::url('mobile/admin_config/mobile_adsense_set', array('code' => 'mobile_adsense_set')), 6)->add_purview('mobile_config_manage');
       
       return $menus;
   }
    
}

RC_Hook::add_action( 'append_admin_setting_group', array('mobile_admin_hooks', 'append_admin_setting_group') );

// end