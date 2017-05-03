<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单列表
 * @author royalwang
 */
class list_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	if ($_SESSION['user_id'] < 1 ) {
    	    return new ecjia_error(100, 'Invalid session');
    	}
		
		$type = $this->requestData('type');
		if (!empty($type) && !in_array($type, array('await_pay', 'await_ship', 'shipped', 'finished', 'unconfirmed'))) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
		}
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);
		
		$options = array('type' => $type, 'page' => $page, 'size' => $size);
		$result = RC_Api::api('orders', 'order_list', $options);
		if (is_ecjia_error($result)) {
			return $result;
		}
		
		$pager = array(
			'total' => $result['page']->total_records,
			'count' => $result['page']->total_records,
			'more'	=> $result['page']->total_pages <= $page ? 0 : 1,
		);
		return array('data' => $result['order_list'], 'pager' => $pager);
	 }	
}

// end