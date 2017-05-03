<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 后台会员菜单API
 * @author royalwang
 */
class user_admin_menu_api extends Component_Event_Api {	
	public function call(&$options) {
		$menus = ecjia_admin::make_admin_menu('05_members', RC_Lang::get('user::users.user_manage'), '', 5);
		$submenus = array(
				ecjia_admin::make_admin_menu('01_users_list', RC_Lang::get('user::users.user_list'), RC_Uri::url('user/admin/init'), 1)->add_purview('user_manage'),
				ecjia_admin::make_admin_menu('02_users_add', RC_Lang::get('user::users.user_add'), RC_Uri::url('user/admin/add'), 2)->add_purview('user_update'),
				ecjia_admin::make_admin_menu('03_user_rank_list', RC_Lang::get('user::users.user_rank'), RC_Uri::url('user/admin_rank/init'), 3)->add_purview('user_rank'),
				ecjia_admin::make_admin_menu('04_user_account', RC_Lang::get('user::users.surplus_reply'), RC_Uri::url('user/admin_account/init'), 4)->add_purview('surplus_manage'),
				ecjia_admin::make_admin_menu('05_user_account_manage', RC_Lang::get('user::users.account_manage'), RC_Uri::url('user/admin_account_manage/init'), 5)->add_purview('account_manage'),
				ecjia_admin::make_admin_menu('06_reg_fields', RC_Lang::get('user::users.reg_fields'), RC_Uri::url('user/admin_reg_fields/init'), 6)->add_purview('reg_fields'),
				ecjia_admin::make_admin_menu('divider', '', '', 7)->add_purview('integrate_users'),
				ecjia_admin::make_admin_menu('menu_user_integrate', RC_Lang::get('user::users.integrate_users'), RC_Uri::url('user/admin_integrate/init'), 8)->add_purview('integrate_users'),
		);
	
		$menus->add_submenu($submenus);
		return RC_Hook::apply_filters('user_admin_menu_api', $menus);;
	}
}

// end
