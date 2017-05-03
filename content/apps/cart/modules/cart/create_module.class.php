<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 添加到购物车
 * @author royalwang
 */
class create_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

    	$this->authSession();
    	if ($_SESSION['user_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}

	    $goods_id		= $this->requestData('goods_id', 0);
	    $goods_number	= $this->requestData('number', 1);
	    $location		= $this->requestData('location', array());
	    $seller_id		= $this->requestData('seller_id', 0);
	    if (!$goods_id) {
	        return new ecjia_error(101, '参数错误');
	    }
	    $goods_spec		= $this->requestData('spec', array());
	    $rec_type		= $this->requestData('rec_type', 0);

	    RC_Loader::load_app_func('cart', 'cart');

	    unset($_SESSION['flow_type']);
    	if (!$goods_id) {
    		return new ecjia_error('not_found_goods', '请选择您所需要购买的商品！');
    	}
    	$store_id_group = array();
    	/* 根据经纬度查询附近店铺id*/
    	if (isset($location['latitude']) && !empty($location['latitude']) && isset($location['longitude']) && !empty($location['longitude'])) {
    		$geohash         = RC_Loader::load_app_class('geohash', 'store');
    		$geohash_code    = $geohash->encode($location['latitude'] , $location['longitude']);
    		$geohash_code    = substr($geohash_code, 0, 5);
    		$store_id_group  = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code));
    	} else {
    		return new ecjia_error('location_error', '请定位您当前所在地址！');
    	}

    	$result = RC_Api::api('cart', 'cart_manage', array('goods_id' => $goods_id, 'goods_number' => $goods_number, 'goods_spec' => $goods_spec, 'rec_type' => $rec_type, 'store_group' => $store_id_group));

	    // 更新：添加到购物车
	    if (!is_ecjia_error($result)){

	        if (isset($location['latitude']) && !empty($location['latitude']) && isset($location['longitude']) && !empty($location['longitude'])) {
	            $geohash        = RC_Loader::load_app_class('geohash', 'store');
	            $geohash_code   = $geohash->encode($location['latitude'] , $location['longitude']);
	            $geohash_code   = substr($geohash_code, 0, 5);
	            $store_id_group = RC_Api::api('store', 'neighbors_store_id', array('geohash' => $geohash_code));
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
	    } else {
	    	return $result;
	    }
	}
}

// end