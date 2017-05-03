<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 找回密码请求
 * @author will
 */
class forget_password_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
        $type = $this->requestData('type');
        $value = $this->requestData('value');
        if (empty($type) || empty($value)) {
        	return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
        }
        
        $db = RC_Model::model('user/users_model');
        
        if ($type == 'mobile') {
        	$user_count = $db->where(array('mobile_phone' => $value))->count();
        	//如果用户数量大于1
        	if ($user_count > 1) {
        		return new ecjia_error('mobile_repeat_error', __('手机号重复，请与管理员联系！'));
        	}
        	$userinfo = $db->find(array('mobile_phone' => $value));
        }
        if ($type == 'email') {
        	$userinfo = $db->find(array('email' => $value));
        }
        
        if (empty($userinfo)) {
        	return new ecjia_error('user_error', __('用户信息错误！'));
        }
        
        $code = rand(100000, 999999);
        /* 短信找回密码*/
        if ($type == 'mobile') {
        	$result = ecjia_app::validate_application('sms');
        	/* 判断是否有短信app*/
        	if (!is_ecjia_error($result)) {
        		//发送短信
        		$tpl_name = 'sms_get_validate';
        		$tpl   = RC_Api::api('sms', 'sms_template', $tpl_name);
        		/* 判断短信模板是否存在*/
        		if (!empty($tpl)) {
        			ecjia_api::$controller->assign('action', __('短信找回密码'));
        			ecjia_api::$controller->assign('code', $code);
        			ecjia_api::$controller->assign('service_phone', ecjia::config('service_phone'));
        			
        			$content = ecjia_api::$controller->fetch_string($tpl['template_content']);
        			$options = array(
        					'mobile' 		=> $value,
        					'msg'			=> $content,
        					'template_id' 	=> $tpl['template_id'],
        			);
        				
        			$response = RC_Api::api('sms', 'sms_send', $options);
        		}
        	}
        }
        /* 邮箱找回密码*/
        if ($type == 'email') {
        	$tpl_name = 'email_verifying_authentication';
        	$tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);
            /* 判断短信模板是否存在*/
        	if (!empty($tpl)) {
        		ecjia_api::$controller->assign('action', __('通过短信找回密码'));
        		ecjia_api::$controller->assign('code', $code);
        		ecjia_api::$controller->assign('service_phone', ecjia::config('service_phone'));
        		$content  = ecjia_api::$controller->fetch_string($tpl['template_content']);
        		$response = RC_Mail::send_mail(ecjia::config('shop_name'), $value, $tpl['template_subject'], $content, $tpl['is_html']);
        	}
        }
        /* 判断是否发送成功*/
        if ($response === true) {
        	$time = RC_Time::gmtime();
        	$_SESSION['forget_code']   = $code;
        	$_SESSION['forget_expiry'] = $time + 600;//设置有效期10分钟
        	return array('data' => '验证码发送成功！');
        } else {
        	return new ecjia_error('send_code_error', __('验证码发送失败！'));
        }
	}
}

// end