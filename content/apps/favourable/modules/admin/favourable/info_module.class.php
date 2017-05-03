<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 满减满赠活动信息
 * @author will
 */
class info_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$priv = $this->admin_priv('goods_manage');
		if (is_ecjia_error($priv)) {
			return $priv;
		}
		
		$id = $this->requestData('act_id', 0);
		if ($id <= 0) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}
		
		$result = RC_Model::Model('favourable/favourable_activity_model')->favourable_info($id);
		if (empty($result)) {
		    return new ecjia_error('not_exists_info', '不存在的信息');
		}
		/* 多商户处理*/
		if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0 && $result['store_id'] != $_SESSION['store_id']) {
			return new ecjia_error('not_exists_info', '不存在的信息');
		}
	
		if ($result['act_range'] == 0) {
			$result['label_act_range'] = __('全部商品');
		} elseif ($result['act_range'] == 1) {
			$result['label_act_range'] = __('指定分类');
			if (!empty($result['act_range_ext'])) {
				$db_category = RC_Model::model('goods/category_model');
				foreach ($result['act_range_ext'] as $key => $val) {
					$image = $db_category->where(array('cat_id' => $val['id']))->get_field('style');
					$result['act_range_ext'][$key]['image'] = !empty($image) ? RC_Upload::upload_url($image) : '';
				}
			}
		} elseif ($result['act_range'] == 2) {
			$result['label_act_range'] = __('指定品牌');
			if (!empty($result['act_range_ext'])) {
				$db_brand = RC_Model::model('goods/brand_model');
				//$db_merchants_brand_db = RC_Model::model('goods/merchants_shop_brand_viewmodel');
					
				foreach ($result['act_range_ext'] as $key => $val) {
					//if (!isset($_SESSION['seller_id'])) {
						$image = $db_brand->where(array('brand_id' => $val['id']))->get_field('brand_logo');
					//} else {
					//	$image = $db_merchants_brand_db->where(array('bid' => $val['id']))->get_field('brandLogo');
					//}
					if (strpos($image, 'http://') === false) {
						$result['act_range_ext'][$key]['image']	= !empty($image) ? RC_Upload::upload_url($image) : '';
					} else {
						$result['act_range_ext'][$key]['image'] = $image;
					}
				}
			}
		
		} else {
			$result['label_act_range'] = __('指定商品');
			if (!empty($result['act_range_ext'])) {
				$db_goods = RC_Model::model('goods/goods_model');
				foreach ($result['act_range_ext'] as $key => $val) {
					$image = $db_goods->where(array('goods_id' => $val['id']))->get_field('original_img');
					if (strpos($image, 'http://') === false) {
						$result['act_range_ext'][$key]['image']	= !empty($image) ? RC_Upload::upload_url($image) : '';
					} else {
						$result['act_range_ext'][$key]['image'] = $image;
					}
				}
			}
		}
			
		$result['gift_items'] = array();
		if ($result['act_type'] == 0) {
			$result['label_act_type'] = __('特惠品');
			if (!empty($result['gift'])) {
				$db_goods = RC_Model::model('goods/goods_model');
				foreach ($result['gift'] as $val) {
					$info = $db_goods->field(array('goods_name', 'shop_price', 'original_img'))->where(array('goods_id' => $val['id']))->find();
					if (strpos($info['original_img'], 'http://') === false) {
						$image = !empty($info['original_img']) ? RC_Upload::upload_url($info['original_img']) : '';
					} else {
						$image = $info['original_img'];
					}
					$result['gift_items'][] = array(
						'id'	                 => $val['id'],
						'name'	                 => $info['goods_name'],
						'shop_price'             => $info['shop_price'],
						'formatted_shop_price'   => price_format($info['shop_price']),
						'price'                  => $val['price'],
						'image'                  => $image,
					);
				}
			}
		} elseif ($result['act_type'] == 1) {
			$result['label_act_type'] = __('现金减免');
		} else {
			$result['label_act_type'] = __('价格折扣');
		}
			
		$result['formatted_start_time'] = $result['start_time'];
		$result['formatted_end_time']   = $result['end_time'];
			
		/* 去除不要的字段*/
		unset($result['start_time']);
		unset($result['end_time']);
		unset($result['gift']);
		unset($result['user_rank']);
		unset($result['sort_order']);
		return $result;
	}
}

// end