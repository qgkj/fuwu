<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class admin_touch_hooks {
	
   public static function append_admin_setting_group($menus) 
   {
       $setting = ecjia_admin_setting::singleton();
       
       $menus[] = ecjia_admin::make_admin_menu('nav-header', 'H5应用', '', 10)->add_purview(array('mobile_config_manage', 'mobile_manage'));
       $menus[] = ecjia_admin::make_admin_menu('wap', $setting->cfg_name_langs('wap'), RC_Uri::url('setting/shop_config/init', array('code' => 'wap')), 11)->add_purview('shop_config')->add_icon('fontello-icon-tablet');
       
       return $menus;
   }
   
   public static function goods_admin_priview_handler($goods_id)
   {
       $url = RC_Uri::url('goods/index/show', array('goods_id' => $goods_id));
       $url = str_replace(RC_Uri::site_url(), RC_Uri::home_url().'/sites/m', $url) ;
       ecjia_admin::$controller->redirect($url);
   }
}

RC_Hook::add_action( 'append_admin_setting_group', array('admin_touch_hooks', 'append_admin_setting_group') );
RC_Hook::add_action( 'goods_admin_priview_handler', array('admin_touch_hooks', 'goods_admin_priview_handler') );

// end