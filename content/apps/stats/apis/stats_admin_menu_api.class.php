<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台菜单API
 * @author wutifang
 */
class stats_admin_menu_api extends Component_Event_Api {
	
	public function call(&$options) {
		$menus = ecjia_admin::make_admin_menu('13_stats', RC_Lang::get('stats::flow_stats.report_statistics'), '', 13);
		
		$submenus = array(
			ecjia_admin::make_admin_menu('01_keywords_stats', RC_Lang::get('stats::statistic.search_keywords'), RC_Uri::url('stats/admin_keywords_stats/init'), 1)->add_purview('keywords_stats'),
		);
        $menus->add_submenu($submenus);
		
        $menus = RC_Hook::apply_filters('stats_admin_menu_api', $menus);
		
        if ($menus->has_submenus()) {
            return $menus;
        }
        return false;
	}
}

// end