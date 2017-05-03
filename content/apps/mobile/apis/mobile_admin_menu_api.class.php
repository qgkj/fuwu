<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台移动应用
 * @author royalwang
 */
class mobile_admin_menu_api extends Component_Event_Api {

    public function call(&$options) {
        $menus = ecjia_admin::make_admin_menu('01_content', RC_Lang::get('mobile::mobile.mobile_app'), '', 1);
        
        $submenus = array(
            ecjia_admin::make_admin_menu('01_mobile_list', RC_Lang::get('mobile::mobile.shorcut'), RC_Uri::url('mobile/admin_shortcut/init'), 1)->add_purview('shortcut_manage'),
        	ecjia_admin::make_admin_menu('02_discover_list', RC_Lang::get('mobile::mobile.discover'), RC_Uri::url('mobile/admin_discover/init'), 2)->add_purview('discover_manage'),
        	ecjia_admin::make_admin_menu('03_device_list', RC_Lang::get('mobile::mobile.mobile_device'), RC_Uri::url('mobile/admin_device/init'), 3)->add_purview('device_manage'),
        	//ecjia_admin::make_admin_menu('04_mobile_news', RC_Lang::get('mobile::mobile.mobile_news'), RC_Uri::url('mobile/admin_mobile_news/init'), 4)->add_purview('mobile_news_manage'),
        	ecjia_admin::make_admin_menu('divider', '', '', 8)->add_purview(array('mobile_manage'), 8),
        	ecjia_admin::make_admin_menu('08_mobile_manage', RC_Lang::get('mobile::mobile.mobile_manage'), RC_Uri::url('mobile/admin_mobile_manage/init'), 9)->add_purview('mobile_manage')
        );
        
        $menus->add_submenu($submenus);
        
        return $menus;
    }
}

// end