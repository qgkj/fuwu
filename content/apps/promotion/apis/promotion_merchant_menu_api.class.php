<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台促销菜单API
 * @author royalwang
 */
class promotion_merchant_menu_api extends Component_Event_Api {
	
	public function call(&$options) {	
		$menus = ecjia_merchant::make_admin_menu('03_promotion', __('促销管理'), '', 3)->add_icon('fa-heart')->add_purview(array('promotion_manage','bonus_type_manage','favourable_manage'))->add_base('promotion');
		$submenus = array(
			ecjia_merchant::make_admin_menu('01_promotion_manage', __('促销商品'), RC_Uri::url('promotion/merchant/init'), 1)->add_purview('promotion_manage')->add_icon('fa-table'), //'promotion_manage'
		);
		
		$menus->add_submenu($submenus);
		$menus = RC_Hook::apply_filters('promotion_merchant_menu_api', $menus);
		
		if ($menus->has_submenus()) {
		    return $menus;
		}
		return false;
	}
}

// end