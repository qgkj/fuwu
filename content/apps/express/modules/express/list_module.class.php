<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 配送信息列表
 * @author will.chen
 */
class list_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		
		$type     = $this->requestData('express_type');
		$order_sn = $this->requestData('order_sn');
		$size     = $this->requestData('pagination.count', 15);
		$page     = $this->requestData('pagination.page', 1);
		
		$where    = array('staff_id' => $_SESSION['staff_id']);
		
		switch ($type) {
			case 'wait_pickup' :
				$where['eo.status'] = 1;
				break;
			case 'wait_shipping' :
				$where['eo.status'] = 2;
				break;
			case 'finished' :
				$where['eo.status'] = 5;
				break;
			default : 
				if (!empty($order_sn)) {
					$where['eo.order_sn'] = array('like' => '%'.$order_sn.'%');
				} else {
					return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
				}
		}
		
		$express_order_db = RC_Model::model('express/express_order_viewmodel');
		
		$count = $express_order_db->join(null)->where($where)->count();
		
		//实例化分页
		$page_row = new ecjia_page($count, $size, 6, '', $page);
		
		$field = 'eo.*, oi.add_time as order_time, oi.pay_time, oi.order_amount, oi.pay_name, sf.merchants_name, sf.address as merchant_address, sf.longitude as merchant_longitude, sf.latitude as merchant_latitude';
		$express_order_result = $express_order_db->field($field)->join(array('delivery_order', 'order_info', 'store_franchisee'))->where($where)->order(array('express_id' => 'desc'))->limit($page_row->limit())->select();
		
		$express_order_list = array();
		if (!empty($express_order_result)) {
			foreach ($express_order_result as $val) {
				switch ($val['status']) {
					case '1' :
						$status = 'wait_pickup';
						break;
					case '2' :
						$status = 'wait_shipping';
						break;
					case '5' :
						$status = 'finished';
						break;
				}
				$express_order_list[] = array(
					'express_id'	         => $val['express_id'],
					'express_sn'	         => $val['express_sn'],
					'express_type'	         => $val['from'],
					'label_express_type'	 => $val['from'] == 'assign' ? '系统派单' : '抢单',
					'order_sn'		         => $val['order_sn'],
					'payment_name'	         => $val['pay_name'],
					'express_from_address'	 => '【'.$val['merchants_name'].'】'. $val['merchant_address'],
					'express_from_location'	 => array(
						'longitude' => $val['merchant_longitude'],
						'latitude'	=> $val['merchant_latitude'],
					),
					'express_to_address'	 => $val['address'],
					'express_to_location'	 => array(
						'longitude' => $val['longitude'],
						'latitude'	=> $val['latitude'],
					),
					'express_status' => $status,
					'distance'		=> $val['distance'],
					'consignee'		=> $val['consignee'],
					'mobile'		=> $val['mobile'],
					'receive_time'	=> $val['receive_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $val['receive_time']) : '',
					'express_time'	=> $val['express_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $val['express_time']) : '',
					'order_time'	=> $val['order_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $val['order_time']) : '',
					'pay_time'		=> empty($val['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $val['pay_time']),
					'signed_time'	=> $val['signed_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $val['signed_time']) : '',
					'best_time'		=> $val['best_time'],
					'shipping_fee'	=> $val['shipping_fee'],
					'order_amount'	=> $val['order_amount'],
				);
			}
		}
		$pager = array(
			'total' => $page_row->total_records,
			'count' => $page_row->total_records,
			'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		return array('data' => $express_order_list, 'pager' => $pager);
	 }	
}

// end