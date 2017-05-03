<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 某一分类的筛选
 * @author will.chen
 */
class filter_module extends api_front implements api_interface {
	
	 public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authSession();
    	
		$data = array();
		$cat_id = $this->requestData('category_id', 0);
		
		if ($cat_id <= 0 ) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}
		$cache_key = 'api_goods_filter_'.$cat_id.'_'.ecjia::config('lang');
		$filter_array = RC_Cache::app_cache_get($cache_key, 'goods');
		if (empty($filter_array)) {
			$filter = RC_Api::api('goods', 'goods_filter', array('cat_id' => $cat_id));
			$filter_array['category_filter'] = array();
			if (!empty($filter['category_filter'])) {
				foreach ($filter['category_filter'] as $key => $val) {
					$filter_array['category_filter'][] = array(
							'cat_id'	=> $val['cat_id'],
							'cat_name'	=> $val['cat_name'],
							'parent_id' => $val['parent_id'],
					);
				}
			}
			
			$filter_array['brand_filter'] = array();
			if (!empty($filter['brands_filter'])) {
				foreach ($filter['brands_filter'] as $key => $val) {
					$filter_array['brand_filter'][] = array(
							'brand_id'		=> $val['brand_id'],
							'brand_name'	=> $val['brand_name'],
					);
				}
			}
			
			$filter_array['price_filter'] = array();
			if (!empty($filter['price_filter'])) {
				foreach ($filter['price_filter'] as $key => $val) {
					$filter_array['price_filter'][] = array(
							'price_range' => $val['price_range'],
							'price_min' => $val['start'],
							'price_max' => $val['end']
					);
				}
			}
			
			$filter_array['attr_filter'] = array();
			if (!empty($filter['attr_filter'])) {
				foreach ($filter['attr_filter'] as $key => $val) {
					$filter_array['attr_filter'][$key]['filter_attr_name'] = $val['filter_attr_name'];
					foreach ($val['attr_list'] as $k => $v) {
						$filter_array['attr_filter'][$key]['attr_list'][] = array(
								'attr_id' => $v['goods_attr_id'],
								'attr_value' => $v['attr_value'],
						);
					}
				}
			}
			RC_Cache::app_cache_set($cache_key, $filter_array, 'goods', 60);
		}
		
		return $filter_array;
	}
}


// end