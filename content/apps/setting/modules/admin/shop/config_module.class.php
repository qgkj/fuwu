<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class config_module extends api_admin implements api_interface
{

    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
    	/*shop_name，店铺名称
		shop_desc，	店铺描述
		shop_address，店铺详细地址
		shop_phone，电话
		shop_email，	邮箱
		shop_closed，商店是否关闭
		close_comment 评论是否关闭
		shop_reg_close 注册是否关闭
		currency_format 价格格式
		time_format  时间格式
		site_url，	店铺网站
		*/
        $data = array(
        	'shop_name'			=> ecjia::config('shop_name'),
        	'shop_desc'			=> ecjia::config('shop_desc'),
        	'shop_address'		=> ecjia::config('shop_address'),
        	'service_phone' 	=> ecjia::config('service_phone'),
        	'shop_email'		=> ecjia::config('service_email'),
        	'shop_closed'       => ecjia::config('shop_closed'),
        	'close_comment'     => ecjia::config('close_comment'),
        	'shop_reg_closed'   => ecjia::config('shop_reg_closed'),
        	'currency_format'   => ecjia::config('currency_format'),
            'time_format'       => ecjia::config('time_format'),
        	'site_url'			=> RC_Config::system('CUSTOM_WEB_SITE_URL'),
        	'goods_url'         => ecjia::config('mobile_touch_url', ecjia::CONFIG_EXISTS) ? ecjia::config('mobile_touch_url').'?m=goods&c=index&a=init&id=' : (ecjia::config('mobile_pc_url', ecjia::CONFIG_EXISTS) ? ecjia::config('mobile_pc_url') : RC_Config::system('CUSTOM_WEB_SITE_URL') . '/goods.php?id='),
        );
        
        return $data;
    }
}


// end