<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * touch共用功能加载
 */
function touch_common_loading() {

	/* 商店关闭了，输出关闭的消息 */
	if (ecjia::config('wap_config') == 0) {
		RC_Hook::do_action('ecjia_shop_closed');
	}

    RC_Loader::load_app_config('constant', 'touch');
    // RC_Loader::load_app_func('front_global','touch');
    // RC_Loader::load_app_class('touch_page', 'touch', false);
    RC_Loader::load_theme('extras/class/touch/touch_page.class.php');

    RC_Lang::load('touch/common');
    RC_Lang::load('touch/user');
    //判断是否显示头部和底部
    if (!empty($_GET['hidenav']) && !empty($_GET['hidetab'])) {
        RC_Cookie::set('hideinfo', 1, array('expire' => 360000));
    }elseif (isset($_GET['hidenav']) && isset($_GET['hidetab']) && $_GET['hidenav'] == 0 && $_GET['hidetab'] == 0) {
        RC_Cookie::delete('hideinfo');
    }

    if (RC_Cookie::get('hideinfo')) {
        ecjia_front::$view_object->assign('hideinfo', 1);
    }

    if (!empty($_GET['hidenav'])) {
        ecjia_front::$view_object->assign('hidenav', intval($_GET['hidenav']));
    }
    if (!empty($_GET['hidetab'])) {
        ecjia_front::$view_object->assign('hidetab', intval($_GET['hidetab']));
    }
    $stylename_code = RC_Hook::apply_filters('ecjia_theme_stylename_code', 'stylename');
    $curr_style = ecjia::config($stylename_code) ? 'style_'.ecjia::config($stylename_code).'.css' : 'style.css';
    ecjia_front::$view_object->assign('curr_style', $curr_style);

    // 提供APP下载广告的配置项
    $shop_app_icon = ecjia::config('shop_app_icon');
    !empty($shop_app_icon) && ecjia_front::$controller->assign('shop_app_icon', RC_Upload::upload_url() . '/' . $shop_app_icon);
}



RC_Hook::add_action('ecjia_front_finish_launching', 'touch_common_loading');

RC_Loader::load_app_class('touch', 'touch', false);

RC_Hook::add_filter('ecjia_theme_template_code', function() {
    return touch::STORAGEKEY_template;
});
RC_Hook::add_filter('ecjia_theme_stylename_code', function() {
    return touch::STORAGEKEY_stylename;
});
RC_Hook::add_filter('page_title_suffix', function ($suffix) {
	return ;
});

/**
 * 设置api session id
 * @param string $session_id session id
 * @return session_id
 */
function set_touch_session_id($session_id) {
    if (isset($_GET['token']) && !empty($_GET['token'])) {
        return $_GET['token'];
    }
    return ;
}
RC_Hook::add_filter('ecjia_front_session_id', 'set_touch_session_id');

/**
 * 自动加载类注册
 */
RC_Hook::add_action('class_ecjia_touch_api',             function () {RC_Package::package('app::touch')->loadClass('ecjia_touch_api', false);});
RC_Hook::add_action('class_ecjia_touch_manager',         function () {RC_Package::package('app::touch')->loadClass('ecjia_touch_manager', false);});
RC_Hook::add_action('class_ecjia_touch_user',            function () {RC_Package::package('app::touch')->loadClass('ecjia_touch_user', false);});
RC_Hook::add_action('class_ecjia_touch_page',            function () {RC_Package::package('app::touch')->loadClass('ecjia_touch_page', false);});

/*
 * ========================================
 * API模型加载
 * ========================================
 */
RC_Hook::add_action('class_api_shop_config_model',         function () {RC_Package::package('app::touch')->loadModel('shop.api_shop_config_model', false);});
RC_Hook::add_action('class_api_shop_help_detail_model',    function () {RC_Package::package('app::touch')->loadModel('shop.api_shop_help_detail_model', false);});
RC_Hook::add_action('class_api_shop_help_model',           function () {RC_Package::package('app::touch')->loadModel('shop.api_shop_help_model', false);});
RC_Hook::add_action('class_api_shop_info_detail_model',    function () {RC_Package::package('app::touch')->loadModel('shop.api_shop_info_detail_model', false);});
RC_Hook::add_action('class_api_shop_info_model',           function () {RC_Package::package('app::touch')->loadModel('shop.api_shop_info_model', false);});
RC_Hook::add_action('class_api_shop_payment_model',        function () {RC_Package::package('app::touch')->loadModel('shop.api_shop_payment_model', false);});
RC_Hook::add_action('class_api_shop_region_model',         function () {RC_Package::package('app::touch')->loadModel('shop.api_shop_region_model', false);});
RC_Hook::add_action('class_api_shop_token_model',          function () {RC_Package::package('app::touch')->loadModel('shop.api_shop_token_model', false);});


