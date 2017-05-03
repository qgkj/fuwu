<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 用户注册绑定验证
 * @author will.chen
 */
class bind_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
    	$this->authSession();	
		$type = $this->requestData('type');
		$value = $this->requestData('value');
		$code = $this->requestData('code');
		
		$type_array = array('mobile');
		//判断值是否为空，且type是否是在此类型中
		if ( empty($type) || empty($value) || empty($code) || !in_array($type, $type_array)) {
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
 		//判断校验码是否过期
 		if ($_SESSION['bindcode_lifetime'] + 1800 < RC_Time::gmtime()) {
 			//过期
 			$result = new ecjia_error('code_timeout', __('验证码已过期，请重新获取！'));
 			return $result;
 		}
 		//判断校验码是否正确
 		if ($code != $_SESSION['bind_code'] ) {
 			$result = new ecjia_error('code_error', __('验证码错误，请重新填写！'));
 			return $result;
 		}
 		
 		//校验其他信息
 		if ($type != $_SESSION['bind_type'] || $value != $_SESSION['bind_value']) {
 			$result = new ecjia_error('msg_error', __('信息错误，请重新获取验证码'));
 			return $result;
 		}
 		
 		if ($type == 'mobile') {
 			RC_Loader::load_app_class('integrate', 'user', false);
 			$user = integrate::init_users();
 			if($user->check_user($value)) {
 				return array('registered' => 1);
 			} else {
	 			unset($_SESSION['bind_code']);
	 			unset($_SESSION['bindcode_lifetime']);
	 			unset($_SESSION['bind_value']);
	 			unset($_SESSION['bind_type']);
	 				
	 			$out = array(
	 				'registered' => 0,
	 			);
	 			return $out;
 			}
 		} 
	}
}

// end