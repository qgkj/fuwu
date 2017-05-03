<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取积分兑换添加购物车
 * @author will.chen
 */
 
class cart_exchange_buy_api extends Component_Event_Api {
    
    public function call(&$options) {
    	if (!is_array($options)) {
    		return new ecjia_error('invalid_parameter', '参数无效');
    	}
        return $this->exchange_buy($options);
    }
    
    /**
	 * 获取积分兑换商品列表
	 * @param   array	 $options（包含当前页码，每页显示条数）
	 * @return  array   商家活动数组
	 */
	private function exchange_buy($options) {
		$goods_id = $options['goods_id'];
		
		/* 查询：取得兑换商品信息 */
		$field = 'g.goods_id, g.goods_sn, g.goods_name, g.cat_id, g.brand_id, g.goods_number, g.warn_number, g.keywords, g.goods_weight, eg.exchange_integral, g.goods_type, g.goods_brief, g.goods_desc, g.goods_thumb, g.seller_note, g.goods_img, eg.is_exchange, eg.is_hot';
    	$goods = RC_Model::model('exchange/exchange_goods_viewmodel')->exchange_goods_find(array('eg.goods_id' => $goods_id), $field);
        
    	if (empty($goods)) {
    		return new ecjia_error('goods_not_exist', RC_Lang::get('goods::goods.goods_not_exist'));
    	}
    	
	    /* 查询：检查兑换商品是否有库存 */
	    if($goods['goods_number'] == 0 && ecjia::config('use_storage') == 1) {
	    	return new ecjia_error('eg_error_number', '商品库存不足！');
	    }
	    
	    /* 查询：检查兑换商品是否是取消 */
	    if ($goods['is_exchange'] == 0) {
	    	return new ecjia_error('eg_error_status', ' 积分商品已下架！');
	    }
	
	    $user_info = RC_Api::api('user', 'user_info', array('user_id' => $_SESSION['user_id']));
	    $user_points = $user_info['pay_points']; // 用户的积分总数
	    
	    if ($goods['exchange_integral'] > $user_points) {
	    	return new ecjia_error('eg_error_integral', '用户积分不足！');
	    }
	
	    /* 查询：取得规格 */
	    $specs = '';
	    foreach ($options['specs'] as $key => $value) {
// 	        if (strpos($key, 'spec_') !== false) {
// 	            $specs .= ',' . intval($value);
// 	        }
			$specs[] = $value;
	    }
// 	    $specs = trim($specs, ',');
	    $product_info = null;
	    
	    /* 查询：如果商品有规格则取规格商品信息 配件除外 */
	    if (!empty($specs)) {
// 	        $_specs = explode(',', $specs);
	    	$_specs = $specs;
	        RC_Loader::load_app_func('admin_goods', 'goods');
	        $product_info = get_products_info($goods_id, $_specs);
	    }
	    
	    if (empty($product_info)) {
	        $product_info = array('product_number' => '', 'product_id' => 0);
	    }
	
	    //查询：商品存在规格 是货品 检查该货品库存
	    if ((!empty($specs)) && ($product_info['product_number'] == 0) && (ecjia::config('use_storage') == 1)) {
	    	return new ecjia_error('eg_error_number', '商品库存不足！');
	    }
	
	    /* 查询：查询规格名称和值，不考虑价格 */
	    $attr_list = array();
	    
	    $attr_list_res = RC_Model::model('goods/goods_attr_viewmodel')->field('a.attr_name, ga.attr_value')->where(array('ga.goods_attr_id' => $specs))->select();
	    if (!empty($attr_list_res)) {
	    	foreach ($attr_list_res as $row) {
	    		$attr_list[] = $row['attr_name'] . ': ' . $row['attr_value'];
	    	}
	    } 
	    
	    $goods_attr = join(chr(13) . chr(10), $attr_list);
	
	    /* 更新：清空购物车中所有团购商品 */
	    RC_Model::model('cart/cart_model')->clear_cart(CART_EXCHANGE_GOODS);
	
	    /* 更新：加入购物车 */
	    $number = 1;
	    $cart = array(
	        'user_id'        => $_SESSION['user_id'],
// 	        'session_id'     => SESS_ID,
	        'goods_id'       => $goods['goods_id'],
	        'product_id'     => $product_info['product_id'],
	        'goods_sn'       => addslashes($goods['goods_sn']),
	        'goods_name'     => addslashes($goods['goods_name']),
	        'market_price'   => $goods['market_price'],
	        'goods_price'    => 0,
	        'goods_number'   => $number,
	        'goods_attr'     => addslashes($goods_attr),
	        'goods_attr_id'  => $specs,
	        'is_real'        => $goods['is_real'],
	        'extension_code' => addslashes($goods['extension_code']),
	        'parent_id'      => 0,
	        'rec_type'       => CART_EXCHANGE_GOODS,
	        'is_gift'        => 0
	    );
	    RC_Model::model('cart/cart_model')->insert($cart);
	
	    /* 记录购物流程类型：团购 */
	    $_SESSION['flow_type']		= CART_EXCHANGE_GOODS;
	    $_SESSION['extension_code'] = 'exchange_goods';
	    $_SESSION['extension_id']	= $goods_id;
	
	    return true;
	}
}

// end