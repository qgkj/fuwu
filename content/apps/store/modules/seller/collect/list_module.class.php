<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 店铺收藏列表
 * @author will.chen
 */
class list_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

    	$this->authSession();
		$user_id   = $_SESSION['user_id'];
		$cs_dbview = RC_Model::model('store/collect_store_viewmodel');

		$where = array();
		$count = RC_DB::table('collect_store as cs')
                ->leftJoin('store_franchisee as sf', RC_DB::raw('cs.store_id'), '=', RC_DB::raw('sf.store_id'))
                ->where('status', '1')
        		->where('user_id', $user_id)
        		->count();

		/* 查询总数为0时直接返回  */
		if ($count == 0) {
			$pager = array(
					'total' => 0,
					'count' => 0,
					'more'	=> 0,
			);
			return array('data' => array(), 'pager' => $pager);
    	}

		/* 获取留言的数量 */
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);

		//加载分页类
		RC_Loader::load_sys_class('ecjia_page', false);
		//实例化分页
		$page_row = new ecjia_page($count, $size, 6, '', $page);
        $field = 'rec_id, sf.store_id, sf.merchants_name as seller_name, sc.cat_name, count(cs.store_id) as follower';
        $result = RC_DB::table('collect_store as cs')
                ->leftJoin('store_franchisee as sf', RC_DB::raw('cs.store_id'), '=', RC_DB::raw('sf.store_id'))
                ->leftjoin('store_category as sc', RC_DB::raw('cs.store_id'), '=', RC_DB::raw('sf.store_id'))
                ->selectRaw($field)
                ->where('status', '1')->where('user_id', $user_id)
                ->take(10)
                ->skip($page->start_id-1)
                ->groupBy(RC_DB::raw('sf.store_id'))
                ->get();
        foreach($result as $key => $val){
            $result[$key]['shop_log'] =RC_DB::table('merchants_config')
                                        ->selectRaw('value')
                                        ->where('store_id', $val['store_id'])
                                        ->pluck();
        }
		$list = array();
		if ( !empty ($result)) {
			$mobilebuy_db = RC_Model::model('goods/goods_activity_model');
			foreach ($result as $row) {
				$options = array(
						'intro'		=> 'new',
						'seller_id' => $row['seller_id'],
						'page'		=> 1,
						'size'		=> 3,
				);

				$result = RC_Api::api('goods', 'goods_list', $options);
				$goods_list = array();
				if (!empty($result['list'])) {
					/* 手机专享*/
					$result_mobilebuy = ecjia_app::validate_application('mobilebuy');
					$is_active        = ecjia_app::is_active('ecjia.mobilebuy');
					foreach ($result['list'] as $val) {
						/* 判断是否有促销价格*/
						$price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_promote_price'] : $val['unformatted_shop_price'];
						$activity_type = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
						/* 计算节约价格*/
						$saving_price = ($val['unformatted_shop_price'] > $val['unformatted_promote_price'] && $val['unformatted_promote_price'] > 0) ? $val['unformatted_shop_price'] - $val['unformatted_promote_price'] : (($val['unformatted_market_price'] > 0 && $val['unformatted_market_price'] > $val['unformatted_shop_price']) ? $val['unformatted_market_price'] - $val['unformatted_shop_price'] : 0);

						$mobilebuy_price = $object_id = 0;
						if (!is_ecjia_error($result_mobilebuy) && $is_active) {
							$mobilebuy = $mobilebuy_db->find(array(
									'goods_id'	 => $val['goods_id'],
									'start_time' => array('elt' => RC_Time::gmtime()),
									'end_time'	 => array('egt' => RC_Time::gmtime()),
									'act_type'	 => GAT_MOBILE_BUY,
							));
							if (!empty($mobilebuy)) {
								$ext_info        = unserialize($mobilebuy['ext_info']);
								$mobilebuy_price = $ext_info['price'];
								if ($mobilebuy_price < $price) {
									$val['promote_price'] = price_format($mobilebuy_price);
									$object_id		      = $mobilebuy['act_id'];
									$activity_type	      = 'MOBILEBUY_GOODS';
									$saving_price         = ($val['unformatted_shop_price'] - $mobilebuy_price) > 0 ? $val['unformatted_shop_price'] - $mobilebuy_price : 0;
								}
							}
						}

						$goods_list[] = array(
								'id'			=> $val['goods_id'],
								'name'			=> $val['name'],
								'market_price'	=> $val['market_price'],
								'shop_price'	=> $val['shop_price'],
								'promote_price'	=> $val['promote_price'],
								'img' => array(
										'thumb'	=> $val['goods_img'],
										'url'	=> $val['original_img'],
										'small'	=> $val['goods_thumb']
								),
								'activity_type' => $activity_type,
								'object_id'		=> $object_id,
								'saving_price'	=>	$saving_price,
								'formatted_saving_price' => $saving_price > 0 ? '已省'.$saving_price.'元' : '',
						);
					}
				}

				if(substr($row['shop_logo'], 0, 1) == '.') {
					$row['shop_logo'] = str_replace('../', '/', $row['shop_logo']);
				}

				$list[] = array(
						'rec_id'			=> $row['rec_id'],
						'id'				=> $row['seller_id'],
						'seller_name'		=> $row['seller_name'],
						'seller_category'	=> $row['cat_name'],
						'seller_logo'		=> empty($row['shop_logo']) ?  '' : RC_Upload::upload_url($row['shop_logo']),
						'seller_goods'		=> $goods_list,
						'follower'			=> $row['follower'],
						'new_goods'			=> $result['page']->total_records,
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
