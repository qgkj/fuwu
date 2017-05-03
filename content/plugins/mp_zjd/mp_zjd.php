<?php
  
/*
Plugin Name: 砸金蛋
Plugin URI: http://www.ecjia.com/plugins/ecjia.mp_zjd/
Description: 使用插件可以让微信公众平台用户参加砸金蛋活动。
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: platform
*/
defined('IN_ECJIA') or exit('No permission resources.');
class plugin_mp_zjd {

    public static function install() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        $param = array('file' => __FILE__, 'config' => $config);
        return RC_Api::api('platform', 'plugin_install', $param);
    }


    public static function uninstall() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        $param = array('file' => __FILE__, 'config' => $config);
        return RC_Api::api('platform', 'plugin_uninstall', $param);
    }


    public static function adapter_instance($instance, $config) {
        require_once RC_Plugin::plugin_dir_path(__FILE__) . 'mp_zjd.class.php';
        $wechat = new mp_zjd($config);
        return $wechat;
    }
}

RC_Plugin::register_activation_hook(__FILE__, array('plugin_mp_zjd', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_mp_zjd', 'uninstall'));
RC_Hook::add_filter('platform_factory_adapter_instance', array( 'plugin_mp_zjd', 'adapter_instance' ), 10, 2);
// end