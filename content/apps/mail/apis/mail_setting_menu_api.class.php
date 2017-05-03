<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台工具菜单API
 * @author royalwang
 */
class mail_setting_menu_api extends Component_Event_Api {
	
	public function call(&$options) {	
		$menus = ecjia_admin::make_admin_menu('05_mail_setting', RC_Lang::get('mail::email_list.mail_template_settings'), RC_Uri::url('mail/admin_mail_settings/init'), 1)->add_purview('mail_settings_manage');
		return $menus;
	}
}

// end