RC_Hook::add_action('class_api_address_add_model',         function () {RC_Package::package('app::touch')->loadModel('address.api_address_add_model', false);});
RC_Hook::add_action('class_api_address_delete_model',      function () {RC_Package::package('app::touch')->loadModel('address.api_address_delete_model', false);});
RC_Hook::add_action('class_api_address_info_model',        function () {RC_Package::package('app::touch')->loadModel('address.api_address_info_model', false);});
RC_Hook::add_action('class_api_address_list_model',        function () {RC_Package::package('app::touch')->loadModel('address.api_address_list_model', false);});
RC_Hook::add_action('class_api_address_setDefault_model',  function () {RC_Package::package('app::touch')->loadModel('address.api_address_setDefault_model', false);});
RC_Hook::add_action('class_api_address_update_model',      function () {RC_Package::package('app::touch')->loadModel('address.api_address_update_model', false);});


RC_Hook::add_action('class_api_bonus_bind_model',          function () {RC_Package::package('app::touch')->loadModel('bonus.api_bonus_bind_model', false);});
RC_Hook::add_action('class_api_bonus_coupon_model',        function () {RC_Package::package('app::touch')->loadModel('bonus.api_bonus_coupon_model', false);});
RC_Hook::add_action('class_api_bonus_validate_model',      function () {RC_Package::package('app::touch')->loadModel('bonus.api_bonus_validate_model', false);});
RC_Hook::add_action('class_api_receive_coupon_model',      function () {RC_Package::package('app::touch')->loadModel('bonus.api_receive_coupon_model', false);});
RC_Hook::add_action('class_api_receive_coupon_model',      function () {RC_Package::package('app::touch')->loadModel('bonus.api_send_coupon_model', false);});


RC_Hook::add_action('class_api_cart_create_model',         function () {RC_Package::package('app::touch')->loadModel('cart.api_cart_create_model', false);});
RC_Hook::add_action('class_api_cart_delete_model',         function () {RC_Package::package('app::touch')->loadModel('cart.api_cart_delete_model', false);});
RC_Hook::add_action('class_api_cart_list_model',           function () {RC_Package::package('app::touch')->loadModel('cart.api_cart_list_model', false);});
RC_Hook::add_action('class_api_cart_update_model',         function () {RC_Package::package('app::touch')->loadModel('cart.api_cart_update_model', false);});
RC_Hook::add_action('class_api_flow_checkOrder_model',     function () {RC_Package::package('app::touch')->loadModel('cart.api_flow_checkOrder_model', false);});
RC_Hook::add_action('class_api_flow_checkOrder_model',     function () {RC_Package::package('app::touch')->loadModel('cart.api_flow_done_model', false);});


RC_Hook::add_action('class_api_home_adsense_model',        function () {RC_Package::package('app::touch')->loadModel('home.api_home_adsense_model', false);});
RC_Hook::add_action('class_api_home_category_model',       function () {RC_Package::package('app::touch')->loadModel('home.api_home_category_model', false);});
RC_Hook::add_action('class_api_home_data_model',           function () {RC_Package::package('app::touch')->loadModel('home.api_home_data_model', false);});
RC_Hook::add_action('class_api_home_discover_model',       function () {RC_Package::package('app::touch')->loadModel('home.api_home_discover_model', false);});
RC_Hook::add_action('class_api_home_news_model',           function () {RC_Package::package('app::touch')->loadModel('home.api_home_news_model', false);});


