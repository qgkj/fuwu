<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 用户收藏列表
 * @author royalwang
 */
class list_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
        $this->authSession();
        $user_id = $_SESSION['user_id'];
    	if ($user_id <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
		
		$size     = $this->requestData('pagination.count', 15);
		$page     = $this->requestData('pagination.page', 1);
        $user_id  = $_SESSION['user_id'];
		$rec_id   = $this->requestData('rec_id', 0);
		
		RC_Loader::load_app_func('admin_user', 'user');
		RC_Loader::load_app_func('global', 'api');
		$db_collect_goods = RC_Model::model('goods/collect_goods_model');
		
		$where = array('user_id'=>$user_id);
		if ($rec_id) {
			$where = array_merge($where, array('rec_id'=>array('lt'=>$rec_id)));
		}
		
		$record_count = $db_collect_goods->where($where)->count();
		//加载分页类
		RC_Loader::load_sys_class('ecjia_page', false);
		//实例化分页
		$page_row = new ecjia_page($record_count, $size, 6, '', $page);
		
		$goods_list = EM_get_collection_goods($user_id, $size, $page, $rec_id);
		
		$data = array();
		if (!empty($goods_list)) {
			$mobilebuy_db = RC_Model::model('goods/goods_activity_model');
			foreach ($goods_list as $key => $value) {
				$temp = API_DATA("SIMPLEGOODS", $value);
				
				$groupbuy = $mobilebuy_db->find(array(
						'goods_id'	 => $value['goods_id'],
						'start_time' => array('elt' => RC_Time::gmtime()),
						'end_time'	 => array('egt' => RC_Time::gmtime()),
						'act_type'	 => GAT_GROUP_BUY,
				));
				$mobilebuy = $mobilebuy_db->find(array(
						'goods_id'	 => $value['goods_id'],
						'start_time' => array('elt' => RC_Time::gmtime()),
						'end_time'	 => array('egt' => RC_Time::gmtime()),
						'act_type'	 => GAT_MOBILE_BUY,
				));
				/* 判断是否有促销价格*/
				$price = ($value['unformatted_shop_price'] > $value['unformatted_promote_price'] && $value['unformatted_promote_price'] > 0) ? $value['unformatted_promote_price'] : $value['unformatted_shop_price'];
				$activity_type = ($value['unformatted_shop_price'] > $value['unformatted_promote_price'] && $value['unformatted_promote_price'] > 0) ? 'PROMOTE_GOODS' : 'GENERAL_GOODS';
				
				$mobilebuy_price = $groupbuy_price = $object_id = 0;
				if (!empty($mobilebuy)) {
					$ext_info        = unserialize($mobilebuy['ext_info']);
					$mobilebuy_price = $ext_info['price'];
					$price           = $mobilebuy_price > $price ? $price : $mobilebuy_price;
					$activity_type   = $mobilebuy_price > $price ? $activity_type : 'MOBILEBUY_GOODS';
					$object_id       = $mobilebuy_price > $price ? $object_id : $mobilebuy['act_id'];
				}
// 						if (!empty($groupbuy)) {
// 							$ext_info = unserialize($groupbuy['ext_info']);
// 							$price_ladder = $ext_info['price_ladder'];
// 							$groupbuy_price  = $price_ladder[0]['price'];
// 							$price = $groupbuy_price > $price ? $price : $groupbuy_price;
// 							$activity_type = $groupbuy_price > $price ? $activity_type : 'GROUPBUY_GOODS';
// 						}
				/* 计算节约价格*/
				$saving_price = ($value['unformatted_shop_price'] - $price) > 0 ? $value['unformatted_shop_price'] - $price : 0;
				
				$temp['promote_price']  = ($price < $value['unformatted_shop_price'] && $price > 0) ? price_format($price) : '';
				$temp['activity_type']	= $activity_type;
				$temp['object_id']		= $object_id;
				$temp['saving_price']	= $saving_price;
				$temp['formatted_saving_price'] = '已省'.$saving_price.'元';
				
				$temp['rec_id']         = $value['rec_id'];
				$temp['attention_rate'] = $value['click_count'];
				$data[]                 = $temp;
			}
		}
		
		$pager = array(
				"total" => $page_row->total_records,
				"count" => $page_row->total_records,
				"more"  => $page_row->total_pages > $page['page'] ? 1 : 0,
		);

		return array('data' => $data, 'pager' => $pager);
		
		// 		$pager = get_pager('collection', array(), $record_count, $page['page'], $page['count']);
		// 		return array('data' => $data, 'pager' => array(
		// 			"total"  => $record_count,
		// 			"count"  => count($data),
		// 			"more"   => intval($pager['page_count'] > $pager['page'])
		// 		));		
		// 		if (!$rec_id) {
		// 		    $record_count = $db_collect_goods->where(array('user_id' => $user_id))->count();
		// 		} else {
		// 			$record_count = $db_collect_goods->where(array('user_id' => $user_id , 'rec_id' => array('lt' => $rec_id)))->count();
		// 		}
	}
}

// end