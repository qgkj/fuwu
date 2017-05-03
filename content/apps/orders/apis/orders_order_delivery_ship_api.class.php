<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单发货接口
 * @author will.chen
 */
class orders_order_delivery_ship_api extends Component_Event_Api {
    /**
     * @param  $options['order_id'] 订单ID
     *         $options['order_sn'] 订单号
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options) 
	        || (!isset($options['order_id']) 
	        && !isset($options['order_sn']))) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
	    }
		return $this->order_info($options['order_id'], $options['order_sn']);
	}
	
	private function delivery_ship() {
		$db_delivery_goods = RC_DB::table('delivery_goods as dg');
		/* 定义当前时间 */
		define('GMTIME_UTC', RC_Time::gmtime()); // 获取 UTC 时间戳
		/* 取得参数 */
		$delivery				= array();
		$order_id				= intval(trim($_POST['order_id']));			// 订单id
		$delivery_id			= intval(trim($_POST['delivery_id']));		// 发货单id
		$delivery['invoice_no']	= isset($_POST['invoice_no']) ? trim($_POST['invoice_no']) : '';
		$action_note			= isset($_POST['action_note']) ? trim($_POST['action_note']) : '';
		
		/* 根据发货单id查询发货单信息 */
		if (!empty($delivery_id)) {
			$delivery_order = delivery_order_info($delivery_id);
		} else {
			return $this->showmessage(RC_Lang::get('orders::order.no_delivery_order'), ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR);
		}
		if (empty($delivery_order)) {
			return $this->showmessage(RC_Lang::get('orders::order.no_delivery_order'), ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR);
		}
		/* 查询订单信息 */
		$order = order_info($order_id);
		
		/* 检查此单发货商品库存缺货情况 */
		$virtual_goods			= array();
		$delivery_stock_result = $db_delivery_goods
			->leftJoin('goods as g', RC_DB::raw('dg.goods_id'), '=', RC_DB::raw('g.goods_id'))
			->leftJoin('products as p', RC_DB::raw('dg.product_id'), '=', RC_DB::raw('p.product_id'))
			->where(RC_DB::raw('dg.delivery_id'), $delivery_id)
			->selectRaw('dg.goods_id, dg.is_real, dg.product_id, SUM(dg.send_number) AS sums, IF(dg.product_id > 0, p.product_number, g.goods_number) AS storage, g.goods_name, dg.send_number')
			->groupby(RC_DB::raw('dg.product_id'))
			->get();
			
