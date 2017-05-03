<?php
  
/*
Plugin Name: 上门取货
Plugin URI: http://www.ecjia.com/plugins/ecjia.cac/
Description: 买家自己到商家指定地点取货
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: shipping
*/

defined('IN_ECJIA') or exit('No permission resources.');
class plugin_ship_cac {

    public static function install() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        $param = array('file' => __FILE__, 'config' => $config);
        RC_Api::api('shipping', 'plugin_install', $param);
    }


    public static function uninstall() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        $param = array('file' => __FILE__, 'config' => $config);
        RC_Api::api('shipping', 'plugin_uninstall', $param);
    }

    public static function adapter_instance($instance, $config) {
        require_once RC_Plugin::plugin_dir_path(__FILE__) . 'ship_cac.class.php';
        return new ship_cac($config);
    }

}

RC_Plugin::register_activation_hook(__FILE__, array('plugin_ship_cac', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_ship_cac', 'uninstall'));
RC_Hook::add_filter('shipping_factory_adapter_instance', array( 'plugin_ship_cac', 'adapter_instance' ), 10, 2);

// end