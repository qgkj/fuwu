<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台工具菜单API
 * @author royalwang
 */
class captcha_setting_menu_api extends Component_Event_Api {
	
	public function call(&$options) {	
		$menus = ecjia_admin::make_admin_menu('05_captcha_setting', RC_Lang::get('captcha::captcha_manage.captcha_manage'), RC_Uri::url('captcha/admin/init'), 5)->add_purview('shop_config');
		return $menus;
	}
}

// end