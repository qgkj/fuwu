<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/*
Plugin Name: ROYALCMS验证码
Plugin URI: http://www.ecjia.com/plugins/ecjia.captcha_royalcms/
Description: ROYALCMS的验证码风格
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: captcha
*/
class plugin_captcha_royalcms {

    public static function install() {
        $param = array('file' => __FILE__);
        return RC_Api::api('captcha', 'plugin_install', $param);
    }


    public static function uninstall() {
        $param = array('file' => __FILE__);
        return RC_Api::api('captcha', 'plugin_uninstall', $param);
    }

    public static function adapter_instance($instance, $config) {
        require_once RC_Plugin::plugin_dir_path(__FILE__) . 'captcha_royalcms_image.class.php';
        return new captcha_royalcms_image($config);
    }
}

RC_Plugin::register_activation_hook( __FILE__, array( 'plugin_captcha_royalcms', 'install' ) );
RC_Plugin::register_deactivation_hook( __FILE__, array( 'plugin_captcha_royalcms', 'uninstall' ) );
RC_Hook::add_filter('captcha_factory_adapter_instance', array( 'plugin_captcha_royalcms', 'adapter_instance' ), 10, 2);


// end