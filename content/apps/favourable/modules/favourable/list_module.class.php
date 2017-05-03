<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取商家活动列表
 * @author zrl
 */
class list_module extends api_front implements api_interface {
	
	 public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$this->authSession();	
		
		$location	 = $this->requestData('location', array());
// 		/*经纬度为空判断*/
// 		if (!is_array($location) || empty($location['longitude']) || empty($location['latitude'])) {
// 			return new ecjia_error('invalid_parameter', '参数无效');
// 		}
		
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);
		
		$where = array();
		/* 正在进行中的*/
		$where['type'] = 'on_going';
		 
		/* 区域定位处理*/
// 		TODO::待增加
		$geohash_code = '';
		
		$options                = array('location' => $location, 'page' => $page, 'size' => $size, 'where' => $where);
		$where['sort_by']    	= 'act_id';
		$where['sort_order'] 	= 'DESC';
		$cache_id               = sprintf('%X', crc32($geohash_code . '-' . page  .'-' . $size  . '-' . $where ));
		
		$cache_key              = 'favourable_list_'.$cache_id;
		$data                   = RC_Cache::app_cache_get($cache_key, 'favourable');
		if (empty($data)) {
			$count           = RC_Api::api('favourable', 'favourable_count', $where);
			
			$page_row        = new ecjia_page($count, $size, 6, '', $page);
			$where['skip']	 = $page_row->start_id-1;
			$where['limit']	 = $size;
			$favourable_list = RC_Api::api('favourable', 'favourable_list', $where);
			
			$data['pager']   = array(
    					'total' => $page_row->total_records,
    					'count' => $page_row->total_records,
    					'more'	=> $page_row->total_pages <= $page ? 0 : 1,
			);
			$data['list'] = array();
			if (!empty($favourable_list)) {
				foreach ($favourable_list as $key => $row) {
					$data['list'][] = array(
						'seller_id'				=> 	$row['seller_id'],
						'seller_name'			=>  $row['merchants_name'],
						'seller_logo'			=>  '',//TODO::待做
						'favourable_name'		=>  $row['act_name'],
						'favourable_type'		=>  ($row['act_type'] == 1 || $row['act_type'] == 2) ?  $row['act_type'] == 1 ? 'price_reduction' : 'price_discount' : 'premiums',
						'label_favourable_type' =>  ($row['act_type'] == 1 || $row['act_type'] == 2) ? $row['act_type'] == 1 ? '满'.$row['min_amount'].'减'.$row['act_type_ext'] : '满'.$row['min_amount'].'享受'.($row['act_type_ext']/10).'折' : __('享受赠品（特惠品）'),
					);
				}
			}
			RC_Cache::app_cache_set($cache_key, $data, 'favourable');
		}
		return array('data' => $data['list'], 'pager' => $data['pager']);
	 }	
}

// end