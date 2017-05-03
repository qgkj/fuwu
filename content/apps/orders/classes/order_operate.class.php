<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 订单操作
 */
class order_operate {
	
	public function operate($order, $operate, $note) {
		$order_operate = 'order_'. $operate;
		return $this->$order_operate($order, $note);
	}
	
	/* 订单确认*/
	private function order_confirm($order, $note) {
		RC_Loader::load_app_func('admin_order', 'orders');
		RC_Loader::load_app_func('global', 'orders');
		/* 标记订单为已确认 */
		$this->update_order($order['order_id'], array('order_status' => OS_CONFIRMED, 'confirm_time' => RC_Time::gmtime()));
		update_order_amount($order['order_id']);
		
		/* 记录日志 */
		ecjia_admin::admin_log('订单号是 '.$order['order_sn'], 'edit', 'order_status');
		/* 记录log */
		$this->order_action($order['order_sn'], OS_CONFIRMED, SS_UNSHIPPED, PS_UNPAYED, $note['action_note']);
		
		/* 如果原来状态不是“未确认”，且使用库存，且下订单时减库存，则减少库存 */
		if ($order['order_status'] != OS_UNCONFIRMED && ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
			change_order_goods_storage($order['order_id'], true, SDT_PLACE);
		}
		
		/* 发送邮件 */
		$cfg = ecjia::config('send_confirm_email');
		if ($cfg == '1') {
			$tpl_name = 'order_confirm';
			$tpl = RC_Api::api('mail', 'mail_template', $tpl_name);
		
			ecjia_admin::$view_object->assign('order', 		$order);
			ecjia_admin::$view_object->assign('shop_name', 	ecjia::config('shop_name'));
			ecjia_admin::$view_object->assign('send_date', 	RC_Time::local_date(ecjia::config('date_format')));
		
			$content = ecjia_admin::$controller->fetch_string($tpl['template_content']);
		
			if (!RC_Mail::send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html'])) {

			}
		}
		return true;
	}
	
	/* 设置已付款*/
	private function order_pay($order, $note) {
		/* 付款 */
		/* 标记订单为已确认、已付款，更新付款时间和已支付金额，如果是货到付款，同时修改订单为“收货确认” */
		if ($order['order_status'] != OS_CONFIRMED) {
			$arr['order_status']	= OS_CONFIRMED;
			$arr['confirm_time']	= RC_Time::gmtime();
		}
		$arr['pay_status']		= PS_PAYED;
		$arr['pay_time']		= RC_Time::gmtime();
		$arr['money_paid']		= $order['money_paid'] + $order['order_amount'];
		$arr['order_amount']	= 0;
		$payment_method = RC_Loader::load_app_class('payment_method', 'payment');
		$payment = $payment_method->payment_info($order['pay_id']);
		if ($payment['is_cod']) {
			$arr['shipping_status']		= SS_RECEIVED;
			$order['shipping_status']	= SS_RECEIVED;
		}
		$this->update_order($order['order_id'], $arr);
		/* 记录日志 */
		ecjia_admin::admin_log('已付款，订单号是 '.$order['order_sn'], 'edit', 'order_status');
		/* 记录log */
		$this->order_action($order['order_sn'], OS_CONFIRMED, $order['shipping_status'], PS_PAYED, $note['action_note']);
		return true;
	}
	
	/* 配货*/
	private function order_prepare($order, $note) {
		/* 配货 */
		/* 标记订单为已确认，配货中 */
		if ($order['order_status'] != OS_CONFIRMED) {
			$arr['order_status']	= OS_CONFIRMED;
			$arr['confirm_time']	= RC_Time::gmtime();
		}
		$arr['shipping_status']		= SS_PREPARING;
		$this->update_order($order['order_id'], $arr);
		/* 记录日志 */
		ecjia_admin::admin_log('配货中，订单号是 '.$order['order_sn'], 'edit', 'order_status');
		/* 记录log */
		$this->order_action($order['order_sn'], OS_CONFIRMED, SS_PREPARING, $order['pay_status'], $note);
		
		return true;
	}
	
