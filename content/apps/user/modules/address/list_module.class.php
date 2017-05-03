<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 所有收货地址列表
 * @author royalwang
 */
class list_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
        //如果用户登录获取其session
        $this->authSession();
        $user_id = $_SESSION['user_id'];
    	if ($user_id <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
		
		$db_user_address = RC_Model::model('user/user_address_model');
		$dbview_user_address = RC_Model::model('user/user_address_user_viewmodel');
		$db_region = RC_Model::model('shipping/region_model');
		
		$size = $this->requestData('pagination.count', 15);
		$page = $this->requestData('pagination.page', 1);
		$record_count = $db_user_address->where(array('user_id' => $user_id))->count();
		
		//实例化分页
		$page_row = new ecjia_page($record_count, $size, 6, '', $page);
		
		$field = 'ua.*, IFNULL(u.address_id, 0) as is_default_address';
		$consignee_list = $dbview_user_address->field($field)->where(array('ua.user_id' => $user_id))->order(array('is_default_address' => 'desc', 'address_id' => 'desc'))->limit($page_row->limit())->select();
	
		$result = array();
		if (!empty($consignee_list)) {
			foreach ($consignee_list as $key => $value) {
			
				$result[$key]['id'] = $value['address_id'];
				$result[$key]['consignee'] = $value['consignee'];
				$result[$key]['address'] = $value['address'];
				$result[$key]['address_info'] = $value['address_info'];
			
				$country = $value['country'];
				$province = $value['province'];
				$city = $value['city'];
				$district = $value['district'];
	
				$region_name = $db_region->where(array('region_id' => array('in'=>$country,$province,$city,$district)))->order('region_type')->select();
				
				$result[$key]['country_name']    = $region_name[0]['region_name'];
				$result[$key]['province_name']   = $region_name[1]['region_name'];
				$result[$key]['city_name']       = $region_name[2]['region_name'];
				$result[$key]['district_name']   = isset($region_name[3]['region_name']) ? $region_name[3]['region_name'] : '';
				$result[$key]['tel']   			 = $value['tel'];
				$result[$key]['mobile']   		 = $value['mobile'];
				$result[$key]['location']		 = array(
														'longitude' => $value['longitude'],
														'latitude'	=> $value['latitude'],
												   );
				
				if ($value['is_default_address'] > 0 ) {
					$result[$key]['default_address'] = 1;
				} else {
					$result[$key]['default_address'] = 0;
				}
			}
		}
		
		return $result;
	}
}

// end