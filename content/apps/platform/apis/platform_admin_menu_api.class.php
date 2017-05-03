<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台公众平台
 * @author royalwang
 */
class platform_admin_menu_api extends Component_Event_Api
{

    public function call(&$options)
    {
        $menus = ecjia_admin::make_admin_menu('15_content', RC_Lang::get('platform::package.platform'), '', 17);
        
        $submenus = array(
        	ecjia_admin::make_admin_menu('01_platform', RC_Lang::get('platform::platform.platform_num_manage'), RC_Uri::url('platform/admin/init'), 1)->add_purview('platform_config_manage'),
        	ecjia_admin::make_admin_menu('02_platform', RC_Lang::get('platform::platform.function_extension'), RC_Uri::url('platform/admin_extend/init'), 2)->add_purview('platform_extend_manage'),
        	ecjia_admin::make_admin_menu('03_platform', RC_Lang::get('platform::platform.about_oracle'), RC_Uri::url('platform/admin_command/search'), 3)->add_purview('platform_command_manage'),
        );
        
        $menus->add_submenu($submenus);
        return $menus;
    }
}

// end