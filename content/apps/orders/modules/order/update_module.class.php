<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 更新订单
 * @author royalwang
 */
class update_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
 		$user_id	= $_SESSION['user_id'];
 		if ($user_id < 1 ) {
 		    return new ecjia_error(100, 'Invalid session');
 		}
 		$order_id	= $this->requestData('order_id', 0);
		$pay_id		= $this->requestData('pay_id',0);
		if (!$order_id || !$pay_id) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
		}
		
		$payment_method = RC_Loader::load_app_class('payment_method', 'payment');
		$payment_info = $payment_method->payment_info($pay_id);
		
		RC_Loader::load_app_func('admin_order', 'orders');
		
		$order_info = get_order_detail($order_id, $user_id, 'front');
		if (is_ecjia_error($order_info)) {
		    return $order_info;
		}
// 		if (empty($payment_info) || ($payment_info['pay_code'] == 'pay_cod' && $order_info[''])) {
// 		    return new ecjia_error('payment_error', '无法使用该支付方式，请选择其他支付方式！');
// 		}
		/*重新处理订单的配送费用*/
		$payfee_change	= $payment_info['pay_fee'] - $order_info['pay_fee'];
		$order_amount	= ($order_info['order_amount'] + $payfee_change) > 0 ? $order_info['order_amount'] + $payfee_change : 0;
		$data = array(
			'pay_id'	=> $payment_info['pay_id'],
			'pay_name'	=> $payment_info['pay_name'],
			'pay_fee'	=> $payment_info['pay_fee'],
			'order_amount' => $order_amount,
		);
		$where = array(
			'order_id'			=> $order_id,
			'user_id'			=> $user_id,
			'pay_status'		=> 0,
			'shipping_status'	=> 0,
		);
		$db_order = RC_Model::model('orders/order_info_model');
		$result = $db_order->where($where)->update($data);
		if ($result) {
			return array();
		} else {
			return new ecjia_error('fail_error', '处理失败！');
		}
	}
}

// end