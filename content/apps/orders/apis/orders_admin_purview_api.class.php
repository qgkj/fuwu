<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class orders_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            array('action_name' => RC_Lang::get('orders::order.order_ss_edit'), 'action_code' => 'order_ss_edit', 	'relevance' => ''),
            array('action_name' => RC_Lang::get('orders::order.order_ps_edit'), 'action_code' => 'order_ps_edit', 	'relevance' => ''),
            array('action_name' => RC_Lang::get('orders::order.order_os_edit'), 'action_code' => 'order_os_edit', 	'relevance' => ''),
            array('action_name' => RC_Lang::get('orders::order.order_edit'), 	'action_code' => 'order_edit', 		'relevance' => ''),
            array('action_name' => RC_Lang::get('orders::order.order_view'), 	'action_code' => 'order_view', 		'relevance' => ''),
        		
            array('action_name' => RC_Lang::get('orders::order.order_view_finished'), 	'action_code' => 'order_view_finished', 'relevance' => ''),
            array('action_name' => RC_Lang::get('orders::order.repay_manage'), 			'action_code' => 'repay_manage', 		'relevance' => ''),
            array('action_name' => RC_Lang::get('orders::order.booking_manage'), 		'action_code' => 'booking', 			'relevance' => ''),
            array('action_name' => RC_Lang::get('orders::order.sale_order_stats'), 		'action_code' => 'sale_order_stats', 	'relevance' => ''),
            array('action_name' => RC_Lang::get('orders::order.client_flow_stats'), 	'action_code' => 'client_flow_stats', 	'relevance' => ''),
            array('action_name' => RC_Lang::get('orders::order.delivery_view'), 		'action_code' => 'delivery_view', 		'relevance' => ''),
            array('action_name' => RC_Lang::get('orders::order.back_view'), 			'action_code' => 'back_view', 			'relevance' => ''),	
            array('action_name' => RC_Lang::get('orders::order.remind_order_view'), 	'action_code' => 'remind_order_view', 	'relevance' => ''),	
        		
        	array('action_name' => RC_Lang::get('orders::order.guest_stats'), 				'action_code' => 'guest_stats', 		'relevance' => ''),
        	array('action_name' => RC_Lang::get('orders::order.order_stats'), 				'action_code' => 'order_stats', 		'relevance' => ''),
        	array('action_name' => RC_Lang::get('orders::order.sale_general_stats'), 		'action_code' => 'sale_general_stats', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('orders::order.users_order_stats'), 		'action_code' => 'users_order_stats', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('orders::order.sale_list_stats'), 			'action_code' => 'sale_list_stats', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('orders::order.sale_order_stats'), 			'action_code' => 'sale_order_stats', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('orders::order.visit_sold_stats'), 			'action_code' => 'visit_sold_stats', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('orders::order.adsense_conversion_stats'), 	'action_code' => 'adsense_conversion_stats', 'relevance' => '')
        );
        
        return $purviews;
    }
}

// end