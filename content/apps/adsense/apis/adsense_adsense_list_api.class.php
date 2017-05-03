<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取广告位的广告列表
 * @author will.chen
 */
class adsense_adsense_list_api extends Component_Event_Api {
	/**
	 *
	 * @param array $options        	
	 * @return array
	 */
	public function call(&$options) {
		return $this->adsense_list($options);
	}
	/**
	 * 取得广告位列表
	 * 
	 * @param array $options        	
	 * @return array 广告位列表
	 */
	private function adsense_list($options) {
		$ad_position_db = RC_Model::model('adsense/orm_ad_position_model');
		RC_Model::model('adsense/orm_ad_model');
		$filter['position_id'] = empty($options['position_id']) ? null : $options['position_id'];
		$cache_key = sprintf('%X', crc32('adsense_position-' . $filter['position_id']));
		$adsense_group = $ad_position_db->get_cache_item($cache_key);
		if (empty($adsense_group)) {
			$ad_position_db = orm_ad_position_model::find($filter['position_id']);
			$ad_position_info = $ad_position_db;
			if (empty($ad_position_info)) {
				return array();
			}
			$adsense_group['title'] = $ad_position_info['position_desc'];
			$time = RC_Time::gmtime();
			$adsense_result = $ad_position_info->ad()->where('start_time', '<=', $time)->where('end_time', '>=', $time)->where('enabled', 1)->orderBy('ad_id', 'asc')->take(4);
			$adsense = $adsense_result->get()->toArray();
			if (! empty($adsense)) {
				foreach ( $adsense as $v ) {
					if (substr($v['ad_code'], 0, 4) != 'http') {
						$v['ad_code'] = RC_Upload::upload_url($v['ad_code']);
					}
					$adsense_group['adsense'][] = array(
						'image' => $v['ad_code'],
						'text' => $v['ad_name'],
						'url' => $v['ad_link'] 
					);
				}
			}
			$ad_position_db->set_cache_item($cache_key, $adsense_group);
		}
		return $adsense_group;
	}
}

// end