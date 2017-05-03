<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 二维码扫描登录创建二维码图片链接
 * @author will.chen
 */
class create_module extends api_front implements api_interface {

	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$this->authSession();
    	
		$device		  = $this->device;
		if (empty($device['udid']) || empty($device['client']) || empty($device['code'])) {
			return new ecjia_error(101, '参数错误');
		}
		$charset 		= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$charset_len    = strlen($charset)-1;
		$code           = 'EC';
		for ($i = 0; $i < 10; $i++) {
			$code .= $charset[rand(1, $charset_len)];
		}
		$is_admin = $device['code'] == '8001' ? 1 : 0;
		$db       = RC_Model::model('mobile/qrcode_validate_model');
		$db->insert(array(
				'user_id' => '',
				'is_admin'      => $is_admin,
				'uuid'		    => $code,
				'status'	    => 0,
				'expires_in'    => RC_Time::gmtime() + 600,
				'device_udid'   => $device['udid'],
				'device_client' => $device['client'],
				'device_code'	=> $device['code'],
		));
		
		$url = RC_Uri::url('mobile/index/init', array('qrcode' => $code));
		return array('qrcode_img' => $url);
	}
}

// end