<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取优惠红包列表
 * @author zrl
 */
class coupon_module extends api_front implements api_interface {
	
	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		
		$this->authSession();
		$location = $this->requestData('location', array());
		/*经纬度为空判断*/
		if (!is_array($location) || empty($location['longitude']) || empty($location['latitude'])) {
			return new ecjia_error('invalid_parameter', '参数无效');
		}
		
		$size = $this->requestData('pagination.count', 15);
        $page = $this->requestData('pagination.page', 1);
		
		$where = array();
		$where['bt.send_type'] = SEND_COUPON;
		$where['bt.store_id'] = array('gt' => '0');
		/*根据经纬度查询附近店铺*/
		if (is_array($location) && !empty($location['latitude']) && !empty($location['longitude'])) {
			$geohash = RC_Loader::load_app_class('geohash', 'store');
			$geohash_code = $geohash->encode($location['latitude'] , $location['longitude']);
			$geohash_code = substr($geohash_code, 0, 5);
			$where['bt.store_id'] = array_merge(array(0), RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code)));
		}
// 		if (!empty($_SESSION['user_id'])) {
// 			$where['ub.user_id'] =  $_SESSION['user_id'];
// 		}
		
		$options = array('location' => $location, 'page' => $page, 'size' => $size, 'where' => $where);
		
		$result = RC_Api::api('bonus', 'coupon_list', $options);
		if (is_ecjia_error($result)) {
		    return $result;
		}
		$list = array();
		if (!empty($result['coupon_list'])) {
			foreach ($result['coupon_list'] as $key => $row) {
				$list[] = array(
					'shop_name' 				=>  $row['shop_name'],
					'bonus_id'  				=> 	$row['type_id'],
					'bonus_name'				=>  $row['type_name'],
					'bonus_amount'				=> intval($row['bonus_amount']),
					'formatted_bonus_amount'	=> price_format($row['bonus_amount']),
					'request_amount'			=> $row['min_goods_amount'],
					'formatted_request_amount'	=> price_format($row['min_goods_amount']),
					'formatted_start_date'		=> RC_Time::local_date(ecjia::config('date_format'), $row['use_start_date']),
					'formatted_end_date'		=> RC_Time::local_date(ecjia::config('date_format'), $row['use_end_date']),
					'received_coupon'			=> (isset($row['user_id']) && $row['user_id'] > 0) ? 1 : 0
				);
			}
		}
		$pager = array(
			'total' => $result['page']->total_records,
			'count' => $result['page']->total_records,
			'more'	=> $result['page']->total_pages <= $page ? 0 : 1,
		);
		return array('data' => $list, 'pager' => $pager);
	}
}

// end