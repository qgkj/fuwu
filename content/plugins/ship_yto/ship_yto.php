<?php
  
/*
Plugin Name: 圆通速递
Plugin URI: http://www.ecjia.com/plugins/ecjia.yto/
Description: 上海圆通物流（速递）有限公司经过多年的网络快速发展，在中国速递行业中一直处于领先地位。为了能更好的发展国际快件市场，加快与国际市场的接轨，强化圆通的整体实力，圆通已在东南亚、欧美、中东、北美洲、非洲等许多城市运作国际快件业务
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: shipping
*/
defined('IN_ECJIA') or exit('No permission resources.');
class plugin_ship_yto {

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
        require_once RC_Plugin::plugin_dir_path(__FILE__) . 'ship_yto.class.php';
        return new ship_yto($config);
    }
}

RC_Plugin::register_activation_hook(__FILE__, array('plugin_ship_yto', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_ship_yto', 'uninstall'));
RC_Hook::add_filter('shipping_factory_adapter_instance', array( 'plugin_ship_yto', 'adapter_instance' ), 10, 2);

// end