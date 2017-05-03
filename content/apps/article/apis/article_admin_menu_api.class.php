<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台文章菜单API
 * @author songqian
 */
class article_admin_menu_api extends Component_Event_Api {

    public function call(&$options) {
        $menus = ecjia_admin::make_admin_menu('09_content', RC_Lang::get('article::article.article_manage'), '', 9);
        
        $submenus = array(
            ecjia_admin::make_admin_menu('01_article_list', RC_Lang::get('article::article.article_list'), RC_Uri::url('article/admin/init'), 1)->add_purview('article_manage'),
        	ecjia_admin::make_admin_menu('02_article_add', RC_Lang::get('article::article.add_article'), RC_Uri::url('article/admin/add'), 2)->add_purview('article_update'),
            ecjia_admin::make_admin_menu('03_articlecat_list', RC_Lang::get('article::article.cat'), RC_Uri::url('article/admin_articlecat/init'), 3)->add_purview('article_cat_manage'),

        	ecjia_admin::make_admin_menu('divider', '', '', 4)->add_purview(array('shophelp_manage', 'shopinfo_manage', 'store_notice_manage')),
            ecjia_admin::make_admin_menu('05_article_help', RC_Lang::get('article::article.shop_help'), RC_Uri::url('article/admin_shophelp/init'), 5)->add_purview('shophelp_manage'),
            ecjia_admin::make_admin_menu('06_article_info', RC_Lang::get('article::article.shop_info'), RC_Uri::url('article/admin_shopinfo/init'), 6)->add_purview('shopinfo_manage'),
        	ecjia_admin::make_admin_menu('divider', '', '', 7)->add_purview(array('article_auto_manage')),
        	ecjia_admin::make_admin_menu('08_article_info', __('文章自动发布'), RC_Uri::url('article/admin_article_auto/init'), 8)->add_purview('article_auto_manage'),
        );
        
        $menus->add_submenu($submenus);
        $menus = RC_Hook::apply_filters('article_admin_menu_api', $menus);
        
		if ($menus->has_submenus()) {
		    return $menus;
		}
		return false;
    }
}

// end