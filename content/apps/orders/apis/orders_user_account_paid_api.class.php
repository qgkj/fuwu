<?php
  
use Ecjia\System\Notifications\OrderPay;
defined('IN_ECJIA') or exit('No permission resources.');


/**
 * 余额支付后处理订单的接口
 * @author royalwang
 */
class orders_user_account_paid_api extends Component_Event_Api {
	
    /**
     * @param  $options['user_id'] 会员id
     *         $options['order_id'] 订单id
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options) 
	        || !isset($options['user_id']) 
	        || !isset($options['order_id'])) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
	    }
	    
	    $result = $this->user_account_paid($options['user_id'], $options['order_id']);
	    
	    if (is_ecjia_error($result)) {
	    	return $result;
	    } else {
	    	return true;
	    }
	    
	}
	
	/**
	 * 余额支付
	 *
	 * @access  public
	 * @param   integer $user_id 用户id
	 * @param   integer $order_id 订单id
	 * @return  void
	 */
	private function user_account_paid($user_id, $order_id) {
		RC_Loader::load_app_func('admin_order', 'orders');
		
		/* 订单详情 */
		$order_info = RC_Api::api('orders', 'order_info', array('order_id' => $order_id));
		if ($user_id != $order_info['user_id']) {
			return new ecjia_error('error_order_detail', RC_Lang::get('orders::order.error_order_detail'));
		}
		/* 会员详情*/
		$user_info = RC_Api::api('user', 'user_info', array('user_id' => $user_id));

		/* 检查订单是否已经付款 */
		if ($order_info['pay_status'] == PS_PAYED && $order_info['pay_time']) {
			return new ecjia_error('order_paid', RC_Lang::get('orders::order.pay_repeat_message'));
		}
		
		/* 检查订单金额是否大于余额 */
		if ($order_info['order_amount'] > ($user_info['user_money'] + $user_info['credit_line'])) {
			return new ecjia_error('balance_less', RC_Lang::get('orders::order.not_enough_balance'));
		}
		
		/* 更新订单表支付后信息 */
		$data = array(
			'order_status'    => OS_CONFIRMED,
			'confirm_time'    => RC_Time::gmtime(),
			'pay_status'      => PS_PAYED,
			'pay_time'        => RC_Time::gmtime(),
			'order_amount'    => 0,
			'surplus'         => $order_info['order_amount'],
		);
		
		/*更新订单状态及信息*/
		update_order($order_info['order_id'], $data);
		
		
		/* 处理余额变动信息 */
		if ($order_info['user_id'] > 0 && $data['surplus'] > 0) {
			$options = array(
				'user_id'       => $order_info['user_id'],
				'user_money'    => $order_info['order_amount'] * (-1),
				'change_desc'	=> sprintf(RC_Lang::get('orders::order.pay_order'), $order_info['order_sn'])
			);
			RC_Api::api('user', 'account_change_log', $options);
			/* 插入支付日志 */
			$payment_method = RC_Loader::load_app_class('payment_method', 'payment');
			$payment_method->insert_pay_log($order_info['order_id'], $order_info['order_amount'], PAY_SURPLUS);
		}
		
		order_action($order_info['order_sn'], OS_CONFIRMED, SS_UNSHIPPED, PS_PAYED, '', RC_Lang::get('orders::order.buyers'));
		
		$db = RC_DB::table('payment_record');
		$db->where('order_sn', $order_info['order_sn'])->where('pay_status', 'buy')->update(array('pay_time' => RC_Time::gmtime(), 'pay_status' => 1));
		
		RC_Api::api('affiliate', 'invite_reward', array('user_id' => $order_info['user_id'], 'invite_type' => 'orderpay'));
		
		$data = array(
			'order_status'	=> RC_Lang::get('orders::order.ps.'.PS_PAYED),
			'order_id'		=> $order_info['order_id'],
			'message'		=> RC_Lang::get('orders::order.notice_merchant_message'),
			'add_time'		=> RC_Time::gmtime(),
		);
		RC_DB::table('order_status_log')->insert($data);
		
		
		RC_DB::table('order_status_log')->insert(array(
			'order_status'	=> RC_Lang::get('cart::shopping_flow.merchant_process'),
			'order_id'		=> $order_info['order_id'],
			'message'		=> '订单已通知商家，等待商家处理',
			'add_time'		=> RC_Time::gmtime(),
		));
		
		
		$result = ecjia_app::validate_application('sms');
		if (!is_ecjia_error($result)) {
			/* 客户付款短信提醒 */
			if (ecjia::config('sms_order_payed') == '1' && ecjia::config('sms_shop_mobile') != '') {
				//发送短信
				$tpl_name = 'order_payed_sms';
				$tpl = RC_Api::api('sms', 'sms_template', $tpl_name);
				if (!empty($tpl)) {
					ecjia_front::$controller->assign('order_sn', $order_info['order_sn']);
					ecjia_front::$controller->assign('consignee', $order_info['consignee']);
					ecjia_front::$controller->assign('mobile', $order_info['mobile']);
					ecjia_front::$controller->assign('order_amount', $order_info['order_amount']);
					$content = ecjia_front::$controller->fetch_string($tpl['template_content']);
			
					$options = array(
						'mobile' 		=> ecjia::config('sms_shop_mobile'),
						'msg'			=> $content,
						'template_id' 	=> $tpl['template_id'],
					);
					$response = RC_Api::api('sms', 'sms_send', $options);
				}
			}
		}
		
		/* 客户付款通知（默认通知店长）*/
		/* 获取店长的记录*/
		$devic_info = $staff_user = array();
		$staff_user = RC_DB::table('staff_user')->where('store_id', $order_info['store_id'])->where('parent_id', 0)->first();
		if (!empty($staff_user)) {
			$devic_info = RC_Api::api('mobile', 'device_info', array('user_type' => 'merchant', 'user_id' => $staff_user['user_id']));
		}
		
		if (!is_ecjia_error($devic_info) && !empty($devic_info)) {
			$push_event = RC_Model::model('push/push_event_viewmodel')->where(array('event_code' => 'order_pay', 'is_open' => 1, 'status' => 1, 'mm.app_id is not null', 'mt.template_id is not null', 'device_code' => $devic_info['device_code'], 'device_client' => $devic_info['device_client']))->find();
			 
			if (!empty($push_event)) {
				/* 通知记录*/
				$orm_staff_user_db = RC_Model::model('express/orm_staff_user_model');
				$staff_user_ob = $orm_staff_user_db->find($staff_user['user_id']);
				
				$order_data = array(
					'title'	=> '客户付款',
					'body'	=> '您有一笔新订单，订单号为：'.$order_info['order_sn'],
					'data'	=> array(
						'order_id'		=> $order_info['order_id'],
						'order_sn'		=> $order_info['order_sn'],
						'order_amount'	=> $order_info['order_amount'],
						'formatted_order_amount' => price_format($order_info['order_amount']),
						'consignee'		=> $order_info['consignee'],
						'mobile'		=> $order_info['mobile'],
						'address'		=> $order_info['address'],
						'order_time'	=> RC_Time::local_date(ecjia::config('time_format'), $order_info['add_time']),
					),
				);
				 
				$push_order_pay = new OrderPay($order_data);
				RC_Notification::send($staff_user_ob, $push_order_pay);

				RC_Loader::load_app_class('push_send', 'push', false);
				ecjia_admin::$controller->assign('order', $order_info);
				$content = ecjia_admin::$controller->fetch_string($push_event['template_content']);
		
				if ($devic_info['device_client'] == 'android') {
					$result = push_send::make($push_event['app_id'])->set_client(push_send::CLIENT_ANDROID)->set_field(array('open_type' => 'admin_message'))->send($devic_info['device_token'], $push_event['template_subject'], $content, 0, 1);
				} elseif ($devic_info['device_client'] == 'iphone') {
					$result = push_send::make($push_event['app_id'])->set_client(push_send::CLIENT_IPHONE)->set_field(array('open_type' => 'admin_message'))->send($devic_info['device_token'], $push_event['template_subject'], $content, 0, 1);
				}
			}
		}
		return true;
    }
}

// end