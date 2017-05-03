<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商铺商品列表
 * @author will.chen
 */
class list_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    		
		$filter = $this->requestData('filter', array());
		
		$keyword = RC_String::unicode2string($filter['keywords']);
		$category = !empty($filter['category_id']) ? intval($filter['category_id']) : 0;
		$sort_type = $filter['sort_by'];
		$store_id = $this->requestData('seller_id');
		$action_type = $this->requestData('action_type', '');
		
		if (empty($store_id)) {
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
		
		switch ($sort_type) {
			case 'new' :
				$order_by = array('g.sort_order' => 'asc', 'goods_id' => 'desc');
				break;
			case 'price_desc' :
				$order_by = array('shop_price' => 'desc', 'g.sort_order' => 'asc');
				break;
			case 'price_asc' :
				$order_by = array('shop_price' => 'asc', 'g.sort_order' => 'asc');
				break;
			case 'last_update' :
				$order_by = array('last_update' => 'desc');
				break;
			case 'hot' :
				$order_by = array('is_hot' => 'desc', 'click_count' => 'desc', 'g.sort_order' => 'asc');
				break;
			default :
				$order_by = array('g.sort_order' => 'asc', 'goods_id' => 'desc');
				break;
		}
		
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);
		
		$options = array(
				'merchant_cat_id'	=> $category,
				'keywords'	=> $keyword,
				'store_id'  => $store_id,
				'sort'		=> $order_by,
				'store_intro'	=> $action_type,
				'page'		=> $page,
				'size'		=> $size,
		);
		
		$result = RC_Api::api('goods', 'goods_list', $options);
		if ($result) {
		    foreach ($result['list'] as $val) {
		        /* 判断是否有促销价格*/
		        $price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_promote_price'] : $val['unformatted_shop_price'];
		        $activity_type = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
		        /* 计算节约价格*/
		        $saving_price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_shop_price'] - $val['unformatted_promote_price'] : (($val['unformatted_market_price'] > 0 && $val['unformatted_market_price'] > $val['unformatted_shop_price']) ? $val['unformatted_market_price'] - $val['unformatted_shop_price'] : 0);
		        
		        $data['list'][] = array(
                    'id' => $val['goods_id'],
                    'name' => $val['name'],
                    'market_price' => $val['market_price'],
		            'unformatted_market_price' => $val['unformatted_market_price'],
                    'shop_price' => $val['shop_price'],
		            'unformatted_shop_price' => $val['unformatted_shop_price'],
                    'promote_price' => $val['promote_price'],
		            'unformatted_promote_price' => $val['unformatted_promote_price'],
                    'img' => array(
                        'thumb' => $val['goods_thumb'],
                        'url' => $val['original_img'],
                        'small' => $val['goods_img']
                    ),
                    'activity_type' => $activity_type,
                    'object_id' => 0,
                    'saving_price' => $saving_price,
                    'formatted_saving_price' => $saving_price > 0 ? '已省' . $saving_price . '元' : ''
                );
		    }
		    $data['pager'] = array(
		        'total' => $result['page']->total_records,
		        'count' => $result['page']->total_records,
		        'more' => $result['page']->total_pages <= $page ? 0 : 1,
		    );
		}
		
		//更新店铺搜索关键字
		if (!empty($keyword) && !empty($store_id)) {
		    RC_Api::api('stats', 'update_store_keywords', array('store_id' => $store_id, 'keywords' => $keyword));
		}
		
// 		if (!empty($result['list'])) {
// 			$mobilebuy_db = RC_Model::model('goods/goods_activity_model');
// 			/* 手机专享*/
// 			$result_mobilebuy = ecjia_app::validate_application('mobilebuy');
// 			$is_active = ecjia_app::is_active('ecjia.mobilebuy');
// 			foreach ($result['list'] as $val) {
// 				/* 判断是否有促销价格*/
// 				$price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_promote_price'] : $val['unformatted_shop_price'];
// 				$activity_type = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
// 				/* 计算节约价格*/
// 				$saving_price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_shop_price'] - $val['unformatted_promote_price'] : (($val['unformatted_market_price'] > 0 && $val['unformatted_market_price'] > $val['unformatted_shop_price']) ? $val['unformatted_market_price'] - $val['unformatted_shop_price'] : 0);
				 
// 				$mobilebuy_price = $object_id = 0;
// 				if (!is_ecjia_error($result_mobilebuy) && $is_active) {
// 					$mobilebuy = $mobilebuy_db->find(array(
// 							'goods_id'	 => $val['goods_id'],
// 							'start_time' => array('elt' => RC_Time::gmtime()),
// 							'end_time'	 => array('egt' => RC_Time::gmtime()),
// 							'act_type'	 => GAT_MOBILE_BUY,
// 					));
// 					if (!empty($mobilebuy)) {
// 						$ext_info = unserialize($mobilebuy['ext_info']);
// 						$mobilebuy_price = $ext_info['price'];
// 						if ($mobilebuy_price < $price) {
// 							$val['promote_price'] = price_format($mobilebuy_price);
// 							$object_id		= $mobilebuy['act_id'];
// 							$activity_type	= 'MOBILEBUY_GOODS';
// 							$saving_price = ($val['unformatted_shop_price'] - $mobilebuy_price) > 0 ? $val['unformatted_shop_price'] - $mobilebuy_price : 0;
// 						}
// 					}
// 				}
					
// 				$data['list'][] = array(
// 						'id'		=> $val['goods_id'],
// 						'name'			=> $val['name'],
// 						'market_price'	=> $val['market_price'],
// 						'shop_price'	=> $val['shop_price'],
// 						'promote_price'	=> $val['promote_price'],
// 						'img' => array(
// 								'thumb'	=> $val['goods_img'],
// 								'url'	=> $val['original_img'],
// 								'small'	=> $val['goods_thumb']
// 						),
// 						'activity_type' => $activity_type,
// 						'object_id'		=> $object_id,
// 						'saving_price'	=>	$saving_price,
// 						'formatted_saving_price' => $saving_price > 0 ? '已省'.$saving_price.'元' : '',
// 				);
// 			}
// 		}
		return array('data' => $data['list'], 'pager' => $data['pager']);
	}	
}

// end