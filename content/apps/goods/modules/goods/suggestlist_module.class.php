<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商品推荐列表
 * @author royalwang
 */
class suggestlist_module extends api_front implements api_interface {

    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$location	 = $this->requestData('location', array());
		$action_type = $this->requestData('action_type', '');
    	$sort_type	 = $this->requestData('sort_by', '');
    	$size = $this->requestData('pagination.count', 15);
    	$page = $this->requestData('pagination.page', 1);
    	$type = array('new', 'best', 'hot', 'promotion');//推荐类型
    	
    	if (!in_array($action_type, $type)) {
    		return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
    	}
    	/*经纬度为空判断*/
    	if (!is_array($location) || empty($location['longitude']) || empty($location['latitude'])) {
    		$data = array();
    		$data['list'] = array();
    		$data['pager'] = array(
    			"total" => '0',
    			"count" => '0',
    			"more"	=> '0'
    		);
    		return array('data' => $data['list'], 'pager' => $data['pager']);
    	} else {
	        $geohash = RC_Loader::load_app_class('geohash', 'store');
	        $geohash_code = $geohash->encode($location['latitude'] , $location['longitude']);
	        $geohash_code = substr($geohash_code, 0, 5);
// 	        $store_id_group = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code));
// 	        if (empty($options['store_id_group'])) {
// 	            $store_id_group = RC_Api::api('store', 'neighbors_store_id', array('geohash' => substr($geohash_code, 0, 4)));
// 	        }
    	}
    	
		switch ($sort_type) {
			case 'goods_id' :
				$order_by = array('goods_id' => 'desc');
				break;
			case 'shop_price_desc' :
				$order_by = array('shop_price' => 'desc', 'g.sort_order' => 'asc');
				break;
			case 'shop_price_asc' :
				$order_by = array('shop_price' => 'asc', 'g.sort_order' => 'asc');
	    		break;
			case 'last_update' :
				$order_by = array('last_update' => 'desc');
				break;
			default :
				$order_by = array('g.sort_order' => 'asc', 'goods_id' => 'desc');
				break;
		}

		$options = array(
			'intro'		=> $action_type,
			'sort'		=> $order_by,
			'page'		=> $page,
			'size'		=> $size,
			'geohash'	=> $geohash_code,
// 			'store_id'  => $store_id_group,
		);
		$result = RC_Api::api('goods', 'goods_list', $options);
		$data['pager'] = array(
			"total"	=> $result['page']->total_records,
			"count"	=> $result['page']->total_records,
			"more"	=> $result['page']->total_pages <= $page ? 0 : 1,
		);
		$data['list'] = array();

		if (!empty($result['list'])) {
			foreach ($result['list'] as $val) {
				/* 判断是否有促销价格*/
				$price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_promote_price'] : $val['unformatted_shop_price'];
				$activity_type = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
				/* 计算节约价格*/
				$saving_price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_shop_price'] - $val['unformatted_promote_price'] : (($val['unformatted_market_price'] > 0 && $val['unformatted_market_price'] > $val['unformatted_shop_price']) ? $val['unformatted_market_price'] - $val['unformatted_shop_price'] : 0);

				$mobilebuy_price = $object_id = 0;
	    			
				$data['list'][] = array(
					'goods_id'		=> $val['goods_id'],
					'id'			=> $val['goods_id'],
					'name'			=> $val['name'],
					'market_price'	=> $val['market_price'],
					'shop_price'	=> $val['shop_price'],
					'promote_price'	=> $val['promote_price'],
					'manage_mode'	=> $val['manage_mode'],
					'unformatted_promote_price' => $val['unformatted_promote_price'],
					'promote_start_date'		=> $val['promote_start_date'],
					'promote_end_date'			=> $val['promote_end_date'],
					'img' => array(
						'thumb'	=> $val['goods_img'],
						'url'	=> $val['original_img'],
						'small'	=> $val['goods_thumb']
					),
					'activity_type' => $activity_type,
					'object_id'		=> $object_id,
					'saving_price'	=>	$saving_price,
					'formatted_saving_price' => $saving_price > 0 ? '已省'.$saving_price.'元' : '',
					'seller_id'		=> $val['store_id'],
					'seller_name'	=> $val['store_name'],
				);
			}
		}
		return array('data' => $data['list'], 'pager' => $data['pager']);
    }
}

// end