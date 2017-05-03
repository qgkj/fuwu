<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 单条收货地址信息
 * @author royalwang
 */
class info_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
        //如果用户登录获取其session
        $this->authSession();
        $user_id = $_SESSION['user_id'];
    	if ($user_id <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
		$id = $this->requestData('address_id', 0);
		if(intval($id) < 1 || empty($user_id)){
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
		
		RC_Loader::load_app_func('admin_order', 'orders');

		$db_user_address = RC_Model::model('user/user_address_model');
		$db_region = RC_Model::model('shipping/region_model');
		$arr = $db_user_address->find(array('address_id' => $id, 'user_id' => $user_id));

		/* 验证地址id */
		if (empty($arr)) {
		    return new ecjia_error(13, '不存在的信息');
		}
		
		$consignee = get_consignee($user_id); // 取得默认地址
		
		$ids = array($arr['country'], $arr['province'], $arr['city'], $arr['district']);
		$ids = array_filter($ids);

		$data = $db_region->in(array('region_id' => implode(',', $ids)))->select();
		
		$out = array();
		foreach ($data as $key => $val) {
			$out[$val['region_id']] = $val['region_name'];
		}
		
		$result = array(
		    'id'         => $arr['address_id'],
		    'consignee'  => $arr['consignee'],
		    'email'      => $arr['email'],
		    
		    'country'    => $arr['country'],
		    'province'   => $arr['province'],
		    'city'       => $arr['city'],
		    'district'   => $arr['district'],
		    'location'	 => array(
		        'longitude' => $arr['longitude'],
		        'latitude'	=> $arr['latitude'],
		    ),
		    
		    'country_name'   => isset($out[$arr['country']]) ? $out[$arr['country']] : '',
		    'province_name'  => isset($out[$arr['province']]) ? $out[$arr['province']] : '',
		    'city_name'      => isset($out[$arr['city']]) ? $out[$arr['city']] : '',
		    'district_name'  => isset($out[$arr['district']]) ? $out[$arr['district']] : '',
		    
		    'address'        => $arr['address'],
		    'address_info'   => $arr['address_info'],
		    'zipcode'        => $arr['zipcode'],
		    'mobile'         => $arr['mobile'],
		    'sign_building'  => $arr['sign_building'],
		    'best_time'      => $arr['best_time'],
		    'default_address'=> $arr['default_address'],
		    'tel'            => $arr['tel'],
		    
		    'default_address'=> $arr['address_id'] == $consignee['address_id'] ? 1 :0,
		);
		
		return $result;		
	}
}

// end