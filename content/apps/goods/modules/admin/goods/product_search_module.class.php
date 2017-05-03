<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 搜索商品（搜索商品）
 * @author luchongchong
 */
class product_search_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}

    	$goods_sn	= $this->requestData('goods_sn','');
    	if (empty($goods_sn)) {
    		return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
    	}
    	$size = $this->requestData('pagination.count', 15);
    	$page = $this->requestData('pagination.page', 1);

		$device		  = $this->device;
    	$device_code = $device['code'];

		$db_goods = RC_Model::model('goods/goods_viewmodel');

		$db_goods->view = array(
			'products' => array(
				'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'		=> 'p',
				'on'		=> 'g.goods_sn=p.product_sn'
			)
		);

		$field = 'g.goods_id, g.goods_name, g.shop_price, g.shop_price, g.goods_sn, g.goods_img, g.original_img, g.goods_thumb, p.goods_attr, p.product_sn';

    	$where[] = "(goods_sn like '%".$goods_sn."%' OR  product_sn like '%".$goods_sn."%')";
        if(!empty($_SESSION['store_id'])){
            $where['store_id'] = $_SESSION['store_id'];
        }
    	if ($device_code == '8001') {
    		$where = array_merge($where, array('is_delete' => 0, 'is_on_sale' => 1, 'is_alone_sale' => 1));
    		if (ecjia::config('review_goods')) {
    			$where['review_status'] = array('gt' => 2);
    		}
    	}

    	$arr = $db_goods->field($field)->join(array('products'))->where($where)->select();
    	$product_search = array();
		if (!empty($arr)) {
			foreach ($arr as $k => $v){
				$product_search[] = array(
					'id'					=> $v['goods_id'],
					'name'					=> $v['goods_name'],
					'shop_price'			=> $v['shop_price'],
					'formatted_shop_price'	=> price_format($v['shop_price']),
					'goods_sn'				=> empty($v['product_sn']) ? $v['goods_sn'] : $v['product_sn'],
					'attribute'				=> $v['goods_attr'],
					'img' => array(
						'thumb'	=> API_DATA('PHOTO', $v['goods_img']),
						'url'	=> API_DATA('PHOTO', $v['original_img']),
						'small'	=> API_DATA('PHOTO', $v['goods_thumb'])
					),
	    	 	);
			}
		}
		return $product_search;
    }
}
