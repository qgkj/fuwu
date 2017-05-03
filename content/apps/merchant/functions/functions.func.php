<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

RC_Hook::add_filter('template', function () {
    return RC_Config::get('system.tpl_style');
}, 11);

/**
 * 自动加载类注册
 */
RC_Hook::add_action('class_ecjia_merchant',             function () {RC_Package::package('app::merchant')->loadClass('ecjia_merchant', false);});
RC_Hook::add_action('class_ecjia_merchant_controller',  function () {RC_Package::package('app::merchant')->loadClass('ecjia_merchant_controller', false);});
RC_Hook::add_action('class_ecjia_merchant_menu',        function () {RC_Package::package('app::merchant')->loadClass('ecjia_merchant_menu', false);});
RC_Hook::add_action('class_ecjia_merchant_screen',      function () {RC_Package::package('app::merchant')->loadClass('ecjia_merchant_screen', false);});
RC_Hook::add_action('class_ecjia_merchant_loader',      function () {RC_Package::package('app::merchant')->loadClass('ecjia_merchant_loader', false);});
RC_Hook::add_action('class_ecjia_merchant_page',        function () {RC_Package::package('app::merchant')->loadClass('ecjia_merchant_page', false);});
RC_Hook::add_action('class_ecjia_merchant_purview',     function () {RC_Package::package('app::merchant')->loadClass('ecjia_merchant_purview', false);});

RC_Hook::add_action('handle_404_error', function ($arg){
});

// end