RC_Hook::add_action('class_api_merchant_goods_category_model',     function () {RC_Package::package('app::touch')->loadModel('merchant.api_merchant_goods_category_model', false);});
RC_Hook::add_action('class_api_merchant_goods_list_model',         function () {RC_Package::package('app::touch')->loadModel('merchant.api_merchant_goods_list_model', false);});
RC_Hook::add_action('class_api_merchant_goods_suggestlist_model',  function () {RC_Package::package('app::touch')->loadModel('merchant.api_merchant_goods_suggestlist_model', false);});
RC_Hook::add_action('class_api_merchant_goods_suggestlist_model',  function () {RC_Package::package('app::touch')->loadModel('merchant.api_merchant_home_data_model', false);});


RC_Hook::add_action('class_api_order_affirmReceived_model',        function () {RC_Package::package('app::touch')->loadModel('order.api_order_affirmReceived_model', false);});
RC_Hook::add_action('class_api_order_cancel_model',                function () {RC_Package::package('app::touch')->loadModel('order.api_order_cancel_model', false);});
RC_Hook::add_action('class_api_order_detail_model',                function () {RC_Package::package('app::touch')->loadModel('order.api_order_detail_model', false);});
RC_Hook::add_action('class_api_order_express_model',               function () {RC_Package::package('app::touch')->loadModel('order.api_order_express_model', false);});
RC_Hook::add_action('class_api_order_list_model',                  function () {RC_Package::package('app::touch')->loadModel('order.api_order_list_model', false);});
RC_Hook::add_action('class_api_order_pay_model',                   function () {RC_Package::package('app::touch')->loadModel('order.api_order_pay_model', false);});
RC_Hook::add_action('class_api_order_reminder_model',              function () {RC_Package::package('app::touch')->loadModel('order.api_order_reminder_model', false);});
RC_Hook::add_action('class_api_order_update_model',                function () {RC_Package::package('app::touch')->loadModel('order.api_order_update_model', false);});


RC_Hook::add_action('class_api_seller_category_model',             function () {RC_Package::package('app::touch')->loadModel('seller.api_seller_category_model', false);});
RC_Hook::add_action('class_api_seller_collect_create_model',       function () {RC_Package::package('app::touch')->loadModel('seller.api_seller_collect_create_model', false);});
RC_Hook::add_action('class_api_seller_collect_delete_model',       function () {RC_Package::package('app::touch')->loadModel('seller.api_seller_collect_delete_model', false);});
RC_Hook::add_action('class_api_seller_collect_list_model',         function () {RC_Package::package('app::touch')->loadModel('seller.api_seller_collect_list_model', false);});
RC_Hook::add_action('class_api_seller_list_model',                 function () {RC_Package::package('app::touch')->loadModel('seller.api_seller_list_model', false);});
RC_Hook::add_action('class_api_seller_search_model',               function () {RC_Package::package('app::touch')->loadModel('seller.api_seller_search_model', false);});


RC_Hook::add_action('class_api_connect_bind_model',                function () {RC_Package::package('app::touch')->loadModel('user.api_connect_bind_model', false);});
RC_Hook::add_action('class_api_connect_signin_model',              function () {RC_Package::package('app::touch')->loadModel('user.api_connect_signin_model', false);});
RC_Hook::add_action('class_api_connect_signup_model',              function () {RC_Package::package('app::touch')->loadModel('user.api_connect_signup_model', false);});

RC_Hook::add_action('class_api_user_account_cancel_model',         function () {RC_Package::package('app::touch')->loadModel('user.api_user_account_cancel_model', false);});
RC_Hook::add_action('class_api_user_account_deposit_model',        function () {RC_Package::package('app::touch')->loadModel('user.api_user_account_deposit_model', false);});
RC_Hook::add_action('class_api_user_account_log_model',            function () {RC_Package::package('app::touch')->loadModel('user.api_user_account_log_model', false);});
RC_Hook::add_action('class_api_user_account_pay_model',            function () {RC_Package::package('app::touch')->loadModel('user.api_user_account_pay_model', false);});
RC_Hook::add_action('class_api_user_account_pay_model',            function () {RC_Package::package('app::touch')->loadModel('user.api_user_account_raply_model', false);});
RC_Hook::add_action('class_api_user_account_pay_model',            function () {RC_Package::package('app::touch')->loadModel('user.api_user_account_record_model', false);});
RC_Hook::add_action('class_api_user_account_update_model',         function () {RC_Package::package('app::touch')->loadModel('user.api_user_account_update_model', false);});


