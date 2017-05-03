<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 广告位置列表
 * @author will.chen
 */
class adsense_adsense_position_list_api extends Component_Event_Api {
	/**
	 *
	 * @param array $options        	
	 * @return array
	 */
	public function call(&$options) {
		return $this->adsense_position_list($options);
	}
	/**
	 * 取得广告位列表
	 * 
	 * @param array $options        	
	 * @return array 广告位列表
	 */
	private function adsense_position_list($options) {
		$db = RC_DB::table('ad_position');
		$filter = array();
		$filter['keywords'] = empty($options['keywords']) ? '' : trim($options['keywords']);
		$filter['page_size'] = empty($options['page_size']) ? 15 : intval($options['page_size']);
		$filter['current_page'] = empty($options['current_page']) ? 1 : intval($options['current_page']);
		$filter['position_id'] = empty($options['position_id']) ? null : $options['position_id'];
		if (! empty($filter['keywords'])) {
			$db->where('position_name', 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
		}
		if (! empty($filter['position_id'])) {
			$db->where('position_id', '=', $filter['position_id']);
		}
		$limit = null;
		/* 判断是否需要分页 will.chen */
		if (isset($options['is_page']) && $options['is_page'] == 1) {
			$count = $db->count();
			$page = new ecjia_page($count, $filter['page_size'], 5, '', $filter['current_page']);
			$filter['record_count'] = $count;
		}
		$result = $db->take($filter['page_size'])->orderBy('position_id', 'desc')->skip($page->start_id - 1)->get();
		if (isset($options['is_page']) && $options['is_page'] == 1) {
			return array(
				'arr' => $result,
				'page' => $page->show(15),
				'desc' => $page->page_desc() 
			);
		} else {
			return array(
				'arr' => $result 
			);
		}
	}
}

// end