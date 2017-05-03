<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 添加收货地址
 * @author royalwang
 */
class add_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
        
        //如果用户登录获取其session
        $this->authSession();
        $user_id = $_SESSION['user_id'];
    	if ($user_id <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
		$address = $this->requestData('address', array());
		if (empty($address) || empty($user_id)) {
		    return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
		
		$address['user_id']       = $_SESSION['user_id'];
		$address['consignee']     = isset($address['consignee']) ? trim($address['consignee']) : '';
// 		$address['country']       = isset($address['country']) ? intval($address['country']) : '';
// 		$address['province']      = isset($address['province']) ? intval($address['province']) : '';
		$address['city']      	  = isset($address['city']) ? intval($address['city']) : '';
		$address['district']      = isset($address['district']) ? intval($address['district']) : '';
		$address['email']         = !empty($address['email']) ? trim($address['email']) : '';
		$address['mobile']        = isset($address['mobile']) ? trim($address['mobile']) : '';
		$address['address']       = isset($address['address']) ? trim($address['address']) : '';
		$address['address_info']  = isset($address['address_info']) ? trim($address['address_info']) : '';
		$address['best_time']     = isset($address['best_time']) ? trim($address['best_time']) : '';
		$address['default']       = (isset($address['set_default']) && $address['set_default'] == 'true') ? 1 : 0;
		$address['sign_building'] = isset($address['sign_building']) ? trim($address['sign_building']) : '';
		$address['tel'] 		  = isset($address['tel']) ? trim($address['tel']) : '';
		
		$address['province']	  = RC_Model::model('user/region_model')->where(array('region_id' => $address['city']))->get_field('parent_id');
		$address['country']		  = RC_Model::model('user/region_model')->where(array('region_id' => $address['province']))->get_field('parent_id');
		$result = RC_Api::api('user', 'address_manage', $address);
	
		if (is_ecjia_error($result)) {
			return $result;
		}
		return array('address_id' => $result);
	}	
}

// end