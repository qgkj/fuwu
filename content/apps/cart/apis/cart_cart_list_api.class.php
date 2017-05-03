<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * @author will.chen
 */
 
class cart_cart_list_api extends Component_Event_Api {
    /**
     * @param
     *
     * @return array
     */
	public function call(&$options) {
		return $this->get_cart_goods($options['cart_id'], $options['flow_type'], $options['store_group']);
	}

	/**
	 * 获得购物车中的商品
	 *
	 * @access  public
	 * @return  array
	 */
	private function get_cart_goods($cart_id = array(), $flow_type = CART_GENERAL_GOODS, $store_group = array()) {
		$dbview_cart = RC_DB::table('cart as c')
					   ->leftJoin('goods as g', RC_DB::raw('c.goods_id'), '=', RC_DB::raw('g.goods_id'))
					   ->leftJoin('store_franchisee as s', RC_DB::raw('s.store_id'), '=', RC_DB::raw('c.store_id'));
		$db_goods_attr = RC_DB::table('goods_attr');

		/* 初始化 */
		$goods_list = array();
		$total = array(
			'goods_price'  => 0, // 本店售价合计（有格式）
			'market_price' => 0, // 市场售价合计（有格式）
			'saving'       => 0, // 节省金额（有格式）
			'save_rate'    => 0, // 节省百分比
			'goods_amount' => 0, // 本店售价合计（无格式）
	        'goods_number' => 0, // 商品总件数
		);
		$dbview_cart->where(RC_DB::raw('c.rec_type'), '=', $flow_type);
		$dbview_cart->where(RC_DB::raw('s.shop_close'), '=', '0');

		/* 符合店铺条件*/
		if (!empty($store_group)) {
			$dbview_cart->whereIn(RC_DB::raw('c.store_id'), $store_group);
		} else {
			$dbview_cart->where(RC_DB::raw('c.store_id'), 0);
		}

		/* 选择购买 */
		if (!empty($cart_id)) {
			$dbview_cart->whereIn(RC_DB::raw('c.rec_id'), $cart_id);
		}
		if ($_SESSION['user_id']) {
			$dbview_cart->where(RC_DB::raw('c.user_id'), $_SESSION['user_id']);
		} else {
			$dbview_cart->where(RC_DB::raw('c.session_id'), RC_Session::session()->getSessionKey());
		}

		/* 循环、统计 */
		$data = $dbview_cart
			->selectRaw("c.*,IF(c.parent_id, c.parent_id, c.goods_id) AS pid, goods_thumb, goods_img, original_img, g.goods_number as g_goods_number, g.is_on_sale, s.merchants_name as store_name, manage_mode")
			->orderBy('add_time', 'desc')
			/*->orderBy('store_id', 'asc')
			 ->orderBy('pid', 'asc')
			->orderBy('parent_id', 'asc') */
			->get();
		/* 用于统计购物车中实体商品和虚拟商品的个数 */
		$virtual_goods_count = 0;
		$real_goods_count    = 0;

		if (!empty($data)) {
			foreach ($data as $row) {
			    $row['is_disabled'] = 0;
			    $row['disabled_label'] = '';
			    //判断库存
			    if ($row['g_goods_number'] < $row['goods_number'] || $row['g_goods_number'] < 1) {
			        $row['is_disabled'] = 1;
			        $row['disabled_label'] = '库存不足';
			    }
			    //判断上架状态
			    if ($row['is_on_sale'] == 0) {
			        $row['is_disabled'] = 1;
			        $row['disabled_label'] = '商品已下架';
			    }
			    //不可用状态，取消选中
			    if ($row['is_disabed'] == 1) {
			        $row['is_checked'] == 0;
			        
			        RC_Loader::load_app_class('cart', 'cart', false);
			        cart::flow_check_cart_goods(array('id' => $row['goods_id'], 'is_checked' => 0));
			    }
			    
			    //增加购物车选中状态判断  by hyy
			    if ($row['is_checked'] == 1) {
			        $total['goods_price']  += $row['goods_price'] * $row['goods_number'];
			        $total['market_price'] += $row['market_price'] * $row['goods_number'];
			    }
			    
			    $total['goods_number'] += $row['goods_number'];
				$row['subtotal']     	= $row['goods_price'] * $row['goods_number'];
				$row['formatted_subtotal']     	= price_format($row['goods_price'] * $row['goods_number'], false);
				/* 返回未格式化价格*/
				$row['goods_price']		= $row['goods_price'];
				$row['market_price']	= $row['market_price'];

				$row['formatted_goods_price']  	= price_format($row['goods_price'], false);
				$row['formatted_market_price'] 	= price_format($row['market_price'], false);

				/* 统计实体商品和虚拟商品的个数 */
				if ($row['is_real']) {
					$real_goods_count++;
				} else {
					$virtual_goods_count++;
				}

				/* 查询规格 */
				if (trim($row['goods_attr']) != '') {
					$row['goods_attr'] = addslashes($row['goods_attr']);
					if (!is_array($row['goods_attr_id'])) {
					    $row['goods_attr_id'] = explode(',', $row['goods_attr_id']);
					}
					$attr_list = $db_goods_attr->select('attr_value')->whereIn('goods_attr_id', $row['goods_attr_id'])->get();
					foreach ($attr_list AS $attr) {
						$row['goods_name'] .= ' [' . $attr['attr_value'] . '] ';
					}
				}

// 				if ($row['extension_code'] == 'package_buy') {
// 					$row['package_goods_list'] = get_package_goods($row['goods_id']);
// 				}
				$row['is_checked']	= $row['is_checked'];
				$goods_list[] = $row;
			}
		}
		$total['goods_amount'] = $total['goods_price'];
		$total['saving']       = price_format($total['market_price'] - $total['goods_price'], false);
		if ($total['market_price'] > 0) {
			$total['save_rate'] = $total['market_price'] ? round(($total['market_price'] - $total['goods_price']) * 100 / $total['market_price']).'%' : 0;
		}
		$total['unformatted_goods_price']  	= $total['goods_price'];
		$total['goods_price']  				= price_format($total['goods_price'], false);
		$total['unformatted_market_price'] 	= $total['market_price'];
		$total['market_price'] 				= price_format($total['market_price'], false);
		$total['real_goods_count']    		= $real_goods_count;
		$total['virtual_goods_count'] 		= $virtual_goods_count;

		return array('goods_list' => $goods_list, 'total' => $total);
	}
}

// end