RC_Hook::add_action('class_api_user_account_update_model',         function () {RC_Package::package('app::touch')->loadModel('user.api_user_collect_create_model', false);});
RC_Hook::add_action('class_api_user_collect_delete_model',         function () {RC_Package::package('app::touch')->loadModel('user.api_user_collect_delete_model', false);});
RC_Hook::add_action('class_api_user_collect_delete_model',         function () {RC_Package::package('app::touch')->loadModel('user.api_user_collect_list_model', false);});


RC_Hook::add_action('class_api_user_collect_delete_model',         function () {RC_Package::package('app::touch')->loadModel('user.api_user_forget_password_model', false);});
RC_Hook::add_action('class_api_user_info_model',                   function () {RC_Package::package('app::touch')->loadModel('user.api_user_info_model', false);});
RC_Hook::add_action('class_api_user_password_model',               function () {RC_Package::package('app::touch')->loadModel('user.api_user_password_model', false);});
RC_Hook::add_action('class_api_user_password_model',               function () {RC_Package::package('app::touch')->loadModel('user.api_user_reset_password_model', false);});
RC_Hook::add_action('class_api_user_password_model',               function () {RC_Package::package('app::touch')->loadModel('user.api_user_send_pwdmail_model', false);});
RC_Hook::add_action('class_api_user_password_model',               function () {RC_Package::package('app::touch')->loadModel('user.api_user_signin_model', false);});
RC_Hook::add_action('class_api_user_password_model',               function () {RC_Package::package('app::touch')->loadModel('user.api_user_signout_model', false);});
RC_Hook::add_action('class_api_user_signup_model',                 function () {RC_Package::package('app::touch')->loadModel('user.api_user_signup_model', false);});
RC_Hook::add_action('class_api_user_signup_model',                 function () {RC_Package::package('app::touch')->loadModel('user.api_user_signupFields_model', false);});
RC_Hook::add_action('class_api_user_snsbind_model',                function () {RC_Package::package('app::touch')->loadModel('user.api_user_snsbind_model', false);});
RC_Hook::add_action('class_api_user_snsbind_model',                function () {RC_Package::package('app::touch')->loadModel('user.api_user_update_model', false);});


RC_Hook::add_action('class_api_validate_account_model',            function () {RC_Package::package('app::touch')->loadModel('user.api_validate_account_model', false);});
RC_Hook::add_action('class_api_validate_account_model',            function () {RC_Package::package('app::touch')->loadModel('user.api_validate_bind_model', false);});
RC_Hook::add_action('class_api_validate_account_model',            function () {RC_Package::package('app::touch')->loadModel('user.api_validate_bonus_model', false);});
RC_Hook::add_action('class_api_validate_account_model',            function () {RC_Package::package('app::touch')->loadModel('user.api_validate_forget_password_model', false);});
RC_Hook::add_action('class_api_validate_integral_model',           function () {RC_Package::package('app::touch')->loadModel('user.api_validate_integral_model', false);});
RC_Hook::add_action('class_api_validate_integral_model',           function () {RC_Package::package('app::touch')->loadModel('user.api_validate_signin_model', false);});


RC_Hook::add_action('class_api_goods_category_model',              function () {RC_Package::package('app::touch')->loadModel('goods.api_goods_category_model', false);});
RC_Hook::add_action('class_api_goods_category_model',              function () {RC_Package::package('app::touch')->loadModel('goods.api_goods_comments_model', false);});
RC_Hook::add_action('class_api_goods_seller_list_model',           function () {RC_Package::package('app::touch')->loadModel('goods.api_goods_seller_list_model', false);});
RC_Hook::add_action('class_api_goods_seller_list_model',           function () {RC_Package::package('app::touch')->loadModel('goods.api_goods_suggestlist_model', false);});
RC_Hook::add_action('class_api_goods_seller_list_model',           function () {RC_Package::package('app::touch')->loadModel('goods.api_goods_detail_model', false);});
RC_Hook::add_action('class_api_goods_seller_list_model',           function () {RC_Package::package('app::touch')->loadModel('goods.api_goods_desc_model', false);});
RC_Hook::add_action('class_api_goods_filter_model',                function () {RC_Package::package('app::touch')->loadModel('goods.api_goods_filter_model', false);});

// end
