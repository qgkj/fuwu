<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 忘记密码请求验证
 * @author will
 */
class forget_validate_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
		$this->authadminSession();
		$ecjia = RC_Loader::load_app_class('api_admin', 'api');
		$ecjia->passwordSession();
		$code = $this->requestData('code');
		$type = $this->requestData('type');
		$time = RC_Time::gmtime() - 6000*3;//三分有效期
		if (empty($code)) {
			$result = new ecjia_error('code_empty_error', __('请填写校验码！'));
			return $result;
		}
		if ($time > $_SESSION['temp_code_time'] || empty($_SESSION['temp_code_time'])) {
			$result = new ecjia_error('code_timeout_error', __('校验码已过期！'));
			return $result;
		}

		if (!empty($code) && $code == $_SESSION['temp_code'] && $time < $_SESSION['temp_code_time']) {
			//校验成功
			return array();
		} else {
			$result = new ecjia_error('code_error', __('校验码错误！'));
			return $result;
		}
	}
}

// end