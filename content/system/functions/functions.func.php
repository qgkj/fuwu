<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 加载ECJia项目主文件
 */
RC_Package::package('system')->loadClass('ecjia', false);
if ($_GET['m'] != 'installer') {
    RC_Hook::add_action('init', 'load_theme_function');
    RC_Hook::add_filter('app_scan_bundles', 'app_scan_bundles');
    RC_Hook::add_action('init', 'check_installed', 2);
    
    RC_Hook::add_action('ecjia_controller', function ($arg) {
        new ecjia_controller();
    });
}

/**
 * 检测是否安装
 */
function check_installed() {
    $install_lock = storage_path() . '/data/install.lock';
    if (!file_exists($install_lock) && !defined('NO_CHECK_INSTALL'))
    {
        $url = RC_Uri::url('installer/index/init');
        
        $cookies = royalcms('response')->headers->getCookies();
        $response = RC_Redirect::away($url, 302);
        foreach ($cookies as $cookie)
        {
            $response->withCookie($cookie);
        }
        
        $response->send();
        exit();
    }
}

/**
 * 加载主题扩展文件
 */
function load_theme_function() {
    
    RC_Loader::load_app_func('functions', 'api');
    $app = RC_Config::load_config('site', 'MAIN_APP');
    if ($app) {
        RC_Loader::load_app_func('functions', $app);
    }
    
    RC_Hook::add_filter('template', function () {
        $template_code = RC_Hook::apply_filters('ecjia_theme_template_code', 'template');
    	return ecjia::config($template_code);
    });
    $dir = RC_Theme::get_template_directory();
    if (file_exists($dir . DS . 'functions.php')) {
        include_once $dir . DS . 'functions.php';
    }
}

function app_scan_bundles() {
    $builtin_bundles = ecjia_app::builtin_bundles();
    $extend_bundles = ecjia_app::extend_bundles();
    return array_merge($builtin_bundles, $extend_bundles);
}

function ecjia_front_access_session() {
    if (ecjia_utility::is_spider()) {
        /* 如果是蜘蛛的访问，那么默认为访客方式，并且不记录到日志中 */
        $_SESSION = array();
        $_SESSION['user_id']     = 0;
        $_SESSION['user_name']   = '';
        $_SESSION['email']       = '';
        $_SESSION['user_rank']   = 0;
        $_SESSION['discount']    = 1.00;
    }
    
    //游客状态也需要设置一下session值
    if (empty($_SESSION['user_id'])) {
        $_SESSION['user_id']     = 0;
        $_SESSION['user_name']   = '';
        $_SESSION['email']       = '';
        $_SESSION['user_rank']   = 0;
        $_SESSION['discount']    = 1.00;
        if (!isset($_SESSION['login_fail'])) {
            $_SESSION['login_fail'] = 0;
        }
    }
}
RC_Hook::add_action('ecjia_front_access_session', 'ecjia_front_access_session');

/**
 * 自定义后台管理访问URL
 * @param string $url
 * @param string $path
 * @return string
 */
function custom_admin_url($url, $path) {
    if (RC_Config::has('site.custom_admin_url')) {
        $home_url = RC_Config::get('site.custom_admin_url');
    } else {
        $home_url = rtrim(ROOT_URL, '/');
    }
    
    $admin_url = $home_url . '/content/system';
    if ($path) {
        $admin_url .= '/' . $path;
    }
    return  $admin_url;
}
RC_Hook::add_filter('admin_url', 'custom_admin_url', 10, 2);


/**
 * 自定义系统静态资源访问URL
 * @param string $url
 * @param string $path
 * @return string
 */
function custom_system_static_url($url, $path) {
    if (RC_Config::has('site.custom_static_url')) {
        $static_url = RC_Config::get('site.custom_static_url');
    } else {
        $static_url = RC_Uri::admin_url('statics');
    }
    $url = $static_url . '/' . $path;
    return rtrim($url, '/');
}
RC_Hook::add_filter('system_static_url', 'custom_system_static_url', 10, 2);


/**
 * 自定义项目访问URL
 * @param string $url
 * @param string $path
 * @return string
 */
function custom_home_url($url, $path, $scheme) {
    if (RC_Config::has('site.custom_home_url')) {
        $home_url = RC_Config::get('site.custom_home_url');
        $url = $home_url . '/' . $path;
    }
    return rtrim($url, '/');
}
RC_Hook::add_filter('home_url', 'custom_home_url', 10, 3);

