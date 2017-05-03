<?php
  
/*
Plugin Name: 商品推荐
Plugin URI: http://www.ecjia.com/plugins/ecjia.mp_goods/
Description: 商品推荐，获得商城的商品信息。
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: platform
*/
defined('IN_ECJIA') or exit('No permission resources.');
class plugin_mp_goods_best {

    public static function install() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        $param = array('file' => __FILE__, 'config' => $config);
        return RC_Api::api('platform', 'plugin_install', $param);
    }


    public static function uninstall() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        $param = array('file' => __FILE__, 'config' => $config);
        return RC_Api::api('platform', 'plugin_uninstall', $param);
    }


    public static function adapter_instance($instance, $config) {        
        switch ($config['sub_code']) {
            case 'best':
                require_once RC_Plugin::plugin_dir_path(__FILE__) . 'mp_goods_best.class.php';
                $wechat = new mp_goods_best($config);
                break;
               
            case 'hot':
                require_once RC_Plugin::plugin_dir_path(__FILE__) . 'mp_goods_hot.class.php';
                $wechat = new mp_goods_hot($config);
                break;
                
            case 'new':
                require_once RC_Plugin::plugin_dir_path(__FILE__) . 'mp_goods_new.class.php';
                $wechat = new mp_goods_new($config);
                break;
                    
            case 'recommend':
                require_once RC_Plugin::plugin_dir_path(__FILE__) . 'mp_goods_recommend.class.php';
                $wechat = new mp_goods_recommend($config);
                break;
                
            case 'promotion':
               	require_once RC_Plugin::plugin_dir_path(__FILE__) . 'mp_goods_promotion.class.php';
                $wechat = new mp_goods_promotion($config);
                break;
                
            default:
                require_once RC_Plugin::plugin_dir_path(__FILE__) . 'mp_goods.class.php';
                $wechat = new mp_goods($config);
        }

        return $wechat;
    }
}

RC_Plugin::register_activation_hook(__FILE__, array('plugin_mp_goods_best', 'install'));
RC_Plugin::register_deactivation_hook(__FILE__, array('plugin_mp_goods_best', 'uninstall'));
RC_Hook::add_filter('platform_factory_adapter_instance', array( 'plugin_mp_goods_best', 'adapter_instance' ), 10, 2);
// end