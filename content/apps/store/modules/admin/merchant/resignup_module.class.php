<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 入驻申请信息修改
 * @author
 */
class resignup_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

        $responsible_person = $this->requestData('responsible_person');
        $email              = $this->requestData('email');
        $mobile             = $this->requestData('mobile');
        $seller_name        = $this->requestData('seller_name');
        $seller_category    = $this->requestData('seller_category');
        $validate_type      = $this->requestData('validate_type');
        $province           = $this->requestData('province');
        $city               = $this->requestData('city');
        $address            = $this->requestData('address');
        $longitude          = $this->requestData('longitude');
        $latitude           = $this->requestData('latitude');
        $validate_code      = $this->requestData('validate_code');

        // 判断验证码
        if (!empty($validate_code)) {
			/* 判断校验码*/
			if ($_SESSION['merchant_validate_code'] != $validate_code) {
				return new ecjia_error('validate_code_error', '校验码错误！');
			} elseif ($_SESSION['merchant_validate_expiry'] < RC_Time::gmtime()) {
				return new ecjia_error('validate_code_time_out', '校验码已过期！');
			} elseif ($_SESSION['merchant_validate_mobile'] != $mobile){
                return new ecjia_error('validate_mobile_error', '手机号码错误！');
            }
		}

        /* 查询入驻信息是否存在 */
		$info_store_preaudit = RC_DB::table('store_preaudit')->where('contact_mobile', $mobile)->first();
		if (empty($info_store_preaudit)) {
			return new ecjia_error('store_error', '您还未申请入驻！');
		}

        if(empty($province) || empty($city)){
            return new ecjia_error('address_error', '请选择地址');
        }elseif(empty($address)){
            return new ecjia_error('address_error', '请填写详细地址');
        }
        // 获取定位信息

        if(empty($longitude) || empty($latitude)){
            $location  = getgeohash($city, $address);
            $latitude  = $location['lat'];
            $longitude = $location['lng'];
        }
        $geohash      = RC_Loader::load_app_class('geohash', 'store');
        $geohash_code = $geohash->encode($latitude, $longitude);
        $geohash_code = substr($geohash_code, 0, 10);

        $data = array(
            'responsible_person' => $responsible_person,
            'email'              => $email,
            'merchants_name'     => $seller_name,
            'cat_id'             => $seller_category,
            'validate_type'      => $validate_type,
            'province'           => $province,
            'city'               => $city,
            'address'            => $address,
            'longitude'          => $longitude,
            'latitude'           => $latitude,
            'geohash'            => $geohash_code
        );

        RC_DB::table('store_preaudit')->where('contact_mobile', '=', $mobile)->update($data);
        //审核日志
        RC_Loader::load_app_func('merchant_franchisee', 'franchisee');
        add_check_log($data, $info_store_preaudit);
        
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