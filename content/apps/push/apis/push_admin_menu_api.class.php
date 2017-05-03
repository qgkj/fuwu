<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台文章菜单API
 * @author royalwang
 */
class push_admin_menu_api extends Component_Event_Api {

    public function call(&$options) {
        $menus = ecjia_admin::make_admin_menu('11_content', RC_Lang::get('push::push.push_msg'), '', 11);
        
        $submenus = array(
        	ecjia_admin::make_admin_menu('01_push_message', RC_Lang::get('push::push.msg_record'), RC_Uri::url('push/admin/init'), 1)->add_purview('push_history_manage'),
        	ecjia_admin::make_admin_menu('02_push_event', RC_Lang::get('push::push.msg_event'), RC_Uri::url('push/admin_event/init'), 2)->add_purview('push_event_manage'),
        	ecjia_admin::make_admin_menu('divider', '', '', 3)->add_purview(array('push_template_manage')),
        	ecjia_admin::make_admin_menu('03_push_template', RC_Lang::get('push::push.msg_template'), RC_Uri::url('push/admin_template/init'), 4)->add_purview('push_template_manage'),
//         	ecjia_admin::make_admin_menu('04_push_config', RC_Lang::get('push::push.msg_config'), RC_Uri::url('push/admin_config/init'),5)->add_purview('push_config_manage')
        		
//         	ecjia_admin::make_admin_menu('01_push', RC_Lang::get('push::push.send_msg'), RC_Uri::url('push/admin/push_add'), 1)->add_purview('push_message'),
//         	ecjia_admin::make_admin_menu('02_push', RC_Lang::get('push::push.msg_record'), RC_Uri::url('push/admin/init'), 2)->add_purview('push_history_manage'),
//         	ecjia_admin::make_admin_menu('divider', '', '', 3)->add_purview(array('push_config_manage','push_template_manage'), 10),
//         	ecjia_admin::make_admin_menu('03_push', RC_Lang::get('push::push.msg_template'), RC_Uri::url('push/admin_template/init'), 4)->add_purview('push_template_manage'),
//         	ecjia_admin::make_admin_menu('04_push', RC_Lang::get('push::push.msg_config'), RC_Uri::url('push/admin_config/init'), 5)->add_purview('push_config_manage')
        );
        
        $menus->add_submenu($submenus);
        
        return $menus;
    }
}

// end