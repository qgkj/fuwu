<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单支付后处理订单的接口
 * @author will.chen
 */
class orders_order_operate_api extends Component_Event_Api {
	
    /**
     * @param  $options['order_id'] 订单ID
     *
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options) 
	        || !isset($options['order_id'])) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
	    }
	    
	    /* 查询订单信息 */
	    $order = RC_Api::api('orders', 'order_info', array('order_id' => $options['order_id'], 'order_sn' => $options['order_sn']));
	    
	    /* 检查能否操作 */
		$operable_list = RC_Api::api('orders', 'order_operable_list', $order);
		if (!isset($operable_list[$options['operation']])) {
			return new ecjia_error('operate_error', RC_Lang::get('orders::order.unable_operation_order'));
		}
		$operate = RC_Loader::load_app_class('order_operate', 'orders');
		
		$result = $operate->operate($order, $options['operation'], $options['note']);
		
		return $result;
	}
}

// end