<?php
  
RC_Loader::load_app_class('platform_interface', 'platform', false);
class mp_userbind_bind_init implements platform_interface {
    
    public function action() {
        $css_url = RC_Plugin::plugins_url('css/wechat_redirect.css', __FILE__);
    	$jq_url = RC_Plugin::plugins_url('js/jquery.js', __FILE__);
    	ecjia_front::$controller->assign('jq_url',$jq_url);
    	ecjia_front::$controller->assign('css_url',$css_url);
    	ecjia_front::$controller->assign_lang();
    	
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	RC_Loader::load_app_class('wechat_user', 'wechat', false);
    	$termmeta_db = RC_Loader::load_app_model('term_meta_model','wechat');
    	$bonustype_db  = RC_Loader::load_app_model('bonus_type_model','bonus');
    	$platform_config = RC_Loader::load_app_model('platform_config_model','platform');
    	
        $tplpath = RC_Plugin::plugin_dir_path(__FILE__) . 'templates/wechat_redirect.dwt.php';
        $tplsuccesspath = RC_Plugin::plugin_dir_path(__FILE__) . 'templates/wechat_bind_success.dwt.php';

        $openid = trim($_GET['openid']);
        $uuid = trim($_GET['uuid']);

        $account = platform_account::make($uuid);
        $wechat_id = $account->getAccountID();
        $wechat_name = $account->getAccountName();
        
        $wechat_user = new wechat_user($wechat_id, $openid);
        $ect_uid = $wechat_user->getUserId();
        
        $user_db = RC_Loader::load_app_model('users_model', 'user');
        $user = $user_db->field('user_name, rank_points')->find(array('user_id' => $ect_uid));
        if (empty($ect_uid)) {
        	$signup_url = RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_signup', 'openid' => $openid, 'uuid' => $uuid));
        	$signin_url = RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_login', 'openid' => $openid, 'uuid' => $uuid));
        	ecjia_front::$controller->assign('wechat_name', $wechat_name);
        	ecjia_front::$controller->assign('signup_url', $signup_url);
        	ecjia_front::$controller->assign('signin_url', $signin_url);
        	ecjia_front::$controller->display($tplpath);
        } else {
        	$meta_value = $termmeta_db->where(array('object_id' => $ect_uid,'object_type' => 'ecjia.user','meta_key' => 'user_first_change_pwd'))->get_field('meta_value');
        	if(empty($meta_value) || $meta_value === 0) {
        		ecjia_front::$controller->assign('one','one');
        	}
        	$info = $platform_config->find(array('account_id' => $wechat_id,'ext_code'=>'mp_userbind'));
        	if (!empty($info)) {
        		// 配置信息
        		$config = array();
        		$config = unserialize($info['ext_config']);
        		foreach ($config as $k => $v) {
            		if ($v['name'] == 'point_status') {
            			$point_status = $v['value'];
            		}
            		if ($v['name'] == 'point_value') {
            			$point_value = $v['value'];
            		}
            		if ($v['name'] == 'bonus_status') {
            			$bonus_status = $v['value'];
            		}
            		if ($v['name'] == 'bonus_id') {
            			$bonus_id = $v['value'];
            		}
            	}
        	
        		if (isset($point_status) && $point_status == 1) {
        			ecjia_front::$controller->assign('point_value', $point_value);
        		}
        		if (isset($bonus_status) && $bonus_status == 1) {
        			$type_money = $bonustype_db->where(array('type_id' => $bonus_id))->get_field('type_money');
        			ecjia_front::$controller->assign('type_money', $type_money);
        		}
        	}
			ecjia_front::$controller->assign('form_action',RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_password', 'openid' => $openid, 'uuid' => $uuid)));
			ecjia_front::$controller->assign('username', $user['user_name']);
			ecjia_front::$controller->display($tplsuccesspath);
		}
	}
}

// end