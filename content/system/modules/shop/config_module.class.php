<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class config_module extends api_front implements api_interface
{

    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
    	$db_region = RC_Loader::load_app_model('region_model', 'shipping');
    	
    	$mobile_recommend_city = explode(',', ecjia::config('mobile_recommend_city'));
    	
    	$regions = array ();
    	$region_data = $db_region->where(array('region_id' => $mobile_recommend_city ))->select();
    	if (!empty($region_data)) {
    		foreach ( $region_data as $val ) {
    			$regions[] = array(
    					'id'	=> $val['region_id'],
    					'name'	=> $val['region_name']
    			);
    		}	
    	}
    	
        $data = array(
            'service_phone'     => ecjia::config('service_phone'),
            'service_qq'        => ecjia::config('qq', ecjia::CONFIG_EXISTS) ? explode(',', ecjia::config('qq')) : array(),
            'site_url'          => ecjia::config('shop_pc_url', ecjia::CONFIG_EXISTS) ? ecjia::config('shop_pc_url') : RC_Config::load_config('site', 'CUSTOM_SITE_URL'),
            'goods_url'         => ecjia::config('shop_touch_url', ecjia::CONFIG_EXISTS) ? ecjia::config('shop_touch_url').'?m=goods&c=index&a=init&id=' : (ecjia::config('shop_pc_url', ecjia::CONFIG_EXISTS) ? ecjia::config('shop_pc_url') : RC_Config::system('CUSTOM_WEB_SITE_URL') . '/goods.php?id='),
            'shop_closed'       => ecjia::config('shop_closed'),
            'close_comment'     => ecjia::config('close_comment'),
            'shop_reg_closed'   => ecjia::config('shop_reg_closed'),
        	'shop_name'			=> ecjia::config('shop_name'),
            'shop_desc'         => ecjia::config('shop_desc'),
        	'shop_address'		=> ecjia::config('shop_address'),
            'currency_format'   => ecjia::config('currency_format'),
            'time_format'       => ecjia::config('time_format'),
        	'get_password_url'	=> RC_Uri::url('user/get_password/forget_pwd', 'type=mobile'),
        	'recommend_city'	=> $regions,
        	'bonus_readme_url'	=> RC_Uri::site_url().ecjia::config('bonus_readme_url'),
        );
        
        $result = ecjia_app::validate_application('sms');
        $is_active = ecjia_app::is_active('ecjia.sms');
         
        if (is_ecjia_error($result) && !$is_active) {
        	$data['get_password_url'] = RC_Uri::url('user/get_password/forget_pwd', 'type=email');
        }
        
        $device	= $this->device;
        if (isset($device['client']) && ($device['client'] == 'iphone' || $device['client'] == 'android')) {
        	$data = array_merge($data, array(
        			'mobile_phone_login_fgcolor' => ecjia::config('mobile_phone_login_fgcolor'),		//前景颜色
        			'mobile_phone_login_bgcolor' => ecjia::config('mobile_phone_login_bgcolor'),		//背景颜色
        			'mobile_phone_login_bgimage' => ecjia::config('mobile_phone_login_bgimage', ecjia::CONFIG_EXISTS) ?	RC_Upload::upload_url().'/'.ecjia::config('mobile_phone_login_bgimage') : '',		//背景图片
        	));
        }
        if (isset($device['client']) && $device['client'] == 'ipad') {
        	$data = array_merge($data, array(
        			'mobile_pad_login_fgcolor' => ecjia::config('mobile_pad_login_fgcolor'),			//前景颜色
        			'mobile_pad_login_bgcolor' => ecjia::config('mobile_pad_login_bgcolor'),			//背景颜色
        			'mobile_pad_login_bgimage' => ecjia::config('mobile_pad_login_bgimage', ecjia::CONFIG_EXISTS) ?	RC_Upload::upload_url().'/'.ecjia::config('mobile_pad_login_bgimage') : '',		//背景图片
        	));
        }
        if (isset($device['client']) && $device['client'] == 'iphone') {
        	$mobile_iphone_qr_code = ecjia::config('mobile_iphone_qr_code');
        	$data['mobile_qr_code']	= !empty($mobile_iphone_qr_code) ? RC_Upload::upload_url().'/'.$mobile_iphone_qr_code : '';
        } elseif(isset($device['client']) && $device['client'] == 'android') {
        	$mobile_android_qr_code = ecjia::config('mobile_android_qr_code');
        	$data['mobile_qr_code']	= !empty($mobile_android_qr_code) ? RC_Upload::upload_url().'/'.$mobile_android_qr_code : '';
        } else {
        	$mobile_ipad_qr_code = ecjia::config('mobile_ipad_qr_code');
        	$data['mobile_qr_code']	= !empty($mobile_ipad_qr_code) ? RC_Upload::upload_url().'/'.$mobile_ipad_qr_code : '';
        }
        
        $data['mobile_app_icon'] = ecjia::config('shop_app_icon', ecjia::CONFIG_EXISTS) ? RC_Upload::upload_url() . '/' . ecjia::config('shop_app_icon') : '';
        $shop_type = RC_Config::load_config('site', 'SHOP_TYPE');
        $data['shop_type'] = !empty($shop_type) ? $shop_type : 'b2c';
        
        return $data;
    }
}


// end