	/* 分单确认 */
	private function order_split($order, $note) {
		RC_Loader::load_app_func('global', 'orders');
		RC_Loader::load_app_func('admin_order', 'orders');
	
		/* 定义当前时间 */
		define('GMTIME_UTC', RC_Time::gmtime()); // 获取 UTC 时间戳
	
		$order_id = $order['order_id'];
		/* 获取表单提交数据 */
		$suppliers_id = isset($_POST['suppliers_id']) ? intval(trim($_POST['suppliers_id'])) : '0'; //供货商
		// 		TODO:delivery基本信息从order中获取
	
		array_walk($_POST['send_number'], 'trim_array_walk');
		array_walk($_POST['send_number'], 'intval_array_walk');
		$send_number = $_POST['send_number'];
	
// 		TODO:默认全部发货，后期改善分批
		$action_note = isset($note['action_note']) ? trim($note['action_note']) : '';
		$delivery['order_sn']		= $order['order_sn'];
		$delivery['user_id']		= intval($order['user_id']);
		$delivery['country']		= intval($order['country']);
		$delivery['province']		= intval($order['province']);
		$delivery['city']			= intval($order['city']);
		$delivery['district']		= intval($order['district']);
		$delivery['agency_id']		= intval($order['agency_id']);
		$delivery['insure_fee']		= floatval($order['insure_fee']);
		$delivery['shipping_fee']	= floatval($order['shipping_fee']);

		/* 订单是否已全部分单检查 */
		if ($order['order_status'] == OS_SPLITED) {
			return new ecjia_error('order_splited', '您的订单'.$order['order_sn'].',已分单，正在发货中');
		}
	
		/* 取得订单商品 */
		$_goods = get_order_goods(array('order_id' => $order_id, 'order_sn' => $delivery['order_sn']));
		$goods_list = $_goods['goods_list'];
		$send_number = 1;
		/* 检查此单发货数量填写是否正确 合并计算相同商品和货品 */
		if (!empty($send_number) && !empty($goods_list)) {
			$send_number = array();
			$goods_no_package = array();
			foreach ($goods_list as $key => $value) {
				// 		TODO:默认全部发货，后期改善分批
				$send_number[$value['rec_id']] = $value['goods_number'];
				
				/* 去除 此单发货数量 等于 0 的商品 */
				if (!isset($value['package_goods_list']) || !is_array($value['package_goods_list'])) {
					// 如果是货品则键值为商品ID与货品ID的组合
					$_key = empty($value['product_id']) ? $value['goods_id'] : ($value['goods_id'] . '_' . $value['product_id']);
					// 统计此单商品总发货数 合并计算相同ID商品或货品的发货数
					if (empty($goods_no_package[$_key])) {
						$goods_no_package[$_key] = $send_number[$value['rec_id']];
					} else {
						$goods_no_package[$_key] += $send_number[$value['rec_id']];
					}
					//去除
					if ($send_number[$value['rec_id']] <= 0) {
						unset($send_number[$value['rec_id']], $goods_list[$key]);
						continue;
					}
				} else {
					/* 组合超值礼包信息 */
					$goods_list[$key]['package_goods_list'] = package_goods($value['package_goods_list'], $value['goods_number'], $value['order_id'], $value['extension_code'], $value['goods_id']);
	
					/* 超值礼包 */
					foreach ($value['package_goods_list'] as $pg_key => $pg_value) {
						// 如果是货品则键值为商品ID与货品ID的组合
						$_key = empty($pg_value['product_id']) ? $pg_value['goods_id'] : ($pg_value['goods_id'] . '_' . $pg_value['product_id']);
						//统计此单商品总发货数 合并计算相同ID产品的发货数
						if (empty($goods_no_package[$_key])) {
							$goods_no_package[$_key] = $send_number[$value['rec_id']][$pg_value['g_p']];
						} else {
							//否则已经存在此键值
							$goods_no_package[$_key] += $send_number[$value['rec_id']][$pg_value['g_p']];
						}
						//去除
						if ($send_number[$value['rec_id']][$pg_value['g_p']] <= 0) {
							unset($send_number[$value['rec_id']][$pg_value['g_p']], $goods_list[$key]['package_goods_list'][$pg_key]);
						}
					}
	
					if (count($goods_list[$key]['package_goods_list']) <= 0) {
						unset($send_number[$value['rec_id']], $goods_list[$key]);
						continue;
					}
				}
	
				/* 发货数量与总量不符 */
				if (!isset($value['package_goods_list']) || !is_array($value['package_goods_list'])) {
					$sended = order_delivery_num($order_id, $value['goods_id'], $value['product_id']);
					if (($value['goods_number'] - $sended - $send_number[$value['rec_id']]) < 0) {
						return new ecjia_error('act_ship_num', '此单发货数量不能超出订单商品数量！');
					}
				} else {
					/* 超值礼包 */
					foreach ($goods_list[$key]['package_goods_list'] as $pg_key => $pg_value) {
						if (($pg_value['order_send_number'] - $pg_value['sended'] - $send_number[$value['rec_id']][$pg_value['g_p']]) < 0) {
							return new ecjia_error('act_ship_num', '此单发货数量不能超出订单商品数量！');
						}
					}
				}
			}
		}
			
		/* 对上一步处理结果进行判断 兼容 上一步判断为假情况的处理 */
		if (empty($send_number) || empty($goods_list)) {
			return new ecjia_error('act_false', '操作失败！');
		}
	
		/* 检查此单发货商品库存缺货情况 */
		/* $goods_list已经过处理 超值礼包中商品库存已取得 */
		$virtual_goods = array();
		$package_virtual_goods = array();
		foreach ($goods_list as $key => $value) {
			// 商品（超值礼包）
			if ($value['extension_code'] == 'package_buy') {
				foreach ($value['package_goods_list'] as $pg_key => $pg_value) {
					if ($pg_value['goods_number'] < $goods_no_package[$pg_value['g_p']] &&
					((ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) ||
							(ecjia::config('use_storage') == '0' && $pg_value['is_real'] == 0))) {
						return new ecjia_error('act_good_vacancy', '商品已缺货！');
					}
	
					/* 商品（超值礼包） 虚拟商品列表 package_virtual_goods*/
					if ($pg_value['is_real'] == 0) {
						$package_virtual_goods[] = array(
							'goods_id'		=> $pg_value['goods_id'],
							'goods_name'	=> $pg_value['goods_name'],
							'num'			=> $send_number[$value['rec_id']][$pg_value['g_p']]
						);
					}
				}
			} elseif ($value['extension_code'] == 'virtual_card' || $value['is_real'] == 0) {
				// 商品（虚货）
				$num = RC_DB::table('virtual_card')->where('goods_id', $value['goods_id'])->where('is_saled', 0)->count();
				
				if (($num < $goods_no_package[$value['goods_id']]) && !(ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE)) {
					return new ecjia_error('virtual_card_oos', '虚拟卡已缺货！');
				}
				/* 虚拟商品列表 virtual_card*/
				if ($value['extension_code'] == 'virtual_card') {
					$virtual_goods[$value['extension_code']][] = array('goods_id' => $value['goods_id'], 'goods_name' => $value['goods_name'], 'num' => $send_number[$value['rec_id']]);
				}
			} else {
				// 商品（实货）、（货品）
				//如果是货品则键值为商品ID与货品ID的组合
				$_key = empty($value['product_id']) ? $value['goods_id'] : ($value['goods_id'] . '_' . $value['product_id']);
				/* （实货） */
				if (empty($value['product_id'])) {
					$num = RC_DB::table('goods')->where('goods_id', $value['goods_id'])->pluck('goods_number');
				} else {
					/* （货品） */
					$num = RC_DB::table('products')->where('goods_id', $value['goods_id'])
						->where('product_id', $value['product_id'])->pluck('product_number');
				}
				if (($num < $goods_no_package[$_key]) && ecjia::config('use_storage') == '1'  && ecjia::config('stock_dec_time') == SDT_SHIP) {
					return new ecjia_error('act_good_vacancy', '商品已缺货！');
				}
			}
		}
	
		/* 生成发货单 */
		/* 获取发货单号和流水号 */
		$delivery['delivery_sn']	= get_delivery_sn();
		$delivery_sn = $delivery['delivery_sn'];
		/* 获取当前操作员 */
		$delivery['action_user']	= $_SESSION['admin_name'];
		/* 获取发货单生成时间 */
		$delivery['update_time']	= GMTIME_UTC;
		$delivery_time = $delivery['update_time'];
	
		$delivery['add_time']		= RC_DB::table('order_info')->where('order_sn', $delivery['order_sn'])->pluck('add_time');
			
		/* 获取发货单所属供应商 */
		$delivery['suppliers_id']	= $suppliers_id;
		/* 设置默认值 */
		$delivery['status']			= 2; // 正常
		$delivery['order_id']		= $order_id;
		/* 过滤字段项 */
		$filter_fileds = array(
			'order_sn', 'add_time', 'user_id', 'how_oos', 'shipping_id', 'shipping_fee',
			'consignee', 'address', 'country', 'province', 'city', 'district', 'sign_building',
			'email', 'zipcode', 'tel', 'mobile', 'best_time', 'postscript', 'insure_fee',
			'agency_id', 'delivery_sn', 'action_user', 'update_time',
			'suppliers_id', 'status', 'order_id', 'shipping_name'
		);
		$_delivery = array();
		foreach ($filter_fileds as $value) {
			$_delivery[$value] = $delivery[$value];
		}
		/* 发货单入库 */
		$delivery_id = RC_DB::table('delivery_order')->insertGetId($_delivery);
		
		/* 记录日志 */
		ecjia_admin::admin_log($order_id, 'produce', 'delivery_order');
		if ($delivery_id) {
			$delivery_goods = array();
			//发货单商品入库
			if (!empty($goods_list)) {
				foreach ($goods_list as $value) {
					// 商品（实货）（虚货）
					if (empty($value['extension_code']) || $value['extension_code'] == 'virtual_card') {
						$delivery_goods = array(
							'delivery_id'	=> $delivery_id,
							'goods_id'		=> $value['goods_id'],
							'product_id'	=> $value['product_id'],
							'product_sn'	=> $value['product_sn'],
							'goods_id'		=> $value['goods_id'],
							'goods_name'	=> addslashes($value['goods_name']),
							'brand_name'	=> addslashes($value['brand_name']),
							'goods_sn'		=> $value['goods_sn'],
							'send_number'	=> $send_number[$value['rec_id']],
							'parent_id'		=> 0,
							'is_real'		=> $value['is_real'],
							'goods_attr'	=> addslashes($value['goods_attr'])
						);
						/* 如果是货品 */
						if (!empty($value['product_id'])) {
							$delivery_goods['product_id'] = $value['product_id'];
						}
						$query = RC_DB::table('delivery_goods')->insertGetId($delivery_goods);
					} elseif ($value['extension_code'] == 'package_buy') {
						// 商品（超值礼包）
						foreach ($value['package_goods_list'] as $pg_key => $pg_value) {
							$delivery_pg_goods = array(
								'delivery_id'		=> $delivery_id,
								'goods_id'			=> $pg_value['goods_id'],
								'product_id'		=> $pg_value['product_id'],
								'product_sn'		=> $pg_value['product_sn'],
								'goods_name'		=> $pg_value['goods_name'],
								'brand_name'		=> '',
								'goods_sn'			=> $pg_value['goods_sn'],
								'send_number'		=> $send_number[$value['rec_id']][$pg_value['g_p']],
								'parent_id'			=> $value['goods_id'], // 礼包ID
								'extension_code'	=> $value['extension_code'], // 礼包
								'is_real'			=> $pg_value['is_real']
							);
							$query = RC_DB::table('delivery_goods')->insertGetId($delivery_pg_goods);
						}
					}
				}
			}
		} else {
			return new ecjia_error('act_false', '操作失败！');
		}
		unset($filter_fileds, $delivery, $_delivery, $order_finish);
	
		/* 定单信息更新处理 */
		if (true) {
			/* 定单信息 */
			$_sended = & $send_number;
			foreach ($_goods['goods_list'] as $key => $value) {
				if ($value['extension_code'] != 'package_buy') {
					unset($_goods['goods_list'][$key]);
				}
			}
			foreach ($goods_list as $key => $value) {
				if ($value['extension_code'] == 'package_buy') {
					unset($goods_list[$key]);
				}
			}
			$_goods['goods_list'] = $goods_list + $_goods['goods_list'];
			unset($goods_list);
	
			/* 更新订单的虚拟卡 商品（虚货） */
			$_virtual_goods = isset($virtual_goods['virtual_card']) ? $virtual_goods['virtual_card'] : '';
			update_order_virtual_goods($order_id, $_sended, $_virtual_goods);
	
			/* 更新订单的非虚拟商品信息 即：商品（实货）（货品）、商品（超值礼包）*/
			update_order_goods($order_id, $_sended, $_goods['goods_list']);
	
			/* 标记订单为已确认 “发货中” */
			/* 更新发货时间 */
			$order_finish = get_order_finish($order_id);
			$shipping_status = SS_SHIPPED_ING;
			if ($order['order_status'] != OS_CONFIRMED && $order['order_status'] != OS_SPLITED && $order['order_status'] != OS_SPLITING_PART) {
				$arr['order_status']	= OS_CONFIRMED;
				$arr['confirm_time']	= GMTIME_UTC;
			}
	
			$arr['order_status']		= $order_finish ? OS_SPLITED : OS_SPLITING_PART; // 全部分单、部分分单
			$arr['shipping_status']		= $shipping_status;
			$this->update_order($order_id, $arr);
		}
		/* 记录log */
		$this->order_action($order['order_sn'], $arr['order_status'], $shipping_status, $order['pay_status'], $action_note);
		return true;
	}
	
