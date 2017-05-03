<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class admin_main_hooks {
    
    
    public static function admin_dashboard_right_2() 
    {
	    $title = __('产品地址');

	    $index_url 	   = RC_Uri::home_url();
	    $h5_url 	   = RC_Uri::home_url().'/sites/m/';
	    $api_url       = RC_Uri::home_url().'/sites/api/';
	    $platform_url  = RC_Uri::home_url().'/sites/platform/';
	    $merchant_url  = RC_Uri::home_url().'/sites/merchant/'; 
	    $admin_url     = RC_Uri::home_url().'/sites/admincp/';
	    
	    $help_urls = array(
	    	'服务到家首页'       => $index_url,
	        '服务到家H5端'       => $h5_url,
	        '服务到家平台后台'    => $admin_url,
	        '服务到家商家后台'    => $merchant_url,
	        '服务到家API地址'    => $api_url,
	    );
	    
	    ecjia_admin::$controller->assign('title',      $title);
	    ecjia_admin::$controller->assign('help_urls',  $help_urls);
	    
	    ecjia_admin::$controller->display(RC_Package::package('app::main')->loadTemplate('admin/library/widget_admin_dashboard_product_help.lbi', true));
	}

	public static function set_daojia_admin_cpname($name) 
	{
	    return '服务到家';
	}
	
	public static function set_daojia_admin_welcome()
	{
	    if (1) {
	        $ecjia_version = RC_Config::get('release.version');
	        $ecjia_release = RC_Config::get('release.build');
	        $ecjia_welcome_logo = RC_Uri::admin_url('statics/images/ecjiawelcom.png');
	        $ecjia_about_url = RC_Uri::url('@index/about_us');
	        $welcomeecjia 	= __('欢迎使用服务到家');
	        $description 	= __("服务到家");
	        $more 			= __('了解更多 »');
	        $welcome = <<<WELCOME
		  <div>
			<a class="close m_r10" data-dismiss="alert">×</a>
			<div class="hero-unit">
				<div class="row-fluid">
					<div class="span3">
						<img src="{$ecjia_welcome_logo}" />
					</div>
					<div class="span9">
						<h1>{$welcomeecjia}</h1>
						<p>{$description}</p>
						<a class="btn btn-info" href="{$ecjia_about_url}" target="_self">{$more}</a>
					</div>
				</div>
			</div>
		</div>
WELCOME;
	        echo $welcome;
	    }
	}
}

RC_Hook::add_action( 'admin_dashboard_right', array('admin_main_hooks', 'admin_dashboard_right_2') );
RC_Hook::add_filter( 'ecjia_admin_cpname', array('admin_main_hooks', 'set_daojia_admin_cpname') );
RC_Hook::remove_action( 'admin_dashboard_top', array('ecjia_admin', 'display_admin_welcome'), 9 );
RC_Hook::add_action( 'admin_dashboard_top', array('admin_main_hooks', 'set_daojia_admin_welcome') );

// end