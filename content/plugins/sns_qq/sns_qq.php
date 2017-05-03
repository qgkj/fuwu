<?php
  
/*
Plugin Name: QQ帐号登录
Plugin URI: http://www.ecjia.com/plugins/ecjia.sns_qq/
Description: 使用QQ第三方帐号登录。<br><a href="http://connect.qq.com/intro/login/" target="_blank"><font color="red">立即在线申请</font></a>。
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: connect
*/
defined('IN_ECJIA') or exit('No permission resources.');
class plugin_sns_qq {

    public static function install() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        $param = array('file' => __FILE__, 'config' => $config);
        return RC_Api::api('connect', 'plugin_install', $param);
    }


    public static function uninstall() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        $param = array('file' => __FILE__, 'config' => $config);
        return RC_Api::api('connect', 'plugin_uninstall', $param);
    }


    public static function adapter_instance($instance, $config) {
        require_once RC_Plugin::plugin_dir_path(__FILE__) . 'sns_qq.class.php';
        $sns_qq = new sns_qq($config['sns_qq_appid'], $config['sns_qq_appkey'], $config);
        return $sns_qq;
    }
}

RC_Plugin::register_activation_hook(__FILE__, array('plugin_sns_qq', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_sns_qq', 'uninstall'));
RC_Hook::add_filter('connect_factory_adapter_instance', array( 'plugin_sns_qq', 'adapter_instance' ), 10, 2);
RC_Hook::add_action('class_ErrorCase', function () {RC_Loader::load_plugin_class('ErrorCase', 'sns_qq',false);});
RC_Hook::add_action('class_QQConnect', function () {RC_Loader::load_plugin_class('QQConnect', 'sns_qq',false);});
RC_Hook::add_action('class_Recorder', function () {RC_Loader::load_plugin_class('Recorder', 'sns_qq',false);});
RC_Hook::add_action('class_UrlUtils', function () {RC_Loader::load_plugin_class('UrlUtils', 'sns_qq',false);});

// end