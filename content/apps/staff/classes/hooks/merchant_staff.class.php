<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class merchant_staff_hooks {
	//店铺信息
	public static function merchant_dashboard_information() {
		RC_Loader::load_app_func('merchant', 'merchant');
		$merchant_info = get_merchant_info();
		ecjia_admin::$controller->assign('merchant_info', $merchant_info);

		ecjia_merchant::$controller->display(
			RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_information.lbi', true)
		);
	}

	//订单统计
	public static function merchant_dashboard_left_8_1() {
		//当前时间戳
		$now = RC_Time::gmtime();

		//本月开始时间
		$start_month = mktime(0,0,0,date('m'),1,date('Y'))-8*3600;

		RC_Loader::load_app_class('merchant_order_list', 'orders', false);
		$order = new merchant_order_list();
		
		$order_money = RC_DB::table('order_info as o')
			->leftJoin('order_goods as og', RC_DB::raw('o.order_id'), '=', RC_DB::raw('og.order_id'))
			->selectRaw("(" . $order->order_amount_field('o.') . ") AS order_amount")
			->where(RC_DB::raw('o.store_id'), $_SESSION['store_id'])
			->where(RC_DB::raw('o.add_time'), '>=', $start_month)
			->where(RC_DB::raw('o.add_time'), '<=', $now)
			->where(RC_DB::raw('o.is_delete'), 0)
			->groupBy(RC_DB::raw('o.order_id'))
			->get();

		//本月订单总额
		$num = 0;
		if (!empty($order_money)) {
			foreach($order_money as $val){
				$num += $val['order_amount'];
			}
			$num = price_format($num);
		}

		//本月订单数量
		$order_number = RC_DB::table('order_info')
			->where('store_id', $_SESSION['store_id'])
			->where('add_time', '>=', $start_month)
			->where('is_delete', 0)
			->count(RC_DB::raw('distinct order_id'));

		//今日开始时间
		$start_time = mktime(0,0,0,date('m'),date('d'),date('Y'))-8*3600;

		//今日待确认订单
		$order_unconfirmed = RC_DB::table('order_info as oi')
			->leftJoin('order_goods as g', RC_DB::raw('oi.order_id'), '=', RC_DB::raw('g.order_id'))
			->select(RC_DB::raw('oi.order_id'))
			->where(RC_DB::raw('oi.store_id'), $_SESSION['store_id'])->where(RC_DB::raw('oi.order_status'), 0)
			->where(RC_DB::raw('oi.add_time'), '>=', $start_time)->where(RC_DB::raw('oi.add_time'), '<=', $now)
			->where(RC_DB::raw('oi.is_delete'), 0)
			->groupBy(RC_DB::raw('oi.order_id'))->get();
		$order_unconfirmed = count($order_unconfirmed);

		$db_order_info = RC_DB::table('order_info as o');

		$payment_method = RC_Loader::load_app_class('payment_method','payment');
		$payment_id_row = $payment_method->payment_id_list(true);
		$payment_id = "";
		foreach ($payment_id_row as $v) {
			$payment_id .= empty($payment_id) ? $v : ','.$v ;
		}
		$payment_id = empty($payment_id) ? "''" : $payment_id;

		$db_order_info->whereIn(RC_DB::raw($alias.'order_status'), array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART));
		$db_order_info->whereIn(RC_DB::raw($alias.'shipping_status'), array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING));
		$db_order_info->whereRaw("( {$alias}pay_status in (" . PS_PAYED .",". PS_PAYING.") OR {$alias}pay_id in (" . $payment_id . "))");

		//今日待发货订单
		$order_await_ship = $db_order_info
			->leftJoin('order_goods as g', RC_DB::raw('o.order_id'), '=', RC_DB::raw('g.order_id'))
			->select(RC_DB::raw('o.order_id'))
			->where(RC_DB::raw('o.store_id'), $_SESSION['store_id'])->where(RC_DB::raw('o.order_status'), 0)
			->where(RC_DB::raw('o.add_time'), '>=', $start_time)->where(RC_DB::raw('o.add_time'), '<=', $now)
			->where(RC_DB::raw('o.is_delete'), 0)
			->groupBy(RC_DB::raw('o.order_id'))->get();
		$order_await_ship = count($order_await_ship);

		ecjia_admin::$controller->assign('order_money', 		$num);
		ecjia_admin::$controller->assign('order_number', 		$order_number);
		ecjia_admin::$controller->assign('order_unconfirmed',	$order_unconfirmed);
		ecjia_admin::$controller->assign('order_await_ship',	$order_await_ship);

		ecjia_admin::$controller->assign('month_start_time', RC_Time::local_date('Y-m-d', $start_month));	//本月开始时间
		ecjia_admin::$controller->assign('month_end_time', RC_Time::local_date('Y-m-d', $now));				//本月结束时间

		ecjia_admin::$controller->assign('today_start_time', RC_Time::local_date('Y-m-d H:i:s', $start_time));				//今天开始时间
		ecjia_admin::$controller->assign('today_end_time', RC_Time::local_date('Y-m-d H:i:s', $start_time+24*3600-1));		//今天结束时间
		ecjia_admin::$controller->assign('wait_ship', CS_AWAIT_SHIP);		//待发货
		ecjia_admin::$controller->assign('unconfirmed', OS_UNCONFIRMED);	//待确认

		ecjia_merchant::$controller->display(
		    RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_overview.lbi', true)
		);
	}

	//个人信息
	public static function merchant_dashboard_right_4_1() {
		$user_info = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->first();
		$user_info['add_time']		= RC_Time::local_date(ecjia::config('time_format'), $user_info['add_time']);
		$user_info['last_login']	= RC_Time::local_date('Y-m-d H:i', $user_info['last_login']);
		
		ecjia_admin::$controller->assign('user_info', $user_info);
		ecjia_merchant::$controller->display(
			RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_profile.lbi', true)
		);
	}

	//订单走势图
	public static function merchant_dashboard_left_8_2() {
		if (!isset($_SESSION['store_id']) || $_SESSION['store_id'] === '') {
			$count_list = array();
		} else {
			$cache_key = 'order_bar_chart_'.md5($_SESSION['store_id']);
			$count_list = RC_Cache::app_cache_get($cache_key, 'order');

			if (!$count_list) {
				$format = '%Y-%m-%d';
				$time = (mktime(0,0,0,date('m'),date('d'),date('Y'))-1)-8*3600;
				$start_time = $time - 30*86400;
				$store_id = $_SESSION['store_id'];

				$where = "add_time > '$start_time' AND add_time <= '$time' AND store_id = $store_id AND is_delete = 0";

				$list = RC_DB::table('order_info')
					->selectRaw("FROM_UNIXTIME(add_time+8*3600, '". $format ."') AS day, count('order_id') AS count")
					->whereRaw($where)
					->groupby('day')
					->get();

				$days = $data = $count_list = array();

				for ($i=30; $i>0; $i--) {
					$days[] = date("Y-m-d", strtotime(' -'. $i . 'day'));
				}

				$max_count = 100;
				if (!empty($list)) {
					foreach ($list as $k => $v) {
						$data[$v['day']] = $v['count'];
					}
				}

				foreach ($days as $k => $v) {
					if (!array_key_exists($v, $data)) {
						$count_list[$v] = 0;
					} else {
						$count_list[$v] = $data[$v];
					}
				}

				$tmp_day = '';
				$tmp_count = '';
				foreach($count_list as $k => $v) {
					$k = intval(date('d', strtotime($k)));
					$tmp_day .= "'$k',";
					$tmp_count .= "$v,";
				}

				$tmp_day = rtrim($tmp_day, ',');
				$tmp_count = rtrim($tmp_count, ',');
				$count_list['day'] = $tmp_day;
				$count_list['count'] = $tmp_count;

				RC_Cache::app_cache_set($cache_key, $count_list, 'order', 60*24);//24小时缓存
			}
		}
		ecjia_merchant::$controller->assign('order_arr', $count_list);
	    ecjia_merchant::$controller->display(
	        RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_bar_chart.lbi', true)
	    );
    }

	//商家公告
	public static function merchant_dashboard_right_4_2() {
		$list = RC_DB::table('article as a')
 			->leftJoin('article_cat as ac', RC_DB::raw('a.cat_id'), '=', RC_DB::raw('ac.cat_id'))
 			->orderBy(RC_DB::raw('a.add_time'), 'desc')
 			->take(5)
 			->where(RC_DB::raw('ac.cat_type'), 6)
 			->get();
		if (!empty($list)) {
			foreach ($list as $k => $v) {
				if (!empty($v['add_time'])) {
					$list[$k]['add_time'] = RC_Time::local_date('m-d', $v['add_time']);
				}
			}
		}
		ecjia_merchant::$controller->assign('list', $list);
		ecjia_merchant::$controller->display(
			RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_notice.lbi', true)
		);
	}


	//操作日志
	public static function merchant_dashboard_right_4_3() {
		if (!ecjia_merchant::$controller->admin_priv('staff_log_manage', ecjia::MSGTYPE_HTML, false)) {
			return false;
		}
		$key = 'staff_log'.$_SESSION['store_id'];
	    $data = RC_Cache::app_cache_get($key, 'staff');
	    if (!$data) {
	        $data = RC_DB::table('staff_log')
	        ->leftJoin('staff_user', 'staff_log.user_id', '=', 'staff_user.user_id')
	        ->select('staff_log.*', 'staff_user.name')
	        ->where('staff_log.store_id', $_SESSION['store_id'])
	        ->orderBy('log_id', 'desc')
	        ->take(5)
	        ->get();
	        RC_Cache::app_cache_set($key, $data, 'staff', 30);
	    }
	    ecjia_admin::$controller->assign('log_lists'  , $data);

		ecjia_merchant::$controller->display(
			RC_Package::package('app::staff')->loadTemplate('merchant/library/widget_merchant_dashboard_loglist.lbi', true)
		);
	}

	public static function set_admin_login_logo() {
		$logo_img = ecjia::config('merchant_admin_login_logo') ? RC_Upload::upload_url() . '/' . ecjia::config('merchant_admin_login_logo') : ecjia_merchant::$controller->get_main_static_url(). '/img/seller_admin_logo.png';
		if ($logo_img) {
			$logo = '<img width="230" height="50" src="' . $logo_img . '" />';
		}
		return $logo;
	}
}

RC_Hook::add_action('merchant_dashboard_top', array('merchant_staff_hooks', 'merchant_dashboard_information'));

RC_Hook::add_action('merchant_dashboard_left8', array('merchant_staff_hooks', 'merchant_dashboard_left_8_1'));
RC_Hook::add_action('merchant_dashboard_left8', array('merchant_staff_hooks', 'merchant_dashboard_left_8_2'));

RC_Hook::add_action('merchant_dashboard_right4', array('merchant_staff_hooks', 'merchant_dashboard_right_4_1'), 1);
RC_Hook::add_action('merchant_dashboard_right4', array('merchant_staff_hooks', 'merchant_dashboard_right_4_2'),3);
RC_Hook::add_action('merchant_dashboard_right4', array('merchant_staff_hooks', 'merchant_dashboard_right_4_3'), 4);

RC_Hook::add_action('ecjia_admin_logo_display', array('merchant_staff_hooks', 'set_admin_login_logo'));

// end
