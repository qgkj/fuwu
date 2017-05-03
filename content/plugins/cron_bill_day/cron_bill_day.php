<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/*
Plugin Name: 商家结算帐单按日生成
Plugin URI: http://www.ecjia.com/plugins/ecjia.cron_bill_day/
Description: 自动按日生成商家结算帐单
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: cron
*/
class plugin_cron_bill_day {

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
//         require_once RC_Plugin::plugin_dir_path(__FILE__) . 'cron_bill_day.class.php';
//         return new cron_bill_day($config);
//     }

}

Ecjia_PluginManager::extend('cron_bill_day', function() {
    require_once RC_Plugin::plugin_dir_path(__FILE__) . 'cron_bill_day.class.php';
        return new cron_bill_day();
});

RC_Plugin::register_activation_hook(__FILE__, array('plugin_cron_bill_day', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_cron_bill_day', 'uninstall'));
// RC_Hook::add_filter('cron_factory_adapter_instance', array( 'plugin_cron_bill_day', 'adapter_instance' ), 10, 2);

// end