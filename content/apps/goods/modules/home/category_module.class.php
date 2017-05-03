<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 首页分类数据
 * @author royalwang
 */
class category_module extends api_front implements api_interface {
	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$this->authSession();

        RC_Loader::load_app_func('admin_goods', 'goods');
        RC_Loader::load_app_func('admin_category', 'goods');
        RC_Loader::load_app_func('global', 'api');

        $categoryGoods = array();
        $category = get_categories_tree();
        if (! empty($category)) {
            foreach ($category as $key => $val) {
                $goods = array();
                $children = get_children($val['id']);
                $goods = EM_get_category_recommend_goods('best', $children);
                if (empty($goods)) {
                	continue;
                }
                $ngoods = array();
                if (empty($val['img'])) {
                	if (count($goods) > 3) {
                		$goods = array_slice($goods, 0, 3);
                	}
                } else {
                	if (count($goods) > 2) {
                		$goods = array_slice($goods, 0, 2);
                	}
                	$ngoods[] = array(
                		'id' 			=> 0,
                		'name' 			=> '',
                		'market_price' 	=> 0,
                		'shop_price' 	=> 0,
                		'promote_price' => 0,
                		'brief' 		=> '',
                		'img' => array(
                			'thumb' => API_DATA('PHOTO', $val['img']),
                			'url' 	=> API_DATA('PHOTO', $val['img']),
                			'small' => API_DATA('PHOTO', $val['img'])
                		)
                	);
                }
                if (! empty($goods))
                    $mobilebuy_db = RC_Model::model('goods/goods_activity_model');
                    foreach ($goods as $k => $v) {
	                	$groupbuy = $mobilebuy_db->find(array(
                			'goods_id'	 => $v['id'],
                			'start_time' => array('elt' => RC_Time::gmtime()),
                			'end_time'	 => array('egt' => RC_Time::gmtime()),
                			'act_type'	 => GAT_GROUP_BUY,
	                	));
	                	$mobilebuy = $mobilebuy_db->find(array(
                			'goods_id'	 => $v['id'],
                			'start_time' => array('elt' => RC_Time::gmtime()),
                			'end_time'	 => array('egt' => RC_Time::gmtime()),
                			'act_type'	 => GAT_MOBILE_BUY,
	                	));
	                	/* 判断是否有促销价格*/
	                	$price = ($v['unformatted_shop_price'] > $v['unformatted_promote_price'] && $v['unformatted_promote_price'] > 0) ? $v['unformatted_promote_price'] : $v['unformatted_shop_price'];
	                	$activity_type = ($v['unformatted_shop_price'] > $v['unformatted_promote_price'] && $v['unformatted_promote_price'] > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';

	                	$mobilebuy_price = $groupbuy_price = $object_id = 0;
	                	if (!empty($mobilebuy)) {
	                		$ext_info = unserialize($mobilebuy['ext_info']);
	                		$mobilebuy_price = $ext_info['price'];
	                		$price = $mobilebuy_price > $price ? $price : $mobilebuy_price;
	                		$activity_type = $mobilebuy_price > $price ? $activity_type : 'MOBILEBUY_GOODS';
	                		$object_id = $mobilebuy_price > $price ? $object_id : $mobilebuy['act_id'];
	                	}
// 						if (!empty($groupbuy)) {
// 							$ext_info = unserialize($groupbuy['ext_info']);
// 							$price_ladder = $ext_info['price_ladder'];
// 							$groupbuy_price  = $price_ladder[0]['price'];
// 							$price = $groupbuy_price > $price ? $price : $groupbuy_price;
// 							$activity_type = $groupbuy_price > $price ? $activity_type : 'GROUPBUY_GOODS';
// 						}
	                	/* 计算节约价格*/
	                	$saving_price = ($v['unformatted_shop_price'] - $price) > 0 ? $v['unformatted_shop_price'] - $price : 0;

                        $ngoods[] = array(
                            'id' 			=> $v['id'],
                            'name' 			=> $v['name'],
                            'market_price' 	=> $v['market_price'],
                            'shop_price' 	=> $v['shop_price'],
                            'promote_price' => ($price < $v['unformatted_shop_price'] && $price > 0) ? price_format($price) : '',
                            'brief' 		=> $v['brief'],
                            'img' => array(
                                'thumb' => API_DATA('PHOTO', $v['goods_img']),
                                'url' 	=> API_DATA('PHOTO', $v['original_img']),
                                'small' => API_DATA('PHOTO', $v['thumb'])
                            ),
                        	'activity_type' => $activity_type,
                        	'object_id'		=> $object_id,
                        	'saving_price'	=> $saving_price,
                        	'formatted_saving_price' => '已省'.$saving_price.'元'
                        );
                    }

                $categoryGoods[] = array(
                    'id' => $val['id'],
                    'name' => $val['name'],
                    'goods' => $ngoods
                );
            }
        }

        return $categoryGoods;
    }
}

