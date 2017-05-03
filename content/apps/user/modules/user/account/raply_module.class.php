<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 用户提现申请
 * @author royalwang
 */
class raply_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	if ($_SESSION['user_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
 		$amount = $this->requestData('amount');
 		$user_note = $this->requestData('note', '');
 		$amount = floatval($amount);
		if ($amount <= 0) {
 			$result = new ecjia_error('amount_gt_zero', __('请在“金额”栏输入大于0的数字！'));
 			return $result;
 		}
 		$user_id = $_SESSION['user_id'];
 		
 		RC_Loader::load_app_func('admin_order', 'orders');
 		/* 变量初始化 */
 		$surplus = array(
			'user_id'      => $user_id,
			'order_sn'	   => get_order_sn(),
			'account_id'   => 0,
			'process_type' => 1,
			'payment_id'   => 0,
			'user_note'    => $user_note,
			'amount'       => $amount
 		);
 		
 		RC_Loader::load_app_func('admin_user', 'user');
 		/* 判断是否有足够的余额的进行退款的操作 */
 		$sur_amount = get_user_surplus($user_id);
 		if ($amount > $sur_amount) {
 			$result = new ecjia_error('surplus_amount_error', __('您要申请提现的金额超过了您现有的余额，此操作将不可进行！'));
//  			return $result;
 		}
 		
 		//插入会员账目明细
 		$insert_amount = '-'.$amount;
 		$surplus['payment'] = '';
 		$surplus['account_id']  = insert_user_account($surplus, $insert_amount);
 		
 		/* 如果成功提交 */
 		if ($surplus['account_id'] > 0) {
 			
 			/* 插入支付流水记录*/
 			$db = RC_DB::table('payment_record');
 			$payment_record = $db->where('order_sn', $surplus['order_sn'])->first();
 			$payment_data = array(
				'order_sn'		=> $surplus['order_sn'],
				'trade_type'	=> 'withdraw',
				'total_fee'		=> $amount,
				'pay_status'	=> 0,
 			);
 			if (empty($payment_record)) {
 				$payment_data['create_time']	= RC_Time::gmtime();
 				$db->insertGetId($payment_data);
 			} elseif($payment_record['pay_status'] == 0 && $amount != $payment_record['total_fee']) {
 				$payment_data['update_time']	= RC_Time::gmtime();
 				$db->where('order_sn', $surplus['order_sn'])->update($payment_data);
 			}
 			
 			return array('data' => "您的提现申请已成功提交，请等待管理员的审核！");
 		} else {
 			$result = new ecjia_error('process_false', __('此次操作失败，请返回重试！'));
 			return $result;
 		}
	}
}

// end