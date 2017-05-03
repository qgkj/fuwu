<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台短信菜单API
 * @author songqian
 */
class sms_admin_menu_api extends Component_Event_Api {

    public function call(&$options) {
        $menus = ecjia_admin::make_admin_menu('10_content', RC_Lang::get('sms::sms.sms_manage'), '', 10);
        
        $submenus = array(
        	ecjia_admin::make_admin_menu('01_sms', RC_Lang::get('sms::sms.sms_record_list'), RC_Uri::url('sms/admin/init'), 1)->add_purview('sms_history_manage'),
        	ecjia_admin::make_admin_menu('divider', '', '', 2)->add_purview(array('sms_template_manage', 'sms_config_manage'), 2),
        	ecjia_admin::make_admin_menu('03_sms', RC_Lang::get('sms::sms.sms_template'), RC_Uri::url('sms/admin_template/init'), 3)->add_purview('sms_history_manage'),
        );
        
        $menus->add_submenu($submenus);
        
        return $menus;
    }
}

// end