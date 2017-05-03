<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * api_admin
 * @author will
 */
abstract class api_admin extends ecjia_api {
	protected $requestData = array();
	protected $token = null;
	protected $device = array();
	
	public function __construct() {
		parent::__construct();
		
		$request = royalcms('request');
		
		$this->requestData = json_decode($request->input('json'), true);
		
		$this->token = $this->requestData('token') ? $this->requestData('token') : $this->requestData('session.sid');
		
		$this->device = $this->requestData('device', array());
		$this->device['client'] = empty($this->device['client']) ? $request->header('device_client') : $this->device['client'];
		$this->device['code']	= empty($this->device['code'])	? $request->header('device_code') : $this->device['code'];
		$this->device['udid']	= empty($this->device['udid']) ? $request->header('device_udid') : $this->device['udid'];
		$this->api_version		= $request->header('api_version');
	}
	
	protected function session_start() {
		RC_Hook::add_filter('royalcms_session_name', function ($sessin_name) {
			return RC_Config::get('session.session_admin_name');
		});
	
		RC_Hook::add_filter('royalcms_session_id', function ($sessin_id) {
			return RC_Hook::apply_filters('ecjia_api_session_id', '');
		});
	
		RC_Session::start();
	}
	
	/**
	 * 管理员登录授权验证
	 */
	public function authadminSession() {
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
	
	/**
	 * 判断管理员对某一个操作是否有权限。
	 * 根据当前对应的action_code，然后再和用户session里面的action_list做匹配，以此来决定是否可以继续执行。
	 * @param     string    $priv_str    操作对应的priv_str
	 * @return true/false
	 */
	public function admin_priv($priv_str) {
		if ($_SESSION['action_list'] == 'all') {
			return true;
		}
	
		if (strpos(',' . $_SESSION['action_list'] . ',', ',' . $priv_str . ',') === false) {
			return false;
		} else {
			return true;
		}
	}
}

// end