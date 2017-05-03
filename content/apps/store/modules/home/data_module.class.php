<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 店铺街首页数据
 * @author will.chen
 */
class data_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
    	$this->authSession();
		RC_Loader::load_app_func('global', 'api');
		//流程逻辑开始
		// runloop 流
		$request = null;
		$response = array();
			
		$response = RC_Hook::apply_filters('api_seller_home_data_runloop', $response, $request);
	
		//流程逻辑结束
		return $response;
	}
}


function adsense_data($response, $request) {
	$ad_view = RC_Model::model('adsense/ad_model');
	
	$adsense = array(
		'position_id'	=> ecjia::config('mobile_seller_home_adsense'),
		'start_time'	=> array('elt' => RC_Time::gmtime()),
		'end_time'		=> array('egt' => RC_Time::gmtime()),
	);
	$adsense_result = $ad_view->where($adsense)->order('ad_id')->limit(4)->select();

	$adsense_data = array();
	if (!empty($adsense_result)) {
		foreach ($adsense_result as $val) {
			if (substr($val['ad_code'], 0, 4) != 'http') {
				$val['ad_code'] = RC_Upload::upload_url().'/'.$val['ad_code'];
			}
			$adsense_data[] = array(
				'image'	=> $val['ad_code'],
				'text'	=> $val['ad_name'],
				'url'	=> $val['ad_link'],
			);
		}
	}

	$response['adsense'] = $adsense_data;
	return $response;
}

RC_Hook::add_filter('api_seller_home_data_runloop', 'adsense_data', 10, 2);

// end