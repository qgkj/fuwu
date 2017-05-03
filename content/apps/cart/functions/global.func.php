<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 比较优惠活动的函数，用于排序（把可用的排在前面）
 * @param   array   $a      优惠活动a
 * @param   array   $b      优惠活动b
 * @return  int     相等返回0，小于返回-1，大于返回1
 */
function cmp_favourable($a, $b) {
    if ($a['available'] == $b['available']) {
        if ($a['sort_order'] == $b['sort_order']) {
            return 0;
        } else {
            return $a['sort_order'] < $b['sort_order'] ? -1 : 1;
        }
    } else {
        return $a['available'] ? -1 : 1;
    }
}

/**
 * 取得某用户等级当前时间可以享受的优惠活动
 * @param   int     $user_rank      用户等级id，0表示非会员
 * @return  array
 */
function em_favourable_list($user_rank) {
	RC_Loader::load_app_func('global', 'goods');
	$db_favourable_activity = RC_Loader::load_app_model('favourable_activity_model','favourable');
	$db_goods = RC_Loader::load_app_model('goods_model','goods');
    /* 购物车中已有的优惠活动及数量 */
    $used_list = cart_favourable();

    /* 当前用户可享受的优惠活动 */
    $favourable_list = array();
    $user_rank = ',' . $user_rank . ',';
    $now = RC_Time::gmtime();
	
    $where = array(
    	"CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'",
    	'start_time' => array('elt' => $now),
    	'end_time' => array('egt' => $now),
    	'act_type' => FAT_GOODS
    );
    
	$data = $db_favourable_activity->where($where)->order('sort_order asc')->select();
    RC_Lang::load('cart/shopping_flow');
    foreach ($data as $favourable) {
        $favourable['formated_start_time'] = RC_Time::local_date(ecjia::config('time_format'), $favourable['start_time']);
        $favourable['formated_end_time']   = RC_Time::local_date(ecjia::config('time_format'), $favourable['end_time']);
        $favourable['formated_min_amount'] = price_format($favourable['min_amount'], false);
        $favourable['formated_max_amount'] = price_format($favourable['max_amount'], false);
        $favourable['gift']       = unserialize($favourable['gift']);

        foreach ($favourable['gift'] as $key => $value) {
            $favourable['gift'][$key]['formated_price'] = price_format($value['price'], false);

            $is_sale = $db_goods->where('is_on_sale = 1 AND goods_id = '.$value['id'].'')->count();            
            if(!$is_sale) {
                unset($favourable['gift'][$key]);
            }
        }
		
        $favourable['act_range_desc'] = act_range_desc($favourable);
        $favourable['act_type_desc'] = sprintf(RC_Lang::get('cart::shopping_flow.fat_ext.'.$favourable['act_type']), $favourable['act_type_ext']);

        /* 是否能享受 */
        $favourable['available'] = favourable_available($favourable);
        if ($favourable['available']) {
            /* 是否尚未享受 */
            $favourable['available'] = !favourable_used($favourable, $used_list);
        }

        $favourable_list[] = $favourable;
    }

    return $favourable_list;
}

/**
 * 根据购物车判断是否可以享受某优惠活动
 * @param   array   $favourable     优惠活动信息
 * @return  bool
 */
function favourable_available($favourable)
{
    /* 会员等级是否符合 */
    $user_rank = $_SESSION['user_rank'];
    if (strpos(',' . $favourable['user_rank'] . ',', ',' . $user_rank . ',') === false) {
        return false;
    }

    /* 优惠范围内的商品总额 */
    $amount = cart_favourable_amount($favourable);
    /* 金额上限为0表示没有上限 */
    return $amount >= $favourable['min_amount'] &&
        ($amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0);
}

/**
 * 取得优惠范围描述
 * @param   array   $favourable     优惠活动
 * @return  string
 */
