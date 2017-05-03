<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 首页轮播图及推荐数据
 * @author royalwang
 */
class data_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	
		$device		= $this->device;

		$location	= $this->requestData('location',array());

		$request = null;
		if (is_array($location) && isset($location['latitude']) && isset($location['longitude'])) {
			$request                     = array('location' => $location);
			$geohash                     = RC_Loader::load_app_class('geohash', 'store');
			$geohash_code                = $geohash->encode($location['latitude'] , $location['longitude']);
			$geohash_code                = substr($geohash_code, 0, 5);
			$request['geohash_code']     = $geohash_code;
			$request['store_id_group']   = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code));

			if (empty($request['store_id_group'])) {
				$request['store_id_group'] = array(0);
			}
		}

		$device['code'] = isset($device['code']) ? $device['code'] : '';
			//流程逻辑开始
			// runloop 流
			$response = array();
			$response = RC_Hook::apply_filters('api_home_data_runloop', $response, $request);//mobile_home_adsense1
		return $response;

	}
}

function cycleimage_data($response, $request) 
{
	$mobile_cycleimage = RC_Loader::load_app_class('cycleimage_method', 'cycleimage');
	$cycleimageDatas   = $mobile_cycleimage->player_data(true);
	$player_data = array();
	foreach ($cycleimageDatas as $val) {
		$player_data[] = array(
				'photo'      => array(
						'small'      => $val['src'],
						'thumb'      => $val['src'],
						'url'        => $val['src'],
				),
				'url'        => $val['url'],
				'description'=> $val['text'],
		);
	}

	/* 限制轮播图片显示最多5张 */
	if (count($player_data) > 5) {
		$player_data = array_slice($player_data, 0, 5);
	}

	$response['player'] = $player_data;

	return $response;
}

function mobile_menu_data($response, $request) {
	$mobile            = RC_Loader::load_app_class('mobile_method','mobile');
	$mobile_menu       = array_merge($mobile->shortcut_data(true));
	$mobile_menu_data  = array();
	if (!empty($mobile_menu)) {
		foreach ($mobile_menu as $key => $val) {
			if ($val['display'] == '1') {
				$mobile_menu_data[] = array(
						'image'	=> $val['src'],
						'text'	=> $val['text'],
						'url'	=> $val['url']
				);
			}
		}
	}

	$response['mobile_menu'] = $mobile_menu_data;
	return $response;
}

function promote_goods_data($response, $request) {
	
	$promote_goods_data = array();
	$order_sort         = array('g.sort_order' => 'ASC', 'goods_id' => 'DESC');
	$filter = array(
			'intro'	  => 'promotion',
			'sort'	  => $order_sort,
			'page'	  => 1,
			'size'	  => 6,
			'geohash' => $request['geohash_code'],
	);

	$result = RC_Api::api('goods', 'goods_list', $filter);
	if ( !empty($result['list']) ) {
		foreach ( $result['list'] as $key => $val ) {
			$promote_goods_data[] = array(
					'id'		                => intval($val['goods_id']),
					'goods_id'	                => intval($val['goods_id']),           //多商铺中不用，后期删除
					'name'		                => $val['goods_name'],
					'market_price'	            => $val['market_price'],
					'shop_price'	            => $val['shop_price'],
					'promote_price'	            => $val['promote_price'],
					'manage_mode'               => $val['manage_mode'],
					'unformatted_promote_price' => $val['unformatted_promote_price'],
					'promote_start_date'        => $val['promote_start_date'],
					'promote_end_date'          => $val['promote_end_date'],
					'img'                       => array(
            							'small' => $val['goods_thumb'],
            							'thumb' => $val['goods_img'],
            							'url'	=> $val['original_img'],
					)
			);
		}
	}
	
	$response['promote_goods'] = $promote_goods_data;
	return $response;
}

function new_goods_data($response, $request) {
	$new_goods_data = array();

	$order_sort = array('g.sort_order' => 'ASC', 'goods_id' => 'DESC');
	$filter     = array(
			'intro'	=> 'new',
			'sort'	=> $order_sort,
			'page'	=> 1,
			'size'	=> 6,
			'geohash' => $request['geohash_code'],
	);
	
	$result = RC_Api::api('goods', 'goods_list', $filter);
	if ( !empty($result['list']) ) {
		foreach ( $result['list'] as $key => $val ) {
			$new_goods_data[] = array(
					'id'            => intval($val['goods_id']),
					'goods_id'      => intval($val['goods_id']),           //多商铺中不用，后期删除
					'name'          => $val['goods_name'],
					'manage_mode'   => $val['manage_mode'],
					'market_price'	=> $val['market_price'],
					'shop_price'	=> $val['shop_price'],
					'promote_price'	=> $val['promote_price'],
					'img'           => array(
							'small' => $val['goods_thumb'],
							'thumb' => $val['goods_img'],
							'url'	=> $val['original_img'],
					)
			);
		}
	}

	$response['new_goods'] = $new_goods_data;
	return $response;
}


function mobile_home_adsense_group($response, $request) {
	if (ecjia::config('mobile_home_adsense_group') == '' || ecjia::config('mobile_home_adsense_group') == 0) {
		$response['adsense_group'] = array();
	} else {
		$adsense_group = explode(',', ecjia::config('mobile_home_adsense_group'));
		$mobile_home_adsense_group = array();
		if (!empty($adsense_group)) {
			foreach ($adsense_group as $key => $val) {
				$mobile_adsense_group = RC_Api::api('adsense', 'adsense_list', array('position_id' => $val));
					
				$mobile_home_adsense_group[] = $mobile_adsense_group;
			}
		}

		$response['adsense_group'] = $mobile_home_adsense_group;
	}

	return $response;
}

function group_goods_data($response, $request) {
	$response['group_goods'] = array();
	return $response;
}

function mobilebuy_goods_data($response, $request) {
	$response['mobile_buy_goods'] = array();
	return $response;
}

function seller_recommend_data($response, $request) {
		$response['seller_recommend'] = array();
		return $response; 
}

function topic_data($response, $request) {
	$response['mobile_topic_adsense'] = array();
	return $response;
}

function mobile_toutiao_data($response, $request) {
	$response['toutiao'] = $mobile_toutiao_data;
	return $response;
}


RC_Hook::add_filter('api_home_data_runloop', 'cycleimage_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'mobile_menu_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'promote_goods_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'new_goods_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'mobile_home_adsense_group', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'group_goods_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'mobilebuy_goods_data', 10, 2);
RC_Hook::add_filter('api_home_data_runloop', 'topic_data', 10, 2);

// end
