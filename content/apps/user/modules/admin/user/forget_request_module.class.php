<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 忘记密码请求
 * @author will
 */
class forget_request_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
		$this->authadminSession();
		$admin_username = $this->requestData('username');
		$type = $this->requestData('type');
		$type_info    = $this->requestData('type_info');
		
		if (empty($admin_username) || empty($type_info)) {
			$result = new ecjia_error('empty_error', __('请填写用户相关信息！'));
			return $result;
		}
		if ($type == "email") {
			if (RC_Validate::_email('mail',$type_info) !== true) {
				$result = new ecjia_error('email_error', __('邮箱格式不正确！'));
				return $result;
			}
			$db = RC_Model::model('user/admin_user_model');
			
			/* 管理员用户名和邮件地址是否匹配，并取得原密码 */
			$admin_info = $db->field('user_id, password')->find(array('user_name' => $admin_username, 'email' => $type_info));
		}
		if (!empty($admin_info)) {
			if ($type == "email") {
				$code = rand(111111, 999999);
				$content = "[".ecjia::config('shop_name')."]您的管理员账户正在变更账户信息，效验码：".$code."，打死都不能告诉别人哦！唯一热线".ecjia::config('service_phone');
				/* 发送确认重置密码的确认邮件 */
				if (RC_Mail::send_mail($admin_username, $type_info, '账户变更效验码', $content, 1)) {
					$_SESSION['temp_code'] = $code;
					$_SESSION['temp_code_time'] = RC_Time::gmtime();
					$data = array(
							'uid' => $admin_info['user_id'],
							'sid' => RC_Session::session_id(),
					);
					
					return $data;
					
				} else {
					$result = new ecjia_error('post_email_error', __('邮件发送失败！'));
					return $result;
				}
			}
		} else {
			/* 提示信息 */
			$result = new ecjia_error('userinfo_error', __('用户名与其信息不匹配！'));
			return $result;
		}
	    
		
		
		// 			/* 生成验证的code */
		// 			$admin_id = $admin_info['user_id'];
		// 			$code     = md5($admin_id . $admin_info['password']);
		
		// 			$reset_email = RC_Uri::url('@get_password/reset_pwd_form', array('uid' => $admin_id, 'code' => $code));
		
		// 			/* 设置重置邮件模板所需要的内容信息 */
		// 			$tpl_name = 'send_password';
		// 			$template   = RC_Api::api('mail', 'mail_template', $tpl_name);
		
		// 			$this->assign('user_name',   $admin_username);
		// 			$this->assign('reset_email', $reset_email);
		// 			$this->assign('shop_name',   ecjia::config('shop_name'));
		// 			$this->assign('send_date',   RC_Time::local_date(ecjia::config('date_format')));
		// 			$this->assign('sent_date',   RC_Time::local_date(ecjia::config('date_format')));
		
		// 			$state = ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON;
		
		// 			if (RC_Mail::send_mail('', $admin_email, $template['template_subject'], $this->fetch_string($template['template_content']), $template['is_html'])) {
		// 				$msg = __('重置密码的邮件已经发到您的邮箱：') . $admin_email;
		// 				$state = ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON;
		// 			} else {
		// 				$msg = __('重置密码邮件发送失败!请与管理员联系');
		// 			}
	}
}

// end