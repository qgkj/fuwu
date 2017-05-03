<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单通知
 * @author will
 */
class orders_remind_order_api extends Component_Event_Api {
	
	public function call(&$options) {
		if (empty($_SESSION['last_check'])) {
			$_SESSION['last_check'] = RC_Time::gmtime();
			return array('new_orders' => 0, 'new_paid' => 0);
		}
		
		$arr['new_orders'] = RC_DB::table('order_info')->where('add_time', '<=', $_SESSION['last_check'])->where('is_delete', 0)->count();
		$arr['new_paid'] = RC_DB::table('order_info')->where('pay_time', '<=', $_SESSION['last_check'])->where('is_delete', 0)->count();
		
		$_SESSION['last_check'] = RC_Time::gmtime();
		if (!(is_numeric($arr['new_orders']) && is_numeric($arr['new_paid']))) {
			return array('new_orders' => 0, 'new_paid' => 0);
		} else {
			return array('new_orders' => $arr['new_orders'], 'new_paid' => $arr['new_paid']);
		}
	}
}


// end