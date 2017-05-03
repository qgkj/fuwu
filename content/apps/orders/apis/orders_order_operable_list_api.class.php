<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 返回订单可执行操作的操作
 * @author will.chen
 */
class orders_order_operable_list_api extends Component_Event_Api {
	
    /**
     * @param  $options 订单信息
     *
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options)) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
	    }
	    
	    return $this->operable_list($options);
	}
	
	/**
	 * 检查支付的金额是否与订单相符
	 *
	 * @access  public
	 * @param   string   $log_id      支付编号
	 * @param   float    $money       支付接口返回的金额
	 * @return  true
	 */
	private function operable_list($order) {
	    /* 取得订单状态、发货状态、付款状态 */
		$os = $order['order_status'];
		$ss = $order['shipping_status'];
		$ps = $order['pay_status'];
	
		/* 取得订单操作权限 */
		$actions = $_SESSION['action_list'];
		if ($actions == 'all') {
			$priv_list	= array('os' => true, 'ss' => true, 'ps' => true, 'edit' => true);
		} else {
			$actions    = ',' . $actions . ',';
			$priv_list  = array(
				'os'	=> strpos($actions, ',order_os_edit,') !== false,
				'ss'	=> strpos($actions, ',order_ss_edit,') !== false,
				'ps'	=> strpos($actions, ',order_ps_edit,') !== false,
				'edit'	=> strpos($actions, ',order_edit,') !== false
			);
		}
	
		/* 取得订单支付方式是否货到付款 */
		$payment_method = RC_Loader::load_app_class('payment_method','payment');
		$payment = $payment_method->payment_info($order['pay_id']);
	
		$is_cod  = $payment['is_cod'] == 1;
	
		/* 根据状态返回可执行操作 */
		$list = array();
		if (OS_UNCONFIRMED == $os) {
			/* 状态：未确认 => 未付款、未发货 */
			if ($priv_list['os']) {
				$list['confirm']	= true;	// 确认
				$list['invalid']	= true;	// 无效
				$list['cancel']		= true;	// 取消
				if ($is_cod) {
					/* 货到付款 */
					if ($priv_list['ss']) {
						$list['prepare']	= true;	// 配货
						$list['split']		= true;	// 分单
					}
				} else {
					/* 不是货到付款 */
					if ($priv_list['ps']) {
						$list['pay'] = true;	// 付款
					}
				}
			}
		} elseif (OS_CONFIRMED == $os || OS_SPLITED == $os || OS_SPLITING_PART == $os) {
			/* 状态：已确认 */
			if (PS_UNPAYED == $ps) {
				/* 状态：已确认、未付款 */
				if (SS_UNSHIPPED == $ss || SS_PREPARING == $ss) {
					/* 状态：已确认、未付款、未发货（或配货中） */
					if ($priv_list['os']) {
						$list['cancel'] = true;		// 取消
						$list['invalid'] = true;	// 无效
					}
					if ($is_cod) {
						/* 货到付款 */
						if ($priv_list['ss']) {
							if (SS_UNSHIPPED == $ss) {
								$list['prepare'] = true;	// 配货
							}
							$list['split'] = true;	// 分单
						}
					} else {
						/* 不是货到付款 */
						if ($priv_list['ps']) {
							$list['pay'] = true;	// 付款
						}
					}
				} elseif (SS_SHIPPED_ING == $ss || SS_SHIPPED_PART == $ss) {
					/* 状态：已确认、未付款、发货中 */
					// 部分分单
					if (OS_SPLITING_PART == $os) {
						$list['split'] = true;		// 分单
					}
					$list['to_delivery'] = true;	// 去发货
				} else {
					/* 状态：已确认、未付款、已发货或已收货 => 货到付款 */
					if ($priv_list['ps']) {
						$list['pay'] = true;	// 付款
					}
					if ($priv_list['ss']) {
						if (SS_SHIPPED == $ss) {
							$list['receive'] = true;	// 收货确认
						}
						$list['unship'] = true;	// 设为未发货
						if ($priv_list['os']) {
							$list['return'] = true;	// 退货
						}
					}
				}
			} else {
				/* 状态：已确认、已付款和付款中 */
				if (SS_UNSHIPPED == $ss || SS_PREPARING == $ss) {
					/* 状态：已确认、已付款和付款中、未发货（配货中） => 不是货到付款 */
					if ($priv_list['ss']) {
						if (SS_UNSHIPPED == $ss) {
							$list['prepare'] = true;	// 配货
						}
						$list['split'] = true;	// 分单
					}
					if ($priv_list['ps']) {
						$list['unpay'] = true;	// 设为未付款
						if ($priv_list['os']) {
							$list['cancel'] = true;	// 取消
						}
					}
				} elseif (SS_SHIPPED_ING == $ss || SS_SHIPPED_PART == $ss) {
					/* 状态：已确认、未付款、发货中 */
					// 部分分单
					if (OS_SPLITING_PART == $os) {
						$list['split'] = true;	// 分单
					}
					$list['to_delivery'] = true;	// 去发货
				} else {
					/* 状态：已确认、已付款和付款中、已发货或已收货 */
					if ($priv_list['ss']) {
						if (SS_SHIPPED == $ss) {
							$list['receive'] = true;	// 收货确认
						}
						if (!$is_cod) {
							$list['unship'] = true;	// 设为未发货
						}
					}
					if ($priv_list['ps'] && $is_cod) {
						$list['unpay']  = true;	// 设为未付款
					}
					if ($priv_list['os'] && $priv_list['ss'] && $priv_list['ps']) {
						$list['return'] = true;	// 退货（包括退款）
					}
				}
			}
		} elseif (OS_CANCELED == $os) {
			/* 状态：取消 */
			if ($priv_list['os']) {
				$list['confirm'] = true;
			}
			if ($priv_list['edit']) {
				$list['remove'] = true;
			}
		} elseif (OS_INVALID == $os) {
			/* 状态：无效 */
			if ($priv_list['os']) {
				$list['confirm'] = true;
			}
			if ($priv_list['edit']) {
				$list['remove'] = true;
			}
		} elseif (OS_RETURNED == $os) {
			/* 状态：退货 */
			if ($priv_list['os']) {
				$list['confirm'] = true;
			}
		}
	
		/* 修正发货操作 */
		if (!empty($list['split'])) {
			/* 如果是团购活动且未处理成功，不能发货 */
			RC_Loader::load_app_func('global', 'orders');
			if ($order['extension_code'] == 'group_buy') {
				RC_Loader::load_app_func('admin_goods', 'goods');
				$group_buy = group_buy_info(intval($order['extension_id']));
				if ($group_buy['status'] != GBS_SUCCEED) {
					unset($list['split']);
					unset($list['to_delivery']);
				}
			}
	
			/* 如果部分发货 不允许 取消 订单 */
			if (order_deliveryed($order['order_id'])) {
				$list['return'] = true;	// 退货（包括退款）
				unset($list['cancel']);	// 取消
			}
		}
	
		/* 售后 */
		$list['after_service'] = true;
		return $list;
	}
}

// end