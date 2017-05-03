<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 店铺信息
 * @author luchongchong
 */
class info_module extends api_admin implements api_interface {
    
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
		    return new ecjia_error(100, 'Invalid session');
		}
		
    	if($_SESSION['store_id'] > 0) {
			$region = RC_Model::model('shipping/region_model');
			$where = array();
			/* if(substr($info['shop_logo'], 0, 1) == '.') {
				$info['shop_logo'] = str_replace('../', '/', $info['shop_logo']);
			} */
// 			$is_validated = (!empty($info['create_time']) && !empty($info['confirm_time'])) ? 1 : 0;
			
			$info = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->first();
			
			$shop_trade_time = RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'shop_trade_time')->pluck('value');
			$shop_trade_time = !empty($shop_trade_time) ? unserialize($shop_trade_time) : array('start' => '8:00', 'end' => '21:00');
			$seller_info = array(
	    	  		'id'					=> $info['store_id'],
	    	  		'seller_name'			=> $info['merchants_name'],
	    	  		'seller_logo'			=> RC_Upload::upload_url(RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'shop_logo')->pluck('value')),
	    	  		'seller_category'		=> RC_DB::table('store_category')->where('cat_id', $info['cat_id'])->pluck('cat_name'),
	    	  		'seller_telephone'		=> RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'shop_kf_mobile')->pluck('value'),
	    	  		'seller_province'		=> $region->where(array('region_id' => $info['province']))->get_field('region_name'),
	    	  		'seller_city'			=> $region->where(array('region_id' => $info['city']))->get_field('region_name'),
			        'seller_district'		=> $region->where(array('region_id' => $info['district']))->get_field('region_name'),
	    	  		'seller_address'		=> $info['address'],
					'validated_status'		=> $info['identity_status'],
	    	  		'seller_description'	=> RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'shop_description')->pluck('value'),
					'seller_notice'			=> RC_DB::table('merchants_config')->where('store_id', $_SESSION['store_id'])->where('code', 'shop_notice')->pluck('value'),
					'trade_time'			=> $shop_trade_time
			);
			$result = $this->admin_priv('franchisee_manage');
			if (is_ecjia_error($result)) {
				$privilege = 1;
// 				Read & Write   3
// 				Read only      1
// 				No Access      0
			} else {
				$privilege = 3;
			}
    	 } else {
			$region = RC_Model::model('shipping/region_model');
			$seller_info = array(
					'id'					=> 0,
	    	  		'seller_name'			=> ecjia::config('shop_name'),
	    	  		'seller_logo'			=> ecjia::config('shop_logo', ecjia::CONFIG_EXISTS) ? RC_Upload::upload_url().'/'.ecjia::config('shop_logo') : '',
	    	  		'seller_category'		=> null,
 	    	  		'seller_telephone'		=> ecjia::config('service_phone'),
 	    	  		'seller_province'		=> $region->where(array('region_id'=>ecjia::config('shop_province')))->get_field('region_name'),
 	    	  		'seller_city'			=> $region->where(array('region_id'=>ecjia::config('shop_city')))->get_field('region_name'),
	    	
	    	  		'seller_address'		=> ecjia::config('shop_address'),
	    	  		'seller_description'	=> strip_tags(ecjia::config('shop_notice'))
			);
			$result = $this->admin_priv('shop_config');
			if (is_ecjia_error($result)) {
				$privilege = 1;
			} else {
				$privilege = 3;
			}
		}
		return array('data' => $seller_info, 'privilege' => $privilege);
    }
}

//end