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
		
		if (empty($type) || empty($type_info)) {
		    return  new ecjia_error('empty_error', __('请填写用户相关信息！'));
		}
		if ($type == "email") {
		    if (RC_Validate::_email('mail',$type_info) !== true) {
		        return new ecjia_error('email_error', __('邮箱格式不正确！'));
		    }
		}
		if ($type == "mobile") {
		    if(! preg_match('/^1[34578]{1}\d{9}$/', $type_info)){
		        return new ecjia_error('mobile_error', __('手机号格式不正确！'));
		    }
		}
		
		//根据用户名判断是商家还是平台管理员
		//如果商家员工表存在，以商家为准
		if ($type == "email") {
		    $row_staff = RC_DB::table('staff_user')->where('email', $type_info)->first();
		} else if ($type == "mobile") {
		    $row_staff = RC_DB::table('staff_user')->where('mobile', $type_info)->first();
		}
		
		if ($row_staff) {
		    //商家
		    return $this->forget_request_merchant($admin_username, $type, $type_info);
		} else {
		    //平台
		    return $this->forget_request_admin($admin_username, $type, $type_info);
		}
		
		
	    
	}
	
	private function forget_request_merchant($admin_username, $type, $type_info) {
	    if ($type == "email") {
	        $user_id = RC_DB::Table('staff_user')->where('email', $type_info)->pluck('user_id');
	
	        if (!empty($user_id)) {
	            $code    = rand(111111, 999999);
	            $content = "[".ecjia::config('shop_name')."]您的管理员账户正在变更账户信息，效验码：".$code."，打死都不能告诉别人哦！唯一热线".ecjia::config('service_phone');
	            /* 发送确认重置密码的确认邮件 */
	            if (RC_Mail::send_mail($admin_username, $type_info, '账户变更效验码', $content, 1)) {
	                $_SESSION['temp_code']      = $code;
	                $_SESSION['temp_code_time'] = RC_Time::gmtime();
	                $data = array(
	                    'uid' => $user_id,
	                    'sid' => RC_Session::session_id(),
	                );
	                 
	                return $data;
	            } else {
	                return new ecjia_error('post_email_error', __('邮件发送失败！'));
	            }
	        } else {
	            /* 提示信息 */
	            return new ecjia_error('userinfo_error', __('用户不存在！'));
	        }
	    } else if ($type == "mobile") {
	
	        $mobile = $type_info;
	        $user_id = RC_DB::Table('staff_user')->where('mobile', $mobile)->pluck('user_id');
	
	        if (!empty($user_id)) {
	            $code      = rand(111111, 999999);
	            $tpl_name  = 'sms_get_password';
	            $tpl       = RC_Api::api('sms', 'sms_template', $tpl_name);
	            if (!empty($tpl)) {
	                $this->assign('code', $code);
	                $this->assign('service_phone', 	ecjia::config('service_phone'));
	                $content = $this->fetch_string($tpl['template_content']);
	                $options = array(
	                    'mobile' 		=> $mobile,
	                    'msg'			=> $content,
	                    'template_id' 	=> $tpl['template_id'],
	                );
	                $response = RC_Api::api('sms', 'sms_send', $options);
	                 
	                if($response === true) {
	                    $_SESSION['user_id'] 	    = $user_id;
	                    $_SESSION['temp_code'] 	    = $code;
	                    $_SESSION['temp_code_time'] = RC_Time::gmtime();
	                    $data = array(
	                        'uid' => $user_id,
	                        'sid' => RC_Session::session_id(),
	                    );
	                     
	                    return $data;
	                } else {
	                    return $response;
	                }
	            } else {
	                return new ecjia_error('sms_tpl_error', __('短信模板错误'));
	            }
	        } else {
	            /* 提示信息 */
	            return new ecjia_error('userinfo_error', __('用户不存在！'));
	        }
	    }
	}
	
	private function forget_request_admin($admin_username, $type, $type_info) {
	    if ($type == "email") {
	        $db = RC_Model::model('user/admin_user_model');
	        /* 管理员用户名和邮件地址是否匹配，并取得原密码 */
	        $admin_info = $db->field('user_id, password')->find(array('user_name' => $admin_username, 'email' => $type_info));
	
	        if (!empty($admin_info)) {
	            $code    = rand(111111, 999999);
	            $content = "[".ecjia::config('shop_name')."]您的管理员账户正在变更账户信息，效验码：".$code."，打死都不能告诉别人哦！唯一热线".ecjia::config('service_phone');
	            /* 发送确认重置密码的确认邮件 */
	            if (RC_Mail::send_mail($admin_username, $type_info, '账户变更效验码', $content, 1)) {
	                $_SESSION['temp_code']      = $code;
	                $_SESSION['temp_code_time'] = RC_Time::gmtime();
	                $data = array(
	                    'uid' => $admin_info['user_id'],
	                    'sid' => RC_Session::session_id(),
	                );
	                 
	                return $data;
	            } else {
	                return new ecjia_error('post_email_error', __('邮件发送失败！'));
	            }
	        } else {
	            /* 提示信息 */
	            return new ecjia_error('userinfo_error', __('用户名与其信息不匹配！'));
	        }
	    }
	}
}

// end