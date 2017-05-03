<?php
  
RC_Loader::load_app_class('platform_interface', 'platform', false);
class mp_userbind_bind_login implements platform_interface {
    
    public function action() {
        $css_url = RC_Plugin::plugins_url('css/wechat_redirect.css', __FILE__);
        $tplpath = RC_Plugin::plugin_dir_path(__FILE__) . 'templates/wechat_bind_login.dwt.php';
        
        RC_Loader::load_app_class('platform_account', 'platform', false);
        $uuid = trim($_GET['uuid']);
        $account = platform_account::make($uuid);
        $wechat_name = $account->getAccountName();
        ecjia_front::$controller->assign('wechat_name', $wechat_name);
        
        $openid = trim($_GET['openid']);
        $uuid = trim($_GET['uuid']);
        ecjia_front::$controller->assign('form_action',RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_signin', 'openid' => $openid, 'uuid' => $uuid)));
        ecjia_front::$controller->assign('css_url',$css_url);
        
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display($tplpath);
    }
}

// end