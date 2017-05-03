<?php
  
/*
Plugin Name: 余额支付
Plugin URI: http://www.ecjia.com/plugins/ecjia.balance/
Description: 使用帐户余额支付。只有会员才能使用，通过设置信用额度，可以透支。
Author: ECJIA TEAM
Version: 1.0.2
Author URI: http://www.ecjia.com/
Plugin App: payment
*/
defined('IN_ECJIA') or exit('No permission resources.');
class plugin_pay_balance {

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
        require_once RC_Plugin::plugin_dir_path(__FILE__) . 'pay_balance.class.php';
        return new pay_balance($config);
    }
}

RC_Plugin::register_activation_hook(__FILE__, array('plugin_pay_balance', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_pay_balance', 'uninstall'));
RC_Hook::add_filter('payment_factory_adapter_instance', array( 'plugin_pay_balance', 'adapter_instance' ), 10, 2);

// end