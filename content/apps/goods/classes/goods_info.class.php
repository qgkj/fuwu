<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商品信息
 * @author will.chen
 */
class goods_info {

	/**
	 * 取指定规格的货品信息
	 *
	 * @access public
	 * @param string $goods_id
	 * @param array $spec_goods_attr_id
	 * @return array
	 */
	public static function get_products_info($goods_id, $spec_goods_attr_id) {

		$return_array = array ();

		if (empty ( $spec_goods_attr_id ) || ! is_array ( $spec_goods_attr_id ) || empty ( $goods_id )) {
			return $return_array;
		}

		$goods_attr_array = self::sort_goods_attr_id_array ( $spec_goods_attr_id );

		if (isset ( $goods_attr_array ['sort'] )) {
			$db = RC_DB::table('products');
			$goods_attr = implode ( '|', $goods_attr_array ['sort'] );
			$return_array = $db->where('goods_id', $goods_id)->where('goods_attr', $goods_attr)->first();
		}
		return $return_array;
	}

	/**
	 * 获得指定的规格的价格
	 *
	 * @access public
	 * @param mix $spec
	 *        	规格ID的数组或者逗号分隔的字符串
	 * @return void
	 */
	public static function spec_price($spec) {
		if (! empty ( $spec )) {
			if (is_array ( $spec )) {
				foreach ( $spec as $key => $val ) {
					$spec [$key] = addslashes ( $val );
				}
			} else {
				$spec = addslashes ( $spec );
			}
			$db = RC_DB::table('goods_attr');
			$rs = $db->whereIn('goods_attr_id', $spec)->select(RC_DB::raw('sum(attr_price) as attr_price'))->get();
			$price = $rs['attr_price'];
		} else {
			$price = 0;
		}

		return $price;
	}

	/**
	 * 取得商品最终使用价格
	 *
	 * @param string $goods_id
	 *        	商品编号
	 * @param string $goods_num
	 *        	购买数量
	 * @param boolean $is_spec_price
	 *        	是否加入规格价格
	 * @param mix $spec
	 *        	规格ID的数组或者逗号分隔的字符串
	 *
	 * @return 商品最终购买价格
	 */
	public static function get_final_price($goods_id, $goods_num = '1', $is_spec_price = false, $spec = array())
	{
		$db_goodsview = RC_Model::model('goods/goods_viewmodel');
		RC_Loader::load_app_func ('goods', 'goods');
		$final_price	= 0; // 商品最终购买价格
		$volume_price	= 0; // 商品优惠价格
		$promote_price	= 0; // 商品促销价格
		$user_price		= 0; // 商品会员价格

		// 取得商品优惠价格列表
		$price_list = self::get_volume_price_list ($goods_id, '1');

		if (! empty ( $price_list )) {
			foreach ( $price_list as $value ) {
				if ($goods_num >= $value ['number']) {
					$volume_price = $value ['price'];
				}
			}
		}
		$field = "g.promote_price, g.promote_start_date, g.promote_end_date,IFNULL(mp.user_price, g.shop_price * '" . intval($_SESSION['discount']) . "') AS shop_price";
		// 取得商品促销价格列表
		$goods = $db_goodsview->join(array('member_price'))->field($field)->where(array('g.goods_id' => $goods_id, 'g.is_delete' => 0))->find();

		/* 计算商品的促销价格 */
		if ($goods ['promote_price'] > 0) {
			$promote_price = self::bargain_price ($goods['promote_price'], $goods ['promote_start_date'], $goods ['promote_end_date'] );
		} else {
			$promote_price = 0;
		}

		// 取得商品会员价格列表
		$user_price = $goods['shop_price'];

		// 比较商品的促销价格，会员价格，优惠价格
		if (empty ( $volume_price ) && empty ( $promote_price )) {
			// 如果优惠价格，促销价格都为空则取会员价格
			$final_price = $user_price;
		} elseif (! empty ( $volume_price ) && empty ( $promote_price )) {
			// 如果优惠价格为空时不参加这个比较。
			$final_price = min ( $volume_price, $user_price );
		} elseif (empty ( $volume_price ) && ! empty ( $promote_price )) {
			// 如果促销价格为空时不参加这个比较。
			$final_price = min ( $promote_price, $user_price );
		} elseif (! empty ( $volume_price ) && ! empty ( $promote_price )) {
			// 取促销价格，会员价格，优惠价格最小值
			$final_price = min ( $volume_price, $promote_price, $user_price );
		} else {
			$final_price = $user_price;
		}
		/* 手机专享*/
		$mobilebuy_db = RC_DB::table('goods_activity');
		$mobilebuy_ext_info = array('price' => 0);
		$mobilebuy = $mobilebuy_db
			->where('goods_id', $goods_id)
			->where('start_time', '<=', RC_Time::gmtime())
			->where('end_time', '>=', RC_Time::gmtime())
			->where('act_type', '=', GAT_MOBILE_BUY)
			->first();

		if (!empty($mobilebuy)) {
			$mobilebuy_ext_info = unserialize($mobilebuy['ext_info']);
		}
		$final_price =  ($final_price > $mobilebuy_ext_info['price'] && !empty($mobilebuy_ext_info['price'])) ? $mobilebuy_ext_info['price'] : $final_price;
	    
		// 如果需要加入规格价格
		if ($is_spec_price) {
			if (! empty ( $spec )) {
				$spec_price = self::spec_price ( $spec );
				$final_price += $spec_price;
			}
		}
		// 返回商品最终购买价格
		return $final_price;
	}

