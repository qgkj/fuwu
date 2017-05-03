<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/*
Plugin Name: 自动处理
Plugin URI: http://www.ecjia.com/plugins/ecjia.cron_auto_manage/
Description: 自动处理商品的上架下架,和文章的发布取消
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: cron
*/
class plugin_cron_auto_manage {

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
//         require_once RC_Plugin::plugin_dir_path(__FILE__) . 'cron_auto_manage.class.php';
//         return new cron_auto_manage($config);
//     }

}

Ecjia_PluginManager::extend('cron_auto_manage', function() {
    require_once RC_Plugin::plugin_dir_path(__FILE__) . 'cron_auto_manage.class.php';
        return new cron_auto_manage();
});

RC_Plugin::register_activation_hook(__FILE__, array('plugin_cron_auto_manage', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_cron_auto_manage', 'uninstall'));
// RC_Hook::add_filter('cron_factory_adapter_instance', array( 'plugin_cron_auto_manage', 'adapter_instance' ), 10, 2);

// end