function EM_get_category_recommend_goods($type = '', $cats = '', $brand = 0, $min = 0, $max = 0, $ext = '') {
	$where = array();
    $brand > 0 ? $where['g.brand_id'] = $brand : ''; // " AND g.brand_id = '$brand'" : '';

    $min > 0 ? $where[] = "g.shop_price >= $min " : '';
    $max > 0 ? $where[] = "g.shop_price <= $max " : '';

    $num = 0;
    $type2lib = array(
        'best' => 'recommend_best',
        'new' => 'recommend_new',
        'hot' => 'recommend_hot',
        'promote' => 'recommend_promotion'
    );
    // 该分类下面取几个产品
    $num = 3; // get_library_number ( $type2lib [$type] );
    switch ($type) {
        case 'best':
            $where['is_best'] = 1;
            break;
        case 'new':
            $where['is_new'] = 1;
            break;
        case 'hot':
            $where['is_hot'] = 1;
            break;
        case 'promote':
            $time = RC_Time::gmtime();
            $where['is_promote'] = 1;
            $where['promote_start_date'] = array('elt' => $time);
            $where['promote_end_date'] = array('egt' => $time);
            break;
    }

    if (!empty($cats)) {
        $where[] = "(" . $cats . " OR " . get_extension_goods($cats) . ")";
    }

    $order_type = ecjia::config('recommend_order');
    $order = ($order_type == 0) ? array(
        'g.sort_order' => 'desc',
        'g.last_update' => 'desc'
    ) : 'RAND()';

    $where['g.is_on_sale'] = 1;
    $where['g.is_alone_sale'] = 1;
    $where['g.is_delete'] = 0;
    $where['g.review_status'] = array('gt' => 2);

    if (ecjia::config('review_goods')) {
    	$where['g.review_status'] = array('gt' => 2);
    }


    $dbview = RC_Model::model('goods/goods_brand_member_viewmodel');
    $res = $dbview
    	->join(array('brand', 'member_price'))
		->where($where)
		->order($order)
		->limit($num)
		->select();

    $idx = 0;
    $goods = array();

    if (! empty($res) && is_array($res)) {
        foreach ($res as $key => $row) {

            if ($row['promote_price'] > 0) {
                $promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
                $goods[$idx]['promote_price'] = $promote_price > 0 ? price_format($promote_price) : '';
            } else {
            	$promote_price = 0;
                $goods[$idx]['promote_price'] = '';
            }

            $goods[$idx]['id'] = $row['goods_id'];
            $goods[$idx]['name'] = $row['goods_name'];
            $goods[$idx]['brief'] = $row['goods_brief'];
            $goods[$idx]['brand_name'] = $row['brand_name'];
            $goods[$idx]['short_name'] = ecjia::config('goods_name_length') > 0 ? RC_String::sub_str($row['goods_name'], ecjia::config('goods_name_length')) : $row['goods_name'];
            $goods[$idx]['market_price'] = price_format($row['market_price']);
            $goods[$idx]['shop_price'] = price_format($row['org_price']);
            $goods[$idx]['thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
            $goods[$idx]['goods_img'] = get_image_path($row['goods_id'], $row['goods_img']);
            $goods[$idx]['original_img'] = get_image_path($row['goods_id'], $row['original_img']);
            $goods[$idx]['url'] = build_uri('goods', array(
                'gid' => $row['goods_id']
            ), $row['goods_name']);
            $goods[$idx]['short_style_name'] = add_style($goods[$idx]['short_name'], $row['goods_name_style']);


            $goods[$idx]['unformatted_shop_price'] = $row['org_price'];
            $goods[$idx]['unformatted_promote_price'] = $promote_price;

            $idx ++;
        }
    }
    return $goods;
}

// end