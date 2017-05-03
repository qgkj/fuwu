<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 店铺列表接口
 * @author
 */
class store_neighbors_store_id_api extends Component_Event_Api {
	/**
	 *
	 * @param array $options
	 * @return  array
	 */
	public function call (&$options) {
		if (!is_array($options) || !isset($options['geohash']) || empty($options['geohash']) ) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}

		return $this->neighbors_store($options['geohash']);
	}

	/**
	 *  获取经纬度周边店铺id
	 *
	 * @access  private
	 * @param 	string 		geohash_code        地区code
	 * @return  array       group_seller_id     店铺id
	 */
	private function neighbors_store($geohash_code)
	{
		/* 载入geohash类*/
		$geohash	  = RC_Loader::load_app_class('geohash', 'store');

		/* 获取当前经纬度周边的geohash值*/
		$geohash_group = $geohash->geo_neighbors($geohash_code);

		$group_store_id = RC_DB::table('store_franchisee')->where('geohash', 'like', $geohash_code.'%')->where('shop_close', '0')->lists('store_id');

		foreach ($geohash_group as $val) {
			$store_id = RC_DB::table('store_franchisee')->where('geohash', 'like', $val.'%')->where('shop_close', '0')->lists('store_id');
			if (!empty($store_id)) {
				$group_store_id = array_merge($group_store_id, $store_id);
			}
		}
		return $group_store_id;

// 		/* 获取当前经纬度的geohash值*/
// 		$geohash_code = $geohash->encode($filter['location']['latitude'] , $filter['location']['longitude']);
// 		$geohash_code = substr($geohash_code, 0, 5);
	}
}

// end
