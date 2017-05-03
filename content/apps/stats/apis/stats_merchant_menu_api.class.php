<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台菜单API
 * @author huangyuyuan
 */
class stats_merchant_menu_api extends Component_Event_Api {
	
	public function call(&$options) {

		$menus = ecjia_merchant::make_admin_menu('13_stats',__('报表统计'), '', 4)->add_icon('fa-bar-chart-o')->add_purview(array('stats_search_keywords','order_stats','sale_general_stats','sale_list_stats','sale_order_stats'))->add_base('stats');
		
		$submenus = array(
            ecjia_merchant::make_admin_menu('01_keywords_stats',__('搜索关键字'), RC_Uri::url('stats/mh_keywords_stats/init'), 1)->add_purview('stats_search_keywords')->add_icon('fa-search'), //'flow_stats'
            ecjia_merchant::make_admin_menu('02_order_stats',__('订单统计'), RC_Uri::url('orders/mh_order_stats/init'), 2)->add_purview('order_stats')->add_icon('fa-bar-chart-o')->add_base('stats'), //'flow_stats'
		    ecjia_merchant::make_admin_menu('03_sale_general',__('销售概况'), RC_Uri::url('orders/mh_sale_general/init'), 3)->add_purview('sale_general_stats')->add_icon('fa-bar-chart-o')->add_base('stats'), //'flow_stats'
		    ecjia_merchant::make_admin_menu('04_sale_list',__('销售明细'), RC_Uri::url('orders/mh_sale_list/init'), 4)->add_purview('sale_list_stats')->add_icon('fa-list')->add_base('stats'), //'flow_stats'
		    ecjia_merchant::make_admin_menu('05_sale_order',__('销售排行'), RC_Uri::url('orders/mh_sale_order/init'), 5)->add_purview('sale_order_stats')->add_icon('fa-trophy')->add_base('stats'), //'flow_stats'
		);
        $menus->add_submenu($submenus);
		
        return $menus;
	}
}

// end