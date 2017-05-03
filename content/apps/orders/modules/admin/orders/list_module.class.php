<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单列表
 * @author will
 */
class list_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		$result = $this->admin_priv('order_view');
		if (is_ecjia_error($result)) {
			return $result;
		}
		$type		= $this->requestData('type', 'whole');
		$keywords	= $this->requestData('keywords');
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);
		
		$device		  = $this->device;
		$device_code = isset($device['code']) ? $device['code'] : '';
		$device_udid = isset($device['udid']) ? $device['udid'] : '';
		$device_client = isset($device['client']) ? $device['client'] : '';

		$order_query = RC_Loader::load_app_class('order_query', 'orders');
		$db = RC_Model::model('orders/order_info_model');
		$db_view = RC_Model::model('orders/order_info_viewmodel');

		$where = array();
		if ( !empty($keywords)) {
			$where[] = "( oi.order_sn like '%".$keywords."%' or oi.consignee like '%".$keywords."%' )";
		}
		if ($device_code != '8001') {
			switch ($type) {
				case 'await_pay':
					$where = $order_query->order_await_pay('oi.');
					break;
				case 'await_ship':
					$where = $order_query->order_await_ship('oi.');
					break;
				case 'shipped':
					$where = $order_query->order_shipped('oi.');
					break;
				case 'finished':
					$where = $order_query->order_finished('oi.');
					break;
				case 'refund':
					$where = $order_query->order_refund('oi.');
					break;
				case 'closed' :
					$where = array_merge($order_query->order_invalid('oi.'),$order_query->order_canceled('oi.'));
					break;
				case 'whole':
					break;
			}


			$total_fee = "(oi.goods_amount + oi.tax + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee) as total_fee";
			$field = 'oi.order_id, oi.order_sn, oi.consignee, oi.mobile, oi.tel, oi.order_status, oi.pay_status, oi.shipping_status, oi.pay_id, oi.pay_name, '.$total_fee.', oi.integral_money, oi.bonus, oi.shipping_fee, oi.discount, oi.add_time, og.goods_number, og.goods_id, og.goods_name, g.goods_thumb, g.goods_img, g.original_img';

			$db_orderinfo_view = RC_Model::model('orders/order_info_viewmodel');
			$result = ecjia_app::validate_application('store');
			if (!is_ecjia_error($result)) {
				$db_orderinfo_view->view = array(
					'order_goods' => array(
						'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'	=> 'og',
						'on'	=> 'oi.order_id = og.order_id'
					),
					'goods' => array(
						'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'	=> 'g',
						'on'	=> 'g.goods_id = og.goods_id'
					),
				);

				if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
					$where['oi.store_id'] = $_SESSION['store_id'];
				}

				/*获取记录条数*/
				$record_count = $db_orderinfo_view->join(array('order_goods'))->where($where)->count('DISTINCT oi.order_id');

				//实例化分页
				$page_row = new ecjia_page($record_count, $size, 6, '', $page);

				$order_id_group = $db_orderinfo_view->field('oi.order_id')->join(array('order_goods'))->where($where)->limit($page_row->limit())->order(array('oi.add_time' => 'desc'))->group('oi.order_id')->select();

				if (empty($order_id_group)) {
					$data = array();
				} else {
					foreach ($order_id_group as $val) {
						$where['oi.order_id'][] = $val['order_id'];
					}
					$data = $db_orderinfo_view->field($field)->join(array('order_info', 'order_goods', 'goods'))->where($where)->order(array('oi.add_time' => 'desc'))->select();
				}
			} else {
				$db_orderinfo_view->view = array(
					'order_goods' => array(
						'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'	=> 'og',
						'on'	=> 'oi.order_id = og.order_id'
					),
					'goods' => array(
						'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'	=> 'g',
						'on'	=> 'g.goods_id = og.goods_id'
					),
				);
				/*获取记录条数*/
				$record_count = $db_orderinfo_view->join(null)->where($where)->count('oi.order_id');
				//实例化分页
				$page_row = new ecjia_page($record_count, $size, 6, '', $page);

				$order_id_group = $db_orderinfo_view->join(null)->where($where)->limit($page_row->limit())->order(array('oi.add_time' => 'desc'))->get_field('order_id', true);
				if (empty($order_id_group)) {
					$data = array();
				} else {
					$where['oi.order_id'] =  $order_id_group;
					$data = $db_orderinfo_view->field($field)->join(array('order_goods', 'goods'))->where($where)->order(array('oi.add_time' => 'desc'))->select();
				}
			}
		} else {
			$db_adviser_log_view = RC_Model::model('orders/adviser_log_viewmodel');
			$where['al.device_id'] = $_SESSION['device_id'];

			/*获取记录条数 */
			$record_count = $db_adviser_log_view->join(null)->where($where)->count('al.order_id');
			$page_row = new ecjia_page($record_count, $size, 6, '', $page);
			$order_id_group = $db_adviser_log_view->join(null)->where($where)->limit($page_row->limit())->order(array('add_time' => 'desc'))->get_field('order_id', true);

			if (empty($order_id_group)) {
				$data = array();
			} else {
				$total_fee = "(oi.goods_amount + oi.tax + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee) as total_fee";
				$field = 'oi.order_id, ad.username, oi.order_sn, oi.consignee, oi.mobile, oi.tel, oi.order_status, oi.pay_status, oi.shipping_status, oi.pay_id, oi.pay_name, '.$total_fee.', oi.integral_money, oi.bonus, oi.shipping_fee, oi.discount, oi.add_time,og.goods_id, og.goods_number, og.goods_name, g.goods_thumb, g.goods_img, g.original_img';
				$where['al.order_id'] =  $order_id_group;

				$data = $db_adviser_log_view->field($field)->join(array('order_info', 'order_goods', 'adviser', 'goods'))->where($where)->order(array('al.add_time' => 'desc'))->select();
			}
		}

		RC_Lang::load('orders/order');

		$order_list = array();
		if (!empty($data)) {
			$order_id = $goods_number = 0;
			foreach ($data as $val) {
				if ($order_id == 0 || $val['order_id'] != $order_id ) {
					$goods_number = 0;
					$order_status = ($val['order_status'] != '2' || $val['order_status'] != '3') ? RC_Lang::get('orders::order.os.'.$val['order_status']) : '';
					$order_status = $val['order_status'] == '2' ? __('已取消') : $order_status;
					$order_status = $val['order_status'] == '3' ? __('无效') : $order_status;

					$payment_method = RC_Loader::load_app_class('payment_method', 'payment');
					if ($val['pay_id'] > 0) {
						$payment = $payment_method->payment_info_by_id($val['pay_id']);
					}
					$goods_lists = array();
					$goods_lists[] = array(
						'goods_id'		=> $val['goods_id'],
						'name'			=> $val['goods_name'],
						'goods_number' 	=> $val['goods_number'],
						'img'		=> array(
							'thumb'	=> (isset($val['goods_img']) && !empty($val['goods_img']))		 ? RC_Upload::upload_url($val['goods_img'])		: RC_Uri::admin_url('statics/images/nopic.png'),
							'url'	=> (isset($val['original_img']) && !empty($val['original_img'])) ? RC_Upload::upload_url($val['original_img'])  : RC_Uri::admin_url('statics/images/nopic.png'),
							'small'	=> (isset($val['goods_thumb']) && !empty($val['goods_thumb']))   ? RC_Upload::upload_url($val['goods_thumb'])   : RC_Uri::admin_url('statics/images/nopic.png')
						)
					);

					if ($device_code == 8001) {
						if (in_array($val['order_status'], array(OS_CANCELED, OS_INVALID, OS_RETURNED))) {
							$label_order_status = '已撤销';
						} elseif ($val['pay_status'] == PS_PAYED) {
							$label_order_status = '已支付';
						} elseif ($val['pay_status'] == PS_UNPAYED) {
							$label_order_status = '未支付';
						}
					} else {
						$label_order_status = $order_status.','.RC_Lang::get('orders::order.ps.'.$val['pay_status']).','.RC_Lang::get('orders::order.ss.'.$val['shipping_status']);
					}

					$goods_number = $val['goods_number'];
					$order_list[$val['order_id']] = array(
						'order_id'	=> $val['order_id'],
						'order_sn'	=> $val['order_sn'],
						'total_fee' => $val['total_fee'],
						'pay_name'	=> $val['pay_name'],
						'consignee' => $val['consignee'],
						'mobile'	=> empty($val['mobile']) ? $val['tel'] : $val['mobile'],
						'formated_total_fee' 		=> price_format($val['total_fee'], false),
						'formated_integral_money'	=> price_format($val['integral_money'], false),
						'formated_bonus'			=> price_format($val['bonus'], false),
						'formated_shipping_fee'		=> price_format($val['shipping_fee'], false),
						'formated_discount'			=> price_format($val['discount'], false),
						'status'					=> $order_status.','.RC_Lang::get('orders::order.ps.'.$val['pay_status']).','.RC_Lang::get('orders::order.ss.'.$val['shipping_status']),
						'label_order_status'		=> $label_order_status,
						'goods_number'				=> intval($goods_number),
						'create_time' 				=> RC_Time::local_date(ecjia::config('date_format'), $val['add_time']),
						//'username' 					=> $val['username'],
						'goods_items' 				=> $goods_lists
					);
					$order_id = $val['order_id'];
				} else {
					$goods_number += $val['goods_number'];
					$order_list[$val['order_id']]['goods_number'] = $goods_number;
					$order_list[$val['order_id']]['goods_items'][] = array(
						'goods_id'		=> $val['goods_id'],
						'name'			=> $val['goods_name'],
						'goods_number' 	=> intval($val['goods_number']),
						'img' => array(
							'thumb'	=> (isset($val['goods_img']) && !empty($val['goods_img']))		 ? RC_Upload::upload_url($val['goods_img'])		: '',
							'url'	=> (isset($val['original_img']) && !empty($val['original_img'])) ? RC_Upload::upload_url($val['original_img'])  : '',
							'small'	=> (isset($val['goods_thumb']) && !empty($val['goods_thumb']))   ? RC_Upload::upload_url($val['goods_thumb'])   : ''
						)
					);
				}
		    }
		}
		$order_list = array_merge($order_list);
		$pager = array(
			'total'	=> $page_row->total_records,
			'count' => $page_row->total_records,
			'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		return array('data' => $order_list, 'pager' => $pager);
	}
}

// end