/**
 * 自定义项目访问URL
 * @param string $url
 * @param string $path
 * @return string
 */
function custom_site_url($url, $path, $scheme) {
    if (RC_Config::has('site.custom_site_url')) {
        $home_url = RC_Config::get('site.custom_site_url');
        $url = $home_url . '/' . $path;
    }
    return rtrim($url, '/');
}
RC_Hook::add_filter('site_url', 'custom_site_url', 10, 3);


/**
 * 自定义上传目录访问URL
 * @param string $url
 * @param string $path
 * @return string
 */
function custom_upload_url($url, $path) {
    if (RC_Config::has('site.custom_upload_url')) {
        $home_url = RC_Config::get('site.custom_upload_url');
        $url = $home_url . '/' . $path;
    }
    return rtrim($url, '/');
}
RC_Hook::add_filter('upload_url', 'custom_upload_url', 10, 2);


/**
 * 自定义上传目录路径
 * @param string $url
 * @param string $path
 * @return string
 */
function custom_upload_path($url, $path) {
    if (RC_Config::has('site.custom_upload_path')) {
        $upload_path = RC_Config::get('site.custom_upload_path');
    } else {
        $upload_path = SITE_UPLOAD_PATH;
    }
    $upload_path = $upload_path . ltrim($path, '/');
    return $upload_path;
}
RC_Hook::add_filter('upload_path', 'custom_upload_path', 10, 2);


/**
 * 自定义商店关闭后输出
 */
function custom_shop_closed() {
    header('Content-type: text/html; charset='.RC_CHARSET);
    die('<div style="margin: 150px; text-align: center; font-size: 14px"><p>' . __('本店盘点中，请您稍后再来...') . '</p><p>' . ecjia::config('close_comment') . '</p></div>');
}
RC_Hook::add_action('ecjia_shop_closed', 'custom_shop_closed');


function compatible_process_handle() {
    ecjia_front::$view_object->assign('ecs_charset', RC_CHARSET);
    
    if (ecjia::config(RC_Hook::apply_filters('ecjia_theme_stylename_code', 'stylename'), ecjia::CONFIG_EXISTS))
    {
        ecjia_front::$view_object->assign('ecs_css_path', RC_Theme::get_template_directory_uri() . '/style_' . ecjia::config(RC_Hook::apply_filters('ecjia_theme_stylename_code', 'stylename')) . '.css');
    }
    else
    {
        ecjia_front::$view_object->assign('ecs_css_path', RC_Theme::get_template_directory_uri() . '/style.css');
    }
}
RC_Hook::add_action('ecjia_compatible_process', 'compatible_process_handle');


function ecjia_set_header() {
    header('content-type: text/html; charset=' . RC_CHARSET);
    header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
}
RC_Hook::add_action('ecjia_admin_finish_launching', 'ecjia_set_header');
RC_Hook::add_action('ecjia_front_finish_launching', 'ecjia_set_header');

function ecjia_mail_config($config) {    
    royalcms('config')->set('mail.host',        ecjia::config('smtp_host'));
    royalcms('config')->set('mail.port',        ecjia::config('smtp_port'));
    royalcms('config')->set('mail.from.address', ecjia::config('smtp_mail'));
    royalcms('config')->set('mail.from.name',   ecjia::config('shop_name'));
    royalcms('config')->set('mail.username',    ecjia::config('smtp_user'));
    royalcms('config')->set('mail.password',    ecjia::config('smtp_pass'));
    royalcms('config')->set('mail.charset',     ecjia::config('mail_charset'));

    if (intval(ecjia::config('smtp_ssl')) === 1) {
        royalcms('config')->set('mail.encryption', 'ssl');
    } else {
        royalcms('config')->set('mail.encryption', 'tcp');
    }
 
    if (intval(ecjia::config('mail_service')) === 1) {
        royalcms('config')->set('mail.driver', 'smtp');
    } else {
        royalcms('config')->set('mail.driver', 'mail');
    }
}
RC_Hook::add_action('reset_mail_config', 'ecjia_mail_config');

