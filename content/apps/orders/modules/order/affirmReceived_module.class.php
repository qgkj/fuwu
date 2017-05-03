<?php
  
use Ecjia\System\Notifications\ExpressFinished;
defined('IN_ECJIA') or exit('No permission resources.');


/**
 * 订单确认收货
 * @author royalwang
 */
class affirmReceived_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	
		$user_id = $_SESSION['user_id'];
		if ($user_id < 1) {
		    return new ecjia_error(100, 'Invalid session');
		}
		$order_id = $this->requestData('order_id', 0);
		if ($order_id < 1) {
		    return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}
		
		$result = affirm_received(intval($order_id), $user_id);	
		if (!is_ecjia_error($result)) {
		    RC_Api::api('commission', 'add_bill_detail', array('order_type' => 1, 'order_id' => $order_id));
		    return array();
		} else {
			return new ecjia_error(8, 'fail');
		}
	}
}


/**
 * 确认一个用户订单
 *
 * @access public
 * @param int $order_id
 *            订单ID
 * @param int $user_id
 *            用户ID
 * @return bool $bool
 */
function affirm_received($order_id, $user_id = 0) {
    $db = RC_Model::model('orders/order_info_model');
    /* 查询订单信息，检查状态 */
    $order = $db->field('user_id, order_sn, order_status, shipping_status, pay_status, shipping_id')->find(array('order_id' => $order_id));

    // 如果用户ID大于 0 。检查订单是否属于该用户
    if ($user_id > 0 && $order['user_id'] != $user_id) {
        return new ecjia_error('no_priv', RC_Lang::get('orders::order.no_priv'));
    }    /* 检查订单 */
    elseif ($order['shipping_status'] == SS_RECEIVED) {
        return new ecjia_error('order_already_received', RC_Lang::get('orders::order.order_already_received'));
    } elseif ($order['shipping_status'] != SS_SHIPPED) {
        return new ecjia_error('order_invalid', RC_Lang::get('orders::order.order_invalid'));
    }     /* 修改订单发货状态为“确认收货” */
    else {
        $data['shipping_status'] = SS_RECEIVED;
        //如果货到付款，修改付款状态为已付款
        if ($order['pay_id']) {
            $payment = RC_DB::table('payment')->where('pay_id', $order['pay_id'])->first();
            if ($payment['is_cod'] == 1) {
                $data['pay_status'] = PS_PAYED;
            }
        }
        $query = $db->where(array('order_id' => $order_id))->update($data);
        if ($query) {
        	$db_order_status_log = RC_Model::model('orders/order_status_log_model');
        	$order_status_data = array(
        		'order_status' => RC_Lang::get('orders::order.confirm_receipted'),
        		'order_id' 	   => $order_id,
        		'message'	   => '宝贝已签收，购物愉快！',
        		'add_time'	   => RC_Time::gmtime()
        	);
        	$db_order_status_log->insert($order_status_data);
        	
        	
        	$order_status_data = array(
            	'order_status' => RC_Lang::get('orders::order.order_finished'),
            	'order_id' 	   => $order_id,
            	'message'	   => '感谢您在'.ecjia::config('shop_name').'购物，欢迎您再次光临！',
            	'add_time'	   => RC_Time::gmtime()
            );
            $db_order_status_log->insert($order_status_data);
            
            /* 判断是否是配送员送货*/
            $express_info = RC_DB::table('express_order')->where('order_sn', $order['order_sn'])->first();
            if (!empty($express_info) && $express_info['status'] != 5) {
            	$orm_staff_user_db = RC_Model::model('express/orm_staff_user_model');
            	$user = $orm_staff_user_db->find($express_info['staff_id']);
            	
            	$express_order_viewdb = RC_Model::model('express/express_order_viewmodel');
            	$where = array('staff_id' => $express_info['staff_id'], 'express_id' => $express_info['express_id']);
            	$field = 'eo.*, oi.add_time as order_time, oi.pay_time, oi.order_amount, oi.pay_name, sf.merchants_name, sf.address as merchant_address, sf.longitude as merchant_longitude, sf.latitude as merchant_latitude';
            	$express_order_info = $express_order_viewdb->field($field)->join(array('delivery_order', 'order_info', 'store_franchisee'))->where($where)->find();
            		
            	$express_data = array(
            		'title'     => '配送成功',
            		'body'      => '买家已成功确认收货！配送单号为：'.$express_order_info['express_id'],
            		'data'      => array(
	            		'express_id'            => $express_order_info['express_id'],
	            		'express_sn'         	=> $express_order_info['express_sn'],
	            		'express_type'  		=> $express_order_info['from'],
	            		'label_express_type'    => $express_order_info['from'] == 'assign' ? '系统派单' : '抢单',
	            		'order_sn'           	=> $express_order_info['order_sn'],
	            		'payment_name'        	=> $express_order_info['pay_name'],
	            		'express_from_address'  => '【'.$express_order_info['merchants_name'].'】'. $express_order_info['merchant_address'],
	            		'express_from_location' => array(
	            			'longitude' => $express_order_info['merchant_longitude'],
	            			'latitude'  => $express_order_info['merchant_latitude'],
	 					),
	          			'express_to_address'    => $express_order_info['address'],
	            		'express_to_location'   => array(
	            			'longitude' 		=> $express_order_info['longitude'],
	            			'latitude'  		=> $express_order_info['latitude'],
	            		),
	            		'distance'        	=> $express_order_info['distance'],
	            		'consignee'       	=> $express_order_info['consignee'],
	            		'mobile'          	=> $express_order_info['mobile'],
	            		'order_time'      	=> RC_Time::local_date(ecjia::config('time_format'), $express_order_info['add_time']),
	            		'pay_time'       	=> empty($express_order_info['pay_time']) 	? '' : RC_Time::local_date(ecjia::config('time_format'), $express_order_info['pay_time']),
	            		'best_time'       	=> empty($express_order_info['best_time']) 	? '' : RC_Time::local_date(ecjia::config('time_format'), $express_order_info['best_time']),
	            		'shipping_fee'    	=> $express_order_info['shipping_fee'],
	            		'order_amount'    	=> $express_order_info['order_amount'],
            		),
            	);
            	$express_finished = new ExpressFinished($express_data);
            	RC_Notification::send($user, $express_finished);
            	RC_DB::table('express_order')->where('express_id', $express_info['express_id'])->update(array('status' => 5, 'signed_time' => RC_Time::gmtime()));
            	
            	/*推送消息*/
            	$devic_info = RC_Api::api('mobile', 'device_info', array('user_type' => 'merchant', 'user_id' => $express_info['staff_id']));
            	if (!is_ecjia_error($devic_info) && !empty($devic_info)) {
            		$push_event = RC_Model::model('push/push_event_viewmodel')->where(array('event_code' => 'express_confirm', 'is_open' => 1, 'status' => 1, 'mm.app_id is not null', 'mt.template_id is not null', 'device_code' => $devic_info['device_code'], 'device_client' => $devic_info['device_client']))->find();
            		if (!empty($push_event)) {
            			RC_Loader::load_app_class('push_send', 'push', false);
            			ecjia_admin::$controller->assign('express_info', $express_order_info);
            			$content = ecjia_admin::$controller->fetch_string($push_event['template_content']);
            			 
            			if ($devic_info['device_client'] == 'android') {
            				$result = push_send::make($push_event['app_id'])->set_client(push_send::CLIENT_ANDROID)->set_field(array('open_type' => 'admin_message'))->send($devic_info['device_token'], $push_event['template_subject'], $content, 0, 1);
            			} elseif ($devic_info['device_client'] == 'iphone') {
            				$result = push_send::make($push_event['app_id'])->set_client(push_send::CLIENT_IPHONE)->set_field(array('open_type' => 'admin_message'))->send($devic_info['device_token'], $push_event['template_subject'], $content, 0, 1);
            			}
            		}
            	}
            	
            	/* 更新配送员相关信息*/
            	$express_user = RC_DB::table('express_user')->where('user_id', $express_info['staff_id'])->first();
            	if ($express_user) {
            		RC_DB::table('express_user')->where('user_id', $express_info['staff_id'])->increment('delivery_count', 1);
            		RC_DB::table('express_user')->where('user_id', $express_info['staff_id'])->increment('delivery_distance', $express_info['distance']);
            		RC_DB::table('express_user')->where('user_id', $express_info['staff_id'])->update(array('longitude' => $express_info['longitude'], 'latitude' => $express_info['latitude']));
            	} else {
            		RC_DB::table('express_user')->insert(array('user_id' => $express_info['staff_id'], 'store_id' => $express_info['store_id'], 'delivery_count' => 1, 'delivery_distance' => $express_info['distance'], 'longitude' => $express_info['longitude'], 'latitude' => $express_info['latitude']));
            	}
            }
            
            /* 记录日志 */
        	RC_Loader::load_app_func('admin_order', 'orders');
            order_action($order['order_sn'], $order['order_status'], SS_RECEIVED, $order['pay_status'], '', '买家');
            return true;
        } else {
            return new ecjia_error('database_query_error', $db->error());
        }
    }
}

// end