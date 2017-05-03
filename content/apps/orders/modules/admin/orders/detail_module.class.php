<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单详情
 * @author will
 */
class detail_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		$result = $this->admin_priv('order_view');
 		if (is_ecjia_error($result)) {
 			return $result;
 		}
		$order_id = $this->requestData('id', 0);
		$order_sn = $this->requestData('order_sn');

 		if (empty($order_id) && empty($order_sn)) {
 			return new ecjia_error(101, '参数错误');
		}
		RC_Loader::load_app_func('admin_order', 'orders');

		/* 订单详情 */
		$order = RC_Api::api('orders', 'order_info', array('order_id' => $order_id, 'order_sn' => $order_sn, 'store_id' => $_SESSION['store_id']));

		if ($order === false) {
			return new ecjia_error(8, 'fail');
		}
		if (is_ecjia_error($order)) {
 			return $order;
		}
		
		$db_user = RC_Model::model('user/users_model');
		$user_name = $db_user->where(array('user_id' => $order['user_id']))->get_field('user_name');

		$order['user_name'] = empty($user_name) ? __('匿名用户') : $user_name;
		//收货人地址
		$db_region = RC_Model::model('shipping/region_model');
		$region_name = $db_region->where(array('region_id' => array('in'=>$order['country'], $order['province'], $order['city'], $order['district'])))->order('region_type')->select();
		$order['country']	= $region_name[0]['region_name'];
		$order['province']	= $region_name[1]['region_name'];
		$order['city']		= $region_name[2]['region_name'];
		$order['district']	= $region_name[3]['region_name'];

		RC_Lang::load('orders/order');
		$order_status = ($order['order_status'] != '2' || $order['order_status'] != '3') ? RC_Lang::get('orders::order.os.'.$order['order_status']) : '';
		$order_status = $order['order_status'] == '2' ? __('已取消') : $order_status;
		$order_status = $order['order_status'] == '3' ? __('无效') : $order_status;

		$order['status'] =strip_tags($order_status.','.RC_Lang::get('orders::order.ps.'.$order['pay_status']).','.RC_Lang::get('orders::order.ss.'.$order['shipping_status']));
		$order['sub_orders'] = array();
		$db_orderinfo_view = RC_Model::model('orders/order_info_viewmodel');
		$total_fee = "(oi.goods_amount + oi.tax + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee) as total_fee";
		$result = ecjia_app::validate_application('seller');
		if (!is_ecjia_error($result)) {
			$sub_orders_result = $db_orderinfo_view->join(null)->field(array('oi.*,'.$total_fee))->where(array('main_order_id' => $order['order_id']))->select();
			if (!empty($sub_orders_result)) {
				$goods_db = RC_Model::model('goods/goods_model');
				$db_order_goods = RC_Model::model('orders/order_goods_model');
				foreach ($sub_orders_result as $val) {
					$seller_name = RC_Model::model('seller/seller_shopinfo_model')->where(array('id' => $val['seller_id']))->get_field('shop_name');
					$order_goods = $db_order_goods->where(array('order_id' => $val['order_id']))->select();

					$order_status = ($val['order_status'] != '2' || $val['order_status'] != '3') ? RC_Lang::get('orders::order.os.'.$val['order_status']) : '';
					$order_status = $val['order_status'] == '2' ? __('已取消') : $order_status;
					$order_status = $val['order_status'] == '3' ? __('无效') : $order_status;

					$goods_lists = array();
					if (!empty($order_goods)) {
						foreach ($order_goods as $v) {

							$goods_info = $goods_db->find(array('goods_id' => $v['goods_id']));

							$goods_lists[] = array(
								'id'			=> $v['goods_id'],
								'name'			=> $v['goods_name'],
								'seller_name'	=> !empty($seller_name) ? $seller_name : '自营',
								'shop_price'	=> price_format($v['goods_price'], false),
								'goods_sn'		=> $v['goods_sn'],
								'number'		=> $v['goods_number'],
								'img' => array(
									'thumb'	=> !empty($goods_info['goods_img']) ? RC_Upload::upload_url($goods_info['goods_img']) : '',
									'url'	=> !empty($goods_info['original_img']) ? RC_Upload::upload_url($goods_info['original_img']) : '',
									'small'	=> !empty($goods_info['goods_thumb']) ? RC_Upload::upload_url($goods_info['goods_thumb']) : '',
								),
							);
						}
					}


					$order['sub_orders'][] = array(
						'order_id'	=> $val['order_id'],
						'order_sn'	=> $val['order_sn'],
						'total_fee' => $val['total_fee'],
						'formated_total_fee' 		=> price_format($val['total_fee'], false),
						'formated_integral_money'	=> price_format($val['integral_money'], false),
						'formated_bonus'			=> price_format($val['bonus'], false),
						'formated_shipping_fee'		=> price_format($val['shipping_fee'], false),
						'formated_discount'			=> price_format($val['discount'], false),
						'status'					=> $order_status.','.RC_Lang::get('orders::order.ps.'.$val['pay_status']).','.RC_Lang::get('orders::order.ss.'.$val['shipping_status']),
						'create_time' 				=> RC_Time::local_date(ecjia::config('date_format'), $val['add_time']),
						'goods_items' 				=> $goods_lists
					);
				}
			}
		}
		$ordergoods_viewdb = RC_Model::model('orders/order_goods_goods_viewmodel');
		$goods_list = $ordergoods_viewdb->where(array('order_id' => $order['order_id']))->select();
		if (!empty($goods_list)) {
			foreach ($goods_list as $k =>$v) {
				$goods_list[$k] = array(
					'id'					=> $v['goods_id'],
					'name'					=> $v['goods_name'],
					'goods_number'			> $v['goods_number'],
					'subtotal'				=> price_format($v['subtotal'], false),
					'goods_attr'			=> trim($v['goods_attr']),
					'formated_shop_price' 	=> price_format($v['goods_price'], false),
					'img' => array(
						'thumb'	=> !empty($v['goods_img']) ? RC_Upload::upload_url($v['goods_img']) : '',
						'url'	=> !empty($v['original_img']) ? RC_Upload::upload_url($v['original_img']) : '',
						'small'	=> !empty($v['goods_thumb']) ? RC_Upload::upload_url($v['goods_thumb']) : '',
					)
				);
			}
		}

		$order['goods_items'] = $goods_list;


		/* 取得订单操作记录 */
		$act_list = array();
		$db_order_action = RC_Model::model('orders/order_action_model');
		$data = $db_order_action->where(array('order_id' => $order['order_id']))->order(array('log_time' => 'asc' ,'action_id' => 'asc'))->select();
        if(!empty($data)) {
			foreach ($data as $key => $row) {
				$row['order_status']	= RC_Lang::get('orders::order.os.'.$row['order_status']);
				$row['pay_status']		= RC_Lang::get('orders::order.ps.'.$row['pay_status']);
				$row['shipping_status']	= RC_Lang::get('orders::order.ss.'.$row['shipping_status']);
				$row['order_status']	= strip_tags($row['order_status']);//处理html标签
				$row['action_time']		= RC_Time::local_date(ecjia::config('time_format'), $row['log_time']);
                $act_list[]				= array(
					'action_time'		=> $row['action_time'],
					'log_description'	=> $row['action_user'].' 操作此订单，变更状态为：'.$row['order_status'].'、'.$row['pay_status'].'、'.$row['shipping_status'].(!empty($row['action_note']) ? '，理由是'.$row['action_note'] : '。'),
                    'order_status'      => $row['order_status'],
    				'pay_status'		=> $row['pay_status'],
    				'shipping_status'	=> $row['shipping_status'],
			   );
			}
		}
		$order['action_logs']   = $act_list;
		return $order;
	}
}

// end