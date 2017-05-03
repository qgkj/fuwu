<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单统计
 * @author will
 */
class orders_orders_stats_api extends Component_Event_Api {
	
	public function call(&$options) {
		$cache_key = 'api_order_stats_'.md5($_SESSION['admin_id']);
        $stats = RC_Cache::app_cache_get($cache_key, 'order');
        
        if (!$stats) {
			$db_order_info = RC_DB::table('order_info');
			/* 获取订单总数*/
			$stats['total'] = $db_order_info->count();
			/* 获取订单金额*/
			$stats['amount'] = $db_order_info->sum('order_amount');
			
			RC_Cache::app_cache_set($cache_key, $stats, 'order', 120);//2小时缓存
        }
		return $stats;
	}
}


// end