<?php
  
/*
Plugin Name: 货到付款
Plugin URI: http://www.ecjia.com/plugins/ecjia.cod/
Description: 开通城市：×××<br>货到付款区域：×××
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: payment
*/
defined('IN_ECJIA') or exit('No permission resources.');
class plugin_pay_cod {

    public static function install() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        $param = array('file' => __FILE__, 'config' => $config);
        return RC_Api::api('payment', 'plugin_install', $param);
    }


    public static function uninstall() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        $param = array('file' => __FILE__, 'config' => $config);
        return RC_Api::api('payment', 'plugin_uninstall', $param);
    }

    public static function adapter_instance($instance, $config) {
        require_once RC_Plugin::plugin_dir_path(__FILE__) . 'pay_cod.class.php';
        return new pay_cod($config);
    }

}

RC_Plugin::register_activation_hook(__FILE__, array('plugin_pay_cod', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_pay_cod', 'uninstall'));
RC_Hook::add_filter('payment_factory_adapter_instance', array( 'plugin_pay_cod', 'adapter_instance' ), 10, 2);

// end