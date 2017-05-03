<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商品列表
 * @author will
 */
class list_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		if (!$this->admin_priv('goods_manage')) {
			return new ecjia_error('privilege_error', '对不起，您没有执行此项操作的权限！');
		}

		$on_sale	= $this->requestData('on_sale');//true.在售, false.下架
		$stock		= $this->requestData('stock');//是否售罄 。true.有货 , false.售罄
		$sort		= $this->requestData('sort_by', 'sort_order');//默认: sort_order  其他: price_desc, price_asc, stock, click_asc, clcik_desc
		$keywords	= $this->requestData('keywords', '');
		$category_id = $this->requestData('category_id', 0);

		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);

		$sort_by = '';
		/* 推荐类型 */
		switch ($sort) {
			case 'sort_order' :
				$sort_by = array('sort_order' => 'asc', 'goods_id' => 'desc');
				break;
			case 'price_desc' :
				$sort_by = array('shop_price' => 'desc', 'goods_id' => 'desc');
				break;
			case 'price_asc' :
				$sort_by = array('shop_price' => 'asc', 'goods_id' => 'desc');
				break;
			case 'stock' :
				$sort_by = array('goods_number' => 'asc', 'goods_id' => 'desc');
				break;
			case 'click_asc' :
				$sort_by = array('click_count' => 'asc', 'goods_id' => 'desc');
				break;
			case 'click_desc' :
				$sort_by = array('click_count' => 'desc', 'goods_id' => 'desc');
				break;
		}
		$where = array();
		$where = array(
			'is_delete' => 0,
		);

		if ($_SESSION['store_id'] > 0) {
			$where = array_merge($where, array('store_id' => $_SESSION['store_id']));
		}
		if (!empty($on_sale)) {
			$where['is_on_sale'] = $on_sale == 'true' ? 1 : 0 ;
		}

		if ($stock == 'false') {
			$where['goods_number'] = 0;
		}
		if (!empty($category_id)) {
			RC_Loader::load_app_func('admin_category', 'goods');
			RC_Loader::load_app_func('admin_goods', 'goods');
			RC_Loader::load_app_func('global', 'goods');
			$children = get_children($category_id);
            $merchant_cat_id = 'merchant_cat_id ' . db_create_in (array_unique(array_merge(array($category_id), array_keys(cat_list($category_id, 0, false )))));
			$where[] = "(".$children ." OR ".get_extension_goods($children) ." OR ". $merchant_cat_id .")";
		}
		if ( !empty($keywords)) {
			$where[] = "( goods_name like '%".$keywords."%' or goods_sn like '%".$keywords."%' )";
		}
		$db = RC_Model::model('goods/goods_viewmodel');

		/* 获取记录条数 */
		$record_count = $db->join(null)->where($where)->count();

		//实例化分页
		$page_row = new ecjia_page($record_count, $size, 6, '', $page);

		$field = "goods_id, goods_sn, goods_name, goods_number, shop_price, market_price, promote_price, promote_start_date, promote_end_date, click_count, goods_thumb, is_best, is_new, is_hot, is_shipping, goods_img, original_img, last_update";
		$data = $db->join(null)->field($field)->where($where)->order($sort_by)->limit($page_row->limit())->select();

		$goods_list = array();
		if (!empty($data)) {
			RC_Loader::load_app_func('admin_goods', 'goods');
			RC_Loader::load_sys_func('global');
			foreach ($data as $key => $val) {
				if ($val['promote_price'] > 0) {
					$promote_price = bargain_price($val['promote_price'], $val['promote_start_date'], $val['promote_end_date']);
				} else {
					$promote_price = 0;
				}
				$goods_list[] = array(
					'goods_id'			=> $val['goods_id'],
					'name'				=> $val['goods_name'],
					'goods_sn'			=> $val['goods_sn'],
					'market_price'		=> price_format($val['market_price'] , false),
					'shop_price'		=> price_format($val['shop_price'] , false),
					'promote_price'		=> $promote_price > 0 ? price_format($promote_price , false) : $promote_price,
					'clicks'			=> intval($val['click_count']),
					'stock'				=> (ecjia::config('use_storage') == 1) ? $val['goods_number'] : '',
					'goods_weight'		=> $val['goods_weight']  = (intval($val['goods_weight']) > 0) ? $val['goods_weight'] . __('千克') : ($val['goods_weight'] * 1000) . __('克'),
					'is_best'			=> $val['is_best'] == 1 ? true : false,
					'is_new'			=> $val['is_new'] == 1 ? true : false,
					'is_hot'			=> $val['is_hot'] == 1 ? true : false,
					'is_shipping'		=> $val['is_shipping'] == 1 ? true : false,
					'last_updatetime' 	=> RC_Time::local_date(ecjia::config('time_format'), $val['last_update']),
					'img' => array(
						'thumb'	=> !empty($val['goods_img']) ? RC_Upload::upload_url($val['goods_img']) : '',
						'url'	=> !empty($val['original_img']) ? RC_Upload::upload_url($val['original_img']) : '',
						'small'	=> !empty($val['goods_thumb']) ? RC_Upload::upload_url($val['goods_thumb']) : '',
					)
				);
			}
		}

		$pager = array(
			'total' => $page_row->total_records,
			'count' => $page_row->total_records,
			'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		return array('data' => $goods_list, 'pager' => $pager);
	}
}

// end