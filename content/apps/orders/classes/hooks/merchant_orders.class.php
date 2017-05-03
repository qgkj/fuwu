<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class orders_merchant_plugin {
	
	public static function widget_admin_dashboard_orderslist() {

	}
	
	// 商城简报
	public static function widget_admin_dashboard_shopchart() {
	    $order_query = RC_Loader::load_app_class('merchant_order_query','orders');
		$db	= RC_Loader::load_app_model('order_info_viewmodel','orders');
		$db->view = array(
			'order_goods' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'on' 	=> 'oi.order_id = g.order_id '
			)
		);
		$db_order_viewmodel = RC_Loader::load_app_model('order_pay_viewmodel', 'orders');
		//TODO: 入驻商订单筛选条件
		$month_order = $db->where(array('oi.store_id' => $_SESSION['store_id'], 'oi.add_time' => array('gt' => RC_Time::gmtime() - 2592000)))->count('distinct oi.order_id');
        $new =RC_Time::gmtime();
        
		$order_money = $db_order_viewmodel->field('pl.order_amount')->where(array('oi.store_id' => $_SESSION['store_id'], 'oi.add_time' =>array('gt' => $new-3600*24*30,'lt' => $new), 'pl.is_paid' => 1))->group(array('oi.order_id'))->select();
		foreach($order_money as $val){
		    $num+=intval($val['order_amount']);
		}
        $order_unconfirmed = $db->field('oi.order_id')->where(array('oi.order_status' => 0, 'oi.store_id'  => $_SESSION['store_id'], 'oi.add_time' => array('gt'=> $new-3600*60*24, 'lt' => $new)))->group('oi.order_id')->select();
        $order_unconfirmed = count($order_unconfirmed);
        
        $order_await_ship = $db->field('oi.order_id')->where(array_merge($order_query->order_await_ship('oi.'), array('oi.store_id'  => $_SESSION['store_id'], 'oi.add_time' => array('gt'=> $new-3600*60*24, 'lt' => $new))))->group('oi.order_id')->select();;
        $order_await_ship = count($order_await_ship);
        
        ecjia_admin::$controller->assign('month_order', $month_order);
		ecjia_admin::$controller->assign('order_money', intval($num));
		ecjia_admin::$controller->assign('order_unconfirmed', $order_unconfirmed);
		ecjia_admin::$controller->assign('order_await_ship', $order_await_ship);
		
	    $title = __('商城简报');
	    
	    ecjia_admin::$controller->assign_lang();
		ecjia_admin::$controller->display(ecjia_app::get_app_template('library/widget_admin_dashboard_shopchart.lbi', 'orders'));
	}
	
	// 销售走势图
	public static function widget_admin_dashboard_salechart() {
	    $title = __('销售走势图');
        $db_order	= RC_Loader::load_app_model('order_info_viewmodel','orders');

        $now_time = RC_Time::gmtime()+28800;
        $start_time = $now_time - 2592000;
        $sale_arr = array();

        for($i = 30; $i>=0; $i--) {
            $tmp_time = $now_time - $i * 86400;
            $tmp_day = date('m-d',$tmp_time);
            $sale_arr[$tmp_day] = '0.00';
        }

        $where = array(
            'oi.store_id' => $_SESSION['store_id'],
            'oi.pay_status' => PS_PAYED,
            'oi.pay_time'   => array(
                'elt'   => $now_time,
                'gt'    => $start_time
            ),
        );

        $rs = $db_order->field('oi.order_id')->where($where)->select();
        $arr = array();
        foreach($rs as $value){
            if(empty($value['main_order_id'])){
                $arr[$value['order_id']]['order_id']        = $value['order_id']; // 主订单 和普通订单
            }else{
                $order[$value['order_id']]['order_id']      = $value['order_id'];
                $order[$value['order_id']]['main_order_id'] = $value['main_order_id']; // 子订单
            }
        }
        foreach ($order as $key => $val){
            unset($arr[$val['main_order_id']]); //删除主订单
            unset($order[$key]['main_order_id']);
        }
        $order = array_merge($order, $arr);
        $in['oi.order_id'] = array(0);
        if (!empty($order)) {
            foreach ($order as $val){
                $in['oi.order_id'][] = $val['order_id'];
            }
        }
        $orders = $db_order->field('count(oi.order_id) as numbers, sum(oi.money_paid) + sum(oi.surplus) as payed, FROM_UNIXTIME(oi.pay_time,"%m-%d")|date')->in($in)->group('date')->select();

        foreach($orders as $order) {
            $sale_arr[$order['date']] = $order['payed'];
        }
        $tmp_day = '';
        $tmp_price = '';
        foreach($sale_arr as $k => $v) {
            $tmp_day .= "'$k',";
            $tmp_price .= "$v,";
        }
        $tmp_day = rtrim($tmp_day, ',');
        $tmp_price = rtrim($tmp_price, ',');
        $sale_arr['day'] = $tmp_day;
        $sale_arr['price'] = $tmp_price;

        ecjia_admin::$controller->assign('sale_arr' , $sale_arr);


        ecjia_admin::$controller->assign_lang();
		ecjia_admin::$controller->display(ecjia_app::get_app_template('library/widget_admin_dashboard_salechart.lbi', 'orders'));
	}
	
	// 订单走势图
	public static function widget_admin_dashboard_orderschart() {
	    $title = __('订单走势图');
	    $db_order	= RC_Loader::load_app_model('order_info_viewmodel','orders');

        $now_time = RC_Time::gmtime()+28800;
        $start_time = $now_time - 2592000;
        $order_arr = array();

        for($i = 30; $i>=0; $i--) {
            $tmp_time = $now_time - $i * 86400;
            $tmp_day = date('m-d',$tmp_time);
            $order_arr[$tmp_day] = '0';
        }

        $where = array(
        	'oi.store_id' => $_SESSION['store_id'],
            'oi.pay_status' => PS_PAYED,
            'oi.pay_time'   => array(
                'elt'   => $now_time,
                'gt'    => $start_time
            ),
        );

        $rs = $db_order->field('oi.order_id')->where($where)->select();
        $arr = array();
	    foreach($rs as $value){
	        if(empty($value['main_order_id'])){
	            $arr[$value['order_id']]['order_id']        = $value['order_id']; // 主订单 和普通订单
	        }else{
	            $order[$value['order_id']]['order_id']      = $value['order_id'];
	            $order[$value['order_id']]['main_order_id'] = $value['main_order_id']; // 子订单
	        }
	    }
	    foreach ($order as $key => $val){
	        unset($arr[$val['main_order_id']]); //删除主订单
	        unset($order[$key]['main_order_id']);
	    }
	    $order = array_merge($order, $arr);
        $in['oi.order_id'] = array(0);
	    if (!empty($order)) {
            foreach ($order as $val){
                $in['oi.order_id'][] = $val['order_id'];
            }
        }
	    $orders = $db_order->field('count(oi.order_id) as numbers, sum(oi.money_paid) + sum(oi.surplus) as payed, FROM_UNIXTIME(oi.pay_time,"%m-%d")|date')->in($in)->group('date')->select();

        foreach($orders as $order) {
            $order_arr[$order['date']] = $order['numbers'];
        }
        $tmp_day = '';
        $tmp_price = '';
        foreach($order_arr as $k => $v) {
            $tmp_day .= "'$k',";
            $tmp_price .= "$v,";
        }
        $tmp_day = rtrim($tmp_day, ',');
        $tmp_price = rtrim($tmp_price, ',');
        $order_arr['day'] = $tmp_day;
        $order_arr['price'] = $tmp_price;

		ecjia_admin::$controller->assign('order_arr' , $order_arr);

	    ecjia_admin::$controller->assign_lang();
		ecjia_admin::$controller->display(ecjia_app::get_app_template('library/widget_admin_dashboard_orderschart.lbi', 'orders'));
	}
	
	// 订单统计信息
	public static function widget_admin_dashboard_ordersstat() {
		$result = ecjia_app::validate_application('payment');
		if (is_ecjia_error($result)) {
			return false;
		}
		 
		$title = __('订单统计信息');
		$order_query = RC_Loader::load_app_class('merchant_order_query','orders');
		
		$db	= RC_Loader::load_app_model('order_info_viewmodel','orders');
		$db_good_booking = RC_Loader::load_app_model('goods_booking_model','goods');
		$db_user_account = RC_Loader::load_app_model('user_account_model','user');
		
		$db->view = array(
			'order_goods' => array(
				'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'g',
				'on'	=> 'oi.order_id = g.order_id'
			)
		);
		/* 全部订单 */
		//TODO: 入驻商订单筛选条件
		$order['count']	= $db->where(array('oi.store_id' => $_SESSION['store_id']))->count('distinct oi.order_id');
		
		
		/* 已完成的订单 */
		$order['finished']		= $db->field('oi.order_id')->where(array_merge($order_query->order_finished('oi.'), array('oi.store_id'  => $_SESSION['store_id'])))->group('oi.order_id')->select();
		$order['finished'] 		= count($order['finished']);
		$status['finished']		= CS_FINISHED;
	   
		/* 待发货的订单： */
		$order['await_ship']	= $db->field('oi.order_id')->where(array_merge($order_query->order_await_ship('oi.'), array('oi.store_id'  => $_SESSION['store_id'])))->group('oi.order_id')->select();
		$order['await_ship'] 	= count($order['await_ship']);
		$status['await_ship']	= CS_AWAIT_SHIP;
		
		/* 待付款的订单： */
		$order['await_pay']		= $db->field('oi.order_id')->where(array_merge($order_query->order_await_pay('oi.'), array('oi.store_id'  => $_SESSION['store_id'])))->group('oi.order_id')->select();
		$order['await_pay'] 	= count($order['await_pay']);
		$status['await_pay']	= CS_AWAIT_PAY;
		
		/* “未确认”的订单 */
		$order['unconfirmed']	= $db->field('oi.order_id')->where(array_merge(array('oi.order_status' => 0),array('oi.store_id'  => $_SESSION['store_id'])))->group('oi.order_id')->select();
		$order['unconfirmed'] 	= count($order['unconfirmed']);
		$status['unconfirmed']	= OS_UNCONFIRMED;
		
		/* “部分发货”的订单 */
		$order['shipped_part']	= $db->field('oi.order_id')->where(array('oi.shipping_status'=> SS_SHIPPED_PART, 'oi.store_id' => $_SESSION['store_id']))->count('oi.order_id');
		$status['shipped_part'] = OS_SHIPPED_PART;
		
		ecjia_admin::$controller->assign('title'			, $title);
		ecjia_admin::$controller->assign('order'			, $order);
		ecjia_admin::$controller->assign('count'			, $order['count']);
		ecjia_admin::$controller->assign('status'			, $status);
		 
		ecjia_admin::$controller->assign_lang();
		ecjia_admin::$controller->display(ecjia_app::get_app_template('library/widget_admin_dashboard_ordersstat.lbi', 'orders'));
	}
	
	static public function orders_stats_admin_menu_api($menus) {
	    $menu = array(
	        ecjia_admin::make_admin_menu('guest_stats', __('客户统计'), RC_Uri::url('orders/admin_guest_stats/init'), 51)->add_purview('guest_stats'),
	        ecjia_admin::make_admin_menu('order_stats', __('订单统计'), RC_Uri::url('orders/admin_order_stats/init'), 52)->add_purview('order_stats'),
	        ecjia_admin::make_admin_menu('sale_general', __('销售概况'), RC_Uri::url('orders/admin_sale_general/init'), 53)->add_purview('sale_general_stats'),
	        ecjia_admin::make_admin_menu('users_order', __('会员排行'), RC_Uri::url('orders/admin_users_order/init'), 54)->add_purview('users_order_stats'),
	        ecjia_admin::make_admin_menu('sale_list', __('销售明细'), RC_Uri::url('orders/admin_sale_list/init'), 55)->add_purview('sale_list_stats'),
	        ecjia_admin::make_admin_menu('sale_order', __('销售排行'), RC_Uri::url('orders/admin_sale_order/init'), 56)->add_purview('sale_order_stats'),
	        ecjia_admin::make_admin_menu('visit_sold', __('访问购买率'), RC_Uri::url('orders/admin_visit_sold/init'), 57)->add_purview('visit_sold_stats'),
	        ecjia_admin::make_admin_menu('adsense', __('广告转化率'), RC_Uri::url('orders/admin_adsense/init'), 58)->add_purview('adsense_conversion_stats')
	    );
	    $menus->add_submenu($menu);
	    return $menus;
	}
	
}

RC_Hook::add_action('admin_dashboard_top', array('orders_merchant_plugin', 'widget_admin_dashboard_shopchart'), 21);
RC_Hook::add_action('admin_dashboard_left', array('orders_merchant_plugin', 'widget_admin_dashboard_orderschart'));
RC_Hook::add_action('admin_dashboard_left', array('orders_merchant_plugin', 'widget_admin_dashboard_ordersstat'), 11);
RC_Hook::add_action('admin_dashboard_right', array('orders_merchant_plugin', 'widget_admin_dashboard_salechart'));
RC_Hook::add_filter('stats_admin_menu_api', array('orders_merchant_plugin', 'orders_stats_admin_menu_api'));

// end