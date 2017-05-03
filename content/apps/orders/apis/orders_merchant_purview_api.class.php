<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class orders_merchant_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
        	array('action_name' => RC_Lang::get('orders::order.order_view'), 	'action_code' => 'order_view', 		'relevance' => ''),
        	array('action_name' => RC_Lang::get('orders::order.order_edit'), 	'action_code' => 'order_edit', 		'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('orders::order.order_ss_edit'), 'action_code' => 'order_ss_edit', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('orders::order.order_ps_edit'), 'action_code' => 'order_ps_edit', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('orders::order.order_os_edit'), 'action_code' => 'order_os_edit', 	'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('orders::order.delivery_view'), 	'action_code' => 'delivery_view', 		'relevance' => ''),
        	array('action_name' => RC_Lang::get('orders::order.back_view'), 		'action_code' => 'back_view', 			'relevance' => ''),
        	array('action_name' => RC_Lang::get('orders::order.remind_order_view'),	'action_code' => 'remind_order_view',	'relevance' => ''),
        		
        	array('action_name' => __('订单统计'), 'action_code' => 'order_stats', 			'relevance'   => ''),
        	array('action_name' => __('销售概况'), 'action_code' => 'sale_general_stats', 	'relevance'   => ''),
        	array('action_name' => __('销售明细'), 'action_code' => 'sale_list_stats', 		'relevance'   => ''),
        	array('action_name' => __('销售排行'), 'action_code' => 'sale_order_stats', 		'relevance'   => ''),
        );
        
        return $purviews;
    }
}

// end