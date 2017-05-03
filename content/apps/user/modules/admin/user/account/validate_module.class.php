<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 
 * @author will
 */
class validate_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	
		$validate_type	= $this->requestData('validate_type');
    	$validate_value = $this->requestData('validate_value');
		
		if (empty($validate_type) || empty($validate_value)) {
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter'));
		}
		
		$code = rand(100000, 999999);
		$response = '';
		if ($validate_type == 'mobile') {
			$result = ecjia_app::validate_application('sms');
			/* 判断是否有短信app*/
			if (!is_ecjia_error($result)) {
				//发送短信
				$tpl_name = 'sms_get_validate';
				$tpl   = RC_Api::api('sms', 'sms_template', $tpl_name);
				/* 判断短信模板是否存在*/
				if (!empty($tpl)) {
					ecjia_api::$controller->assign('code', $code);
					ecjia_api::$controller->assign('service_phone', ecjia::config('service_phone'));
					 
					$content = ecjia_api::$controller->fetch_string($tpl['template_content']);
					$options = array(
							'mobile' 		=> $validate_value,
							'msg'			=> $content,
							'template_id' 	=> $tpl['template_id'],
					);
		
					$response = RC_Api::api('sms', 'sms_send', $options);
				}
			}
		}
		
		
		/* 判断是否发送成功*/
		if ($response === true) {
			$time = RC_Time::gmtime();
			$_SESSION['adminuser_validate_value']	= $validate_value;
			$_SESSION['adminuser_validate_code']	= $code;
			$_SESSION['adminuser_validate_expiry']	= $time + 600;//设置有效期10分钟
			return array('data' => '验证码发送成功！');
		} else {
			return new ecjia_error('send_code_error', __('验证码发送失败！'));
		}
		
	}
}

// end