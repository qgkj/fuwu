<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单统计
*/
class mh_order_stats extends ecjia_merchant {
	private $db_order_info;
	private $db_goods;
	private $db_payment_view;
	private $db_shipping_view;
	private $db_orderinfo_view;

	public function __construct() {
		parent::__construct();
		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
				
		/*加载自定义js*/
		RC_Script::enqueue_script('acharts-min', RC_App::apps_url('statics/js/acharts-min.js', __FILE__), array('ecjia-merchant'), false, 1);
		RC_Script::enqueue_script('order_stats', RC_App::apps_url('statics/js/merchant_order_stats.js', __FILE__), array('ecjia-merchant'), false, 1);
		RC_Script::enqueue_script('order_stats_chart', RC_App::apps_url('statics/js/merchant_order_stats_chart.js', __FILE__), array('ecjia-merchant'), false, 1);
		RC_Style::enqueue_style('orders-css', RC_App::apps_url('statics/css/merchant_orders.css', __FILE__));
		RC_Style::enqueue_style('stats-css', RC_App::apps_url('statics/css/merchant_stats.css', __FILE__));
		
		RC_Lang::load('statistic');
		RC_Loader::load_app_func('global','orders');

		$this->db_order_info  = RC_Loader::load_app_model('order_info_model', 'orders');
		$this->db_goods  = RC_Loader::load_app_model('goods_model', 'orders');
		$this->db_payment_view  = RC_Loader::load_app_model('payment_viewmodel', 'orders');
		$this->db_shipping_view  = RC_Loader::load_app_model('shipping_viewmodel', 'orders');
		$this->db_orderinfo_view  = RC_Loader::load_app_model('order_order_infogoods_viewmodel', 'orders');

		ecjia_merchant_screen::get_current_screen()->set_parentage('stats');
	}

