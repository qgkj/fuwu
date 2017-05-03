<?php
  
/*
Plugin Name: 商家结算帐单按月生成
Plugin URI: http://www.ecjia.com/plugins/ecjia.cron_bill_month/
Description: 自动按月生成商家结算帐单
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: cron
*/
defined('IN_ECJIA') or exit('No permission resources.');
class plugin_cron_bill_month {

    public static function install() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        $param = array('file' => __FILE__, 'config' => $config);
        return RC_Api::api('cron', 'plugin_install', $param);
    }


    public static function uninstall() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        $param = array('file' => __FILE__, 'config' => $config);
        return RC_Api::api('cron', 'plugin_uninstall', $param);
    }

//     public static function adapter_instance($instance, $config) {
//         require_once RC_Plugin::plugin_dir_path(__FILE__) . 'cron_bill_month.class.php';
//         return new cron_bill_month($config);
//     }

}

Ecjia_PluginManager::extend('cron_bill_month', function() {
    require_once RC_Plugin::plugin_dir_path(__FILE__) . 'cron_bill_month.class.php';
        return new cron_bill_month();
});

RC_Plugin::register_activation_hook(__FILE__, array('plugin_cron_bill_month', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_cron_bill_month', 'uninstall'));
// RC_Hook::add_filter('cron_factory_adapter_instance', array( 'plugin_cron_bill_month', 'adapter_instance' ), 10, 2);

// end