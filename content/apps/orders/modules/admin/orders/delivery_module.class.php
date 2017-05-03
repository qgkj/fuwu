<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单详情
 * @author will
 */
class delivery_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		
		$order_id = $this->requestData('order_id', 0);

 		if (empty($order_id)) {
 			return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
		}
		
		$delivery_result = RC_DB::table('delivery_order')->where('store_id', $_SESSION['store_id'])->where('order_id', $order_id)->get();
		$delivery_list = array();
		if (!empty($delivery_result)) {
			foreach ($delivery_result as $val) {
				$delivery_list[] = array(
					'delivery_id'	=> $val['delivery_id'],
					'delivery_sn'	=> $val['delivery_sn'],
					'pickup_qrcode_sn'	=> 'ecjiaopen://app?open_type=express_pickup&delivery_sn='. $val['delivery_sn'],
					'order_sn'		=> $val['order_sn'],
					'shipping_name'	=> $val['shipping_name'],
					'consignee'		=> $val['consignee'],
					'address'		=> $val['address'],
					'mobile'		=> $val['mobile'],
					'status'		=> $val['status'] == 0 ? 'shipped' : 'shipping',
					'label_status'	=> $val['status'] == 0 ? '已发货' : '发货中', 
				);
			}
		}
		return $delivery_list;
	}
}

// end