	/**
	 * 订单统计
	 */
	public function init() {
		/* 判断权限 */
		$this->admin_priv('order_stats');
		/* 加载面包屑  */
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('报表统计', RC_Uri::url('stats/mh_keywords_stats/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('订单统计')));


		$this->assign('ur_here','订单统计');
		$this->assign('action_link', array('text' => '订单统计报表下载', 'href' => RC_Uri::url('orders/mh_order_stats/download')));

		/* 随机的颜色数组 */
		$color_array = array('33FF66', 'FF6600', '3399FF', '009966', 'CC3399', 'FFCC33', '6699CC', 'CC3366');
		/* 计算订单各种费用之和的语句 */
		$total_fee = " SUM(" . order_amount_field() . ") AS total_turnover ";
		/* 取得订单转化率数据 */
		$order_general = $this->db_orderinfo_view->join('null')->field('COUNT(*) AS total_order_num , '.$total_fee.'')->where(array('oi.store_id' => $_SESSION['store_id']))->find('1' . order_query_sql('finished').'');

		$order_general['total_turnover'] = floatval($order_general['total_turnover']);
		/* 取得商品总点击数量 */
		$click_count = $this->db_goods->where(array('is_delete' => 0, 'store_id' => $_SESSION['store_id']))->sum('click_count');
		$click_count = floatval($click_count);
		/* 每千个点击的订单数 */
		$click_ordernum = $click_count > 0 ? round(($order_general['total_order_num'] * 1000)/$click_count,2) : 0;
		/* 每千个点击的购物额 */
		$click_turnover = $click_count > 0 ? round(($order_general['total_turnover'] * 1000)/$click_count,2) : 0;
		/* 时区 */
		$timezone = isset($_SESSION['timezone']) ? $_SESSION['timezone'] : $GLOBALS['_CFG']['timezone'];
		/* 时间参数 */
		$is_multi = empty($_GET['is_multi']) ? false : true;
		/* 时间参数 */
		$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : RC_Time::local_date('Y-m-d', RC_Time::local_strtotime('-6 days'));
		$end_date   = !empty($_GET['end_date'])   ? $_GET['end_date']   : RC_Time::local_date('Y-m-d');
		
		$this->assign('start_date', $start_date);
        $this->assign('end_date', $end_date);

		if (!empty($_GET['year_month'])) {
			$filter	= explode('.', $_GET['year_month']);
			$arr 	= array_filter($filter);
			$tmp 	= $arr;

			for ($i = 0; $i < count($tmp); $i++) {
				if (!empty($tmp[$i])) {
					$tmp_time 			= RC_Time::local_strtotime($tmp[$i] . '-1');
					$start_date_arr[$i]	= $tmp_time;
				}
			}
		} else {
			$tmp_time 			= RC_Time::local_strtotime(RC_Time::local_date('Y-m-d'));
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
        $this->assign('order_general', $order_general);
        $this->assign('total_turnover', price_format($order_general['total_turnover']));
        $this->assign('click_count', $click_count); // 商品总点击数
        $this->assign('click_ordernum', $click_ordernum); // 每千点订单数
        $this->assign('click_turnover', price_format($click_turnover));  //每千点购物额

		$this->assign('is_multi', $is_multi);
        $this->assign('year_month', $_GET['year_month']);

		$this->assign_lang();
		$this->display('order_stats.dwt');
	}

	/**
	 * 订单统计-订单概况 ajax
	 */
	public function get_order_general() {
	    /* 判断权限 */
	    $this->admin_priv('order_stats', ecjia::MSGTYPE_JSON);

		$is_multi = empty($_GET['is_multi']) ? false : true;
		if (!$is_multi) {
			/*时间参数*/
			$start_date = !empty($_GET['start_date']) ? RC_Time::local_strtotime($_GET['start_date']) : RC_Time::local_strtotime(RC_Time::local_date('Y-m-d'))-86400*6;
			$end_date   = !empty($_GET['end_date'])   ? RC_Time::local_strtotime($_GET['end_date'])   : RC_Time::local_strtotime(RC_Time::local_date('Y-m-d'));

			$order_info = $this->get_orderinfo($start_date, $end_date);
			if ($order_info) {
			    foreach ($order_info as $k=>$v) {
			        if ($k=='unconfirmed_num') {
			            $order_info['未确认订单'] = $order_info['unconfirmed_num'];
			            unset($order_info['unconfirmed_num']);
			        } elseif ($k=='confirmed_num') {
			            $order_info['已确认订单'] = $order_info['confirmed_num'];
			            unset($order_info['confirmed_num']);
			        } elseif ($k=='succeed_num') {
			            $order_info['已完成订单'] = $order_info['succeed_num'];
			            unset($order_info['succeed_num']);
			        } elseif ($k=='invalid_num') {
			            $order_info['已取消订单'] = $order_info['invalid_num'];
			            unset($order_info['invalid_num']);
			        }
			    }
			}

			$order_infos = json_encode($order_info);
			echo $order_infos;
		}
	}

	/**
	 * 月份 获取订单走势数据
	 */
	public function get_order_status() {
	    /* 判断权限 */
	    $this->admin_priv('order_stats', ecjia::MSGTYPE_JSON);

		if (!empty($_GET['year_month'])) {
			$filter	= explode('.',$_GET['year_month']);
			$arr 	= array_filter(json_decode(json_encode($filter),true));
			$tmp 	= $arr;

			for ($i = 0; $i < count($tmp); $i++) {
				if (!empty($tmp[$i])) {
					$tmp_time 			= RC_Time::local_strtotime($tmp[$i].'-1');
					$start_date_arr[$i]	= $tmp_time;
					$end_date_arr[$i]   = RC_Time::local_strtotime('+1 month', strtotime($tmp[$i].'-1')) - 1;
				}
			}

			$where = '';
			foreach ($start_date_arr as $key => $val)  {
				$order_info[RC_Time::local_date('Y-m', $start_date_arr[$key])] = $this->get_orderinfo($start_date_arr[$key], $end_date_arr[$key], false);
			}

			foreach ($order_info as $k => $v) {
                foreach ($v as $k1 => $v1) {
					if ($k1=='unconfirmed_num') {
						$arr1['未确认订单'][$k] = $v1;
						unset($arr1['unconfirmed_num']);
					} elseif ($k1=='confirmed_num') {
						$arr1['已确认订单'][$k] = $v1;
						unset($arr1['confirmed_num']);
					} elseif ($k1=='succeed_num') {
						$arr1['已完成订单'][$k] = $v1;
						unset($arr1['succeed_num']);
					} elseif ($k1=='invalid_num') {
						$arr1['已取消订单'][$k] = $v1;
						unset($arr1['invalid_num']);
					}
				}
			}
			$templateCounts = json_encode($arr1);
			echo $templateCounts;
		}
	}

	/**
	 * 订单统计-配送方式 ajax
	 */
	public function get_ship_status() {
	    /* 判断权限 */
	    $this->admin_priv('order_stats', ecjia::MSGTYPE_JSON);

		$is_multi = empty($_GET['is_multi']) ? false : true;
		if (!$is_multi) {
			/*时间参数*/
			$start_date = !empty($_GET['start_date']) ? RC_Time::local_strtotime($_GET['start_date']) : RC_Time::local_strtotime(RC_Time::local_date('Y-m-d'), '-6 days');
			$end_date   = !empty($_GET['end_date'])   ? RC_Time::local_strtotime($_GET['end_date'])+86399   : RC_Time::local_strtotime(RC_Time::local_date('Y-m-d'))+86399;
			$where = "i.store_id= ".$_SESSION['store_id']." AND i.add_time >= '$start_date' AND i.add_time <= '$end_date'".order_query_sql('finished').' ';
			$where .= " AND i.is_delete = 0";
			$ship_info = $this->db_shipping_view->field('sp.shipping_name AS ship_name, COUNT(i.order_id) AS order_num')->where($where)->group('i.shipping_id')->order(array('order_num'=>'DESC'))->select();
			if ($ship_info) {
			    foreach ($ship_info as $k => $v) {
			        $new_ship_info[$v['ship_name']] = (int)$v['order_num'];
			    }
			} else {
			    $new_ship_info['配送方式'] = 0;
			}

			echo json_encode($new_ship_info);
		}
	}

	/**
	 * 按月 查询获取配送方式数据
	 */
	public function get_ship_stats() {
	    /* 判断权限 */
	    $this->admin_priv('order_stats', ecjia::MSGTYPE_JSON);
		if (!empty($_GET['year_month'])) {
			$filter	= explode('.', $_GET['year_month']);
			$arr 	= array_filter(json_decode(json_encode($filter),true));
			$tmp 	= $arr;

			for ($i = 0; $i < count($tmp); $i++) {
				if (!empty($tmp[$i])) {
					$tmp_time 			= RC_Time::local_strtotime($tmp[$i].'-1');
					$start_date_arr[$i]	= $tmp_time;
					$end_date_arr[$i]   = RC_Time::local_strtotime('+1 month', $tmp_time) - 1;
				}
			}

			$format_start_date = array();
			foreach ($start_date_arr as $key => $val) {
			    $order_info[RC_Time::local_date('Y-m', $start_date_arr[$key])] = $this->get_orderinfo($start_date_arr[$key], $end_date_arr[$key], false);
			    $format_start_date[$key] = RC_Time::local_date('Y-m', $start_date_arr[$key]);
			}

			//查询所有配送方式
			foreach ($start_date_arr as $key => $val) {
			    $where =  "i.add_time >= '$start_date_arr[$key]' AND i.add_time <= '$end_date_arr[$key]'".order_query_sql('finished').' AND i.store_id = '.$_SESSION['store_id'];
			    $ship_name[] = $this->db_shipping_view->field('DISTINCT sp.shipping_name AS ship_name')->where($where)->group('i.shipping_id')->select();
			}
			function array_get_by_key(array $array, $string) {
			    if (!trim($string)) return false;
			    preg_match_all("/\"$string\";\w{1}:(?:\d+:|)(.*?);/", serialize($array), $res);
			    return $res[1];
			}
			$ship_name  = array_get_by_key($ship_name, 'ship_name');
			foreach ($ship_name as $key => &$ship_name_val) {
			    $ship_name_val = str_replace('"', '',$ship_name_val );
			}
			$ship_name = array_unique($ship_name);

			//按月份查询数据
			$ship_info = array();
			foreach ($start_date_arr as $key => $val) {
				$where =  "i.add_time >= '$start_date_arr[$key]' AND i.add_time <= '$end_date_arr[$key]'".order_query_sql('finished').' AND i.store_id = '.$_SESSION['store_id'];
				$tmp = $this->db_shipping_view->field('sp.shipping_name AS ship_name, COUNT(i.order_id) AS order_num')->where($where)->group('i.shipping_id')->order(array('order_num'=>'DESC'))->select();
				$tmp[$key]['shipping_time'] = RC_Time::local_date('Y-m', $val);
				$ship_info[RC_Time::local_date('Y-m', $start_date_arr[$key])] = $tmp;
			}

			//组装数据
			$format_ship_info = array();
			if ($ship_name) {
                foreach ($ship_name as $v_ship_name) {
                    foreach ($format_start_date as $k2 => $v2) {
                        foreach ($ship_info as $k3 => $v3) {
                            if ($k3 == $format_start_date[$k2]) {
                                if ($v3) {
                                    foreach ($v3 as $k4 => $v4) {
                                        if ($v4['ship_name'] == $v_ship_name)
                                            $format_ship_info[$v_ship_name][$format_start_date[$k2]] = $v4['order_num'];
                                    }
                                } else {
                                    $format_ship_info[$v_ship_name][$format_start_date[$k2]] = 0;
                                }
                            }
                        }
                    }
                }
                foreach ($format_ship_info as $k3 => &$v3) {
                    foreach ($v3 as $k4 => &$v4) {
                        foreach ($format_start_date as $k2 => $v2) {
                            if ( $k4 != $v2 && !isset($v3[$v2])) {
                                $v3[$v2] = 0;
                            }
                        }
                    }

                }
			} else {

			    foreach ($format_start_date as $k => $v) {
			        $format_ship_info['配送方式'][$v] = 0;
			    }
			}

			echo json_encode($format_ship_info);
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

		/*文件名*/
		$filename = RC_Lang::get('orders::statistic.order_statement').'_'.$_GET['start_date'].'至'.$_GET['end_date'];
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=$filename.xls");

		/* 订单概况 */
		$order_info = $this->get_orderinfo($start_date, $end_date);

		$data = RC_Lang::get('orders::statistic.order_circs') . "\n";
		$data .= RC_Lang::get('orders::statistic.confirmed') ."\t". RC_Lang::get('orders::statistic.succeed') ."\t". RC_Lang::get('orders::statistic.unconfirmed') ."\t". RC_Lang::get('orders::statistic.invalid')."\n";
		$data .= $order_info[confirmed_num]."\t". $order_info[succeed_num] ."\t". $order_info[unconfirmed_num] ."\t". $order_info[invalid_num]."\n";

		/* 配送方式 */
		$where = 'i.add_time >= '.$start_date.' AND i.add_time <= '.$end_date.''.order_query_sql('finished').' AND i.store_id = '.$_SESSION['store_id'];
		$ship_res = $this->db_shipping_view->field('sp.shipping_id, sp.shipping_name AS ship_name, COUNT(i.order_id) AS order_num')->where($where)->group('i.shipping_id')->order(array('order_num'=>'DESC'))->select();

		$data .= "\n".RC_Lang::get('orders::statistic.shipping_method')."\n";
		foreach ($ship_res AS $val) {
			$data .= $val['ship_name']."\t";
		}
		$data .= "\n";
		foreach ($ship_res AS $val) {
			$data .= $val['order_num']."\t";
		}
		echo mb_convert_encoding($data."\t",'UTF-8', 'auto')."\t";
		exit;
	}

	/**
	  * 取得订单概况数据(包括订单的几种状态)
	  * @param       $start_date    开始查询的日期
	  * @param       $end_date      查询的结束日期
	  * @return      $order_info    订单概况数据
	  */
	 private function get_orderinfo($start_date, $end_date, $is_edit_end_date = true) {
	    if ($is_edit_end_date)
	        $end_date += 86399;
	 	$order_info = array();
	 	$where = "oi.store_id = " . $_SESSION['store_id'] . " AND oi.add_time >= " . $start_date . " AND oi.add_time <= " . $end_date;
	 	$where .= ' AND oi.is_delete = 0';

	 	/* 未确认订单数 */
	 	$order_info['unconfirmed_num'] = $this->db_orderinfo_view->field('COUNT(*) AS unconfirmed_num')->where($where ." AND oi.order_status = '" .OS_UNCONFIRMED. "'" )->count('DISTINCT order_sn|unconfirmed_num');
	 	/* 已确认订单数 */
	 	$order_info['confirmed_num'] = $this->db_orderinfo_view->field('COUNT(*) AS confirmed_num')->where($where ." AND oi.order_status = '" .OS_CONFIRMED. "' AND oi.shipping_status != ".SS_SHIPPED." && oi.shipping_status != ".SS_RECEIVED." AND oi.pay_status != ".PS_PAYED." && pay_status != ".PS_PAYING )->count('DISTINCT order_sn|confirmed_num');
	 	/* 已成交订单数 */
	    $order_info['succeed_num'] = $this->db_orderinfo_view->field('COUNT(*) AS succeed_num')->where($where . order_query_sql('finished'))->count('DISTINCT order_sn|succeed_num');
	    /* 无效或已取消订单数 */
	    $order_info['invalid_num'] = $this->db_orderinfo_view->field('COUNT(*) AS invalid_num')->where($where ." AND oi.order_status IN ('" .OS_CANCELED.  "','" .OS_INVALID.  "','" .OS_RETURNED.  "') ")->count('DISTINCT order_sn|invalid_num');
		return $order_info;
	 }
}

// end