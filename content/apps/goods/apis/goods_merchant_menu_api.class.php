<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia商家后台商品菜单API
 */
class goods_merchant_menu_api extends Component_Event_Api {
	public function call(&$options) {
		$menus = ecjia_merchant::make_admin_menu('03_cat_and_goods', __('商品管理'), '', 1)->add_icon('fa-gift')->add_purview(array('goods_manage','goods_update','goods_type','merchant_category_manage','goods_manage'))->add_base('goods');
		$submenus = array(
			ecjia_merchant::make_admin_menu('01_goods_list', __('商品列表'), RC_Uri::url('goods/merchant/init'), 1)->add_purview('goods_manage')->add_icon('fa-list-alt'), //array('goods_manage')
			ecjia_merchant::make_admin_menu('02_goods_add', __('添加新商品'), RC_Uri::url('goods/merchant/add'), 2)->add_purview('goods_update')->add_icon('fa-plus-square-o'), //array('goods_manage')
			ecjia_merchant::make_admin_menu('03_goods_type', __('商品类型'), RC_Uri::url('goods/mh_type/init'), 3)->add_purview('goods_type')->add_icon('fa-navicon'), //'attr_manage'
			ecjia_merchant::make_admin_menu('04_category_list', __('商品分类'), RC_Uri::url('goods/mh_category/init'), 4)->add_purview('merchant_category_manage')->add_icon('fa-th-list'), //array('cat_manage')
			ecjia_merchant::make_admin_menu('05_goods_trash', __('商品回收站'), RC_Uri::url('goods/merchant/trash'), 5)->add_purview('goods_manage')->add_icon('fa-recycle'), //array('goods_manage')
		);
        $menus->add_submenu($submenus);
        return $menus;
    }
}

// end