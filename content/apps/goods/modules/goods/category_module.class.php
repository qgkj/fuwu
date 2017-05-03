<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取所有商品分类
 * @author royalwang
 */
class category_module extends api_front implements api_interface {
	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
// 		$cache_key = 'api_goods_category';
// 		$categoryGoods = RC_Cache::app_cache_get($cache_key, 'goods');
	
// 		if (empty($categoryGoods)) {
			$categoryGoods = array();
			RC_Loader::load_app_class('goods_category', 'goods', false);
			$category = goods_category::get_categories_tree();
			$category = array_merge($category);
			
			if (!empty($category)) {
				foreach($category as $key => $val) {
					$categoryGoods[$key]['id'] = $val['id'];
					$categoryGoods[$key]['name'] = $val['name'];
					$categoryGoods[$key]['image'] = $val['img'];
					if (!empty($val['cat_id'])) {
						foreach($val['cat_id'] as $k => $v ) {
							$categoryGoods[$key]['children'][$k] = array(
									'id'     => $v['id'],
									'name'   => $v['name'],
									'image'	 => $v['img'],
							);
								
							if( !empty($v['cat_id']) ) {
								foreach($v['cat_id'] as $k1 => $v1) {
									$categoryGoods[$key]['children'][$k]['children'][] = array(
											'id'     => $v1['id'],
											'name'   => $v1['name'],
											'image'	 => $v1['img'],
									);
								}
							} else {
								$categoryGoods[$key]['children'][$k]['children'] = array();
							}
								
							$categoryGoods[$key]['children'] = array_merge($categoryGoods[$key]['children']);
						}
					} else {
						$categoryGoods[$key]['children'] = array();
					}
				}
			}
// 			RC_Cache::app_cache_set($cache_key, $categoryGoods, 'goods', 60);
// 		}
		return $categoryGoods;
	}
}

// end