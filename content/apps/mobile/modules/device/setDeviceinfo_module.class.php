<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * @author chen
 */
class setDeviceinfo_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
		
		$device = $this->device;
		
		$device['device_token'] = $this->requestData('device_token');
		
		$device_name	= $this->requestData('device_name');
		$device_os		= $this->requestData('device_os');
		$device_type	= $this->requestData('device_type');
		$province		= $this->requestData('province');
		$city			= $this->requestData('city');
		$user_type		= $this->requestData('user_type', 'user');
		
		if (empty($device['udid']) || empty($device['client']) || empty($device['code'])) {
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
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
			$device_data['add_time']		    = RC_Time::gmtime();
			$device_data['device_token']	    = !empty($device['device_token']) ? $device['device_token'] : '';
			$device_data['device_name']		    = $device_name;
			$device_data['device_os']		    = $device_os;
			$device_data['device_type']		    = $device_type;
			$device_data['location_province']	= $province;
			$device_data['location_city']		= $city;
			$device_data['visit_times']		    = 1;
			
			$db_mobile_device->insert($device_data);
		} else {
			$data = array();
			if (!empty($device['device_token'])) {
				$data['device_token'] = $device['device_token'];
			}
			$data['device_name']		= $device_name;
			$data['device_os']			= $device_os;
			$data['device_type']		= $device_type;
			$data['location_province']	= $province;
			$data['location_city']		= $city;
			$data['visit_times']		= $row['visit_times'] + 1;
			$data['update_time']		= RC_Time::gmtime();
			
			$db_mobile_device->where($device_data)->update($data);
		}
		return array();
		
	}
}

// end