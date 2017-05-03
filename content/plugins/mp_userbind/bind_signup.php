<?php
  
RC_Loader::load_app_class('platform_interface', 'platform', false);
class mp_userbind_bind_signup implements platform_interface {
    
    public function action() {
    	$css_url = RC_Plugin::plugins_url('css/wechat_redirect.css', __FILE__);
    	$jq_url = RC_Plugin::plugins_url('js/jquery.js', __FILE__);
    	$tplpath = RC_Plugin::plugin_dir_path(__FILE__) . 'templates/wechat_bind_success.dwt.php';
    
    	$platform_config = RC_Loader::load_app_model('platform_config_model','platform');
    	$account_log_db  = RC_Loader::load_app_model('account_log_model','user');
    	$bonustype_db  = RC_Loader::load_app_model('bonus_type_model','bonus');
    	$userbonus_db = RC_Loader::load_app_model('user_bonus_model','bonus');
    	$termmeta_db = RC_Loader::load_app_model('term_meta_model','wechat');
    	
	    $openid = trim($_GET['openid']);
	    $uuid = trim($_GET['uuid']);
	    RC_Loader::load_app_class('platform_account', 'platform', false);
	    
	    $account = platform_account::make($uuid);
	    $wechat_id = $account->getAccountID();
	    
       	RC_Loader::load_app_class('wechat_user', 'wechat', false);
       	$wechat_user = new wechat_user($wechat_id, $openid);
       	$ect_uid = $wechat_user->getUserId();
       	$time = RC_Time::gmtime();
       	if (empty($ect_uid)) {       		
       		$username  = $wechat_user->getNickname();
       		$password  = wechat_user::generate_password();
       		$email     = wechat_user::generate_email();
       		$sex       = $wechat_user->sex();
       		$reg_time  = RC_Time::gmtime();
       		$user = RC_Api::api('user', 'init_user');
       		if ($user && $user->check_user($username)) {
       		    $username = $username . rc_random(4, 'abcdefghijklmnopqrstuvwxyz0123456789');
       		}
       		$user_info = RC_Api::api('user', 'add_user', array('username' => $username, 'password' => $password, 'email' => $email, 'sex'=>$sex, 'reg_time'=>$reg_time));
            if (is_ecjia_error($user_info)) {
            	ecjia_front::$controller->showmessage($user_info->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                $user_id = $user_info['user_id'];
            	$wechat_user->setUserId($user_id);
            	$info = $platform_config->find(array('account_id' => $wechat_id,'ext_code'=>'mp_userbind'));
            	if (!empty($info)) {
            		// 配置信息
            		$config = array();
            		$config = unserialize($info['ext_config']);
            		foreach ($config as $k => $v) {
            			if ($v['name'] == 'point_status') {
            				$point_status = $v['value'];
            			}
            			if ($v['name'] == 'point_interval') {
            				$point_interval = $v['value'];
            			}
            			if ($v['name'] == 'point_num') {
            				$point_num = $v['value'];
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
            			$users_db = RC_Loader::load_app_model('users_model','user');
            			$point = array(
            				'rank_points' =>intval($point_value)
            			);
            			$users_db->where(array('user_id' => $user_id))->update($point);
            			// 积分记录
            			$data['user_id'] = $user_id;
            			$data['user_money'] = 0;
            			$data['frozen_money'] = 0;
            			$data['rank_points'] = $point_value;
            			$data['pay_points'] = 0;
            			$data['change_time'] = $time;
            			$data['change_desc'] = '积分赠送';
            			$data['change_type'] = ACT_OTHER;
            			$log_id = $account_log_db->insert($data);
            			ecjia_front::$controller->assign('point_value', $point_value);
            		} 
            		
            		$type_money = $bonustype_db->where(array('type_id' => $bonus_id))->get_field('type_money');
            		
            	    //赠送红包      		
            		if (isset($bonus_status) && $bonus_status == 1) {
            			$data['bonus_type_id'] = $bonus_id;
            			$data['bonus_sn'] = 0;
            			$data['user_id'] = $user_id;
            			$data['used_time'] = 0;
            			$data['order_id'] = 0;
            			$data['emailed'] = 0;
            			$userbonus_db->insert($data);
            			ecjia_front::$controller->assign('type_money', $type_money);
            		}
            		$meta_value = $termmeta_db->where(array('object_id' => $user_id,'object_type' => 'ecjia.user','meta_key' => 'user_first_change_pwd'))->get_field('meta_value');
            		if(empty($meta_value) || $meta_value === 0) {
            			ecjia_front::$controller->assign('one','one');
            		} 
            		ecjia_front::$controller->assign('form_action',RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_password', 'openid' => $openid, 'uuid' => $uuid)));
            		ecjia_front::$controller->assign('username',$username);
            		ecjia_front::$controller->assign('css_url',$css_url);
            		ecjia_front::$controller->assign('jq_url',$jq_url);
            		ecjia_front::$controller->assign_lang();
            		ecjia_front::$controller->display($tplpath);
            	}
            }
       	} 
	}
}

// end