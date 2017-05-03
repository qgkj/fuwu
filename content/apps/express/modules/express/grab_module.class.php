<?php
  
use Ecjia\System\Notifications\ExpressGrab;
defined('IN_ECJIA') or exit('No permission resources.');


/**
 * 配送抢单列表
 * @author will.chen
 */
class grab_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        
		$location	= $this->requestData('location', array());
		$express_id = $this->requestData('express_id');
		
		if (empty($express_id)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
		$where                = array('store_id' => $_SESSION['store_id'], 'staff_id' => 0, 'express_id' => $express_id);
		
		$express_order_db     = RC_Model::model('express/express_order_model');
		$express_order_info   = $express_order_db->where($where)->find();
		
		if (!empty($express_order_info)) {
			$update_date                     = array('staff_id' => $_SESSION['staff_id'], 'from' => 'grab', 'status' => 1, 'receive_time' => RC_Time::gmtime());
			$update_date['express_user']	 = $_SESSION['staff_name'];
			$update_date['express_mobile']	 = $_SESSION['staff_mobile'];
			
			$result                  = $express_order_db->where($where)->update($update_date);
			$orm_staff_user_db       = RC_Model::model('express/orm_staff_user_model');
			$user                    = $orm_staff_user_db->find($_SESSION['staff_id']);
			$express_order_viewdb    = RC_Model::model('express/express_order_viewmodel');
			
			$where                   = array('staff_id' => $_SESSION['staff_id'], 'express_id' => $express_id);
			$field                   = 'eo.*, oi.add_time as order_time, oi.pay_time, oi.order_amount, oi.pay_name, sf.merchants_name, sf.address as merchant_address, sf.longitude as merchant_longitude, sf.latitude as merchant_latitude';
			$express_order_info      = $express_order_viewdb->field($field)->join(array('delivery_order', 'order_info', 'store_franchisee'))->where($where)->find();
			
			$express_data            = array(
				'title'	=> '抢单成功',
				'body'	=> '您已成功抢到配送单号，单号为：'.$express_order_info['express_sn'],
				'data'	=> array(
					'express_id'	        => $express_order_info['express_id'],
					'express_sn'	        => $express_order_info['express_sn'],
					'express_type'	        => $express_order_info['from'],
					'label_express_type'	=> $express_order_info['from'] == 'assign' ? '系统派单' : '抢单',
					'order_sn'		        => $express_order_info['order_sn'],
					'payment_name'	        => $express_order_info['pay_name'],
					'express_from_address'	=> '【'.$express_order_info['merchants_name'].'】'. $express_order_info['merchant_address'],
					'express_from_location'	=> array(
						'longitude'     => $express_order_info['merchant_longitude'],
						'latitude'	    => $express_order_info['merchant_latitude'],
					),
					'express_to_address'	=> $express_order_info['address'],
					'express_to_location'	=> array(
						'longitude'     => $express_order_info['longitude'],
						'latitude'	    => $express_order_info['latitude'],
					),
					'distance'		=> $express_order_info['distance'],
					'consignee'		=> $express_order_info['consignee'],
					'mobile'		=> $express_order_info['mobile'],
					'order_time'	=> RC_Time::local_date(ecjia::config('time_format'), $express_order_info['add_time']),
					'pay_time'		=> empty($express_order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $express_order_info['pay_time']),
					'best_time'		=> empty($express_order_info['best_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $express_order_info['best_time']),
					'shipping_fee'	=> $express_order_info['shipping_fee'],
					'order_amount'	=> $express_order_info['order_amount'],
				),
			);
			$express_grab = new ExpressGrab($express_data);
			RC_Notification::send($user, $express_grab);
			
			/*推送消息*/
			$devic_info = RC_Api::api('mobile', 'device_info', array('user_type' => 'merchant', 'user_id' => $_SESSION['staff_id']));
			if (!is_ecjia_error($devic_info) && !empty($devic_info)) {
				$push_event = RC_Model::model('push/push_event_viewmodel')->where(array('event_code' => 'express_grab', 'is_open' => 1, 'status' => 1, 'mm.app_id is not null', 'mt.template_id is not null', 'device_code' => $devic_info['device_code'], 'device_client' => $devic_info['device_client']))->find();
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
			return array();
		} else {
			return new ecjia_error('grab_error', '此单已被抢！');
		}
	 }	
}

// end