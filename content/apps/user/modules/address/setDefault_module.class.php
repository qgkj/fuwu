<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 设置默认收货地址
 * @author royalwang
 */
class setDefault_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
        //如果用户登录获取其session
        $this->authSession();
        $user_id = $_SESSION['user_id'];
    	if ($user_id <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
		$address_id = $this->requestData('address_id', 0);
		if (empty($address_id) || empty($user_id)) {
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
		
		$db_user_address = RC_Model::model('user/user_address_model');
		$db_users = RC_Model::model('user/users_model');
		
		$arr = $db_user_address->find(array('address_id' => $address_id, 'user_id' => $user_id));
		if (empty($arr)) {
			return new ecjia_error(8, 'fail');
		}
		
		/* 保存到session */
		$db_users->where(array('user_id' => $user_id))->update(array('address_id' => $address_id));
		return array();
	}
}

// end