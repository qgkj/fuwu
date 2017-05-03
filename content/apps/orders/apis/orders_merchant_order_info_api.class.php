<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单详情接口
 * @author royalwang
 */
class orders_merchant_order_info_api extends Component_Event_Api {
    /**
     * @param  $options['order_id'] 订单ID
     *         $options['order_sn'] 订单号
     *
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options) 
	        || (!isset($options['order_id']) 
	        && !isset($options['order_sn']))) {
	        return new ecjia_error('invalid_parameter', '参数无效');
	    }
		return $this->order_info($options['order_id'], $options['order_sn']);
	}
	
	
	/**
	 * 取得订单信息
	 * @param   int	 $order_id   订单id（如果order_id > 0 就按id查，否则按sn查）
	 * @param   string  $order_sn   订单号
	 * @return  array   订单信息（金额都有相应格式化的字段，前缀是formated_）
	 */
	private function order_info($order_id, $order_sn = '') {
	    /* 计算订单各种费用之和的语句 */
	    $total_fee = " (goods_amount - discount + tax + shipping_fee + insure_fee + pay_fee + pack_fee + card_fee) AS total_fee ";
	    $order_id = intval($order_id);
	    if ($order_id > 0) {
	        $order = RC_DB::table('order_info')->selectRaw('*,'.$total_fee)->where('order_id', $order_id)->where('is_delete', 0)->first();
	    } else {
	        $order = RC_DB::table('order_info')->selectRaw('*,'.$total_fee)->where('order_sn', $order_sn)->where('is_delete', 0)->first();
	    }
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
	    }
	    return $order;
	}
}

// end