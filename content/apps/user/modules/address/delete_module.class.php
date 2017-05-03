<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 删除收货地址
 * @author royalwang
 */
class delete_module extends api_front implements api_interface {
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
		
		if (!drop_consignee($address_id, $user_id)) {
			return new ecjia_error(8, 'fail');
		}
		return array();
	}
}

/**
 * 删除一个收货地址
 *
 * @access public
 * @param integer $id
 * @return boolean
 */
function drop_consignee($id, $user_id) {
    return RC_Model::model('user/user_address_model')->where(array('address_id' => $id, 'user_id' => $user_id))->delete();
}

// end