<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * @author royalwang
 */
class setDeviceToken_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authSession();	
		
		$device = $this->device;
		
		$device['device_token'] = $this->requestData('device_token');
		$user_type		        = $this->requestData('user_type', 'user');
		
		if (empty($device['udid']) || empty($device['client']) || empty($device['code']) || empty($device['device_token'])) {
			return new ecjia_error(101, '参数错误');
		}
		
		$db_mobile_device = RC_Model::model('mobile/mobile_device_model');
		$device_data = array(
				'device_udid'	=> $device['udid'],
				'device_client'	=> $device['client'],
				'device_code'	=> $device['code'],
				'user_type'		=> $user_type,
		);
		$row = $db_mobile_device->find($device_data);
		
		if (empty($row)) {
			$device_data['add_time']     = RC_Time::gmtime();
			$device_data['device_token'] = !empty($device['device_token']) ? $device['device_token'] : '';
				
			$db_mobile_device->insert($device_data);
		} else {
			$data = array();
			if (!empty($device['device_token'])) {
				$data['device_token'] = $device['device_token'];
				$data['update_time']  = RC_Time::gmtime();
			}
			$db_mobile_device->where($device_data)->update($data);
		}
		return array();
		
	}
}

// end