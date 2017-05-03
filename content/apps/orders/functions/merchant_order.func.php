<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 返回商家某个订单可执行的操作列表，包括权限判断
 * @param   array   $order      订单信息 order_status, shipping_status, pay_status
 * @param   bool    $is_cod     支付方式是否货到付款
 * @return  array   可执行的操作  confirm, pay, unpay, prepare, ship, unship, receive, cancel, invalid, return, drop
 * 格式 array('confirm' => true, 'pay' => true)
 */
function merchant_operable_list($order) {
    /* 取得订单状态、发货状态、付款状态 */
    $os = $order['order_status'];
    $ss = $order['shipping_status'];
    $ps = $order['pay_status'];
    /* 取得订单操作权限 */
    $actions = $_SESSION['action_list'];
    if ($actions == 'all') {
        $priv_list = array('os' => true, 'ss' => true, 'ps' => true, 'edit' => true);
    } else {
        $actions = ',' . $actions . ',';
        $priv_list = array('os' => strpos($actions, ',order_os_edit,') !== false, 'ss' => strpos($actions, ',order_ss_edit,') !== false, 'ps' => strpos($actions, ',order_ps_edit,') !== false, 'edit' => strpos($actions, ',order_edit,') !== false);
    }
    /* 取得订单支付方式是否货到付款 */
    $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
    $payment = array();
    if (!empty($payment_method)) {
        $payment = $payment_method->payment_info($order['pay_id']);
    }
    $is_cod = $payment['is_cod'] == 1;
    /* 根据状态返回可执行操作 */
    $list = array();
    if (OS_UNCONFIRMED == $os) {
        /* 状态：未确认 => 未付款、未发货 */
        if ($priv_list['os']) {
            $list['confirm'] = true;
            // 确认
            $list['invalid'] = true;
            // 无效
            $list['cancel'] = true;
            // 取消
            if ($is_cod) {
                /* 货到付款 */
                if ($priv_list['ss']) {
                    $list['prepare'] = true;
                    // 配货
                    $list['split'] = true;
                    // 分单
                }
            } else {
                /* 不是货到付款 */
                if ($priv_list['ps']) {
                    $list['pay'] = false;
                    // 付款
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
                    $list['cancel'] = true;
                    // 取消
                    $list['invalid'] = true;
                    // 无效
                }
                if ($is_cod) {
                    /* 货到付款 */
                    if ($priv_list['ss']) {
                        if (SS_UNSHIPPED == $ss) {
                            $list['prepare'] = true;
                            // 配货
                        }
                        $list['split'] = true;
                        // 分单
                    }
                } else {
                    /* 不是货到付款 */
                    if ($priv_list['ps']) {
                        $list['pay'] = false;
                        // 付款
                    }
                }
            } elseif (SS_SHIPPED_ING == $ss || SS_SHIPPED_PART == $ss) {
                /* 状态：已确认、未付款、发货中 */
                // 部分分单
                if (OS_SPLITING_PART == $os) {
                    $list['split'] = true;
                    // 分单
                }
                $list['to_delivery'] = true;
                // 去发货
            } else {
                /* 状态：已确认、未付款、已发货或已收货 => 货到付款 */
                if ($priv_list['ps']) {
                    $list['pay'] = false;
                    // 付款
                }
                if ($priv_list['ss']) {
                    if (SS_SHIPPED == $ss) {
                        $list['receive'] = true;
                        // 收货确认
                    }
                    if(SS_RECEIVED != $ss) {
                        $list['unship'] = true;
                        //已收货后不能设未发货
                    }
//                     $list['unship'] = true;
                    // 设为未发货
                    if ($priv_list['os']) {
                        $list['return'] = true;
                        // 退货
                    }
                }
            }
        } else {
            /* 状态：已确认、已付款和付款中 */
            if (SS_UNSHIPPED == $ss || SS_PREPARING == $ss) {
                /* 状态：已确认、已付款和付款中、未发货（配货中） => 不是货到付款 */
                if ($priv_list['ss']) {
                    if (SS_UNSHIPPED == $ss) {
                        $list['prepare'] = true;
                        // 配货
                    }
                    $list['split'] = true;
                    // 分单
                }
                if ($priv_list['ps']) {
                    $list['unpay'] = false;
                    // 设为未付款
                    if ($priv_list['os']) {
                        $list['cancel'] = true;
                        // 取消
                    }
                }
            } elseif (SS_SHIPPED_ING == $ss || SS_SHIPPED_PART == $ss) {
                /* 状态：已确认、未付款、发货中 */
                // 部分分单
                if (OS_SPLITING_PART == $os) {
                    $list['split'] = true;
                    // 分单
                }
                $list['to_delivery'] = true;
                // 去发货
            } else {
                /* 状态：已确认、已付款和付款中、已发货或已收货 */
                if ($priv_list['ss']) {
                    if (SS_SHIPPED == $ss) {
                        $list['receive'] = true;
                        // 收货确认
                    }
                    if (!$is_cod) {
                        if(SS_RECEIVED != $ss) {
                            $list['unship'] = true;
                            //已收货后不能设未发货
                        }
                        // 设为未发货
                    }
                }
                if ($priv_list['ps'] && $is_cod) {
                    $list['unpay'] = false;
                    // 设为未付款
                }
                if ($priv_list['os'] && $priv_list['ss'] && $priv_list['ps']) {
                    $list['return'] = true;
                    // 退货（包括退款）
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
        /* 状态：无效 无效订单只能删除*/
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
        if ($order['extension_code'] == 'group_buy') {
            unset($list['split']);
            unset($list['to_delivery']);
            // 			TODO:团购活动暂时注释，直接不给予发货等操作
            // 			RC_Loader::load_app_func('admin_goods', 'goods');
            // 			$group_buy = group_buy_info(intval($order['extension_id']));
            // 			if ($group_buy['status'] != GBS_SUCCEED) {
            // 				unset($list['split']);
            // 				unset($list['to_delivery']);
            // 			}
        }
        /* 如果部分发货 不允许 取消 订单 */
        if (order_deliveryed($order['order_id'])) {
            $list['return'] = true;
            // 退货（包括退款）
            unset($list['cancel']);
            // 取消
        }
    }
    $list['unpay'] = $list['pay'] = false;
    /* 售后 */
    $list['after_service'] = true;
    return $list;
}

/**
 *  获取商家退货单列表信息
 * @access  public
 * @param
 * @return void
 */
function get_merchant_back_list() {
	$args = $_GET;
	/* 过滤信息 */
	$filter['delivery_sn'] = empty($args['delivery_sn']) ? '' : trim($args['delivery_sn']);
	$filter['order_sn'] = empty($args['order_sn']) ? '' : trim($args['order_sn']);
	$filter['order_id'] = empty($args['order_id']) ? 0 : intval($args['order_id']);
	$filter['consignee'] = empty($args['consignee']) ? '' : trim($args['consignee']);
	$filter['sort_by'] = empty($args['sort_by']) ? 'update_time' : trim($args['sort_by']);
	$filter['sort_order'] = empty($args['sort_order']) ? 'DESC' : trim($args['sort_order']);
	$filter['keywords'] = empty($args['keywords']) ? '' : trim($args['keywords']);
	$db_back_order = RC_DB::table('back_order as bo')->leftJoin('order_info as oi', RC_DB::raw('bo.order_id'), '=', RC_DB::raw('oi.order_id'));
	isset($_SESSION['store_id']) ? $db_back_order->where(RC_DB::raw('bo.store_id'), $_SESSION['store_id']) : '';
	$where = array();
	if ($filter['keywords']) {
		$db_back_order->whereRaw('(bo.order_sn like "%' . mysql_like_quote($filter['keywords']) . '%" or bo.consignee like "%' . mysql_like_quote($filter['keywords']) . '%")');
	}
	if ($filter['order_sn']) {
		$db_back_order->where(RC_DB::raw('bo.order_sn'), 'like', '%' . mysql_like_quote($filter['order_sn']) . '%');
	}
	if ($filter['consignee']) {
		$db_back_order->where(RC_DB::raw('bo.consignee'), 'like', '%' . mysql_like_quote($filter['consignee']) . '%');
	}
	if ($filter['delivery_sn']) {
		$db_back_order->where(RC_DB::raw('bo.delivery_sn'), 'like', '%' . mysql_like_quote($filter['delivery_sn']) . '%');
	}
	/* 记录总数 */
	$count = RC_DB::table('back_order as bo')->leftJoin('order_info as oi', RC_DB::raw('bo.order_id'), '=', RC_DB::raw('oi.order_id'))->count();
	$filter['record_count'] = $count;
	//加载分页类
	RC_Loader::load_sys_class('ecjia_page', false);
	//实例化分页
	$page = new ecjia_merchant_page($count, 15, 6);
	/* 查询 */
	$row = $db_back_order->selectRaw('bo.back_id, bo.order_id, bo.delivery_sn, bo.order_sn, bo.order_id, bo.add_time, bo.action_user, bo.consignee, bo.country,bo.province, bo.city, bo.district, bo.tel, bo.status, bo.update_time, bo.email, bo.return_time')->orderBy($filter['sort_by'], $filter['sort_order'])->take(15)->skip($page->start_id - 1)->groupBy('back_id')->get();
	if (!empty($row) && is_array($row)) {
		/* 格式化数据 */
		foreach ($row as $key => $value) {
			$row[$key]['return_time'] = RC_Time::local_date(ecjia::config('time_format'), $value['return_time']);
			$row[$key]['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $value['add_time']);
			$row[$key]['update_time'] = RC_Time::local_date(ecjia::config('time_format'), $value['update_time']);
			if ($value['status'] == 1) {
				$row[$key]['status_name'] = RC_Lang::get('orders::order.delivery_status.1');
			} else {
				$row[$key]['status_name'] = RC_Lang::get('orders::order.delivery_status.0');
			}
		}
	}
	return array('back' => $row, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
}

/**
 *  获取商家发货单列表信息
 *
 * @access  public
 * @param
 *
 * @return void
 */
function get_merchant_delivery_list() {
	$db_delivery_order = RC_DB::table('delivery_order as do')->leftJoin('order_info as oi', RC_DB::raw('do.order_id'), '=', RC_DB::raw('oi.order_id'));
	isset($_SESSION['store_id']) ? $db_delivery_order->where(RC_DB::raw('do.store_id'), $_SESSION['store_id']) : '';
	$args = $_GET;
	/* 过滤信息 */
	$filter['delivery_sn'] = empty($args['delivery_sn']) ? '' : trim($args['delivery_sn']);
	$filter['order_sn'] = empty($args['order_sn']) ? '' : trim($args['order_sn']);
	$filter['order_id'] = empty($args['order_id']) ? 0 : intval($args['order_id']);
	$filter['consignee'] = empty($args['consignee']) ? '' : trim($args['consignee']);
	$filter['sort_by'] = empty($args['sort_by']) ? 'update_time' : trim($args['sort_by']);
	$filter['sort_order'] = empty($args['sort_order']) ? 'DESC' : trim($args['sort_order']);
	$filter['keywords'] = empty($args['keywords']) ? '' : trim($args['keywords']);
	if ($filter['order_sn']) {
		$db_delivery_order->where(RC_DB::raw('do.order_sn'), 'like', '%' . mysql_like_quote($filter['order_sn']) . '%');
	}
	if ($filter['consignee']) {
		$db_delivery_order->where(RC_DB::raw('do.consignee'), 'like', '%' . mysql_like_quote($filter['consignee']) . '%');
	}
	if ($filter['delivery_sn']) {
		$db_delivery_order->where(RC_DB::raw('do.delivery_sn'), 'like', '%' . mysql_like_quote($filter['delivery_sn']) . '%');
	}
	if ($filter['keywords']) {
		$db_delivery_order->whereRaw('(do.order_sn like "%' . mysql_like_quote($filter['keywords']) . '%" or do.consignee like "%' . mysql_like_quote($filter['keywords']) . '%")');
	}
	/* 记录总数 */
	$type_count = $db_delivery_order->select(RC_DB::raw('count(*) as count_goods_num'), RC_DB::raw('SUM(IF(status = 0, 1, 0)) as already_shipped'), RC_DB::raw('SUM(IF(status = 1, 1, 0)) as op_return'), RC_DB::raw('SUM(IF(status = 2, 1, 0)) as normal'))->first();
	if (empty($type_count['already_shipped'])) {
		$type_count['already_shipped'] = 0;
	}
	if (empty($type_count['op_return'])) {
		$type_count['op_return'] = 0;
	}
	if (empty($type_count['normal'])) {
		$type_count['normal'] = 0;
	}
	if (empty($args['type'])) {
		$delivery_status = 0;
	} else {
		$delivery_status = $args['type'];
	}
	if ($delivery_status == 0) {
		$count = $type_count['already_shipped'];
		$filter['record_count'] = $count;
	} elseif ($delivery_status == 1) {
		$count = $type_count['op_return'];
		$filter['record_count'] = $count;
	} elseif ($delivery_status == 2) {
		$count = $type_count['normal'];
		$filter['record_count'] = $count;
	}
	/* 查询 */
	$status = $_GET['type'];
	if (empty($status)) {
		$status = 0;
	}
	$page = new ecjia_merchant_page($count, 15, 3);
	$row = $db_delivery_order->selectRaw('delivery_id, do.order_id, delivery_sn, do.order_sn, do.add_time, action_user, do.consignee, do.country, do.province, do.city, do.district, do.tel, do.status, do.update_time, do.email, do.suppliers_id')->orderBy($filter['sort_by'], $filter['sort_order'])->where(RC_DB::Raw('do.status'), $status)->take(15)->skip($page->start_id - 1)->get();
	/* 格式化数据 */
	if (!empty($row)) {
		foreach ($row as $key => $value) {
			$row[$key]['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $value['add_time']);
			$row[$key]['update_time'] = RC_Time::local_date(ecjia::config('time_format'), $value['update_time']);
			if ($value['status'] == 1) {
				$row[$key]['status_name'] = RC_Lang::get('orders::order.delivery_status.1');
			} elseif ($value['status'] == 2) {
				$row[$key]['status_name'] = RC_Lang::get('orders::order.delivery_status.2');
			} else {
				$row[$key]['status_name'] = RC_Lang::get('orders::order.delivery_status.0');
			}
		}
	}
	return array('delivery' => $row, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'type_count' => $type_count);
}

//end