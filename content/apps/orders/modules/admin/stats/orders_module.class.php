<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单数量
 * @author luchongchong
 *
 */
class orders_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
		$this->authadminSession();
		if ($_SESSION['admin_id' ] <= 0 && $_SESSION['staff_id'] <= 0) {
		    return new ecjia_error(100, 'Invalid session');
		}
		
		$result = $this->admin_priv('order_stats');
		if (is_ecjia_error($result)) {
			return $result;
		}
		//传入参数
		$start_date = $this->requestData('start_date');
		$end_date = $this->requestData('end_date');
		if (empty($start_date) || empty($end_date)) {
			return new ecjia_error(101, '参数错误');
		}
		$cache_key = 'admin_stats_orders_'.$_SESSION['store_id'].'_'.md5($start_date.$end_date);
		$data = RC_Cache::app_cache_get($cache_key, 'api');
		if (empty($data)) {
			$response = orders_module($start_date, $end_date);
			RC_Cache::app_cache_set($cache_key, $response, 'api', 60);
			//流程逻辑结束
		} else {
			$response = $data;
		}
		return $response;
	}
}

function orders_module($start_date, $end_date) {
	$db_orderinfo_view = RC_Model::model('orders/order_info_viewmodel');
	$db_orderinfo_view->view = array(
		'order_goods' => array(
			'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias'	=> 'og',
			'on'	=> 'oi.order_id = og.order_id'
		)
	);

	$type = $start_date == $end_date ? 'time' : 'day';
	$start_date = RC_Time::local_strtotime($start_date. ' 00:00:00');
	$end_date	= RC_Time::local_strtotime($end_date. ' 23:59:59');

	/* 计算时间刻度*/
	$group_scale = ($end_date+1-$start_date)/6;
	$stats_scale = ($end_date+1-$start_date)/30;
	/* 计算出有多少天*/
	$day = round(($end_date - $start_date)/(24*60*60));
	
	$where = array();
	if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
		/*入驻商*/
		$where['store_id'] = $_SESSION['store_id'];
	}
	$where['oi.pay_status'] = 2;
	$member_orders = 0;//会员数量
	$anonymity_orders = 0;//非会员数量
	
	$field = 'oi.order_id, oi.pay_time, oi.user_id';
	
	/* 判断是否是入驻商*/
	if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0 ) {
		$join = array('order_goods');
	} else {
		$join = null;
	}

	$stats = $group = array();
	$temp_start_time = $start_date;
	$now_time = RC_Time::gmtime();
	$j = 1;
	while ($j <= 30) {
		if ($temp_start_time > $now_time) {
			break;
		}
		$temp_end_time = $temp_start_time + $stats_scale;
		if ($j == 30) {
			$temp_end_time = $temp_end_time-1;
		}
		$temp_total_orders = 0;
		$result = $db_orderinfo_view->field($field)
			->join($join)
			->where(array_merge($where, array('oi.pay_time >="' .$temp_start_time. '" and oi.pay_time<="' .$temp_end_time. '"')))
			->order(array('oi.pay_time' => 'asc'))
			->select();
		if (!empty($result)) {
			foreach ($result as $val) {
				$temp_total_orders++;
				if ($val['user_id'] > 0) {
					$member_orders++;
				} else {
					$anonymity_orders++;
				}
			}
			$stats[] = array(
				'time'				=> $temp_start_time,
				'formatted_time'	=> RC_Time::local_date('Y-m-d H:i:s', $temp_start_time),
				'orders'			=> $temp_total_orders,
				'value'				=> $temp_total_orders,
			);
		} else {
			$stats[] = array(
				'time'				=> $temp_start_time,
				'formatted_time'	=> RC_Time::local_date('Y-m-d H:i:s', $temp_start_time),
				'orders'			=> 0,
				'value'				=> 0,
			);
		}
		$temp_start_time += $stats_scale;
		$j++;
	}
	
	$i = 1;
	$temp_group = $start_date;
	while ($i <= 7) {
		if ($i == 7) {
			$group[] = array(
				'time'				=> $end_date,
				'formatted_time'	=> RC_Time::local_date('Y-m-d H:i:s', $end_date),
			);
			break;
		}
		$group[] = array(
			'time'				=> $temp_group,
			'formatted_time'	=> RC_Time::local_date('Y-m-d H:i:s', $temp_group),
		);
		$temp_group += $group_scale;
		$i++;
	}

	$order_query = RC_Loader::load_app_class('order_query', 'orders');
	/* 已付款*/
	$payed_orders = $db_orderinfo_view->join($join)->where(array_merge($where, array('oi.pay_status' => array(PS_PAYED, PS_PAYING))))->count('oi.order_id');
	/* 未发货*/
	$wait_ship_orders = $db_orderinfo_view->join($join)->where(array_merge($where, $order_query->order_await_ship('oi.')))->count('oi.order_id');
	/* 已发货*/
	$shipped_orders = $db_orderinfo_view->join($join)->where(array_merge($where, $order_query->order_shipped('oi.')))->count('oi.order_id');
	
	$data = array(
		'stats'				=> $stats,
		'group'				=> $group,
		'payed_orders'		=> $payed_orders,
		'wait_ship_orders'	=> $wait_ship_orders,
		'shipped_orders'	=> $shipped_orders,
		'member_orders'		=> $member_orders,
		'anonymity_orders'	=> $anonymity_orders,
	);
	return $data;
}

//end