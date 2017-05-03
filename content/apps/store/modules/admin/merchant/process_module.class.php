<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 申请商家入驻查询进度
 * @author will.chen
 */
class process_module  extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$mobile 		= $this->requestData('mobile');
    	$validate_code	= $this->requestData('validate_code');

        if (empty($mobile) || empty($validate_code)) {
        	return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
    	}
    	
    	/* 判断校验码*/
    	if ($_SESSION['merchant_validate_code'] != $validate_code) {
    		return new ecjia_error('validate_code_error', '校验码错误！');
    	} elseif ($_SESSION['merchant_validate_expiry'] < RC_Time::gmtime()) {
    		return new ecjia_error('validate_code_time_out', '校验码已过期！');
    	}

    	$info_store_preaudit = RC_DB::table('store_preaudit')->where(RC_DB::raw('contact_mobile'), $mobile)->first();
    	$info_store_franchisee = RC_DB::table('store_franchisee')->where(RC_DB::raw('contact_mobile'), $mobile)->first();

    	if (empty($info_store_preaudit) && empty($info_store_franchisee)) {
    		return new ecjia_error('merchant_errors', '您还未申请商家入驻！');
    	}
    	
    	if (!empty($info_store_preaudit)) {
    		return array(
    				'check_status'	=> $info_store_preaudit['check_status'], 
    				'merchant_info' => array(
    						'responsible_person'	=> $info_store_preaudit['responsible_person'],
    						'email'					=> $info_store_preaudit['email'],
    						'mobile'				=> $info_store_preaudit['contact_mobile'],
    						'seller_name'			=> $info_store_preaudit['merchants_name'],
    						'seller_category'		=> RC_DB::table('store_category')->where('cat_id', $info_store_preaudit['cat_id'])->pluck('cat_name'),
    						'address'				=> RC_DB::table('region')->where('region_id', $info_store_preaudit['province'])->pluck('region_name').RC_DB::table('region')->where('region_id', $info_store_preaudit['city'])->pluck('region_name').RC_DB::table('region')->where('region_id', $info_store_preaudit['district'])->pluck('region_name').$info_store_preaudit['address'],
    				        'remark'                => $info_store_preaudit['remark'],
    				)
    		);
    	} elseif (!empty($info_store_franchisee)) {
    		return array(
    				'check_status'	=> 2,
    				'merchant_info' => array(
    						'responsible_person'	=> $info_store_franchisee['responsible_person'],
    						'email'					=> $info_store_franchisee['email'],
    						'mobile'				=> $info_store_franchisee['contact_mobile'],
    						'seller_name'			=> $info_store_franchisee['merchants_name'],
    						'seller_category'		=> RC_DB::table('store_category')->where('cat_id', $info_store_franchisee['cat_id'])->pluck('cat_name'),
    						'address'				=> RC_DB::table('region')->where('region_id', $info_store_preaudit['province'])->pluck('region_name').RC_DB::table('region')->where('region_id', $info_store_preaudit['city'])->pluck('region_name').RC_DB::table('region')->where('region_id', $info_store_franchisee['district'])->pluck('region_name').$info_store_franchisee['address'],
    				        'remark'                => $info_store_franchisee['remark'],
    				)
    		);
    		
    	}
    }
}

//end