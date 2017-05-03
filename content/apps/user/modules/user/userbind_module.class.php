<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 手机快速注册/用户账户关联注册（手机、邮箱等）
 * @author will.chen
 */
class userbind_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	$this->authSession();	
		$type = $this->requestData('type');
		$value = $this->requestData('value');
		
		$type_array = array('mobile');
		//判断值是否为空，且type是否是在此类型中
		if ( empty($type) || empty($value) || !in_array($type, $type_array)) {
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
		
		$db_user = RC_Model::model('user/users_model');
		//设置session用于校验校验码
		$code = rand(100000, 999999);
		RC_Loader::load_app_class('integrate', 'user', false);
		$user = integrate::init_users();
		if ($user->check_user($value)) {
			return array('registered' => 1);
		}
		$mobile_phone = $db_user->find(array('mobile_phone' => $value));
		if (!empty($mobile_phone)) {
			return array('registered' => 1);
		}
		
		if ($type == 'mobile') {
			//发送短信
			$tpl_name = 'sms_get_validate';
			$tpl   = RC_Api::api('sms', 'sms_template', $tpl_name);
			/* 判断短信模板是否存在*/
			if (empty($tpl)) {
			    return new ecjia_error('sms_tpl_error', '短信模板错误');
			}
			ecjia_api::$controller->assign('code', $code);
			ecjia_api::$controller->assign('mobile', $value);
			ecjia_api::$controller->assign('shopname', ecjia::config('shop_name'));
			ecjia_api::$controller->assign('service_phone', ecjia::config('service_phone'));
			$time = RC_Time::gmtime();
			ecjia_api::$controller->assign('time', RC_Time::local_date(ecjia::config('date_format'), $time));
			
			$content = ecjia_api::$controller->fetch_string($tpl['template_content']);
			$options = array(
				'mobile' 		=> $value,
				'msg'			=> $content,
				'template_id' 	=> $tpl['template_id'],
			);
			
			$response = RC_Api::api('sms', 'sms_send', $options);
			
			if ($response === true) {
				$_SESSION['bind_code']         = $code;
				$_SESSION['bindcode_lifetime'] = RC_Time::gmtime();
				$_SESSION['bind_value']        = $value;
				$_SESSION['bind_type']         = $type;
				return array('registered' => 0);
			} else {
				$result = new ecjia_error('sms_error', __('短信发送失败！'));
				return $result;
			}
		}
	}
}

// end