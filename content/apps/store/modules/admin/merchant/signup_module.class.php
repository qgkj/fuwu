<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 申请商家入驻
 * @author will.chen
 */
class signup_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
        $this->authadminSession();
		$responsible_person = $this->requestData('responsible_person', '');
		$email 				= $this->requestData('email', '');
		$mobile				= $this->requestData('mobile', '');
		$seller_name		= $this->requestData('seller_name', '');
		$seller_category	= $this->requestData('seller_category', '');
		$validate_type		= $this->requestData('validate_type');
		$province			= $this->requestData('province');
		$city				= $this->requestData('city');
		$district			= $this->requestData('district');
		$address			= $this->requestData('address');
		$longitude			= $this->requestData('location.longitude');
		$latitude			= $this->requestData('location.latitude');
		$validate_code	    = $this->requestData('validate_code');


		if (empty($responsible_person) || empty($email) || empty($mobile) || empty($seller_name) || empty($seller_category)
		     || empty($validate_type) || empty($province) || empty($city)|| empty($district) || empty($address) || empty($longitude) || empty($latitude)) {
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}

        $preaudit_count   = RC_DB::table('store_preaudit')->where('email', '=', $email)->count();
        $franchisee_count = RC_DB::table('store_franchisee')->where('email', '=', $email)->count();
        if(!empty($preaudit_count) || !empty($franchisee_count)){
            return new ecjia_error('validate_email_error', '邮箱地址已经被使用，请填写其他邮箱地址');
        }

        // RC_Logger::getLogger('error')->error($_SESSION['merchant_validate_code'].'signup_module: 37 line');
        // RC_Logger::getLogger('error')->error($validate_code.'signup_module: 38 line');
		/* 判断校验码*/
		if ($_SESSION['merchant_validate_code'] != $validate_code) {
			return new ecjia_error('validate_code_error', '校验码错误！');
		} elseif ($_SESSION['merchant_validate_expiry'] < RC_Time::gmtime()) {
			return new ecjia_error('validate_code_time_out', '校验码已过期！');
		} elseif ($_SESSION['merchant_validate_mobile'] != $mobile) {
			return new ecjia_error('validate_mobile_error', '手机号码已经更改请重新获取验证码');
		}

        if(empty($longitude) || empty($latitude)){
            $location  = getgeohash($city, $address);
            $latitude  = $location['lat'];
            $longitude = $location['lng'];
        }
        $geohash      = RC_Loader::load_app_class('geohash', 'store');
        $geohash_code = $geohash->encode($latitude, $longitude);
        $geohash_code = substr($geohash_code, 0, 10);


		$info_store_preaudit	= RC_DB::table('store_preaudit')->where(RC_DB::raw('contact_mobile'), $mobile)->first();
		$info_store_franchisee	= RC_DB::table('store_franchisee')->where(RC_DB::raw('contact_mobile'), $mobile)->first();
		$info_staff_user		= RC_DB::table('staff_user')->where('mobile', $mobile)->first();
		if (!empty($info_store_preaudit) || !empty($info_store_franchisee)) {
			return new ecjia_error('already_signup', '您已申请请勿重复申请！');
		}
        if(!empty($info_staff_user)){
            return new ecjia_error('already_signup', '改手机号码已被注册为店铺员工');
        }

		$merchant_shop_data = array(
				'responsible_person'	=> $responsible_person,
				'merchants_name'		=> $seller_name,
				'contact_mobile'		=> $mobile,
				'email'					=> $email,
				'check_status'			=> 1,
				'apply_time'			=> RC_Time::gmtime(),
				'store_id'				=> 0,
				'cat_id'				=> $seller_category,
				'validate_type'			=> $validate_type,
				'province'				=> $province,
				'city'					=> $city,
				'district'				=> $district,
				'address'				=> $address,
				'longitude'				=> $longitude,
				'latitude'				=> $latitude,
		);
		
		$insert_id = RC_DB::table('store_preaudit')->insertGetId($merchant_shop_data);
		//审核日志
		RC_Loader::load_app_func('merchant_franchisee', 'franchisee');
		add_check_log($merchant_shop_data, '', $insert_id);

		unset($_SESSION['merchant_validate_code']);
		unset($_SESSION['merchant_validate_expiry']);
		return array();
    }

}

/**
 * 根据地区获取经纬度
 */
function getgeohash($city, $address){
    $shop_province      = !empty($province)    ? intval($province)           : 0;
    $shop_city          = !empty($city)        ? intval($city)               : 0;
    $shop_address       = !empty($address)     ? htmlspecialchars($address)  : 0;

    $city_name              = RC_DB::table('region')->where('region_id', $shop_city)->pluck('region_name');
    $city_district          = RC_DB::table('region')->where('region_id', $shop_district)->pluck('region_name');
    $address                = $city_name.'市'.$shop_address;
    $shop_point             = file_get_contents("https://api.map.baidu.com/geocoder/v2/?address='".$address."&output=json&ak=E70324b6f5f4222eb1798c8db58a017b");
    $shop_point             = (array)json_decode($shop_point);
    $shop_point['result']   = (array)$shop_point['result'];
    $location               = (array)$shop_point['result']['location'];
    return $location;
}

//end