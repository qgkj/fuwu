<?php
  
/*
Plugin Name: 支付宝
Plugin URI: http://www.ecjia.com/plugins/ecjia.alipay/
Description: 支付宝网站(www.alipay.com) 是国内先进的网上支付平台。<br/>支付宝收款接口：在线即可开通，<font color="red"><b>零预付，免年费</b></font>，单笔阶梯费率，无流量限制。<br/><a href="http://cloud.ecjia.com/payment_apply.php?mod=alipay" target="_blank"><font color="red">立即在线申请</font></a>
Author: ECJIA TEAM
Version: 2.0.0
Author URI: http://www.ecjia.com/
Plugin App: payment
*/
defined('IN_ECJIA') or exit('No permission resources.');

define('PAY_ALIPAY_PATH', RC_App::app_dir_path(__FILE__) . DS);

class plugin_pay_alipay {
    
    public static function install() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        $param = array('file' => __FILE__, 'config' => $config);
        RC_Api::api('payment', 'plugin_install', $param);
    }
    
    
    public static function uninstall() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        $param = array('file' => __FILE__, 'config' => $config);
        RC_Api::api('payment', 'plugin_uninstall', $param);
    }
    
    public static function adapter_instance($instance, $config) {
        include_once RC_Plugin::plugin_dir_path(__FILE__) . 'pay_alipay.class.php';
        return new pay_alipay($config);
    }
    
}

RC_Plugin::register_activation_hook(__FILE__, array('plugin_pay_alipay', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_pay_alipay', 'uninstall'));
RC_Hook::add_filter('payment_factory_adapter_instance', array( 'plugin_pay_alipay', 'adapter_instance' ), 10, 2);
RC_Hook::add_action('class_alipay_core', function () {RC_Loader::load_plugin_class('alipay_core', 'pay_alipay', false);});
RC_Hook::add_action('class_alipay_notify', function () {RC_Loader::load_plugin_class('alipay_notify', 'pay_alipay', false);});
RC_Hook::add_action('class_alipay_notify_web', function () {RC_Loader::load_plugin_class('alipay_notify_web', 'pay_alipay', false);});
RC_Hook::add_action('class_alipay_notify_wap', function () {RC_Loader::load_plugin_class('alipay_notify_wap', 'pay_alipay', false);});
RC_Hook::add_action('class_alipay_notify_mobile', function () {RC_Loader::load_plugin_class('alipay_notify_mobile', 'pay_alipay', false);});
RC_Hook::add_action('class_alipay_request', function () {RC_Loader::load_plugin_class('alipay_request', 'pay_alipay', false);});
RC_Hook::add_action('class_alipay_request_web', function () {RC_Loader::load_plugin_class('alipay_request_web', 'pay_alipay', false);});
RC_Hook::add_action('class_alipay_request_wap', function () {RC_Loader::load_plugin_class('alipay_request_wap', 'pay_alipay', false);});
RC_Hook::add_action('class_alipay_sign_interface', function () {RC_Loader::load_plugin_class('alipay_sign_interface', 'pay_alipay', false);});
RC_Hook::add_action('class_alipay_sign_md5', function () {RC_Loader::load_plugin_class('alipay_sign_md5', 'pay_alipay', false);});
RC_Hook::add_action('class_alipay_sign_rsa', function () {RC_Loader::load_plugin_class('alipay_sign_rsa', 'pay_alipay', false);});

// end