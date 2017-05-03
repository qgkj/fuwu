<?php
  
/*
Plugin Name: 银行转帐
Plugin URI: http://www.ecjia.com/plugins/ecjia.bank/
Description: 银行名称<br/>收款人信息：全称 ××× ；帐号或地址 ××× ；开户行 ×××。<br>注意事项：办理电汇时，请在电汇单“汇款用途”一栏处注明您的订单号。
Author: ECJIA TEAM
Version: 2.0.0
Author URI: http://www.ecjia.com/
Plugin App: payment
*/
defined('IN_ECJIA') or exit('No permission resources.');
class plugin_pay_bank {

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
        require_once RC_Plugin::plugin_dir_path(__FILE__) . 'pay_bank.class.php';
        return new pay_bank($config);
    }

}

RC_Plugin::register_activation_hook(__FILE__, array('plugin_pay_bank', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_pay_bank', 'uninstall'));
RC_Hook::add_filter('payment_factory_adapter_instance', array( 'plugin_pay_bank', 'adapter_instance' ), 10, 2);

// end