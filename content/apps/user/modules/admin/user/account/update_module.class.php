<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * @author will
 */
class update_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	
    	if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
    	
		$mobile	= $this->requestData('mobile');
    	$validate_code = $this->requestData('validate_code');
		
		if (empty($validate_code)) {
			return new ecjia_error('validate_code_empty', '请输入验证码！');
		}
		
		/* 判断code有效期*/
		$time = RC_Time::gmtime();
		if ($_SESSION['adminuser_validate_expiry'] < $time) {
			return new ecjia_error('code_expiry_error', __('验证码过期，请重新获取验证码！'));
		}
		
		if ($_SESSION['adminuser_validate_code'] != $validate_code) {
			return new ecjia_error('validate_code_error', '验证码错误！');
		}
		
		if (!empty($mobile)) {
			if ($_SESSION['adminuser_validate_value'] != $mobile) {
				return new ecjia_error('mobile_error', '验证手机号与提交手机号不符！');
			}
			$exists_staff_mobile = RC_DB::table('staff_user')->where('user_id', '<>', $_SESSION['staff_id'])->where('mobile', $mobile)->first();
			if ($exists_staff_mobile) {
				return new ecjia_error('mobile_exists', '手机号已存在！');
			}
			
			RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update(array('mobile' => $mobile));
		}
		
		return array();
	}
}

// end