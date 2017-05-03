<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class merchant_merchant_hooks {

    public static function ecjia_builtin_app_bundles($apps) {
        $merchant_apps = RC_Config::get('merchant.apps');
        return $merchant_apps;
    }
    
    
    public static function ecjia_merchant_dashboard_contact() {
        ecjia_merchant::$controller->display(
		    RC_Package::package('app::merchant')->loadTemplate('merchant/library/widget_merchant_dashboard_contact.lbi', true)
		);
    }

}

RC_Hook::add_filter( 'ecjia_builtin_app_bundles', array('merchant_merchant_hooks', 'ecjia_builtin_app_bundles') );
RC_Hook::add_filter( 'merchant_dashboard_right4', array('merchant_merchant_hooks', 'ecjia_merchant_dashboard_contact'), 2 );

// end