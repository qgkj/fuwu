<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 店铺update信息
 * @author 
 */
class update_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) 
    { 
    	$this->authadminSession();
    	if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
    	//$ssi_db				= RC_Loader::load_app_model('seller_shopinfo_model', 'seller');
    	//$msi_category_db 	= RC_Loader::load_app_model('merchants_shop_information_model', 'seller');
		
		//$seller_category 	= $this->requestData('seller_category', '');
		$seller_telephone 	= $this->requestData('seller_telephone', '');
// 		$province		 	= $this->requestData('provice', '');
// 		$city				= $this->requestData('city', '');
// 		$seller_address		= $this->requestData('seller_address', '');
		$seller_description = $this->requestData('seller_description', '');
		$seller_notice		= $this->requestData('seller_notice');
		$trade_time			= $this->requestData('trade_time');
		
		
		if ($_SESSION['store_id'] > 0) {
			$result1 = $this->admin_priv('franchisee_manage');
			$result2 = $this->admin_priv('merchant_manage');
			
			if (is_ecjia_error($result1) || is_ecjia_error($result2)) {
				return $result1;
			}
			
			RC_Loader::load_app_func('global', 'store');
			assign_adminlog_content();
			
			$data_franchisee = array();
			
// 			if (isset($province) && !empty($province)) {
// 			 	$data_franchisee['province'] = $province;
// 			}
// 			if (isset($city)) {
// 			 	$data_franchisee['city'] = $city;
// 			}	
// 			if (isset($seller_address)) {
// 				$data_franchisee['address'] = $seller_address;
// 			}
			
			if (isset($trade_time['start']) && isset($trade_time['end']) && !empty($trade_time['start']) && !empty($trade_time['end'])) {
				$seller_trade_time = serialize($trade_time);
				RC_DB::table('merchants_config')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->where(RC_DB::raw('code'), 'shop_trade_time')->update(array('value' => $seller_trade_time));
			}
			
			//$count_category = $msi_category_db->where($where1)->update($data_category);
			//$count_shopinfo = $ssi_db->where($where2)->update($data_shopinfo);
// 			RC_DB::table('store_franchisee')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->update($data_franchisee);
			RC_DB::table('merchants_config')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->where(RC_DB::raw('code'), 'shop_kf_mobile')->update(array('value' => $seller_telephone));
			RC_DB::table('merchants_config')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->where(RC_DB::raw('code'), 'shop_description')->update(array('value' => $seller_description));
			RC_DB::table('merchants_config')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->where(RC_DB::raw('code'), 'shop_notice')->update(array('value' => $seller_notice));
			
// 			ecjia_merchant::admin_log('店铺设置>基本信息设置【来源掌柜】', 'edit', 'config');
			RC_Api::api('merchant', 'admin_log', array('text'=>'店铺设置>基本信息设置【来源掌柜】', 'action'=>'edit', 'object'=>'config'));
	    	return true;
	    	
		} else {
			$result = $this->admin_priv('shop_config');
			if (is_ecjia_error($result)) {
				return $result;
			}
			if (isset($seller_telephone)) {
				ecjia_config::instance()->write_config('service_phone', $seller_telephone);
			}
			if(isset($province)){
				ecjia_config::instance()->write_config('shop_province', $province);
			}
			if(isset($city)){
				ecjia_config::instance()->write_config('shop_city', $city);
			}
			if (isset($seller_address)) {
				ecjia_config::instance()->write_config('shop_address', $seller_address);
			}
			if (isset($seller_description)) {
				ecjia_config::instance()->write_config('shop_notice', $seller_description);
			}
			ecjia_admin::admin_log('控制面板>系统设置>商店设置【来源掌柜】', 'edit', 'shop_config');
			return true;
		}
    }	
}

//end