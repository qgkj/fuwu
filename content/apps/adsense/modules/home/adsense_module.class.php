<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 手机启动页广告
 * @author will.chen
 */
class adsense_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	
    	$this->authSession();
		$data = RC_Cache::app_cache_get('app_home_adsense', 'adsense');
		if (empty($data)) {
			//流程逻辑开始
			// runloop 流
			$request = null;
			$response = array();
			$response = RC_Hook::apply_filters('api_home_adsense_runloop', $response, $request);
			RC_Cache::app_cache_set('app_home_adsense', $response, 'adsense');
			//流程逻辑结束
		} else {
			$response = $data;
		}
		return $response;
	}
}

function adsense_data($response, $request) {
    $mobile_launch_adsense = ecjia::config('mobile_launch_adsense');
	if (empty($mobile_launch_adsense)) {
		return array();
	}
	$where = array(
		'position_id'	=> ecjia::config('mobile_launch_adsense'),
		'enabled'		=> 1,
		'start_time'	=> array('elt' => RC_Time::gmtime()),
		'end_time'		=> array('egt' => RC_Time::gmtime())
	);
	
	$result = RC_Model::model('adsense/ad_model')->field('ad_id, ad_link, ad_code, start_time, end_time')->where($where)->limit(5)->select();
	
	$adsense_list = array();
	if (!empty($result)) {
		foreach ($result as $val) {
			$adsense_list[] = array(
				'id'		 => $val['ad_id'],
				'ad_link'	 => $val['ad_link'],
				'ad_img'	 => empty($val['ad_code']) ? '' : RC_Upload::upload_url().'/'.$val['ad_code'],
				'start_time' => RC_Time::local_date(ecjia::config('date_format'), $val['start_time']),
				'end_time'	 => RC_Time::local_date(ecjia::config('date_format'), $val['end_time']),
			);
		}
	}
	$response = $adsense_list;
	return $response;
}

RC_Hook::add_filter('api_home_adsense_runloop', 'adsense_data', 10, 2);

// end