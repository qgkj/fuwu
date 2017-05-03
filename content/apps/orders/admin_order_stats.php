<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单统计
*/
class admin_order_stats extends ecjia_admin {
	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_func('global', 'orders');
		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('acharts-min', RC_App::apps_url('statics/js/acharts-min.js', __FILE__));
		RC_Script::enqueue_script('order_stats', RC_App::apps_url('statics/js/order_stats.js', __FILE__));
		RC_Script::enqueue_script('order_stats_chart', RC_App::apps_url('statics/js/order_stats_chart.js', __FILE__));
		RC_Style::enqueue_style('orders-css', RC_App::apps_url('statics/css/admin_orders.css', __FILE__));

		RC_Script::localize_script('order_stats', 'js_lang', RC_Lang::get('orders::statistic.js_lang'));
		RC_Script::localize_script('order_stats_chart', 'js_lang', RC_Lang::get('orders::statistic.js_lang'));
	}

	/**
	 * 订单统计
	 */
	public function init() {
		$this->admin_priv('order_stats');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::statistic.order_stats')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('orders::statistic.overview'),
			'content'	=> '<p>' . RC_Lang::get('orders::statistic.order_stats_help') . '</p>'
		));

		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('orders::statistic.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:订单统计#.E8.AE.A2.E5.8D.95.E6.A6.82.E5.86.B5" target="_blank">'. RC_Lang::get('orders::statistic.about_order_stats') .'</a>') . '</p>'
		);

		$this->assign('ur_here', RC_Lang::get('orders::statistic.order_stats'));
		$this->assign('action_link', array('text' => RC_Lang::get('orders::statistic.down_order_statistics'), 'href' => RC_Uri::url('orders/admin_order_stats/download')));

		//获取订单统计信息
		$order_stats = $this->get_order_stats();
		/* 时间参数 */
		$is_multi = empty($_GET['is_multi']) ? false : true;
		/* 时间参数 */
		$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : RC_Time::local_date(ecjia::config('date_format'),strtotime('-1 month')-8*3600);
		$end_date   = !empty($_GET['end_date'])   ? $_GET['end_date']   : RC_Time::local_date(ecjia::config('date_format'));

		$this->assign('start_date', $start_date);
		$this->assign('end_date', $end_date);

		$year_month = !empty($_GET['year_month']) ? $_GET['year_month'] : '';
		
		if (!empty($year_month)) {
			$filter	= explode('.', $year_month);
			$arr 	= array_filter($filter);
			$tmp 	= $arr;

			for ($i = 0; $i < count($tmp); $i++) {
				if (!empty($tmp[$i])) {
					$tmp_time 			= RC_Time::local_strtotime($tmp[$i] . '-1');
					$start_date_arr[$i]	= $tmp_time;
				}
			}
		} else {
			$start_date_arr[] 	= RC_Time::local_strtotime(RC_Time::local_date('Y-m') . '-1');
		}
		
		for ($i = 0; $i < 4; $i++) {
			if (isset($start_date_arr[$i])) {
				$start_date_arr[$i] = RC_Time::local_date('Y-m', $start_date_arr[$i]);
			} else {
				$start_date_arr[$i] = null;
			}
		}

		$this->assign('start_date_arr', $start_date_arr);
		$this->assign('order_stats', $order_stats);
		$this->assign('page', 'init');
		$this->assign('form_action', RC_Uri::url('orders/admin_order_stats/init'));

		$this->assign('is_multi', $is_multi);
		$this->assign('year_month', $year_month);

		$this->display('order_stats.dwt');
	}

	/**
	 * 配送方式
	 */
	public function shipping_status() {
		$this->admin_priv('order_stats');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::statistic.order_stats')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('orders::statistic.overview'),
			'content'	=> '<p>' . RC_Lang::get('orders::statistic.order_stats_help') . '</p>'
		));

		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('orders::statistic.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:订单统计#.E9.85.8D.E9.80.81.E6.96.B9.E5.BC.8F" target="_blank">'. RC_Lang::get('orders::statistic.about_order_stats') .'</a>') . '</p>'
		);

		$this->assign('ur_here', RC_Lang::get('orders::statistic.order_stats'));
		$this->assign('action_link', array('text' => RC_Lang::get('orders::statistic.down_order_statistics'), 'href' => RC_Uri::url('orders/admin_order_stats/download')));

		//获取订单统计信息
		$order_stats = $this->get_order_stats();

		/* 时间参数 */
		$is_multi = empty($_GET['is_multi']) ? false : true;

		/* 时间参数 */
		$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : RC_Time::local_date(ecjia::config('date_format'),strtotime('-1 month')-8*3600);
		$end_date   = !empty($_GET['end_date'])   ? $_GET['end_date']   : RC_Time::local_date(ecjia::config('date_format'));

		$this->assign('start_date', $start_date);
		$this->assign('end_date', $end_date);

		$year_month = !empty($_GET['year_month']) ? $_GET['year_month'] : '';

		if (!empty($year_month)) {
			$filter	= explode('.', $year_month);
			$arr 	= array_filter($filter);
			$tmp 	= $arr;
		
			for ($i = 0; $i < count($tmp); $i++) {
				if (!empty($tmp[$i])) {
					$tmp_time 			= RC_Time::local_strtotime($tmp[$i] . '-1');
					$start_date_arr[$i]	= $tmp_time;
				}
			}
		} else {
			$start_date_arr[] 	= RC_Time::local_strtotime(RC_Time::local_date('Y-m') . '-1');
		}
		
		for ($i = 0; $i < 4; $i++) {
			if (isset($start_date_arr[$i])) {
				$start_date_arr[$i] = RC_Time::local_date('Y-m', $start_date_arr[$i]);
			} else {
				$start_date_arr[$i] = null;
			}
		}

		$this->assign('start_date_arr', $start_date_arr);
		$this->assign('order_stats', $order_stats);

		$this->assign('is_multi', $is_multi);
		$this->assign('year_month', $year_month);
		$this->assign('page', 'shipping_status');
		$this->assign('form_action', RC_Uri::url('orders/admin_order_stats/shipping_status'));

		$this->display('order_stats.dwt');
	}

	/**
	 * 支付方式
	 */
	public function pay_status() {
		$this->admin_priv('order_stats');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::statistic.order_stats')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('orders::statistic.overview'),
			'content'	=> '<p>' . RC_Lang::get('orders::statistic.order_stats_help') . '</p>'
		));

		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('orders::statistic.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:订单统计#.E6.94.AF.E4.BB.98.E6.96.B9.E5.BC.8F" target="_blank">'. RC_Lang::get('orders::statistic.about_order_stats') .'</a>') . '</p>'
		);

		$this->assign('ur_here', RC_Lang::get('orders::statistic.order_stats'));
		$this->assign('action_link', array('text' => RC_Lang::get('orders::statistic.down_order_statistics'), 'href' => RC_Uri::url('orders/admin_order_stats/download')));

		//获取订单统计信息
		$order_stats = $this->get_order_stats();

		/* 时间参数 */
		$is_multi = empty($_GET['is_multi']) ? false : true;

		/* 时间参数 */
		$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : RC_Time::local_date('Y-m-d',RC_Time::local_strtotime('-1 month'));
		$end_date   = !empty($_GET['end_date'])   ? $_GET['end_date']   : RC_Time::local_date('Y-m-d');

		$this->assign('start_date', $start_date);
		$this->assign('end_date', $end_date);

		$year_month = !empty($_GET['year_month']) ? $_GET['year_month'] : '';

		if (!empty($year_month)) {
			$filter	= explode('.', $year_month);
			$arr 	= array_filter($filter);
			$tmp 	= $arr;

			for ($i = 0; $i < count($tmp); $i++) {
				if (!empty($tmp[$i])) {
					$tmp_time 			= RC_Time::local_strtotime($tmp[$i] . '-1');
					$start_date_arr[$i]	= $tmp_time;
				}
			}
		} else {
			$start_date_arr[] 	= RC_Time::local_strtotime(RC_Time::local_date('Y-m') . '-1');
		}
		
		for ($i = 0; $i < 4; $i++) {
			if (isset($start_date_arr[$i])) {
				$start_date_arr[$i] = RC_Time::local_date('Y-m', $start_date_arr[$i]);
			} else {
				$start_date_arr[$i] = null;
			}
		}

		$this->assign('start_date_arr', $start_date_arr);
		$this->assign('order_stats', $order_stats);
		$this->assign('page', 'pay_status');
		$this->assign('is_multi', $is_multi);
		$this->assign('year_month', $year_month);
		$this->assign('form_action', RC_Uri::url('orders/admin_order_stats/pay_status'));
		$this->assign_lang();

		$this->display('order_stats.dwt');
	}

	/**
	 * 获取订单走势数据
	 */
	public function get_order_general() {
		$is_multi = empty($_GET['is_multi']) ? false : true;
		if (!$is_multi) {
			/*时间参数*/
			$start_date = !empty($_GET['start_date']) ? RC_Time::local_strtotime($_GET['start_date']) : RC_Time::local_strtotime(RC_Time::local_date(ecjia::config('date_format')))-86400*7;
			$end_date   = !empty($_GET['end_date'])   ? RC_Time::local_strtotime($_GET['end_date'])   : RC_Time::local_strtotime(RC_Time::local_date(ecjia::config('date_format')))+86400;

			$order_info = $this->get_orderinfo($start_date, $end_date);
			if (!empty($order_info)) {
				foreach ($order_info as $k=>$v) {
					if ($k=='unconfirmed_num') {
						$key = RC_Lang::get('orders::statistic.unconfirmed_order');
						$order_info[$key] = $order_info['unconfirmed_num'];
						unset($order_info['unconfirmed_num']);

					} elseif ($k=='confirmed_num') {
						$key = RC_Lang::get('orders::statistic.confirmed_order');
						$order_info[$key] = $order_info['confirmed_num'];

					} elseif ($k =='succeed_num') {
						$key = RC_Lang::get('orders::statistic.succeed_order');
						$order_info[$key] = $order_info['succeed_num'];
						unset($order_info['succeed_num']);

					} elseif ($k =='invalid_num') {
						$key = RC_Lang::get('orders::statistic.invalid_order');
						$order_info[$key] = $order_info['invalid_num'];
						unset($order_info['invalid_num']);
					}
				}
				arsort($order_info);
				foreach ($order_info as $k=> $v) {
					if ($order_info[RC_Lang::get('orders::statistic.unconfirmed_order')] == 0 && $order_info[RC_Lang::get('orders::statistic.confirmed_order')] ==0
					&& $order_info[RC_Lang::get('orders::statistic.succeed_order')] ==0 && $order_info[RC_Lang::get('orders::statistic.invalid_order')] ==0 ) {
						$order_info = null;
					} else {
						break;
					}
				}
			}

			$order_infos = json_encode($order_info);
			echo $order_infos;
		}
	}

	/**
	 * 按年月获取订单走势数据
	 */
	public function get_order_status() {

		if (!empty($_GET['year_month'])) {
			$filter	= explode('.', $_GET['year_month']);
			$arr 	= array_filter($filter);
			$tmp 	= $arr;
			for ($i = 0; $i < count($tmp); $i++) {
				if (!empty($tmp[$i])) {
					$tmp_time 			= RC_Time::local_strtotime($tmp[$i].'-1');
					$start_date_arr[$i]	= $tmp_time;
					$end_date_arr[$i]   = RC_Time::local_strtotime($tmp[$i].'-31');
				}
			}
			$where = '';
			foreach ($start_date_arr as $key=>$val)  {
				$month = RC_Time::local_date('Y-m', $start_date_arr[$key]);
				$sta = $start_date_arr[$key];
				$end = $end_date_arr[$key];
				$order_info[$month] = $this->get_orderinfo($sta, $end);
			}
			foreach ($order_info as $k=>$v) {
				foreach ($v as $k1 => $v1) {
					if ($k1=='unconfirmed_num') {
						$key = RC_Lang::get('orders::statistic.unconfirmed_order');
						$arr1[$key][$k] = $v1;
						unset($arr1['unconfirmed_num']);

					} elseif ($k1=='confirmed_num') {
						$key = RC_Lang::get('orders::statistic.confirmed_order');
						$arr1[$key][$k] = $v1;
						unset($arr1['confirmed_num']);

					} elseif ($k1=='succeed_num') {
						$key = RC_Lang::get('orders::statistic.succeed_order');
						$arr1[$key][$k] = $v1;
						unset($arr1['succeed_num']);

					} elseif ($k1=='invalid_num') {
						$key = RC_Lang::get('orders::statistic.invalid_order');
						$arr1[$key][$k] = $v1;
						unset($arr1['invalid_num']);
					}
				}
			}
			arsort($arr1);
			$templateCounts = json_encode($arr1);
			echo $templateCounts;
		}
	}

	/**
	 * 获取配送方式数据
	 */
	public function get_ship_status() {
		$is_multi = empty($_GET['is_multi']) ? false : true;
		if (!$is_multi) {
			/*时间参数*/
			$start_date = !empty($_GET['start_date']) ? RC_Time::local_strtotime($_GET['start_date']) : RC_Time::local_strtotime(RC_Time::local_date('Y-m-d'))-86400*6;
			$end_date   = !empty($_GET['end_date'])   ? RC_Time::local_strtotime($_GET['end_date'])   : RC_Time::local_strtotime(RC_Time::local_date('Y-m-d'))+86400;
			$where =  "i.add_time >= '$start_date' AND i.add_time <= '$end_date'".order_query_sql('finished');

			$ship_info = RC_DB::table('shipping as sp')
				->leftJoin('order_info as i', RC_DB::raw('sp.shipping_id'), '=', RC_DB::raw('i.shipping_id'))
				->select(RC_DB::raw('sp.shipping_name AS ship_name, COUNT(i.order_id) AS order_num'))
				->whereRaw($where)
				->groupby(RC_DB::raw('i.shipping_id'))
				->orderby('order_num', 'desc')
				->get();

			if (!empty($ship_info)) {
				arsort($ship_info);
			} else {
				$ship_info = null;
			}
			$ship_infos = json_encode($ship_info);
			echo $ship_infos;
		}
	}

	/**
	 * 按月查询获取配送方式数据
	 */
	public function get_ship_stats() {
		if (!empty($_GET['year_month'])) {
			$filter	= explode('.', $_GET['year_month']);
			$arr 	= array_filter($filter);
			$tmp 	= $arr;

			for ($i = 0; $i < count($tmp); $i++) {
				if (!empty($tmp[$i])) {
					$tmp_time 			= RC_Time::local_strtotime($tmp[$i].'-1');
					$start_date_arr[$i]	= $tmp_time;
					$end_date_arr[$i]   = RC_Time::local_strtotime($tmp[$i].'-31');
				}
			}
			foreach ($start_date_arr as $key=>$val) {
				$where =  "i.add_time >= '$start_date_arr[$key]' AND i.add_time <= '$end_date_arr[$key]'".order_query_sql('finished');

				$ship_info[] = RC_DB::table('shipping as sp')
				->leftJoin('order_info as i', RC_DB::raw('sp.shipping_id'), '=', RC_DB::raw('i.shipping_id'))
				->select(RC_DB::raw('i.shipping_time, sp.shipping_name AS ship_name, COUNT(i.order_id) AS order_num'))
				->whereRaw($where)
				->groupby(RC_DB::raw('i.shipping_id'))
				->orderby('order_num', 'desc')
				->get();

			}

			$arr1 = array();
			if (!empty($ship_info)) {
				foreach ($ship_info as $k=>$v) {
					if (empty($v)) {
						unset($ship_info[$k]);
					}
				}
				foreach ($ship_info as $k=>$v) {
					foreach ($v as $k1=>$v1) {
						$arr1[$v1['ship_name']][RC_Time::local_date('Y-m',($v1['shipping_time']))] = $v1['order_num'];
						$v2[] = RC_Time::local_date('Y-m',($v1['shipping_time']));
					}
				}
				if (!empty($arr1)) {
					foreach ($arr1 as $k=>$v) {
						foreach (array_unique($v2) as $v1) {
							if (!array_key_exists($v1, $v)) {
								foreach ($v as $k1 => $v2) {
									$arr1[$k][$v1] = 0;
								}
							}
						}
					}
					array_multisort($arr1);
				}
			}
			if (empty($arr1)) {
				$arr1 = null;
			}
			$ship_infos = json_encode($arr1);
			echo $ship_infos;
		}
	}

	/**
	 * 获取支付方式数据
	 */
	public function get_pay_status() {
		$is_multi = empty($_GET['is_multi']) ? false : true;
		if (!$is_multi) {
			/*时间参数*/
			$start_date = !empty($_GET['start_date']) ? RC_Time::local_strtotime($_GET['start_date']) : RC_Time::local_strtotime(RC_Time::local_date('Y-m-d'))-86400*6;
			$end_date   = !empty($_GET['end_date'])   ? RC_Time::local_strtotime($_GET['end_date'])   : RC_Time::local_strtotime(RC_Time::local_date('Y-m-d'))+86400;

			$where = "i.add_time >= '$start_date' AND i.add_time <= '$end_date'". order_query_sql('finished');

			$pay_info = RC_DB::table('payment as p')
				->leftJoin('order_info as i', RC_DB::raw('p.pay_id'), '=', RC_DB::raw('i.pay_id'))
				->select(RC_DB::raw('i.pay_id, p.pay_name, COUNT(i.order_id) AS order_num'))
				->whereRaw($where)
				->groupby(RC_DB::raw('i.pay_id'))
				->orderby('order_num', 'desc')
				->get();

			if (!empty($pay_info)) {
				foreach ($pay_info as $key => $val) {
					unset($pay_info[$key]['pay_id']);
				}
				arsort($pay_info);
			} else {
				$pay_info = null;
			}
			$pay_infos = json_encode($pay_info);
			echo $pay_infos;
		}
	}

	/**
	 * 按月查询获取支付方式数据
	 */
	public function get_pay_stats() {
		if (!empty($_GET['year_month'])) {
			$filter	= explode('.', $_GET['year_month']);
			$arr 	= array_filter($filter);
			$tmp 	= $arr;

			for ($i = 0; $i < count($tmp); $i++) {
				if (!empty($tmp[$i])) {
					$start_date_arr[$i]	= RC_Time::local_strtotime($tmp[$i].'-1');
					$end_date_arr[$i]   = RC_Time::local_strtotime('+1 month', $start_date_arr[$i]) - 1;
				}
			}
			foreach ($start_date_arr as $key=>$val) {
				$where = "p.pay_id = i.pay_id AND (i.order_status = '" .OS_CONFIRMED. "' or i.order_status = '" .OS_SPLITED. "') AND i.pay_status > '" .PS_UNPAYED. "' AND i.shipping_status > '" .SS_UNSHIPPED. "' "."AND i.add_time >= '$start_date_arr[$key]' AND i.add_time <= '$end_date_arr[$key]'";

				$pay_stats[] = RC_DB::table('payment as p')
					->leftJoin('order_info as i', RC_DB::raw('p.pay_id'), '=', RC_DB::raw('i.pay_id'))
					->select(RC_DB::raw('i.pay_id, p.pay_name, i.pay_time, COUNT(i.order_id) AS order_num'))
					->whereRaw($where)
					->groupby(RC_DB::raw('i.pay_id'))
					->orderby('order_num', 'desc')
					->get();
			}

			$arr1 = array();
			if (!empty($pay_stats)) {
				foreach ($pay_stats as $k=>$v) {
					if (empty($v)) {
						unset($pay_stats[$k]);
					}
				}
				foreach ($pay_stats as $k=>$v) {
					foreach ($v as $k1=>$v1) {
						$arr1[$v1['pay_name']][RC_Time::local_date('Y-m', $v1['pay_time'])] = $v1['order_num'];
					}
				}
				array_multisort($arr1);
			}
			if (empty($arr1)) {
				$arr1 = null;
			}
			$pay_stat = json_encode($arr1);
			echo $pay_stat;
		}
	}

	/**
	 * 报表下载
	 */
	public function download() {
		/* 判断权限 */
		$this->admin_priv('order_stats', ecjia::MSGTYPE_JSON);

		/* 时间参数 */
		$start_date = RC_Time::local_strtotime($_GET['start_date']);
		$end_date = RC_Time::local_strtotime($_GET['end_date']);
        $filename = RC_Lang::get('orders::statistic.order_statement');
        if(!empty($start_date) && !empty($end_date)){
            $filename .= '_'.$_GET['start_date'].'至'.$_GET['end_date'];
        }

		/*文件名*/
		$filename = mb_convert_encoding($filename, "GBK", "UTF-8");
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=$filename.xls");

		/* 订单概况 */
		$order_info = $this->get_orderinfo($start_date, $end_date);

		$data = RC_Lang::get('orders::statistic.order_circs') . "\n";
		$data .= RC_Lang::get('orders::statistic.confirmed') ."\t". RC_Lang::get('orders::statistic.succeed') ."\t". RC_Lang::get('orders::statistic.unconfirmed') ."\t". RC_Lang::get('orders::statistic.invalid')."\n";
		$data .= $order_info['confirmed_num']."\t". $order_info['succeed_num'] ."\t". $order_info['unconfirmed_num'] ."\t". $order_info['invalid_num']."\n";
		$data .= "\n".RC_Lang::get('orders::statistic.pay_method')."\n";

		/* 支付方式 */
		$where = "i.add_time >= '$start_date' AND i.add_time <= '$end_date'".order_query_sql('finished');

		$pay_res = RC_DB::table('payment as p')
			->leftJoin('order_info as i', RC_DB::raw('p.pay_id'), '=', RC_DB::raw('i.pay_id'))
			->select(RC_DB::raw('i.pay_id, p.pay_name, COUNT(i.order_id) AS order_num'))
			->whereRaw($where)
			->groupby(RC_DB::raw('i.pay_id'))
			->orderby('order_num', 'desc')
			->get();

		if (!empty($pay_res)) {
			foreach ($pay_res AS $val) {
				$data .= $val['pay_name'] . "\t";
			}
		}
		$data .= "\n";
		if (!empty($pay_res)) {
			foreach ($pay_res AS $val) {
				$data .= $val['order_num'] . "\t";
			}
		}
		/* 配送方式 */
		$where = 'i.add_time >= '.$start_date.' AND i.add_time <= '.$end_date.''.order_query_sql('finished') ;

		$ship_res = RC_DB::table('shipping as sp')
			->leftJoin('order_info as i', RC_DB::raw('sp.shipping_id'), '=', RC_DB::raw('i.shipping_id'))
			->select(RC_DB::raw('sp.shipping_id, sp.shipping_name AS ship_name, COUNT(i.order_id) AS order_num'))
			->whereRaw($where)
			->groupby(RC_DB::raw('i.shipping_id'))
			->orderby('order_num', 'desc')
			->get();

		$data .= "\n".RC_Lang::get('orders::statistic.shipping_method')."\n";
		if (!empty($ship_res)) {
			foreach ($ship_res AS $val) {
				$data .= $val['ship_name']."\t";
			}
		}
		$data .= "\n";
		if (!empty($ship_res)) {
			foreach ($ship_res AS $val) {
				$data .= $val['order_num']."\t";
			}
		}
		echo mb_convert_encoding($data."\t","GBK","UTF-8")."\t";
		exit;
	}

	/**
	  * 取得订单概况数据(包括订单的几种状态)
	  * @param       $start_date    开始查询的日期
	  * @param       $end_date      查询的结束日期
	  * @return      $order_info    订单概况数据
	  */
	 private function get_orderinfo($start_date, $end_date) {
	 	$order_info = array();
	    /* 未确认订单数 */
	 	$order_info['unconfirmed_num'] = RC_DB::table('order_info')
	 		->select(RC_DB::raw('COUNT(*) AS unconfirmed_num'))
	 		->whereRaw("order_status = '" .OS_UNCONFIRMED. "' AND add_time >= '$start_date' AND add_time < '" . ($end_date + 86400) . "' ")
	 		->where('is_delete', 0)
	 		->count();

	 	/* 已确认订单数 */
	 	$order_info['confirmed_num'] = RC_DB::table('order_info')
		 	->select(RC_DB::raw('COUNT(*) AS confirmed_num'))
		 	->whereRaw("order_status = '" .OS_CONFIRMED. "' AND shipping_status != ".SS_SHIPPED." && shipping_status != ".SS_RECEIVED." AND pay_status != ".PS_PAYED." && pay_status != ".PS_PAYING." AND add_time >= '$start_date' AND add_time < '" . ($end_date + 86400) . "'")
		 	->where('is_delete', 0)
	 		->count();

	    /* 已成交订单数 */
		$order_info['succeed_num'] = RC_DB::table('order_info')
			->select(RC_DB::raw('COUNT(*) AS succeed_num'))
			->whereRaw(" 1 AND add_time >= '$start_date' AND add_time < '" . ($end_date + 86400) . "' ". order_query_sql('finished'))
			->where('is_delete', 0)
			->count();

	    /* 无效或已取消订单数 */
	    $order_info['invalid_num'] = RC_DB::table('order_info')
		    ->select(RC_DB::raw('COUNT(*) AS invalid_num'))
		    ->whereRaw("order_status IN ('" .OS_CANCELED.  "','" .OS_INVALID.  "','" .OS_RETURNED.  "') AND add_time >= '$start_date' AND add_time < '" . ($end_date + 86400) . "' ")
		    ->where('is_delete', 0)
	    	->count();

	    return $order_info;
	 }

	 /**
	  * 获取订单统计信息信息
	  * @return	$arr 订单统计信息
	  */
	 private function get_order_stats() {
	 	$arr = array();
	 	/* 随机的颜色数组 */
	 	$color_array = array('33FF66', 'FF6600', '3399FF', '009966', 'CC3399', 'FFCC33', '6699CC', 'CC3366');

	 	/* 计算订单各种费用之和的语句 */
	 	$total_fee = " SUM(" . order_amount_field() . ") AS total_turnover ";

	 	/* 取得订单转化率数据 */
	 	$order_general = RC_DB::table('order_info')->select(RC_DB::raw('COUNT(*) AS total_order_num , '.$total_fee.''))
	 		->whereRaw('1' . order_query_sql('finished'). ' AND is_delete = 0')->first();

	 	$order_general['total_turnover'] = floatval($order_general['total_turnover']);

	 	/* 取得商品总点击数量 */
	 	$click_count = RC_DB::table('goods')->where('is_delete', 0)->sum('click_count');
	 	$click_count = floatval($click_count);

	 	/* 每千个点击的订单数 */
	 	$click_ordernum = $click_count > 0 ? round(($order_general['total_order_num'] * 1000)/$click_count,2) : 0;

	 	/* 每千个点击的购物额 */
	 	$click_turnover = $click_count > 0 ? round(($order_general['total_turnover'] * 1000)/$click_count,2) : 0;

	 	/* 时区 */
	 	$timezone = isset($_SESSION['timezone']) ? $_SESSION['timezone'] : '';

	 	$arr = array(
	 		'total_turnover'	=> price_format($order_general['total_turnover']),
	 		'click_count'		=> $click_count,
	 		'click_ordernum'	=> $click_ordernum,
	 		'click_turnover'	=> price_format($click_turnover)
	 	);
	 	return $arr;
	 }
}

// end