<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台菜单API
 * @author songqian
 */
class mail_admin_menu_api extends Component_Event_Api {
	
	public function call(&$options) {

		$menus = ecjia_admin::make_admin_menu('14_email_manage', RC_Lang::get('mail::email_list.email_manage'), '', 14);
		
		$submenus = array(
		    ecjia_admin::make_admin_menu('email_list', RC_Lang::get('mail::email_list.email_list'), RC_Uri::url('mail/admin_email_list/init'), 2)->add_purview('email_list_manage'),
		    ecjia_admin::make_admin_menu('view_sendlist', RC_Lang::get('mail::email_list.email_send_list'), RC_Uri::url('mail/admin_view_sendlist/init'), 4)->add_purview('email_sendlist_manage'),
		    ecjia_admin::make_admin_menu('divider', '', '', 7)->add_purview('mail_template_manage', 10),
		    ecjia_admin::make_admin_menu('mail_template', RC_Lang::get('mail::email_list.mail_template'), RC_Uri::url('mail/admin/init'), 11)->add_purview('mail_template_manage'),
		);
		
		$menus->add_submenu($submenus);
		
		return $menus;
	}
}

// end