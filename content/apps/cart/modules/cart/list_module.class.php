<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 购物车列表
 * @author royalwang
 */
class list_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

    	$this->authSession();
    	
    	if ($_SESSION['user_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
    	RC_Loader::load_app_func('cart', 'cart');
    	//recalculate_price(); //后续方法重新计算
		$location  = $this->requestData('location', array());

		$seller_id = $this->requestData('seller_id', 0);

		if (isset($location['latitude']) && !empty($location['latitude']) && isset($location['longitude']) && !empty($location['longitude'])) {
			$geohash         = RC_Loader::load_app_class('geohash', 'store');
			$geohash_code    = $geohash->encode($location['latitude'] , $location['longitude']);
			$geohash_code    = substr($geohash_code, 0, 5);
			$store_id_group  = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code));
			if (!empty($seller_id) && !in_array($seller_id, $store_id_group)) {
				return new ecjia_error('location_beyond', '店铺距离过远！');
			} elseif (!empty($seller_id)) {
				$store_id_group = array($seller_id);
			}
		} else {
			return new ecjia_error('location_error', '请定位您当前所在地址！');
		}

		$cart_result = RC_Api::api('cart', 'cart_list', array('store_group' => $store_id_group, 'flow_type' => CART_GENERAL_GOODS));
		
		return formated_cart_list($cart_result);
	}
}

// end