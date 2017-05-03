<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单详情接口
 * @author royalwang
 */
class orders_order_info_api extends Component_Event_Api {
    /**
     * @param  $options['order_id'] 订单ID
     *         $options['order_sn'] 订单号
     *
     * @return array
     */
	public function call(&$options) {
	    if (!is_array($options) || (!isset($options['order_id']) && !isset($options['order_sn']))) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
	    }
		return $this->order_info($options['order_id'], $options['order_sn'], $options['store_id'], $options['user_id']);
	}

	/**
	 * 取得订单信息
	 * @param   int	 $order_id   订单id（如果order_id > 0 就按id查，否则按sn查）
	 * @param   string  $order_sn   订单号
	 * @return  array   订单信息（金额都有相应格式化的字段，前缀是formated_）
	 */
	private function order_info($order_id, $order_sn = '', $store_id = 0, $user_id = 0) {
	    $db_order_info = RC_DB::table('order_info');
	    /* 计算订单各种费用之和的语句 */
	    $total_fee = " (goods_amount - discount + tax + shipping_fee + insure_fee + pay_fee + pack_fee + card_fee) AS total_fee ";
	    $order_id = intval($order_id);

	    $db_order_info->selectRaw('*, '.$total_fee);
	    if ($order_id > 0) {
	        $db_order_info->where('order_id', $order_id);
	    } else {
	        $db_order_info->where('order_sn', $order_sn);
	    }
        if(!empty($store_id)){
            $db_order_info->where('store_id', $store_id);
        }
        $db_order_info->where('is_delete', 0);
	    $order = $db_order_info->first();

	    /* 格式化金额字段 */
	    if ($order) {
	        $order['formated_goods_amount']		= price_format($order['goods_amount'], false);
	        $order['formated_discount']			= price_format($order['discount'], false);
	        $order['formated_tax']				= price_format($order['tax'], false);
	        $order['formated_shipping_fee']		= price_format($order['shipping_fee'], false);
	        $order['formated_insure_fee']		= price_format($order['insure_fee'], false);
	        $order['formated_pay_fee']			= price_format($order['pay_fee'], false);
	        $order['formated_pack_fee']			= price_format($order['pack_fee'], false);
	        $order['formated_card_fee']			= price_format($order['card_fee'], false);
	        $order['formated_total_fee']		= price_format($order['total_fee'], false);
	        $order['formated_money_paid']		= price_format($order['money_paid'], false);
	        $order['formated_bonus']			= price_format($order['bonus'], false);
	        $order['formated_integral_money']	= price_format($order['integral_money'], false);
	        $order['formated_surplus']			= price_format($order['surplus'], false);
	        $order['formated_order_amount']		= price_format(abs($order['order_amount']), false);
	        $order['formated_add_time']			= RC_Time::local_date(ecjia::config('time_format'), $order['add_time']);
	        
	        // 检查订单是否属于该用户
	        if ($user_id > 0 && $user_id != $order['user_id']) {
	        	return new ecjia_error('orders_error', '未找到相应订单！');
	        }
	        
	        $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
	        if ($order['pay_id'] > 0) {
	        	$payment = $payment_method->payment_info_by_id($order['pay_id']);
	        }
	        
	        if (in_array($order['order_status'], array(OS_CONFIRMED, OS_SPLITED)) &&
	        in_array($order['shipping_status'], array(SS_RECEIVED)) &&
	        in_array($order['pay_status'], array(PS_PAYED, PS_PAYING)))
	        {
	        	$order['label_order_status'] = '已完成';
	        	$order['status_code'] = 'finished';
	        }
	        elseif (in_array($order['shipping_status'], array(SS_SHIPPED)))
	        {
	        	$order['label_order_status'] = '待收货';
	        	$order['status_code'] = 'shipped';
	        }
	        elseif (in_array($order['order_status'], array(OS_CONFIRMED, OS_SPLITED, OS_UNCONFIRMED)) &&
	        		in_array($order['pay_status'], array(PS_UNPAYED)) &&
	        		(in_array($order['shipping_status'], array(SS_SHIPPED, SS_RECEIVED)) || !$payment['is_cod']))
	        {
	        	$order['label_order_status'] = '待付款';
	        	$order['status_code'] = 'await_pay';
	        }
	        elseif (in_array($order['order_status'], array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) &&
	        		in_array($order['shipping_status'], array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) &&
	        		(in_array($order['pay_status'], array(PS_PAYED, PS_PAYING)) || $payment['is_cod']))
	        {
	        	$order['label_order_status'] = '待发货';
	        	$order['status_code'] = 'await_ship';
	        }
	        elseif (in_array($order['order_status'], array(OS_CANCELED))) {
	        	$order['label_order_status'] = '已取消';
	        	$order['status_code'] = 'canceled';
	        }
	        
	        /* 对发货号处理 */
	        if (! empty($order['invoice_no'])) {
	        	$shipping_code = RC_Model::model('shipping/shipping_model')->field('shipping_code')->find('shipping_id = ' . $order['shipping_id']);
	        	$shipping_code = $shipping_code['shipping_code'];
	        }
	        
	        /* 只有未确认才允许用户修改订单地址 */
	        if ($order['order_status'] == OS_UNCONFIRMED) {
	        	$order['allow_update_address'] = 1; // 允许修改收货地址
	        } else {
	        	$order['allow_update_address'] = 0;
	        }
	        
	        /* 获取订单中实体商品数量 */
	        $order['exist_real_goods'] = RC_DB::table('order_goods')->where('order_id', $order_id)->where('is_real', 1)->count();
	        
	        $pay_method = RC_Loader::load_app_class('payment_method', 'payment');
	        // 获取需要支付的log_id
	        $order['log_id'] = $pay_method->get_paylog_id($order['order_id'], $pay_type = PAY_ORDER);
	        
	        $order['user_name'] = $_SESSION['user_name'];
	        
	        /* 无配送时的处理 */
	        $order['shipping_id'] == - 1 and $order['shipping_name'] = RC_Lang::get('orders::order.shipping_not_need');
	        
	        /* 其他信息初始化 */
	        $order['how_oos_name'] = $order['how_oos'];
	        $order['how_surplus_name'] = $order['how_surplus'];
	        
	        /* 确认时间 支付时间 发货时间 */
	        if ($order['confirm_time'] > 0 && ($order['order_status'] == OS_CONFIRMED || $order['order_status'] == OS_SPLITED || $order['order_status'] == OS_SPLITING_PART)) {
	        	$order['confirm_time'] =  RC_Time::local_date(ecjia::config('time_format'), $order['confirm_time']);
	        } else {
	        	$order['confirm_time'] = '';
	        }
	        if ($order['pay_time'] > 0 && $order['pay_status'] != PS_UNPAYED) {
	        	$order['pay_time'] =  RC_Time::local_date(ecjia::config('time_format'), $order['pay_time']);
	        } else {
	        	$order['pay_time'] = '';
	        }
	        if ($order['shipping_time'] > 0 && in_array($order['shipping_status'], array(
	        		SS_SHIPPED,
	        		SS_RECEIVED
	        ))) {
	        	$order['shipping_time'] = RC_Time::local_date(ecjia::config('time_format'), $order['shipping_time']);
	        } else {
	        	$order['shipping_time'] = '';
	        }
	    }
	    
	    return $order;
	}
}

// end