<?php
  
/*
Plugin Name: EMS 国内邮政特快专递
Plugin URI: http://www.ecjia.com/plugins/ecjia.ems/
Description: EMS 国内邮政特快专递描述内容
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: shipping
*/
defined('IN_ECJIA') or exit('No permission resources.');
class plugin_ship_ems {

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
        require_once RC_Plugin::plugin_dir_path(__FILE__) . 'ship_ems.class.php';
        return new ship_ems($config);
    }

}

RC_Plugin::register_activation_hook(__FILE__, array('plugin_ship_ems', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_ship_ems', 'uninstall'));
RC_Hook::add_filter('shipping_factory_adapter_instance', array( 'plugin_ship_ems', 'adapter_instance' ), 10, 2);

// end