function act_range_desc($favourable)
{
	$db_brand = RC_Loader::load_app_model('brand_model','goods');
	$db_category = RC_Loader::load_app_model('category_model','goods');
	$db_goods = RC_Loader::load_app_model('goods_model','goods');

    if ($favourable['act_range'] == FAR_BRAND) {
    	$brandArr = array();
    	if (!empty($favourable['act_range_ext'])) {
    		$brandName = $db_brand->field('brand_name')->in(array('brand_id'=>$favourable['act_range_ext']))->select();
    		foreach ($brandName as $row) {
    			$brandArr[] = $row['brand_name'];
    		}
    		return join(',', $brandArr);
    	}
    	return '';
    } elseif ($favourable['act_range'] == FAR_CATEGORY) {
    	$catArr = array();
    	if (!empty($favourable['act_range_ext'])) {
	    	$cat_name = $db_category->field('cat_name')->in(array('cat_id'=>$favourable['act_range_ext']))->select();
	    	foreach ($cat_name as $row) {
	    		$catArr[] = $row['cat_name'];
	    	}
	    	return join(',', $catArr);
    	}
    	return '';
    } elseif ($favourable['act_range'] == FAR_GOODS) {
    	if (!empty($favourable['act_range_ext'])) {
	        $goods_name = $db_goods->field('goods_name')->in(array('goods_id'=>$favourable['act_range_ext']))->select();
	    	foreach ($goods_name as $row) {
	    		$goodsArr[] = $row['goods_name'];
	    	}
	    	return join(',', $goodsArr);
    	}
    	return '';
    } else {
        return '';
}

/**
 * 取得购物车中已有的优惠活动及数量
 * @return  array
 */
function cart_favourable() {
	$db_cart = RC_Loader::load_app_model('cart_model','cart');
    $list = array();

    $data = $db_cart->field('is_gift, COUNT(*) AS num')->where('session_id = "' . SESS_ID . '" AND rec_type = ' . CART_GENERAL_GOODS . ' AND is_gift > 0')->group('is_gift asc')->select();
    
    if(!empty($data))
    {
	    foreach ($data as $row)
	    {
	        $list[$row['is_gift']] = $row['num'];
	    }
    }
    return $list;
}

/**
 * 购物车中是否已经有某优惠
 * @param   array   $favourable     优惠活动
 * @param   array   $cart_favourable购物车中已有的优惠活动及数量
 */
function favourable_used($favourable, $cart_favourable) {
    if ($favourable['act_type'] == FAT_GOODS)
    {
        return isset($cart_favourable[$favourable['act_id']]) &&
            $cart_favourable[$favourable['act_id']] >= $favourable['act_type_ext'] &&
            $favourable['act_type_ext'] > 0;
    }
    else
    {
        return isset($cart_favourable[$favourable['act_id']]);
    }
}

/**
 * 添加优惠活动（赠品）到购物车
 * @param   int     $act_id     优惠活动id
 * @param   int     $id         赠品id
 * @param   float   $price      赠品价格
 */
function add_gift_to_cart($act_id, $id, $price) {
	$db_goods = RC_Loader::load_app_model('goods_model','goods');
	$db_cart = RC_Loader::load_app_model('cart_model','cart');

	$row = $db_goods->field('goods_id, goods_sn, goods_name, market_price, is_real, extension_code')->find('goods_id = '.$id.'');
	$data = array(
		'user_id' => $_SESSION['user_id'],
		'session_id' => SESS_ID,
		'goods_id' => $row['goods_id'],
		'goods_sn' => $row['goods_sn'],
		'goods_name' => $row['goods_name'],
		'market_price' => $row['market_price'],
		'goods_price' => $price,
		'goods_number' => 1,
		'is_real' => $row['is_real'],
		'extension_code' => $row['extension_code'],
		'parent_id' => 0,
		'is_gift' => $act_id,
		'rec_type' => CART_GENERAL_GOODS,
	);

	$db_cart->insert($data);
}

/**
 * 添加优惠活动（非赠品）到购物车
 * @param   int     $act_id     优惠活动id
 * @param   string  $act_name   优惠活动name
 * @param   float   $amount     优惠金额
 */
function add_favourable_to_cart($act_id, $act_name, $amount) {
	$db_cart = RC_Loader::load_app_model('cart_model','cart');

	$data = array(
		'user_id' => $_SESSION['user_id'],
		'session_id' => SESS_ID,
		'goods_id' => 0,
		'goods_sn' => '',
		'goods_name' => $act_name,
		'market_price' => 0,
		'goods_price' => (-1) * $amount,
		'goods_number' => 1,
		'is_real' => 0,
		'extension_code' => '',
		'parent_id' => 0,
		'is_gift' => $act_id,
		'rec_type' => CART_GENERAL_GOODS
	);
	$db_cart->insert($data);	
}

/**
 * 取得购物车中某优惠活动范围内的总金额
 * @param   array   $favourable     优惠活动
 * @return  float
 */
function cart_favourable_amount($favourable) {
	$db_cartview = RC_Loader::load_app_model('cart_good_member_viewmodel','cart');
    /* 查询优惠范围内商品总额的sql */
	$db_cartview->view =array(
    	'goods' => array(
    		'type'  =>Component_Model_View::TYPE_LEFT_JOIN,
    		'alias' => 'g',
    		'on'   	=> 'c.goods_id = g.goods_id'
    	)
    );
    $where = array(
    	'c.rec_type' => CART_GENERAL_GOODS,
    	'c.is_gift' => 0,
    	'c.goods_id' => array('gt' => 0),
    );
    if ($_SESSION['user_id']) {
    	$where = array_merge($where,array('c.user_id' => $_SESSION['user_id']));
    } else {
    	$where = array_merge(array('c.session_id' => SESS_ID));
    }
	$sum = 'c.goods_price * c.goods_number';
	RC_Loader::load_app_func('global', 'goods');
	RC_Loader::load_app_func('admin_category', 'goods');
	
    /* 根据优惠范围修正sql */
    if ($favourable['act_range'] == FAR_ALL) {
        // sql do not change
    } elseif ($favourable['act_range'] == FAR_CATEGORY) {
        /* 取得优惠范围分类的所有下级分类 */
        $id_list = array();
        $cat_list = explode(',', $favourable['act_range_ext']);
        foreach ($cat_list as $id) {
            $id_list = array_merge($id_list, array_keys(cat_list(intval($id), 0, false)));
        }
        $where = array_merge($where,array('g.cat_id'.db_create_in($id_list)));
	} elseif ($favourable['act_range'] == FAR_BRAND) {
        $id_list = explode(',', $favourable['act_range_ext']);
        $where = array_merge($where,array('g.brand_id'.db_create_in($id_list)));
		$query = $db_cartview->where($where)->in(array('g.brand_id' => $id_list))->sum($sum);
    } else {
        $id_list = explode(',', $favourable['act_range_ext']);
        $where = array_merge($where,array('g.goods_id'.db_create_in($id_list)));
	}
    $id_list = explode(',', $favourable['act_range_ext']);
    
    /* 优惠范围内的商品总额 */
	$row = $db_cartview->where($where)->sum($sum);
  	return $row;
}

// end