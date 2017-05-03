<?php
  
RC_Loader::load_app_class('platform_interface', 'platform', false);
class mp_userbind_bind_password implements platform_interface {
    
    public function action() {
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	RC_Loader::load_app_class('wechat_user', 'wechat', false);
    	$termmeta_db = RC_Loader::load_app_model('term_meta_model','wechat');
    	
    	$openid = trim($_GET['openid']);
    	$uuid = trim($_GET['uuid']);
    	$account = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	
    	$wechat_user = new wechat_user($wechat_id, $openid);
    	$ect_uid = $wechat_user->getUserId();
    	
    	$newpassword = trim($_POST['newpassword']);
    	$oldpassword = trim($_POST['oldpassword']);
    	$confirm_password = trim($_POST['confirm_password']);
    	
    	if(!empty($_POST['again']) && empty($oldpassword)) {
    		ecjia_front::$controller->showmessage('请输入原密码！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	if(empty($newpassword)) {
    		ecjia_front::$controller->showmessage('请设输入新密码！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    
    	if(empty($confirm_password)) {
    		ecjia_front::$controller->showmessage('请输入再次确认密码！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
        if($newpassword != $confirm_password) {
        	ecjia_front::$controller->showmessage('两次密码输入不一致，请重新设置密码！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
        	if(!empty($oldpassword)){
        		$result = RC_Api::api('user', 'edit_user', array('new_password' => $newpassword, 'user_id'=>$ect_uid, 'old_password' => $oldpassword));
        	}else {
        		$result = RC_Api::api('user', 'edit_user', array('new_password' => $newpassword, 'user_id'=>$ect_uid));
        		$data['object_type'] = 'ecjia.user';
        		$data['object_group'] = 'user';
        		$data['object_id'] = $ect_uid;
        		$data['meta_key'] = 'user_first_change_pwd';
        		$data['meta_value'] = 1;
        		$termmeta_db->insert($data);
        	}
        	
        	if (is_ecjia_error($result)) {
        		ecjia_front::$controller->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	} else {
        		ecjia_front::$controller->showmessage('设置密码成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_init', 'openid' => $openid, 'uuid' => $uuid,'ect_id'=>$ect_uid))));
        	}
        }
	}
}

// end