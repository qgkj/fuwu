<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 手机专享商品列表
 * @author will.chen
 */
class mobilebuygoods_module extends api_front implements api_interface {

    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$this->authSession();

    	$location = $this->requestData('location', array());
//     	$location = array(
// 	        'latitude'	=> '31.235450744628906',
// 	        'longitude' => '121.41641998291016',
// 	    );

    	$mobilebuywhere['act_type']		= GAT_MOBILE_BUY;
    	$mobilebuywhere['start_time']	= array('elt' => RC_Time::gmtime());
    	$mobilebuywhere['end_time']		= array('egt' => RC_Time::gmtime());
    	$mobilebuywhere[] = 'g.goods_id is not null';
    	$mobilebuywhere['g.is_delete'] = '0';
    	$mobilebuywhere['g.review_status'] = array('gt' => 2);
    	$mobilebuywhere['g.is_on_sale'] = 1;
    	$mobilebuywhere['g.is_alone_sale'] = 1;
    	if (ecjia::config('review_goods')) {
    		$mobilebuywhere['g.review_status'] = array('gt' => 2);
    	}

    	if (is_array($location) && isset($location['latitude']) && isset($location['longitude'])) {
    		$geohash = RC_Loader::load_app_class('geohash', 'store');
    		$geohash_code = $geohash->encode($location['latitude'] , $location['longitude']);
    		$geohash_code = substr($geohash_code, 0, 5);

    		$mobilebuywhere['geohash'] = array('like' => "%".$geohash_code."%");
    	}

    	$db_goods_activity = RC_Model::model('goods/goods_activity_viewmodel');

    	$count = $db_goods_activity->join(array('goods', 'seller_shopinfo'))->where($mobilebuywhere)->count();

		/* 查询总数为0时直接返回  */
    	if ($count == 0 || !is_array($location) || empty($location['latitude']) || empty($location['longitude'])) {
			$pager = array(
				'total' => 0,
				'count' => 0,
				'more'	=> 0,
			);
			return array('data' => array(), 'pager' => $pager);
		}

		/* 获取数量 */
   		$size = $this->requestData('pagination.count', 15);
    	$page = $this->requestData('pagination.page', 1);

    	//实例化分页
    	$page_row = new ecjia_page($count, $size, 6, '', $page);

    	$res = $db_goods_activity->field('ga.act_id, ga.goods_id, ga.goods_name, ga.start_time, ga.end_time, ext_info, shop_price, market_price, goods_brief, goods_thumb, goods_img, original_img')
    							 ->join(array('goods', 'seller_shopinfo'))
    							 ->where($mobilebuywhere)
    							 ->order(array('act_id' => 'DESC'))
    							 ->limit($page_row->limit())
    							 ->select();

    	$list = array();
    	if (!empty($res)) {
    		foreach ($res as $val) {
    			$ext_info = unserialize($val['ext_info']);
    			$price  = $ext_info['price'];;    		// 初始化
    			/* 计算节约价格*/
    			$saving_price = ($val['shop_price'] - $price) > 0 ? $val['shop_price'] - $price : 0;
    			$list[] = array(
    					'id'	=> $val['goods_id'],
    					'name'	=> $val['goods_name'],
    					'market_price'	=> price_format($val['market_price']),
    					'shop_price'	=> price_format($val['shop_price']),
    					'promote_price'	=> price_format($price),
    					'promote_start_date'	=> RC_Time::local_date('Y/m/d H:i:s', $val['start_time']),
    					'promote_end_date'		=> RC_Time::local_date('Y/m/d H:i:s', $val['end_time']),
    					'brief' => $val['goods_brief'],
    					'img'	=> array(
    							'small'	=> RC_Upload::upload_url(). '/' .$val['goods_thumb'],
    							'thumb'	=> RC_Upload::upload_url(). '/' .$val['goods_img'],
    							'url'	=> RC_Upload::upload_url(). '/' .$val['original_img']
    					),
    					'activity_type' => 'MOBILEBUY_GOODS',
    					'saving_price'	=> $saving_price,
    					'formatted_saving_price' => '已省'.$saving_price.'元',
    					'object_id'	=> $val['act_id'],
    			);
    		}
    	}

    	$pager = array(
    			"total" => $page_row->total_records,
    			"count" => $page_row->total_records,
    			"more"	=> $page_row->total_pages <= $page ? 0 : 1,
    	);

    	return array('data' => $list, 'pager' => $pager);
    }
}


// end
