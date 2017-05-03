<?php
  
/*
Plugin Name: 自动关闭未付款订单
Plugin URI: http://www.ecjia.com/plugins/ecjia.cron_unpayed/
Description: 计划任务-自动关闭未付款订单
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: cron
*/
defined('IN_ECJIA') or exit('No permission resources.');
class plugin_cron_unpayed {

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
//         require_once RC_Plugin::plugin_dir_path(__FILE__) . 'cron_unpayed.class.php';
//         return new cron_unpayed($config);
//     }

}

Ecjia_PluginManager::extend('cron_unpayed', function() {
    require_once RC_Plugin::plugin_dir_path(__FILE__) . 'cron_unpayed.class.php';
        return new cron_unpayed();
});

RC_Plugin::register_activation_hook(__FILE__, array('plugin_cron_unpayed', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_cron_unpayed', 'uninstall'));
// RC_Hook::add_filter('cron_factory_adapter_instance', array( 'plugin_cron_unpayed', 'adapter_instance' ), 10, 2);

// end