<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 店铺update信息
 * @author luchongchong
 *
 */
class update_module  extends api_admin implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
    	$this->authadminSession();
    	
		$seller_category	= isset($_POST['seller_category']) ? $_POST['seller_category'] : null;
		$seller_telephone	= isset($_POST['seller_telephone']) ? $_POST['seller_telephone'] : null;
		$province			= isset($_POST['provice']) ? $_POST['provice'] :null;
		$city				= isset($_POST['city']) ? $_POST['city'] : null;
		$seller_address		= isset($_POST['seller_address']) ? $_POST['seller_address'] : null;
		$seller_description	= isset($_POST['seller_description']) ? $_POST['seller_description'] : null;
		
		
		if (!$this->admin_priv('shop_config')) {
			return new ecjia_error('privilege_error', '对不起，您没有执行此项操作的权限！');
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
		return array();
    }	
    
}