	/* 收货确认 */
	private function order_receive($order, $note) {
		/* 标记订单为“收货确认”，如果是货到付款，同时修改订单为已付款 */
		$arr = array('shipping_status' => SS_RECEIVED);
		$payment_method = RC_Loader::load_app_class('payment_method', 'payment');
		$payment = $payment_method->payment_info($order['pay_id']);
		if ($payment['is_cod']) {
			$arr['pay_status']		= PS_PAYED;
			$order['pay_status']	= PS_PAYED;
		}
		if ($this->update_order($order['order_id'], $arr)) {
		    /* 记录log */
		    $this->order_action($order['order_sn'], $order['order_status'], SS_RECEIVED, $order['pay_status'], $note['action_note']);
		    RC_Api::api('commission', 'add_bill_detail', array('store_id' => $order['store_id'], 'order_type' => 1, 'order_id' => $order['order_id'], 'order_amount' => $order['order_amount']));
		    return true;
		} else {
		    return false;
		}
	}
	
	/* 取消订单*/
	private function order_cancel($order, $note) {
	    /* 判断付款状态 */
	    if ($order['pay_status'] != PS_UNPAYED) {
	        return false;
	    }
	    $arr['order_status'] = OS_CANCELED;
	    $this->update_order($order['order_id'], $arr);
	    /* 记录log */
	    $this->order_action($order['order_sn'], OS_CANCELED, $order['shipping_status'], $order['pay_status'], $note['action_note']);
	}
	
