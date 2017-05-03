<?php
  
/*
Plugin Name: 运费到付
Plugin URI: http://www.ecjia.com/plugins/ecjia.fpd/
Description: 所购商品到达即付运费
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: shipping
*/
defined('IN_ECJIA') or exit('No permission resources.');
class plugin_ship_fpd {

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
        require_once RC_Plugin::plugin_dir_path(__FILE__) . 'ship_fpd.class.php';
        return new ship_fpd($config);
    }
}

RC_Plugin::register_activation_hook(__FILE__, array('plugin_ship_fpd', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_ship_fpd', 'uninstall'));
RC_Hook::add_filter('shipping_factory_adapter_instance', array( 'plugin_ship_fpd', 'adapter_instance' ), 10, 2);

// end