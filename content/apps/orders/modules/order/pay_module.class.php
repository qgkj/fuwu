<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单支付
 * @author royalwang
 * 16-12-09 增加支付状态
 */
class pay_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	$user_id = $_SESSION['user_id'];
    	if ($user_id < 1 ) {
    	    return new ecjia_error(100, 'Invalid session');
    	}
    	
		$order_id	= $this->requestData('order_id', 0);
		$is_mobile	= $this->requestData('is_mobile', true);
		
		if (!$order_id) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
		}
		
		/* 订单详情 */
		$order = RC_Api::api('orders', 'order_info', array('order_id' => $order_id));
		if (is_ecjia_error($order)) {
			return $order;
		}
		
		if ($_SESSION['user_id'] != $order['user_id']) {
			return new ecjia_error('error_order_detail', RC_Lang::get('orders::order.error_order_detail'));
		}
		
		//判断是否是管理员登录
		if ($_SESSION['admin_id'] > 0) {
			$_SESSION['user_id'] = $order['user_id'];
		}
		
		//支付方式信息
		$payment_method = RC_Loader::load_app_class('payment_method', 'payment');
		$payment_info = $payment_method->payment_info_by_id($order['pay_id']);
		// 取得支付信息，生成支付代码
		$payment_config = $payment_method->unserialize_config($payment_info['pay_config']);

		$handler = $payment_method->get_payment_instance($payment_info['pay_code'], $payment_config);
		$handler->set_orderinfo($order);
		$handler->set_mobile($is_mobile);
		
		$result = $handler->get_code(payment_abstract::PAYCODE_PARAM);
        if (is_ecjia_error($result)) {
            return $result;
        } else {
            $order['payment'] = $result;
        }
        
        /* 插入支付流水记录*/
        $db = RC_DB::table('payment_record');
        $payment_record = $db->where('order_sn', $order['order_sn'])->first();
        $payment_data = array(
        	'order_sn'		=> $order['order_sn'],
        	'trade_type'	=> 'buy',
        	'pay_code'		=> $payment_info['pay_code'],
        	'pay_name'		=> $payment_info['pay_name'],
        	'total_fee'		=> $order['order_amount'],
        	'pay_status'	=> 0,
        );
        if (empty($payment_record)) {
        	$payment_data['create_time']	= RC_Time::gmtime();
        	$db->insertGetId($payment_data);
        } elseif($payment_record['pay_status'] == 0 && $payment_record['pay_code'] != $payment_info['pay_code'] && $order['order_amount'] != $payment_record['total_fee']) {
        	$payment_data['update_time']	= RC_Time::gmtime();
        	$db->where('order_sn', $order['order_sn'])->update($payment_data);
        }
        //增加支付状态
        $order['payment']['order_pay_status'] = $order['pay_status'];//0 未付款，1付款中，2已付款
        
        return array('payment' => $order['payment']);
	}
}

// end