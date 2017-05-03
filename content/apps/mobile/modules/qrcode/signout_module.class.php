<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 二维码登录验证解绑
 * @author will.chen
 */
class signout_module extends api_front implements api_interface {

	 public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$this->authSession();
    	
		$code = $this->requestData('code');
		if (empty($code)) {
			return new ecjia_error(101, '参数错误');
		}
		$db = RC_Model::model('mobile/qrcode_validate_model');
		$where = array(
				'session_id' => RC_Session::session()->get_session_id(),
				'uuid'		 => $code,
				'status'	 => 1,
				'expires_in' => array('gt' => RC_Time::gmtime()), 
		);
		
		$result = $db->where($where)->update(array('status' => 3));
		return array();
	}
}

// end