	/**
	 * 修改订单
	 * @param   int	 $order_id   订单id
	 * @param   array   $order	  key => value
	 * @return  bool
	 */
	private function update_order($order_id, $order) {
		return RC_DB::table('order_info')->where('order_id', $order_id)->update($order);
	}
	
	/**
	 * 记录订单操作记录
	 *
	 * @access public
	 * @param string $order_sn
	 *        	订单编号
	 * @param integer $order_status
	 *        	订单状态
	 * @param integer $shipping_status
	 *        	配送状态
	 * @param integer $pay_status
	 *        	付款状态
	 * @param string $note
	 *        	备注
	 * @param string $username
	 *        	用户名，用户自己的操作则为 buyer
	 * @return void
	 */
	private function order_action($order_sn, $order_status, $shipping_status, $pay_status, $note = '', $username = null, $place = 0) {
		if (is_null ( $username )) {
			$username = empty($_SESSION ['admin_name']) ? '系统' : $_SESSION ['admin_name'];
		}
	
		$row = RC_DB::table('order_info')->where('order_sn', $order_sn)->first();
		
		$data = array (
			'order_id'           => $row ['order_id'],
			'action_user'        => $username,
			'order_status'       => $order_status,
			'shipping_status'    => $shipping_status,
			'pay_status'         => $pay_status,
			'action_place'       => $place,
			'action_note'        => $note,
			'log_time'           => RC_Time::gmtime()
		);
		RC_DB::table('order_action')->insert($data);
	}
}

// end