<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 收货地址管理接口
 * @author 
 */
class user_address_manage_api extends Component_Event_Api {
    
    public function call(&$address) {
        if (!is_array($address) 
	        || !isset($address['user_id'])
	        || !isset($address['address'])
	        || !isset($address['consignee'])
	        || (!isset($address['mobile']) && !isset($address['tel']))
        ) {
            return new ecjia_error('invalid_parameter', '参数无效');
        }
        
        /* 验证参数的合法性*/
        /* 邮箱*/
        if (!empty($address['email'])) {
        	if (!$this->is_email($address['email'])) {
        		return new ecjia_error('invalid_email', 'email地址格式错误');
        	}
        }
        
        if (!empty($address['province']) && !empty($address['city']) && !empty($address['address']) && empty($address['location'])) {
        	$db_region   = RC_Model::model('user/region_model');
        	$region_name = $db_region->where(array('region_id' => array('in' => array($address['province'], $address['city'], $address['district']))))->order('region_type')->select();
        	 
        	$province_name	   = $region_name[0]['region_name'];
        	$city_name		   = $region_name[1]['region_name'];
        	$district_name	   = $region_name[2]['region_name'];
        	$consignee_address = $province_name.'省'.$city_name.'市'.$address['address'];

        	$shop_point = file_get_contents("https://api.map.baidu.com/geocoder/v2/?address='".$consignee_address."'&output=json&ak=E70324b6f5f4222eb1798c8db58a017b");

        	$shop_point = json_decode($shop_point);
        	if (!empty($shop_point->result)) {
        		$shop_point_result = $shop_point->result;
        		$location = $shop_point_result->location;
        
        		$address['longitude']	= $location->lng;
        		$address['latitude']	= $location->lat;
        		unset($address['location']);
        	}
        } else {
        	$address['longitude']	= $address['location']['longitude'];
        	$address['latitude']	= $address['location']['latitude'];
        }
     
        /* 获取用户地址 */
        $db_user_address = RC_Model::model('user/user_address_model');
        $user_address = $db_user_address->where(array('address_id' => $address['address_id'], 'user_id' => $_SESSION['user_id']))->get_field('address_id');
        
        if ($address['address_id'] != $user_address) {
        	return new ecjia_error('not_exists_info', '不存在的信息');
        }
        
        $address_id = $this->update_address($address);
        return $address_id;
    }
       
    /**
     * 验证输入的邮件地址是否合法
     *
     * @access public
     * @param string $email
     *            需要验证的邮件地址
     * @return bool
     */
    private function is_email($email)
    {
    	$chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
    	if (strpos($email, '@') !== false && strpos($email, '.') !== false) {
    		if (preg_match($chars, $email))
    			return true;
    	}
    	return false;
    }
    
    /**
     *  添加或更新指定用户收货地址
     *
     * @access  public
     * @param   array       $address
     * @return  bool
     */
    private function update_address($address)
    {
    	$db_user_address = RC_Model::model('user/user_address_model');
    
    	$address_id = 0;
    	if (isset($address['address_id'])) {
    		$address_id = intval($address['address_id']);
    		unset($address['address_id']);
    	}
    	
    	//验证是否重复
    	$where = array(
    	    'address_id' => array('neq' => $address_id),
    	    'user_id'   =>  $address['user_id'],
    	    'consignee' =>  $address['consignee'],
    	    'email'     =>  $address['email'],
    	    'country'   =>  $address['country'],
    	    'province'  =>  $address['province'],
    	    'city'      =>  $address['city'],
    	    'district'  =>  $address['district'],
    	    'address'   =>  $address['address'],
    	    'address_info' =>  $address['address_info'],
    	    'zipcode'   =>  $address['zipcode'],
    	    'tel'       =>  $address['tel'],
    	    'mobile'    =>  $address['mobile'],
    	    
    	);
    	if ($db_user_address->where($where)->count()) {
    	    return new ecjia_error('address_repeat', '收货地址信息重复，请修改！');
    	}
    	
    	if ($address_id > 0) {
    		$address['district'] = empty($address['district']) ? '' : $address['district'];
    		
    		/* 更新指定记录 */
    		$db_user_address->where(array('address_id' => $address_id, 'user_id' => $address['user_id']))->update($address);
    		
    	} else {
    		/* 插入一条新记录 */
    		$address_id = $db_user_address->insert($address);
    	}
    
    	if (isset($address['default']) && $address['default'] > 0 && isset($address['user_id'])) {
    		$db_user = RC_Model::model('user/users_model');
    		$db_user->where(array('user_id' => $address['user_id']))->update(array('address_id' => $address_id));
    	}
    
    	return $address_id;
    }
}

// end