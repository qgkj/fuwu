<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 验证红包
 * @author royalwang
 */
class bonus_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
    	$this->authSession();	
 		RC_Loader::load_app_func('admin_order', 'orders');
 		RC_Loader::load_app_func('cart', 'cart');
 		$bonus_sn = $this->requestData('bonus_sn');
 		
 		if (empty($_SESSION['user_id'])) {
 		    return new ecjia_error(100, 'Invalid session' );
 		}
 		
		if (is_numeric($bonus_sn)) {
			RC_Loader::load_app_func('admin_bonus', 'bonus');
			$bonus = bonus_info(0, $bonus_sn);
		} else {
			$bonus = array();
		}
		//$bonus_kill = price_format($bonus['type_money'], false);
		$result = array('error' => '', 'content' => '');

		/* 取得购物类型 */
		$flow_type  = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;

		/* 获得收货人信息 */
		$consignee  = get_consignee($_SESSION['user_id']);

		/* 对商品信息赋值 */
		$cart_goods = cart_goods($flow_type); // 取得商品列表，计算合计

		if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type)) {
			$result['error'] = RC_Lang::get('user::user.no_goods_in_cart');
		} else {
			/* 取得订单信息 */
			$order = flow_order_info();

			if (((!empty($bonus) && $bonus['user_id'] == $_SESSION['user_id']) || ($bonus['type_money'] > 0 && empty($bonus['user_id']))) && $bonus['order_id'] <= 0) {
				//$order['bonus_kill'] = $bonus['type_money'];
				$now = RC_Time::gmtime();

				if ($now > $bonus['use_end_date']) {
					$order['bonus_id'] = '';
					$result['error']   = RC_Lang::get('user::user.bonus_use_expire');
				} else {
					$order['bonus_id'] = $bonus['bonus_id'];
					$order['bonus_sn'] = $bonus_sn;
				}
			} else {
				$order['bonus_id']     = '';
				$result['error']       = RC_Lang::get('user::user.invalid_bonus');
			}

			/* 计算订单的费用 */
			$total = order_fee($order, $cart_goods, $consignee);

			if($total['goods_price'] < $bonus['min_goods_amount']) {
				$order['bonus_id'] = '';
				/* 重新计算订单 */
				$total = order_fee($order, $cart_goods, $consignee);
				$result['error'] = sprintf(RC_Lang::get('user::user.bonus_min_amount_error'), price_format($bonus['min_goods_amount'], false));
			}
			/* 团购标志 */
			if ($flow_type == CART_GROUP_BUY_GOODS) {
				$is_group_buy = 1;
			}

			$result['is_group_buy'] = $is_group_buy;
			$result['total'] = $total;
		}
		if (!empty($result['error'])) {
			return new ecjia_error(101, '参数错误');
		}

		$out = array('bonus'=>$result['total']['bonus'], 'bonus_formated'=>$result['total']['bonus_formated']);
		return $out;
	}
}

// end