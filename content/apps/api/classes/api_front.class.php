<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * api_front
 * @author will
 */
abstract class api_front extends ecjia_api {
	protected $requestData = array();
	
	protected $token = null;
	
	protected $device = array();
	
	protected $api_version = null;
	
	public function __construct() {
        parent::__construct();
        
        $request = royalcms('request');
        
        $json = str_replace('\\', '', $request->input('json'));
        $this->requestData = json_decode($json, true);
        
        $this->token = $this->requestData('token') ? $this->requestData('token') : $this->requestData('session.sid');
        
        $this->device = $this->requestData('device', array());
        $this->device['client'] = empty($this->device['client']) ? $request->header('device_client') : $this->device['client'];
        $this->device['code']	= empty($this->device['code'])	? $request->header('device_code') : $this->device['code'];
        $this->device['udid']	= empty($this->device['udid']) ? $request->header('device_udid') : $this->device['udid'];
        $this->api_version		= $request->header('api_version');
        
        $this->authSession();
        
        RC_Api::api('stats', 'statsapi', array('api_name' => $request->input('url'), 'device' => $this->device));
        RC_Api::api('mobile', 'device_record', array('device' => $this->device));
	}
	
	protected function session_start() {
		RC_Hook::add_filter('royalcms_session_name', function ($sessin_name) {
			return RC_Config::get('session.session_name');
		});
	
		RC_Hook::add_filter('royalcms_session_id', function ($sessin_id) {
			return RC_Hook::apply_filters('ecjia_api_session_id', '');
		});
	
		RC_Session::start();
	}
	
	/**
	 * 登录session授权
	 */
	public function authSession() {
// 		if (!empty($this->token)) {
// 			if (RC_Session::session_id() != $this->token) {
//     			RC_Session::destroy();
//     			RC_Session::init(null, $this->token);
//     		}
// 		}
	}
	
	public function requestData($key, $default = null) {
		$requestData = array_get($this->requestData, $key);
		if (!empty($requestData)) {
			return $requestData;
		} else {
			$input = explode('.', $key);
			$request = royalcms('request');
			$input_val = $request->input($input[0]);
			if(isset($input_val)) {
			    $this->requestData[$input[0]] = $request->input($input[0]);
			}
			return array_get($this->requestData, $key, $default);
		}
	}
}

// end