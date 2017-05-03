<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 店铺信息
 * @author luchongchong
 *
 */
class info_module extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
		$this->authadminSession();
    	
		$region = RC_Loader::load_app_model('region_model', 'shipping');
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
		return $seller_info;
    }	
    
}