function set_ecjia_config_filter($arr) {
    /* 对数值型设置处理 */
    $arr['watermark_alpha']      = isset($arr['watermark_alpha']) ? intval($arr['watermark_alpha']) : 0;
    $arr['market_price_rate']    = isset($arr['market_price_rate']) ? floatval($arr['market_price_rate']) : 0;
    $arr['integral_scale']       = isset($arr['integral_scale']) ? floatval($arr['integral_scale']) : 0;
    $arr['integral_percent']     = isset($arr['integral_percent']) ? floatval($arr['integral_percent']) : 0;
    $arr['cache_time']           = isset($arr['cache_time']) ? intval($arr['cache_time']) : 0;
    $arr['thumb_width']          = isset($arr['thumb_width']) ? intval($arr['thumb_width']) : 0;
    $arr['thumb_height']         = isset($arr['thumb_height']) ? intval($arr['thumb_height']) : 0;
    $arr['image_width']          = isset($arr['image_width']) ? intval($arr['image_width']) : 0;
    $arr['image_height']         = isset($arr['image_height']) ? intval($arr['image_height']) : 0;
    $arr['best_number']          = !empty($arr['best_number']) && intval($arr['best_number']) > 0 ? intval($arr['best_number'])     : 3;
    $arr['new_number']           = !empty($arr['new_number']) && intval($arr['new_number']) > 0 ? intval($arr['new_number'])      : 3;
    $arr['hot_number']           = !empty($arr['hot_number']) && intval($arr['hot_number']) > 0 ? intval($arr['hot_number'])      : 3;
    $arr['promote_number']       = !empty($arr['promote_number']) && intval($arr['promote_number']) > 0 ? intval($arr['promote_number'])  : 3;
    $arr['top_number']           = (isset($arr['top_number']) && intval($arr['top_number']) > 0) ? intval($arr['top_number'])      : 10;
    $arr['history_number']       = (isset($arr['history_number']) && intval($arr['history_number']) > 0) ? intval($arr['history_number'])  : 5;
    $arr['comments_number']      = (isset($arr['comments_number']) && intval($arr['comments_number']) > 0) ? intval($arr['comments_number']) : 5;
    $arr['article_number']       = (isset($arr['article_number']) && intval($arr['article_number']) > 0) ? intval($arr['article_number'])  : 5;
    $arr['page_size']            = (isset($arr['page_size']) && intval($arr['page_size']) > 0) ? intval($arr['page_size'])       : 10;
    $arr['bought_goods']         = isset($arr['bought_goods']) ? intval($arr['bought_goods']) : 0;
    $arr['goods_name_length']    = isset($arr['goods_name_length']) ? intval($arr['goods_name_length']) : 0;
    $arr['top10_time']           = isset($arr['top10_time']) ? intval($arr['top10_time']) : 0;
    $arr['goods_gallery_number'] = (isset($arr['goods_gallery_number']) && intval($arr['goods_gallery_number'])) ? intval($arr['goods_gallery_number']) : 5;
    $arr['no_picture']           = !empty($arr['no_picture']) ? str_replace('../', './', $arr['no_picture']) : 'images/no_picture.gif'; // 修改默认商品图片的路径
    $arr['qq']                   = !empty($arr['qq']) ? $arr['qq'] : '';
    $arr['ww']                   = !empty($arr['ww']) ? $arr['ww'] : '';
    $arr['default_storage']      = isset($arr['default_storage']) ? intval($arr['default_storage']) : 1;
    $arr['min_goods_amount']     = isset($arr['min_goods_amount']) ? floatval($arr['min_goods_amount']) : 0;
    $arr['one_step_buy']         = empty($arr['one_step_buy']) ? 0 : 1;
    $arr['invoice_type']         = empty($arr['invoice_type']) ? array('type' => array(), 'rate' => array()) : unserialize($arr['invoice_type']);
    $arr['show_order_type']      = isset($arr['show_order_type']) ? $arr['show_order_type'] : 0;    // 显示方式默认为列表方式
    $arr['help_open']            = isset($arr['help_open']) ? $arr['help_open'] : 1;    // 显示方式默认为列表方式
    
    
    //限定语言项
    $lang_array = array('zh_cn', 'zh_tw', 'en_us');
    if (empty($arr['lang']) || !in_array($arr['lang'], $lang_array)) {
        $arr['lang'] = 'zh_cn'; // 默认语言为简体中文
    }
    
    if (empty($arr['integrate_code'])) {
        $arr['integrate_code'] = 'ecjia'; // 默认的会员整合插件为 ecjia
    }
    
    return $arr;
}
RC_Hook::add_filter('set_ecjia_config_filter', 'set_ecjia_config_filter');    

// end