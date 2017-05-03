<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 店铺列表接口
 * @author
 */
class store_store_list_api extends Component_Event_Api {
	/**
	 *
	 * @param array $options
	 * @return  array
	 */
	public function call (&$options) {
        if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}

		return $this->store_list($options);
	}

    /**
	 *  获取店铺列表
	 *
	 * @access  private
	 * @return  array       $order_list     订单列表
	 */
	private function store_list($filter)
	{
		$where = array();
		$where['ssi.status'] = 1;
		$where['ssi.store_id'] = array();
		
		/* 商家列表缓存key*/
		$cache_key = 'store-list';
		
		/* 商品分类*/
		if (isset($filter['goods_category']) && !empty($filter['goods_category'])) {
			RC_Loader::load_app_class('goods_category', 'goods', false);

			$key = 'category-children-'.$filter['goods_category'];
			$category_children_cachekey = sprintf('%X', crc32($key));
			$children = RC_Cache::app_cache_get($category_children_cachekey, 'goods');
			
			if (empty($children)) {
				$children = goods_category::get_children($filter['goods_category']);
				RC_Cache::app_cache_set($category_children_cachekey, $children, 'goods');
			}

			$seller_group_where = array(
					"(". $children ." OR ".goods_category::get_extension_goods($children, 'goods_id').")",
					'is_on_sale'	=> 1,
					'is_alone_sale' => 1,
					'is_delete'		=> 0,
					'review_status'	=> array('gt' => 2),
			);

			$seller_group = RC_Model::model('goods/goods_viewmodel')->join(null)
									->where($seller_group_where)
									->get_field('store_id', true);

			if (!empty($seller_group)) {
				$where['ssi.store_id'] = $seller_group = array_unique($seller_group);
			} else {
				$where['ssi.store_id'] = 0;
			}
			
			$cache_key .= '-goods_category-' . $filter['goods_category'];
		}

		/* 关键字*/
		if (!empty($filter['keywords'])) {
			$cache_key .= '-keywords-' . $filter['keywords'];
			$where[]    = '(merchants_name like "%'.$filter['keywords'].'%" or goods_name like "%'.$filter['keywords'].'%")';
		}

		/* 店铺分类*/
		if (isset($filter['seller_category']) && !empty($filter['seller_category'])) {
			$cache_key           .= '-seller_category-' . $filter['seller_category'];
			$where['ssi.cat_id']  = $filter['seller_category'];
		}


		/* 获取当前经纬度周边的geohash值*/
		if (isset($filter['geohash']) && !empty($filter['geohash'])) {
			/* 载入geohash类*/
			$geohash	                 = RC_Loader::load_app_class('geohash', 'store');
			$geohash_code                = substr($filter['geohash'], 0, 5);
			$geohash_group               = $geohash->geo_neighbors($geohash_code);
			$store_geohash               = array_merge(array($geohash_code), $geohash_group);
			$where['left(geohash, 5)']   = $store_geohash;
			$cache_key                   .= '-geohash-' . $filter['geohash'];
		}

		$where['shop_close'] = '0';

		if (isset($filter['limit']) && $filter['limit'] == 'all') {
			$cache_key .= '-limit-all';
		}
		
		$store_franchisee_db = RC_Model::model('store/orm_store_franchisee_model');
		/* 储存商品列表缓存key*/
		$fomated_cache_key = $store_franchisee_db->create_cache_key_array($cache_key, 2880);
		$store_list = $store_franchisee_db->get_cache_item($fomated_cache_key);
		
		if (empty($store_list)) {
			$db_store_franchisee = RC_Model::model('store/store_franchisee_viewmodel');
			$count = $db_store_franchisee->join(array('goods'))->where($where)->count('distinct(ssi.store_id)');
			
			//加载分页类
			RC_Loader::load_sys_class('ecjia_page', false);
			//实例化分页
			$page_row = new ecjia_page($count, $filter['size'], 6, '', $filter['page']);
			
			$limit = $filter['limit'] == 'all' ? null : $page_row->limit();
			
			$seller_list = array();
			
			$field = 'ssi.*, sc.cat_name, count(cs.store_id) as follower';
			$result = $db_store_franchisee->join(array('collect_store', 'store_category', 'goods'))->field($field)->where($where)->limit($limit)->group('ssi.store_id')->order(array())->select();
			
			if (!empty($result)) {
				foreach($result as $k => $val){
					$store_config = array(
							'shop_kf_mobile'            => '', // 客服手机号码
							'shop_logo'                 => '', // 默认店铺页头部LOGO
							'shop_banner_pic'           => '', // banner图
							'shop_trade_time'           => '', // 营业时间
							'shop_description'          => '', // 店铺描述
							'shop_notice'               => '', // 店铺公告
			
					);
					$config = RC_DB::table('merchants_config')->where('store_id', $val['store_id'])->select('code', 'value')->get();
					foreach ($config as $key => $value) {
						$store_config[$value['code']] = $value['value'];
					}
					$result[$k] = array_merge($result[$k], $store_config);
			
					if(substr($result[$k]['shop_logo'], 0, 1) == '.') {
						$result[$k]['shop_logo'] = str_replace('../', '/', $val['shop_logo']);
					}
					$result[$k]['trade_time'] = !empty($result[$k]['shop_trade_time']) ? unserialize($result[$k]['shop_trade_time']) : array('start' => '8:00', 'end' => '21:00');
					$seller_list[] = array(
							'id'				 => $result[$k]['store_id'],
							'seller_name'		 => $result[$k]['merchants_name'],
							'seller_category'	 => $result[$k]['cat_name'],//后期删除
							'manage_mode'		 => $result[$k]['manage_mode'],
							'shop_logo'		     => empty($result[$k]['shop_logo']) ?  '' : RC_Upload::upload_url($result[$k]['shop_logo']),//后期增加
							'seller_logo'		 => empty($result[$k]['shop_logo']) ?  '' : RC_Upload::upload_url($result[$k]['shop_logo']),//后期删除
							'follower'			 => $result[$k]['follower'],
							'sort_order'		 => $result[$k]['sort_order'],
							'location' => array(
									'latitude'  => $result[$k]['latitude'],
									'longitude' => $result[$k]['longitude'],
							),
							'label_trade_time'	 => $result[$k]['trade_time']['start'] . ' - '. $result[$k]['trade_time']['end'],
					);
				}
			}
			
			$store_list = array('seller_list' => $seller_list, 'page' => $page_row);
			
			$store_franchisee_db->set_cache_item($fomated_cache_key, $store_list, 2880);
		}
		return $store_list;
	}
}

// end