		/* 如果商品存在规格就查询规格，如果不存在规格按商品库存查询 */
		if (!empty($delivery_stock_result)) {
			foreach ($delivery_stock_result as $value) {
				if (($value['sums'] > $value['storage'] || $value['storage'] <= 0) &&
				((ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) ||
						(ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {
						
					/* 操作失败 */
					$links[] = array('text' => RC_Lang::get('orders::order.order_info'), 'href' => RC_Uri::url('orders/admin_order_delivery/delivery_info', 'delivery_id=' . $delivery_id));
					return $this->showmessage(sprintf(RC_Lang::get('orders::order.act_goods_vacancy'), $value['goods_name']), ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR, array('links' => $links));
				}
		
				/* 虚拟商品列表 virtual_card */
				if ($value['is_real'] == 0) {
					$virtual_goods[] = array(
						'goods_id'		=> $value['goods_id'],
						'goods_name'	=> $value['goods_name'],
						'num'			=> $value['send_number']
					);
				}
			}
		} else {
			
			$delivery_stock_result = $db_delivery_goods
				->leftJoin('goods as g', RC_DB::raw('dg.goods_id'), '=', RC_DB::raw('g.goods_id'))
				->where(RC_DB::raw('dg.delivery_id'), $delivery_id)
				->selectRaw('dg.goods_id, dg.is_real, SUM(dg.send_number) AS sums, g.goods_number, g.goods_name, dg.send_number')
				->groupby(RC_DB::raw('dg.product_id'))
				->get();
		
			foreach ($delivery_stock_result as $value) {
				if (($value['sums'] > $value['goods_number'] || $value['goods_number'] <= 0) &&
				((ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) ||
						(ecjia::config('use_storage') == '0' && $value['is_real'] == 0))) {
					/* 操作失败 */
					$links[] = array('text' => RC_Lang::get('orders::order.order_info'), 'href' => RC_Uri::url('orders/order_delilvery/delivery_info', 'delivery_id=' . $delivery_id));
					return $this->showmessage(sprintf(RC_Lang::get('orders::order.act_goods_vacancy'), $value['goods_name']), ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR, array('links' => $links));
					break;
				}
		
				/* 虚拟商品列表 virtual_card*/
				if ($value['is_real'] == 0) {
					$virtual_goods[] = array(
						'goods_id'		=> $value['goods_id'],
						'goods_name'	=> $value['goods_name'],
						'num'			=> $value['send_number']
					);
				}
			}
		}
		
		/* 发货 */
		/* 处理虚拟卡 商品（虚货） */
		if (is_array($virtual_goods) && count($virtual_goods) > 0) {
			foreach ($virtual_goods as $virtual_value) {
				//虚拟商品不支持
// 				virtual_card_shipping($virtual_value,$order['order_sn'], $msg, 'split');
			}
		}
		
		/* 如果使用库存，且发货时减库存，则修改库存 */
		if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_SHIP) {
			foreach ($delivery_stock_result as $value) {
				/* 商品（实货）、超级礼包（实货） */
				if ($value['is_real'] != 0) {
					/* （货品） */
					if (!empty($value['product_id'])) {
						$data = array(
							'product_number' => $value['storage'] - $value['sums'],
						);
						RC_DB::table('products')->where('product_id', $value['product_id'])->update($data);
					} else {
						$data = array(
							'goods_number' => $value['storage'] - $value['sums'],
						);
						RC_DB::table('goods')->where('goods_id', $value['goods_id'])->update($data);
					}
				}
			}
		}
		
		/* 修改发货单信息 */
		$invoice_no = str_replace(',', '<br>', $delivery['invoice_no']);
		$invoice_no = trim($invoice_no, '<br>');
		$_delivery['invoice_no']	= $invoice_no;
		$_delivery['status']		= 0;	/* 0，为已发货 */
		$result = RC_DB::table('delivery_order')->where('delivery_id', $delivery_id)->update($_delivery);
		
		if (!$result) {
			/* 操作失败 */
			$links[] = array('text' => RC_Lang::get('orders::order.delivery_sn') . RC_Lang::get('orders::order.detail'), 'href' => RC_Uri::url('orders/admin_order_delivery/delivery_info','delivery_id=' . $delivery_id));
			return $this->showmessage(RC_Lang::get('orders::order.act_false'), ecjia_admin::MSGTYPE_JSON | ecjia_admin::MSGSTAT_ERROR, array('links' => $links));
		}
		
		/* 标记订单为已确认 “已发货” */
		/* 更新发货时间 */
		$order_finish				= get_all_delivery_finish($order_id);
		$shipping_status			= ($order_finish == 1) ? SS_SHIPPED : SS_SHIPPED_PART;
		$arr['shipping_status']		= $shipping_status;
		$arr['shipping_time']		= GMTIME_UTC; // 发货时间
		$arr['invoice_no']			= trim($order['invoice_no'] . '<br>' . $invoice_no, '<br>');
		update_order($order_id, $arr);
		
		/* 发货单发货记录log */
		order_action($order['order_sn'], OS_CONFIRMED, $shipping_status, $order['pay_status'], $action_note, null, 1);
		ecjia_admin::admin_log(RC_Lang::get('orders::order.op_ship').' '.RC_Lang::get('orders::order.order_is').$order['order_sn'], 'setup', 'order');
		
		/* 如果当前订单已经全部发货 */
		if ($order_finish) {
			/* 如果订单用户不为空，计算积分，并发给用户；发红包 */
			if ($order['user_id'] > 0) {
				/* 取得用户信息 */
				$user = user_info($order['user_id']);
				/* 计算并发放积分 */
				$integral = integral_to_give($order);
				$options = array(
					'user_id'		=> $order['user_id'],
					'rank_points'	=> intval($integral['rank_points']),
					'pay_points'	=> intval($integral['custom_points']),
					'change_desc'	=> sprintf(RC_Lang::get('orders::order.order_gift_integral'), $order['order_sn'])
				);
				RC_Api::api('user', 'account_change_log',$options);
				/* 发放红包 */
				send_order_bonus($order_id);
			}
		
			/* 发送邮件 */
			$cfg = ecjia::config('send_ship_email');
			if ($cfg == '1') {
				$order['invoice_no'] = $invoice_no;
				$tpl_name = 'deliver_notice';
				$tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);
		
				$this->assign('order', $order);
				$this->assign('send_time', RC_Time::local_date(ecjia::config('time_format')));
				$this->assign('shop_name', ecjia::config('shop_name'));
				$this->assign('send_date', RC_Time::local_date(ecjia::config('date_format')));
				$this->assign('confirm_url', SITE_URL . 'receive.php?id=' . $order['order_id'] . '&con=' . rawurlencode($order['consignee']));
				$this->assign('send_msg_url', SITE_URL . RC_Uri::url('user/admin/message_list','order_id=' . $order['order_id']));
		
				$content = $this->fetch_string($tpl['template_content']);
		
				if (!RC_Mail::send_mail($order['consignee'], $order['email'] , $tpl['template_subject'], $content, $tpl['is_html'])) {
					return $this->showmessage(RC_Lang::get('orders::order.send_mail_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			$result = ecjia_app::validate_application('sms');
			if (!is_ecjia_error($result)) {
				/* 如果需要，发短信 */
				if (ecjia::config('sms_order_shipped') == '1' && $order['mobile'] != '') {
					//发送短信
					$tpl_name = 'order_shipped_sms';
					$tpl   = RC_Api::api('sms', 'sms_template', $tpl_name);
					if (!empty($tpl)) {
						$this->assign('order_sn', 		$order['order_sn']);
						$this->assign('shipped_time', 	RC_Time::local_date(RC_Lang::get('orders::order.sms_time_format')));
						$this->assign('mobile', 		$order['mobile']);
		
						$content = $this->fetch_string($tpl['template_content']);
		
						$options = array(
							'mobile' 		=> $order['mobile'],
							'msg'			=> $content,
							'template_id' 	=> $tpl['template_id'],
						);
						$response = RC_Api::api('sms', 'sms_send', $options);
					}
				}
			}
		}
	}
}

// end