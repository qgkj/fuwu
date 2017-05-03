<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 用户充值付款
 * @author royalwang
 */
class pay_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
    	if ($_SESSION['user_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
 		//变量初始化
 		$account_id = $this->requestData('account_id', 0);
 		$payment_id = $this->requestData('payment_id', 0);
 		$user_id = $_SESSION['user_id'];
	
 		if ($account_id <= 0 || $payment_id <= 0) {
	    	return new ecjia_error(101, '参数错误');
	    }
	    if (!$user_id) {
	        return new ecjia_error(100, 'Invalid session' );
	    }
	    
	    //获取单条会员帐目信息
	    $order = get_surplus_info($account_id, $user_id);
	    if (empty($order)) {
	        return new ecjia_error('deposit_log_not_exist', '充值记录不存在');
	    }
	    
	    $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
	    //支付方式的信息
	    $payment_info = array();
	    $payment_info = $payment_method->payment_info($payment_id);
	
	    /* 如果当前支付方式没有被禁用，进行支付的操作 */
	    if (!empty($payment_info)) {
	        //取得支付信息，生成支付代码
	        $payment_config = $payment_method->unserialize_config($payment_info['pay_config']);
	
	        //获取需要支付的log_id
	        $order['log_id'] = $payment_method->get_paylog_id($account_id, $pay_type = PAY_SURPLUS);
	
	        $order['user_name']      = $_SESSION['user_name'];
	        $order['surplus_amount'] = $order['amount'];
	        
			RC_Loader::load_app_func('admin_order', 'orders');
	        //计算支付手续费用
	        $payment_info['pay_fee'] = pay_fee($payment_id, $order['surplus_amount'], 0);
	
	        //计算此次预付款需要支付的总金额
	        $order['order_amount']   = strval($order['surplus_amount'] + $payment_info['pay_fee']);
	

	        
	        if (!empty($order['log_id'])) {
	        	//如果支付费用改变了，也要相应的更改pay_log表的order_amount
	        	$pay_db = RC_Model::model('orders/pay_log_model');
	        	$order_amount = $pay_db-> where(array('log_id' => $order['log_id']))->get_field('order_amount');
	        	if ($order_amount <> $order['order_amount']) {
	        		$pay_db->where(array('log_id' => $order['log_id']))->update(array('order_amount' => $order['order_amount']));
	        	}
	        } else {
	        	$order['log_id'] = strval($payment_method->insert_pay_log($order['id'], $order['order_amount'], PAY_SURPLUS, 0));
	        }

	        $handler = $payment_method->get_payment_instance($payment_info['pay_code'], $payment_config);
	        $handler->set_orderinfo($order);
	        $handler->set_mobile(true);
	        	
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
        		'trade_type'	=> 'deposit',
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
	        
	        return array('payment' => $order['payment']);
	    } else {
	    	/* 重新选择支付方式 */
	    	$result = new ecjia_error('select_payment_pls_again', __('支付方式无效，请重新选择支付方式！'));
 			return $result;
	    }
	}
}

/**
 * 根据ID获取当前余额操作信息
 *
 * @access  public
 * @param   int     $account_id  会员余额的ID
 *
 * @return  int
 */
function get_surplus_info($account_id, $user_id) {
	$db = RC_Model::model('user/user_account_model');
	
	return $db->find(array('id' => $account_id, 'user_id' => $user_id));
}

// end