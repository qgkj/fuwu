<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 取消订单
 * @author royalwang
 */
class cancel_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
		$user_id = $_SESSION['user_id'];
		if ($user_id < 1 ) {
		    return new ecjia_error(100, 'Invalid session');
		}
		
		$order_id = $this->requestData('order_id', 0);
		if($user_id < 1 || $order_id <1) {
		    return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
		}
		$result = cancel_order($order_id, $user_id);
		if (!is_ecjia_error($result)) {
			
			return array();
		} else {
			return $result;
		}
	}
}

/**
 * 取消一个用户订单
 *
 * @access public
 * @param int $order_id
 *            订单ID
 * @param int $user_id
 *            用户ID
 * @return void
 */
function cancel_order ($order_id, $user_id = 0) {
    $db = RC_Model::model('orders/order_info_model');
    /* 查询订单信息，检查状态 */
    $order = $db->field('user_id, order_id, order_sn , surplus , integral , bonus_id, order_status, shipping_status, pay_status')->find(array('order_id' => $order_id));

    if (empty($order)) {
        return new ecjia_error('order_exist', RC_Lang::get('orders::order.order_not_exist'));
    }

    // 如果用户ID大于0，检查订单是否属于该用户
    if ($user_id > 0 && $order['user_id'] != $user_id) {
        return new ecjia_error('no_priv', RC_Lang::get('orders::order.no_priv'));
    }

    //TODO:未付款前都可取消，付款后取消暂不考虑
    // 订单状态只能是“未确认”或“已确认”
//     if ($order['order_status'] != OS_UNCONFIRMED && $order['order_status'] != OS_CONFIRMED) {
//         return new ecjia_error('current_os_not_unconfirmed', RC_Lang::get('orders::order.current_os_not_unconfirmed'));
//     }

    // 订单一旦确认，不允许用户取消
//     if ($order['order_status'] == OS_CONFIRMED) {
//         return new ecjia_error('current_os_already_confirmed', RC_Lang::get('orders::order.current_os_already_confirmed'));
//     }

    // 发货状态只能是“未发货”
    if ($order['shipping_status'] != SS_UNSHIPPED) {
        return new ecjia_error('current_ss_not_cancel', RC_Lang::get('orders::order.current_ss_not_cancel'));
    }

    // 如果付款状态是“已付款”、“付款中”，不允许取消，要取消和商家联系
    if ($order['pay_status'] != PS_UNPAYED) {
        return new ecjia_error('current_ps_not_cancel', RC_Lang::get('orders::order.current_ps_not_cancel'));
    }

    // 将用户订单设置为取消
    $query = $db->where(array('order_id' => $order_id))->update(array('order_status' => OS_CANCELED));
    if ($query) {
        RC_Loader::load_app_func('admin_order', 'orders');
        /* 记录log */
        order_action($order['order_sn'], OS_CANCELED, $order['shipping_status'], PS_UNPAYED, RC_Lang::get('orders::order.buyer_cancel'), 'buyer');
        /* 退货用户余额、积分、红包 */
        if ($order['user_id'] > 0 && $order['surplus'] > 0) {
        	$options = array(
        		'user_id'		=> $order['user_id'],
        		'user_money'	=> $order['surplus'],
        		'change_desc'	=> sprintf(RC_Lang::get('orders::order.return_surplus_on_cancel'), $order['order_sn'])
        	);
        	$result = RC_Api::api('user', 'account_change_log',$options);
        	if (is_ecjia_error($result)) {
        		return $result;
        	}
        }
        if ($order['user_id'] > 0 && $order['integral'] > 0) {
            $options = array(
            	'user_id'		=> $order['user_id'],
            	'pay_points'	=> $order['integral'],
            	'change_desc'	=> sprintf(RC_Lang::get('orders::order.return_integral_on_cancel'), $order['order_sn'])
            );
            $result = RC_Api::api('user', 'account_change_log', $options);
            if (is_ecjia_error($result)) {
            	return $result;
            }
        }
        if ($order['user_id'] > 0 && $order['bonus_id'] > 0) {
        	RC_Loader::load_app_func('admin_bonus', 'bonus');
            change_user_bonus($order['bonus_id'], $order['order_id'], false);
        }

        /* 如果使用库存，且下订单时减库存，则增加库存 */
        if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
            change_order_goods_storage($order['order_id'], false, 1);
        }

        /* 修改订单 */
        $arr = array(
            'bonus_id' => 0,
            'bonus' => 0,
            'integral' => 0,
            'integral_money' => 0,
            'surplus' => 0
        );
        update_order($order['order_id'], $arr);
        RC_DB::table('order_status_log')->insert(array(
	        'order_status'	=> RC_Lang::get('orders::order.order_cancel'),
	        'order_id'		=> $order['order_id'],
	        'message'		=> '您的订单已取消成功！',
	        'add_time'		=> RC_Time::gmtime(),
        ));
        return true;
    } else {
        return new ecjia_error('database_query_error', $db->error());
    }
}

// end