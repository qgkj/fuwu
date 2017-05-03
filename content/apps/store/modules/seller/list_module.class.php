<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 店铺街列表
 * @author will.chen
 */
class list_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$seller_categroy	= $this->requestData('category_id', 0);
		
		$keywords	 = $this->requestData('keywords');
		$location	 = $this->requestData('location', array());
		/*经纬度为空判断*/
		if (!is_array($location) || empty($location['longitude']) || empty($location['latitude'])) {
			$seller_list = array();
			$page = array(
				'total'	=> '0',
				'count'	=> '0',
				'more'	=> '0',
			);
			return array('data' => $seller_list, 'pager' => $page);
		} else {
            $geohash      = RC_Loader::load_app_class('geohash', 'store');
            $geohash_code = $geohash->encode($location['latitude'] , $location['longitude']);
            $geohash_code = substr($geohash_code, 0, 7);
        }
		/* 获取数量 */
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);
		
		$options = array(
				'seller_category'	=> $seller_categroy,
				'keywords'		    => $keywords,
				'size'			    => $size,
				'page'			    => $page,
				'geohash'		    => $geohash_code,
				'sort'			    => array('sort_order' => 'asc'),
				'limit'			    => 'all'
		);
		
// 		$cache_id = sprintf('%X', crc32($seller_categroy .'-' . $_SESSION['user_rank']. '-' .
// 				$keywords . '-'. $geohash_code));
		
// 		$cache_key = 'seller_list_'.$cache_id;
// 		$store_data = RC_Cache::app_cache_get($cache_key, 'store');
		
// 		$store_id_group = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code));
		
// 		if (!$store_data) {
			$store_data = RC_Api::api('store', 'store_list', $options);
// 			RC_Cache::app_cache_set($cache_key, $store_data, 'store', 10080);
// 		}

		$seller_list = array();
		if (!empty($store_data['seller_list'])) {
			$collect_store_id = RC_DB::table('collect_store')->where('user_id', $_SESSION['user_id'])->lists('store_id');
			
			$db_favourable = RC_Model::model('favourable/favourable_activity_model');
			/* 手机专享*/
			foreach ($store_data['seller_list'] as $key => $row) {
				$favourable_list = array();
				$store_options = array(
						'store_id' => $row['id']
				);
				$favourable_result = RC_Api::api('favourable', 'store_favourable_list', $store_options);
				
				if (!empty($favourable_result)) {
					foreach ($favourable_result as $val) {
						if ($val['act_range'] == '0') {
							$favourable_list[] = array(
									'name' => $val['act_name'],
									'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
									'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
							);
						} else {
							$act_range_ext = explode(',', $val['act_range_ext']);
							switch ($val['act_range']) {
								case 1 :
									$favourable_list[] = array(
									'name' => $val['act_name'],
									'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
									'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
									);
									break;
								case 2 :
									$favourable_list[] = array(
									'name' => $val['act_name'],
									'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
									'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
									);
									break;
								case 3 :
									$favourable_list[] = array(
									'name' => $val['act_name'],
									'type' => $val['act_type'] == '1' ? 'price_reduction' : 'price_discount',
									'type_label' => $val['act_type'] == '1' ? __('满减') : __('满折'),
									);
									break;
								default:
									break;
							}
						}
					}
				}
				
				$goods_list = array();
// 				//TODO ::增加商品缓存
// 				$store_goods_cache_key = sprintf('%X', crc32('goods_list_store_' . $row['id'] . '_'. $keywords));
// 				$goods_store_data = RC_Cache::app_cache_get($store_goods_cache_key, 'goods');
				
// 				if (!$goods_store_data) {
				$goods_options = array('store_id' => $row['id'], 'keywords' => $keywords, 'page' => 1, 'size' => 10);
				/* 如有查询添加，不限制分页*/
				if (!empty($keywords)) {
					$goods_options['size'] = $goods_options['page'] = 0;
				}
					
				$goods_result = RC_Api::api('goods', 'goods_list', $goods_options);
					
				if (!empty($goods_result['list'])) {
					foreach ($goods_result['list'] as $val) {
						/* 判断是否有促销价格*/
						$price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_promote_price'] : $val['unformatted_shop_price'];
						$activity_type = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
						/* 计算节约价格*/
						$saving_price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_shop_price'] - $val['unformatted_promote_price'] : (($val['unformatted_market_price'] > 0 && $val['unformatted_market_price'] > $val['unformatted_shop_price']) ? $val['unformatted_market_price'] - $val['unformatted_shop_price'] : 0);
						$goods_list[] = array(
									'goods_id'		=> $val['goods_id'],
									'name'			=> $val['name'],
									'market_price'	=> $val['market_price'],
									'shop_price'	=> $val['shop_price'],
									'promote_price'	=> $val['promote_price'],
									'img' => array(
											'thumb'	=> $val['goods_img'],
											'url'	=> $val['original_img'],
											'small'	=> $val['goods_thumb']
									),
									'activity_type' => $activity_type,
									'object_id'		=> 0,
									'saving_price'	=>	$saving_price,
									'formatted_saving_price' => $saving_price > 0 ? '已省'.$saving_price.'元' : '',
						);
					}
				}
					$goods_store_data = array('goods_list' => $goods_list, 'count' => $goods_result['page']->total_records);
					
// 					RC_Cache::app_cache_set($store_goods_cache_key, $goods_store_data, 'goods', 10080);
// 			}
				
				$distance = getDistance($location['latitude'], $location['longitude'], $row['location']['latitude'], $row['location']['longitude']);
				
				$distance_list[]	= $distance;
				$sort_order[]	 	= $row['sort_order'];
				
				$seller_list[] = array(
						'id'				=> $row['id'],
						'seller_name'		=> $row['seller_name'],
						'seller_category'	=> $row['seller_category'],
						'manage_mode'		=> $row['manage_mode'],
						'seller_logo'		=> $row['shop_logo'],
						'seller_goods'		=> $goods_store_data['goods_list'],
						'follower'			=> $row['follower'],
						'is_follower'		=> in_array($row['id'], $collect_store_id) ? 1 : 0,
						'goods_count'       => $goods_store_data['count'],
						'favourable_list'	=> $favourable_list,
						'distance'			=> $distance,
						'label_trade_time'	=> $row['label_trade_time'],
				);
			}
			array_multisort($distance_list, SORT_ASC, $sort_order, SORT_ASC, $seller_list);
		}
		
		$seller_list = array_slice($seller_list, ($page-1)*$size, $size);
		$page = array(
				'total'	=> $store_data['page']->total_records,
				'count'	=> $store_data['page']->total_records,
				'more'	=> $store_data['page']->total_pages <= $page ? 0 : 1,
		);

		return array('data' => $seller_list, 'pager' => $page);
	}
}

/**
 * 计算两组经纬度坐标 之间的距离
 * @param params ：lat1 纬度1； lng1 经度1； lat2 纬度2； lng2 经度2； len_type （1:m or 2:km);
 * @return return m or km
 */
function getDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 1)
{
	$EARTH_RADIUS  = 6378.137;
	$PI            = 3.1415926;
	$radLat1       = $lat1 * $PI / 180.0;
	$radLat2       = $lat2 * $PI / 180.0;
	$a             = $radLat1 - $radLat2;
	$b             = ($lng1 * $PI / 180.0) - ($lng2 * $PI / 180.0);
	$s             = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
	$s             = $s * $EARTH_RADIUS;
	$s             = round($s * 1000);
	if ($len_type > 1) {
		$s /= 1000;
	}

	return round($s, $decimal);
}

// end
