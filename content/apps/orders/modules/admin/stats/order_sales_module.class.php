<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单统计汇总
 * @author will.chen
 */
class order_sales_module extends api_admin implements api_interface {
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
		
		$cache_key = 'admin_stats_order_sales_'.$_SESSION['store_id'].'_'.md5($start_date.$end_date);
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
	
	$where = array();
	if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
		/*入驻商*/
		$where['store_id'] = $_SESSION['store_id'];
	}
	$where['oi.pay_status'] = 2;
	$member_orders = 0;//会员数量
	$anonymity_orders = 0;//非会员数量

	$field = 'count(oi.order_id) as count, SUM(IF(oi.user_id > 0, 1, 0)) as member_orders, SUM(oi.discount) as discount, SUM(oi.bonus) as bonus, SUM(oi.integral_money) as integral_money, 
			SUM(oi.goods_amount - oi.discount + oi.tax + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee) AS total_fee';
	
	/* 判断是否是入驻商*/
	if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0 ) {
		$join = array('order_goods');
	} else {
		$join = null;
	}

	$result = $db_orderinfo_view->join($join)->field($field)->where($where)->find();

	$data = array(
		'orders'				=> $result['count'],
		'total_sales_volume'	=> $result['total_fee'],
		'member_orders'			=> $result['member_orders'],
		'anonymity_orders'		=> $result['count'] - $result['member_orders'],
		'discount_money'		=> $result['discount'],
		'bonus_money'			=> $result['bonus'],
		'integral_money'		=> $result['integral_money'],
		'formatted_total_sales_volume'	=> price_format($result['total_fee'], false),
		'formatted_discount_money'		=> price_format($result['discount'], false),
		'formatted_bouns_money'			=> price_format($result['bouns'], false),
		'formatted_integral_money'		=> price_format($result['integral_money'], false),
	);
	
	return $data;
}

//end
