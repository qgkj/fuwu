<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 二维码登录验证绑定
 * @author will.chen
 */
class bind_module extends api_front implements api_interface {

	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authSession();
    	
		$code         = $this->requestData('code');
		$device		  = $this->device;
		$type         = $this->requestData('type');
		if (empty($code) || empty($type)) {
			return new ecjia_error(101, '参数错误');
		}
		//判断是管理员还是普通用户
		$is_admin = in_array($device['code'], array('8001', '5001', '5002', '2001', '2002')) ? 1 : 0;
		$db       = RC_Model::model('mobile/qrcode_validate_model');
		$where    = array(
				'is_admin'   => $is_admin,
				'uuid'		 => $code,
				'status'	 => 1,
				'expires_in' => array('gt' => RC_Time::gmtime()), 
		);
		$result = $db->find($where);
		if (empty($result)) {
			return new ecjia_error(8, 'fail');
		}
		//判断是管理员还是普通用户
		$user_id = $is_admin == 1 ? $_SESSION['admin_id'] : $_SESSION['user_id'];
		//判断是授权还是取消
		$status = $type == 'bind' ? 2 : 3;
		$result = $db->where($where)->update(array('status' => $status, 'user_id' => $user_id));
		return array();
	}
}

// end