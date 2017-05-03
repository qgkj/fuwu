<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单详情
 * @author royalwang
 */
class detail_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	
    	$user_id = $_SESSION['user_id'];
    	if ($user_id < 1 ) {
    	    return new ecjia_error(100, 'Invalid session');
    	}

		RC_Loader::load_app_func('admin_order', 'orders');
		$order_id = $this->requestData('order_id', 0);
		if (!$order_id) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
		}

		/* 订单详情 */
		$order = get_order_detail($order_id, $user_id, 'front');

		if(is_ecjia_error($order)) {
		    return $order;
		}
		
		/*返回数据处理*/
		$order['order_id'] 			= intval($order['order_id']);
		$order['user_id'] 			= intval($order['user_id']);
		$order['order_status'] 		= intval($order['order_status']);
		$order['shipping_status'] 	= intval($order['shipping_status']);
		$order['pay_status'] 		= intval($order['pay_status']);
		$order['shipping_id'] 		= intval($order['shipping_id']);
		$order['pay_id'] 			= intval($order['pay_id']);
		$order['pack_id'] 			= intval($order['pack_id']);
		$order['card_id'] 			= intval($order['card_id']);
		$order['bonus_id'] 			= intval($order['bonus_id']);
		$order['agency_id'] 		= intval($order['agency_id']);
		$order['extension_id'] 		= intval($order['extension_id']);
		$order['parent_id'] 		= intval($order['parent_id']);

		if ($order === false) {
			return new ecjia_error(8, 'fail');
		}
		
		/* 判断支付方式*/
		$shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
		$shipping_info = $shipping_method->shipping_info($order['shipping_id']);
		$order['shipping_code'] = $shipping_info['shipping_code'];
		if ($shipping_info['shipping_code'] == 'ship_o2o_express') {
			$express_info = RC_DB::table('express_order')->where('order_sn', $order['order_sn'])->orderBy('express_id', 'desc')->first();
			$order['express_user'] = $express_info['express_user'];
			$order['express_mobile'] = $express_info['express_mobile'];
		}
		
		//收货人地址
		$db_region = RC_Model::model('shipping/region_model');
		$region_name = $db_region->in(array('region_id' => array($order['country'], $order['province'], $order['city'], $order['district'])))->order('region_type')->select();

		$order['country']	= $region_name[0]['region_name'];
		$order['province']	= $region_name[1]['region_name'];
		$order['city']		= $region_name[2]['region_name'];
		$order['district']	= $region_name[3]['region_name'];
		$goods_list = EM_order_goods($order_id);

		foreach ($goods_list as $k => $v) {
			if ($k == 0) {
				if ($v['store_id'] > 0) {
					$seller_info = RC_DB::table('store_franchisee')->where(RC_DB::raw('store_id'), $v['store_id'])->select('merchants_name', 'manage_mode')->first();
				}

				$order['seller_id']		= isset($v['store_id']) ? intval($v['store_id']) : 0;
				$order['seller_name']	= isset($seller_info['merchants_name']) ? $seller_info['merchants_name'] : '自营';
				$order['manage_mode']	= $seller_info['manage_mode'];
				$order['service_phone']		= RC_DB::table('merchants_config')->where(RC_DB::raw('store_id'), $v['store_id'])->where(RC_DB::raw('code'), 'shop_kf_mobile')->pluck('value');
			}
			$attr = array();
			if (!empty($v['goods_attr'])) {
				$goods_attr = explode("\n", $v['goods_attr']);
				$goods_attr = array_filter($goods_attr);
				foreach ($goods_attr as  $val) {
					$a = explode(':',$val);
					if (!empty($a[0]) && !empty($a[1])) {
						$attr[] = array('name'=>$a[0], 'value'=>$a[1]);
					}
				}
			}

			$goods_list[$k] = array(
				'goods_id'		=> $v['goods_id'],
				'name'			=> $v['goods_name'],
				'goods_attr'	=> empty($attr) ? '' : $attr,
				'goods_number'	=> $v['goods_number'],
				'subtotal'		=> price_format($v['subtotal'], false),
				'formated_shop_price' => $v['goods_price'] > 0 ? price_format($v['goods_price'], false) : __('免费'),
				'is_commented'	=> $v['is_commented'],
				'img' => array(
					'small'	=> !empty($v['goods_thumb']) ? RC_Upload::upload_url($v['goods_thumb']) : '',
					'thumb'	=> !empty($v['goods_img']) ? RC_Upload::upload_url($v['goods_img']) : '',
					'url' 	=> !empty($v['original_img']) ? RC_Upload::upload_url($v['original_img']) : '',
				)
			);
		}
		$order['goods_list'] = $goods_list;

		$order_status_log = RC_Model::model('orders/order_status_log_model')->where(array('order_id' => $order_id))->order(array('log_id' => 'desc'))->select();
		$order['order_status_log'] = array();
		if (!empty($order_status_log)) {
			$labe_order_status = array(
				'place_order'	=> RC_Lang::get('orders::order.place_order'),//下单 
				'unpay'			=> RC_Lang::get('orders::order.unpay'), 
				'payed' 		=> RC_Lang::get('orders::order.payed'),
				'merchant_process' => RC_Lang::get('orders::order.merchant_process'),//等待接单
				'shipping' 		=> RC_Lang::get('orders::order.shipping'), 
				'shipped' 		=> RC_Lang::get('orders::order.shipped'),
				'express_user_pickup'	=> RC_Lang::get('orders::order.express_user_pickup'),
				'cancel'		=> RC_Lang::get('orders::order.order_cancel'),
				'confirm_receipt'	=> RC_Lang::get('orders::order.confirm_receipted'),
				'finished'		=> RC_Lang::get('orders::order.order_finished')
			);
			
			foreach ($order_status_log as $val) {
				$order['order_status_log'][] = array(
					'status'		=> array_search($val['order_status'], $labe_order_status),
					'order_status'	=> $val['order_status'],
					'message'		=> $val['message'],
					'time'			=> RC_Time::local_date(ecjia::config('time_format'), $val['add_time']),
				);
			}
		}
		return array('data' => $order);
	}
}

// end