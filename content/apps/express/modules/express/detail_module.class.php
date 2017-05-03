<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 配送信息详情
 * @author will.chen
 */
class detail_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
    	$express_id = $this->requestData('express_id');
    	$express_sn = $this->requestData('express_sn');
    	$location	= $this->requestData('location', array());
    	if (empty($express_id) && empty($express_sn)) {
    		return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
    	}
    	$express_order     = array();
    	$express_order_db  = RC_Model::model('express/express_order_viewmodel');
    	if (!empty($express_id)) {
    		$where = array('staff_id' => $_SESSION['staff_id'], 'express_id' => $express_id);
    	} else {
    		$where = array('staff_id' => $_SESSION['staff_id'], 'express_sn' => $express_sn);
    	}
    	
    	$field = 'eo.*, oi.add_time as order_time, oi.pay_time, oi.order_amount, oi.pay_name, sf.merchants_name, sf.address as merchant_address, sf.longitude as merchant_longitude, sf.latitude as merchant_latitude';
    	$express_order_info = $express_order_db->field($field)->join(array('delivery_order', 'order_info', 'store_franchisee'))->where($where)->find();
		
    	/* 判断配送单是否存在*/
		if (empty($express_order_info)) {
			return new ecjia_error('express_no_exists_error', '此配送单不存在！');
		}
    	$express_order = array(
    		'express_id'	        => $express_order_info['express_id'],
    		'express_sn'	        => $express_order_info['express_sn'],
    		'express_type'	        => $express_order_info['from'],
    		'label_express_type'	=> $express_order_info['from'] == 'assign' ? '系统派单' : '抢单',
    		'order_sn'		        => $express_order_info['order_sn'],
    		'payment_name'	        => $express_order_info['pay_name'],
    		'express_from_address'	=> '【'.$express_order_info['merchants_name'].'】'. $express_order_info['merchant_address'],
    		'express_from_location'	=> array(
        		'longitude' => $express_order_info['merchant_longitude'],
        		'latitude'	=> $express_order_info['merchant_latitude'],
    		),
    		'express_to_address'	=> $express_order_info['address'],
    		'express_to_location'	=> array(
        		'longitude' => $express_order_info['longitude'],
        		'latitude'	=> $express_order_info['latitude'],
    		),
    		'distance'		=> $express_order_info['distance'],
    		'consignee'		=> $express_order_info['consignee'],
    		'mobile'		=> $express_order_info['mobile'],
    		'receive_time'	=> $express_order_info['receive_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $express_order_info['receive_time']) : '',
    		'express_time'	=> $express_order_info['express_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $express_order_info['express_time']) : '',
    		'order_time'	=> $express_order_info['order_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $express_order_info['order_time']) : '',
    		'pay_time'		=> empty($express_order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $express_order_info['pay_time']),
    		'best_time'		=> $express_order_info['best_time'],
    		'signed_time'	=> $express_order_info['signed_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $express_order_info['signed_time']) : '',
    		'shipping_fee'	=> $express_order_info['shipping_fee'],
    		'order_amount'	=> $express_order_info['order_amount'],
    		'goods_items'	=> array(),
    	);
    	
    	$goods_items = RC_DB::table('delivery_goods as dg')
    		->leftjoin('goods as g', RC_DB::raw('dg.goods_id'), '=', RC_DB::raw('g.goods_id'))
        	->selectRaw('dg.*, g.goods_thumb, g.goods_img, g.original_img, g.shop_price')
          	->where('delivery_id', $express_order_info['delivery_id'])
          	->get();
    	
    	if (!empty($goods_items)) {
    		foreach ($goods_items as $val) {
    			$express_order['goods_items'][] = array(
    				'goods_id'	            => $val['goods_id'],
    				'name'		            => $val['goods_name'],
    				'goods_number'	        => $val['send_number'],
    				'formatted_shop_price'	=> price_format($val['shop_price']),
    				'img'		            => array(
    					'small'	=> !empty($val['goods_thumb']) ? RC_Upload::upload_url($val['goods_thumb']) : '',
    					'thumb'	=> !empty($val['goods_img']) ? RC_Upload::upload_url($val['goods_img']) : '',
    					'url'	=> !empty($val['original_img']) ? RC_Upload::upload_url($val['original_img']) : '',
    				),
    			);
    		}	
    	}
		return $express_order;
	 }	
}

// end