	/**
	 * 取得商品优惠价格列表
	 *
	 * @param string $goods_id
	 *        	商品编号
	 * @param string $price_type
	 *        	价格类别(0为全店优惠比率，1为商品优惠价格，2为分类优惠比率)
	 *
	 * @return 优惠价格列表
	 */
	public static function get_volume_price_list($goods_id, $price_type = '1') {
		$db = RC_DB::table('volume_price');
		$volume_price = array ();
		$temp_index = '0';

		$res = $db
			->select(RC_DB::raw('volume_number, volume_price'))
			->where('goods_id', $goods_id)
			->where('price_type', $price_type)
			->orderBy('volume_number', 'asc')
			->get();
		if (! empty ( $res )) {
			foreach ( $res as $k => $v ) {
				$volume_price [$temp_index] = array ();
				$volume_price [$temp_index] ['number'] = $v ['volume_number'];
				$volume_price [$temp_index] ['price'] = $v ['volume_price'];
				$volume_price [$temp_index] ['format_price'] = price_format ( $v ['volume_price'] );
				$temp_index ++;
			}
		}
		return $volume_price;
	}

	/**
	 * 获得指定的商品属性
	 * @access	  public
	 * @param	   array	   $arr		规格、属性ID数组
	 * @param	   type		$type	   设置返回结果类型：pice，显示价格，默认；no，不显示价格
	 * @return	  string
	 */
	public static function get_goods_attr_info($arr, $type = 'pice') {
		$attr   = '';
		if (!empty($arr)) {
			$fmt = "%s:%s[%s] \n";
			$dbview = RC_DB::table('goods_attr as ga')
					->leftjoin('attribute as a', RC_DB::raw('a.attr_id'), '=', RC_DB::raw('ga.attr_id'));

			$data = $dbview->whereIn(RC_DB::raw('ga.goods_attr_id'), $arr)->get();
			if(!empty($data)) {
				foreach ($data as $row) {
					$attr_price = round(floatval($row['attr_price']), 2);
					$attr .= sprintf($fmt, $row['attr_name'], $row['attr_value'], $attr_price);
				}
			}
			$attr = str_replace('[0]', '', $attr);
		}
		return $attr;
	}

	/**
	 *
	 * 是否存在规格
	 *
	 * @access public
	 * @param array $goods_attr_id_array
	 *        	一维数组
	 *
	 * @return string
	 */
	public static function is_spec($goods_attr_id_array, $sort = 'asc') {
		$dbview = RC_DB::table('attribute as a')
					->leftJoin('goods_attr as v', RC_DB::raw('v.attr_id'), '=', RC_DB::raw('a.attr_id'));
		$dbview->where(RC_DB::raw('a.attr_type'), '=', 1);
		if (empty ( $goods_attr_id_array )) {
			return $goods_attr_id_array;
		}

		// 重新排序
		$row = $dbview
				->whereIn(RC_DB::raw('v.goods_attr_id'), $goods_attr_id_array)
				->orderBy(RC_DB::raw('a.attr_id'), $sort)
				->get();
		$return_arr = array ();
		if (!empty($row)) {
			foreach ( $row as $value ) {
				$return_arr ['sort'] [] = $value ['goods_attr_id'];
				$return_arr ['row'] [$value ['goods_attr_id']] = $value;
			}
		}

		if (! empty ( $return_arr )) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 判断某个商品是否正在特价促销期
	 *
	 * @access public
	 * @param float $price
	 *        	促销价格
	 * @param string $start
	 *        	促销开始日期
	 * @param string $end
	 *        	促销结束日期
	 * @return float 如果还在促销期则返回促销价，否则返回0
	 */
	private static function bargain_price($price, $start, $end) {
		if ($price == 0) {
			return 0;
		} else {
			$time = RC_Time::gmtime ();
			if ($time >= $start && $time <= $end) {
				return $price;
			} else {
				return 0;
			}
		}
	}

	/**
	 * 将 goods_attr_id 的序列按照 attr_id 重新排序
	 *
	 * 注意：非规格属性的id会被排除
	 *
	 * @access public
	 * @param array $goods_attr_id_array
	 *        	一维数组
	 * @param string $sort
	 *        	序号：asc|desc，默认为：asc
	 *
	 * @return string
	 */
	private function sort_goods_attr_id_array($goods_attr_id_array, $sort = 'asc') {
		$dbview = RC_DB::table('attribute as a')
		->leftJoin('goods_attr as v', RC_DB::raw('v.attr_id'), '=', RC_DB::raw('a.attr_id'));
		$dbview->where(RC_DB::raw('a.attr_type'), '=', 1);
		if (empty($goods_attr_id_array)) {
			return $goods_attr_id_array;
		}

		// 重新排序
		$row = $dbview
				->whereIn(RC_DB::raw('v.goods_attr_id'), $goods_attr_id_array)
				->orderBy(RC_DB::raw('a.attr_id'), $sort)
				->get();
		$return_arr = array();
		if (! empty($row)) {
			foreach ($row as $value) {
				$return_arr['sort'][] = $value['goods_attr_id'];

				$return_arr['row'][$value['goods_attr_id']] = $value;
			}
		}
		return $return_arr;
	}
}

// end