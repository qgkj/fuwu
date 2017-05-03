<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods {
    /**
     * 取得推荐类型列表
     *
     * @return array 推荐类型列表
     */
    public static function intro_list() {
        $arr = array(
            'is_best'		=> RC_Lang::get('goods::goods.is_best'),
            'is_new'		=> RC_Lang::get('goods::goods.is_new'),
            'is_hot'		=> RC_Lang::get('goods::goods.is_hot'),
            'is_promote'	=> RC_Lang::get('goods::goods.is_promote'),
            'all_type'		=> RC_Lang::get('goods::goods.all_type')
        );
        
        return $arr;
    }
    
    /**
     * 取得重量单位列表
     *
     * @return array 重量单位列表
     */
    public static function unit_list() {
        $arr = array(
            '1' =>		RC_Lang::get('goods::goods.unit_kg'),
            '0.001' =>	RC_Lang::get('goods::goods.unit_g')
        );
        
        return $arr;
    }
    
    /**
     * 获得商品列表
     *
     * @access public
     * @param
     *            s integer $isdelete
     * @param
     *            s integer $real_goods
     * @param
     *            s integer $conditions
     * @return array
     */
    public static function goods_list($is_delete, $real_goods = 1, $conditions = '') {
        /* 过滤条件 */
        $param_str 	= '-' . $is_delete . '-' . $real_goods;
        $day 		= getdate();
        $today 		= RC_Time::local_mktime(23, 59, 59, $day ['mon'], $day ['mday'], $day ['year']);
    
        $filter ['cat_id'] 			= empty ($_REQUEST ['cat_id']) 			? 0 	: intval($_REQUEST ['cat_id']);
        $filter ['intro_type'] 		= empty ($_REQUEST ['intro_type']) 		? '' 	: trim($_REQUEST ['intro_type']);
        $filter ['is_promote'] 		= empty ($_REQUEST ['is_promote']) 		? 0 	: intval($_REQUEST ['is_promote']);
        $filter ['stock_warning'] 	= empty ($_REQUEST ['stock_warning']) 	? 0 	: intval($_REQUEST ['stock_warning']);
        $filter ['brand_id'] 		= empty ($_REQUEST ['brand_id']) 		? 0 	: intval($_REQUEST ['brand_id']);
        $filter ['keywords'] 		= empty ($_REQUEST ['keywords']) 		? '' 	: trim($_REQUEST ['keywords']);
        $filter ['merchant_keywords'] = empty ($_REQUEST ['merchant_keywords']) ? '' : trim($_REQUEST ['merchant_keywords']);
        
        $filter ['suppliers_id'] 	= isset ($_REQUEST ['suppliers_id']) 	? (empty ($_REQUEST ['suppliers_id']) ? '' : trim($_REQUEST ['suppliers_id'])) : '';
        $filter ['type'] 			= !empty($_REQUEST ['type']) 			? $_REQUEST ['type'] : '';
    
        $filter ['sort_by'] 		= empty ($_REQUEST ['sort_by']) 		? 'goods_id' 	: trim($_REQUEST ['sort_by']);
        $filter ['sort_order'] 		= empty ($_REQUEST ['sort_order']) 		? 'DESC' 		: trim($_REQUEST ['sort_order']);
        $filter ['extension_code'] 	= empty ($_REQUEST ['extension_code']) 	? '' 			: trim($_REQUEST ['extension_code']);
        $filter ['is_delete'] 		= $is_delete;
        $filter ['real_goods'] 		= $real_goods;
        
        $filter ['review_status']	= empty ($_REQUEST ['review_status'])	? 0 	: intval($_REQUEST ['review_status']);
        $filter ['store_id']		= empty ($_REQUEST ['store_id'])		? 0 	: intval($_REQUEST ['store_id']);
        
        $where = $filter ['cat_id'] > 0 ? " AND " . get_children($filter ['cat_id']) : '';
    
        /* 推荐类型 */
        switch ($filter ['intro_type']) {
        	case 'is_best' :
        	    $where .= " AND is_best=1";
        	    break;
        	case 'is_hot' :
        	    $where .= ' AND is_hot=1';
        	    break;
        	case 'is_new' :
        	    $where .= ' AND is_new=1';
        	    break;
        	case 'is_promote' :
        	    $where .= " AND is_promote = 1 AND promote_price > 0 AND promote_start_date <= '$today' AND promote_end_date >= '$today'";
        	    break;
        	case 'all_type' :
        	    $where .= " AND (is_best=1 OR is_hot=1 OR is_new=1 OR (is_promote = 1 AND promote_price > 0 AND promote_start_date <= '" . $today . "' AND promote_end_date >= '" . $today . "'))";
        }
    
        /* 库存警告 */
        if ($filter ['stock_warning']) {
            $where .= ' AND goods_number <= warn_number ';
        }
    
        /* 品牌 */
        if ($filter ['brand_id']) {
            $where .= " AND brand_id=".$filter['brand_id'];
        }
    
        /* 扩展 */
        if ($filter ['extension_code']) {
            $where .= " AND extension_code='".$filter['extension_code']."'";
        }
    
        /* 关键字 */
        if (!empty ($filter ['keywords'])) {
            $where .= " AND (goods_sn LIKE '%" . mysql_like_quote($filter ['keywords']) . "%' OR goods_name LIKE '%" . mysql_like_quote($filter ['keywords']) . "%')";
        }
        
        /* 商家关键字 */
        if (!empty ($filter ['merchant_keywords'])) {
        	$where .= " AND (s.merchants_name LIKE '%" . mysql_like_quote($filter ['merchant_keywords']) . "%')";
        }
        
        /* 审核状态 */
        if (!empty($filter['review_status'])) {
        	$where .= " AND g.review_status=".$filter['review_status'];
        }
        
        /* 店铺id*/
        if (!empty($filter['store_id'])) {
        	$where .= " AND g.store_id=".$filter['store_id'];
        }
    
        if ($real_goods > -1) {
            $where .= " AND is_real='$real_goods'";
        }
        
        $db_goods = RC_DB::table('goods as g')
       		->leftJoin('store_franchisee as s', RC_DB::raw('g.store_id'), '=', RC_DB::raw('s.store_id'));
        
        //筛选全部 已上架 未上架 商家
        $filter_count = $db_goods
       		->select(RC_DB::raw('count(*) as count_goods_num'), 
       			RC_DB::raw('SUM(IF(is_on_sale = 1, 1, 0)) as count_on_sale'), 
       			RC_DB::raw('SUM(IF(is_on_sale = 0, 1, 0)) as count_not_sale'),
       			RC_DB::raw('SUM(IF(is_on_sale = 0, 1, 0)) as count_not_sale'),
       			RC_DB::raw('SUM(IF(s.manage_mode = "self", 1, 0)) as self'))
       		->whereRaw('is_delete = ' . $is_delete . '' . $where)
        	->first();

        /* 是否上架 */
        if ($filter ['type'] == 1 || $filter ['type'] == 2) {
        	$is_on_sale = $filter ['type'];
            $filter ['type'] == 2 && $is_on_sale = 0;
            $where .= " AND (is_on_sale='" . $is_on_sale . "')";
        } elseif ($filter['type'] == 'self') {
        	$where .= " AND s.manage_mode = 'self'";
        }
        
        /* 供货商 */
        if (!empty ($filter ['suppliers_id'])) {
            $where .= " AND (suppliers_id = '" . $filter ['suppliers_id'] . "')";
        }
        $where .= $conditions;

        $db_goods = RC_DB::table('goods as g')
        	->leftJoin('store_franchisee as s', RC_DB::raw('g.store_id'), '=', RC_DB::raw('s.store_id'));
        /* 记录总数 */
        $count = $db_goods->whereRaw('is_delete = ' . $is_delete . '' . $where)->count('goods_id');
        $page = new ecjia_page ($count, 10, 5);
        $filter ['record_count'] 	= $count;
        $filter ['count_goods_num'] = $filter_count['count_goods_num'] > 0 ? $filter_count['count_goods_num'] : 0;
        $filter ['count_on_sale'] 	= $filter_count['count_on_sale'] > 0 ? $filter_count['count_on_sale'] : 0;
        $filter ['count_not_sale'] 	= $filter_count['count_not_sale'] > 0 ? $filter_count['count_not_sale'] : 0;
        $filter ['self'] 			= $filter_count['self'] > 0 ? $filter_count['self'] : 0;
        
        $sql = $db_goods
        	->selectRaw('g.goods_id, g.goods_name, g.goods_type, g.goods_sn, g.shop_price, g.goods_thumb, g.is_on_sale, g.is_best, g.is_new, g.is_hot, g.sort_order, g.goods_number, g.integral, (g.promote_price > 0 AND g.promote_start_date <= ' . $today . ' AND g.promote_end_date >= ' . $today . ') as is_promote, g.review_status, s.merchants_name')
        	->orderBy($filter ['sort_by'], $filter['sort_order'])
        	->take(10)
        	->skip($page->start_id-1)
        	->get();
        	
        $filter ['keyword'] = stripslashes($filter ['keyword']);
        $filter ['count'] 	= $count;
    
        if (!empty($sql)) {
        	foreach ($sql as $k => $v) {
        		if (!empty($v['goods_thumb']) && file_exists(RC_Upload::upload_path($v['goods_thumb']))) {
        			$sql[$k]['goods_thumb'] = RC_Upload::upload_url($v['goods_thumb']);
        		} else {
        			$sql[$k]['goods_thumb'] = RC_Uri::admin_url('statics/images/nopic.png');
        		}
        	}
        }
        $row = $sql;
        return array(
            'goods'		=> $row,
            'filter'	=> $filter,
            'page'		=> $page->show(2),
            'desc'		=> $page->page_desc()
        );
    }
    
    /**
     * 获得商家商品列表
     *
     * @access public
     * @param
     *            s integer $isdelete
     * @param
     *            s integer $real_goods
     * @param
     *            s integer $conditions
     * @return array
     */
    public static function merchant_goods_list($is_delete, $real_goods = 1, $conditions = '') {
    	//     	$db = RC_Loader::load_app_model('goods_viewmodel', 'goods');
    
    	/* 过滤条件 */
    	$param_str 	= '-' . $is_delete . '-' . $real_goods;
    	$day 		= getdate();
    	$today 		= RC_Time::local_mktime(23, 59, 59, $day ['mon'], $day ['mday'], $day ['year']);
    
    	$filter ['cat_id'] 			= empty ($_REQUEST ['cat_id']) 			? 0 	: intval($_REQUEST ['cat_id']);
    	$filter ['intro_type'] 		= empty ($_REQUEST ['intro_type']) 		? '' 	: trim($_REQUEST ['intro_type']);
    	$filter ['is_promote'] 		= empty ($_REQUEST ['is_promote']) 		? 0 	: intval($_REQUEST ['is_promote']);
    	$filter ['stock_warning'] 	= empty ($_REQUEST ['stock_warning']) 	? 0 	: intval($_REQUEST ['stock_warning']);
    	$filter ['brand_id'] 		= empty ($_REQUEST ['brand_id']) 		? 0 	: intval($_REQUEST ['brand_id']);
    	$filter ['keywords'] 		= empty ($_REQUEST ['keywords']) 		? '' 	: trim($_REQUEST ['keywords']);
    	$filter ['merchant_keywords'] = empty ($_REQUEST ['merchant_keywords']) ? '' : trim($_REQUEST ['merchant_keywords']);
    
    	$filter ['suppliers_id'] 	= isset ($_REQUEST ['suppliers_id']) 	? (empty ($_REQUEST ['suppliers_id']) ? '' : trim($_REQUEST ['suppliers_id'])) : '';
    	$filter ['type'] 			= !empty($_REQUEST ['type']) 			? $_REQUEST ['type'] : '';
    
    	$filter ['sort_by'] 		= empty ($_REQUEST ['sort_by']) 		? 'store_sort_order' 	: trim($_REQUEST ['sort_by']);
    	$filter ['sort_order'] 		= empty ($_REQUEST ['sort_order']) 		? 'asc' 				: trim($_REQUEST ['sort_order']);
    	$filter ['extension_code'] 	= empty ($_REQUEST ['extension_code']) 	? '' 					: trim($_REQUEST ['extension_code']);
    	$filter ['is_delete'] 		= $is_delete;
    	$filter ['real_goods'] 		= $real_goods;
    
    	$filter ['review_status'] 			= empty ($_REQUEST ['review_status']) 			?  0 	: intval($_REQUEST ['review_status']);
    
    	$where = $filter ['cat_id'] > 0 ? " AND " . merchant_get_children($filter ['cat_id']) : '';
    
    	/* 推荐类型 */
    	switch ($filter ['intro_type']) {
    		case 'is_best' :
    			$where .= " AND store_best=1";
    			break;
    		case 'is_hot' :
    			$where .= ' AND store_hot=1';
    			break;
    		case 'is_new' :
    			$where .= ' AND store_new=1';
    			break;
    		case 'is_promote' :
    			$where .= " AND is_promote = 1 AND promote_price > 0 AND promote_start_date <= '$today' AND promote_end_date >= '$today'";
    			break;
    		case 'all_type' :
    			$where .= " AND ((store_best=1 AND store_hot=1 AND store_new=1) OR (is_promote = 1 AND promote_price > 0 AND promote_start_date <= '" . $today . "' AND promote_end_date >= '" . $today . "'))";
    	}
    
    	/* 库存警告 */
    	if ($filter ['stock_warning']) {
    		$where .= ' AND goods_number <= warn_number ';
    	}
    
    	/* 品牌 */
    	//         if ($filter ['brand_id']) {
    	//             $where .= " AND brand_id=".$filter['brand_id'];
    	//         }
    
    	/* 扩展 */
    	if ($filter ['extension_code']) {
    		$where .= " AND extension_code='".$filter['extension_code']."'";
    	}
    
    	/* 关键字 */
    	if (!empty ($filter ['keywords'])) {
    		$where .= " AND (goods_sn LIKE '%" . mysql_like_quote($filter ['keywords']) . "%' OR goods_name LIKE '%" . mysql_like_quote($filter ['keywords']) . "%')";
    	}
    
    	/* 审核状态 */
    	if (!empty($filter['review_status'])) {
    		$where .= " AND review_status='".$filter['review_status']."'";
    	}
    
    	if ($real_goods > -1) {
    		$where .= " AND is_real='$real_goods'";
    	}
    
    	$db_goods = RC_DB::table('goods as g')
    		->leftJoin('store_franchisee as s', RC_DB::raw('g.store_id'), '=', RC_DB::raw('s.store_id'))
    		->where(RC_DB::raw('g.store_id'), $_SESSION['store_id']);
    
    	//筛选全部 已上架 未上架 商家
    	$filter_count = $db_goods
    	->select(RC_DB::raw('count(*) as count_goods_num'),
    			RC_DB::raw('SUM(IF(is_on_sale = 1, 1, 0)) as count_on_sale'),
    			RC_DB::raw('SUM(IF(is_on_sale = 0, 1, 0)) as count_not_sale'),
    			RC_DB::raw('SUM(IF(is_on_sale = 0, 1, 0)) as count_not_sale'),
    			RC_DB::raw('SUM(IF(g.store_id > 0, 1, 0)) as merchant'))
    			->whereRaw('is_delete = ' . $is_delete . '' . $where)
    			->first();
    
    	/* 是否上架 */
    	if ($filter ['type'] == 1 || $filter ['type'] == 2) {
    		$is_on_sale = $filter ['type'];
    		$filter ['type'] == 2 && $is_on_sale = 0;
    		$where .= " AND (is_on_sale='" . $is_on_sale . "')";
    	} elseif ($filter['type'] == 'merchant') {
    		$where .= " AND g.store_id > 0";
    	}
    
    	/* 供货商 */
    	if (!empty ($filter ['suppliers_id'])) {
    		$where .= " AND (suppliers_id = '" . $filter ['suppliers_id'] . "')";
    	}
    	$where .= $conditions;
    
    	$db_goods = RC_DB::table('goods as g')
    	->leftJoin('store_franchisee as s', RC_DB::raw('g.store_id'), '=', RC_DB::raw('s.store_id'))
    	->where(RC_DB::raw('g.store_id'), $_SESSION['store_id']);
    
    	/* 记录总数 */
    	$count = $db_goods->whereRaw('is_delete = ' . $is_delete . '' . $where)->count('goods_id');
    	$page = new ecjia_merchant_page ($count, 10, 3);
    	$filter ['record_count'] 	= $count;
    	$filter ['count_goods_num'] = $filter_count['count_goods_num'] > 0 ? $filter_count['count_goods_num'] : 0;
    	$filter ['count_on_sale'] 	= $filter_count['count_on_sale'] > 0 ? $filter_count['count_on_sale'] : 0;
    	$filter ['count_not_sale'] 	= $filter_count['count_not_sale'] > 0 ? $filter_count['count_not_sale'] : 0;
    	$filter ['merchant'] 		= $filter_count['merchant'] > 0 ? $filter_count['merchant'] : 0;
    
    	$sql = $db_goods
	    	->selectRaw('g.goods_id, g.goods_name, g.goods_type, g.goods_sn, g.shop_price, g.goods_thumb, g.is_on_sale, g.store_best, g.store_new, g.store_hot, g.store_sort_order, g.goods_number, g.integral, (g.promote_price > 0 AND g.promote_start_date <= ' . $today . ' AND g.promote_end_date >= ' . $today . ') as is_promote, g.review_status, s.merchants_name')
	    	->orderBy($filter ['sort_by'], $filter['sort_order'])
	    	->orderBy('goods_id', 'desc')
	    	->take(10)
	    	->skip($page->start_id-1)
	    	->get();
    
    	$filter ['keyword'] = stripslashes($filter ['keyword']);
    	$filter ['count'] 	= $count;
    
    	if (!empty($sql)) {
    		foreach ($sql as $k => $v) {
    			if (!empty($v['goods_thumb']) && file_exists(RC_Upload::upload_path($v['goods_thumb']))) {
    				$sql[$k]['goods_thumb'] = RC_Upload::upload_url($v['goods_thumb']);
    			} else {
    				$sql[$k]['goods_thumb'] = RC_Uri::admin_url('statics/images/nopic.png');
    			}
    		}
    	}
    	$row = $sql;
    
    	return array(
    		'goods'		=> $row,
    		'filter'	=> $filter,
    		'page'		=> $page->show(2),
    		'desc'		=> $page->page_desc()
    	);
    }
}

// end