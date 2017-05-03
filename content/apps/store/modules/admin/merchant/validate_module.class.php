<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 入驻申请等信息获取验证码
 * @author
 */
class validate_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$type		    = $this->requestData('type');
		$value		    = $this->requestData('value');
		$validate_type	= $this->requestData('validate_type');
		$validate_code	= $this->requestData('validate_code');
		$time           = RC_Time::gmtime();

		if (empty($type) || empty($value)) {
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}

		/* 如果进度查询，查询入驻信息是否存在*/
		if ($validate_type == 'process') {
			$info_store_preaudit	= RC_DB::table('store_preaudit')->where('contact_mobile', $value)->first();
			$info_store_franchisee	= RC_DB::table('store_franchisee')->where('contact_mobile', $value)->first();
			if (empty($info_store_preaudit) && empty($info_store_franchisee)) {
				return new ecjia_error('store_error', '您还未申请入驻！');
			}
		}

		if ($type == 'mobile' && $validate_type == 'signup') {
            $info_store_preaudit	= RC_DB::table('store_preaudit')->where('contact_mobile', $value)->count();
			$info_store_franchisee	= RC_DB::table('store_franchisee')->where('contact_mobile', $value)->first();
            $info_staff_user		= RC_DB::table('staff_user')->where('mobile', $value)->first();
			if (!empty($info_store_preaudit)){
                return new ecjia_error('merchant_checking', '手机号'.$value.'已被申请请确认该账号是否为本人所有');
            }elseif(!empty($info_store_franchisee)){
                return new ecjia_error('merchant_exist', '手机号'.$value.'已被申请请确认该账号是否为本人所有');
            }
            if(!empty($info_staff_user)){
                return new ecjia_error('already_signup', '手机号'.$value.'已被注册为店铺员工');
            }
		}

        if (!empty($validate_code)) {
			/* 判断校验码*/
			if ($_SESSION['merchant_validate_code'] != $validate_code) {
				return new ecjia_error('validate_code_error', '校验码错误！');
			} elseif ($_SESSION['merchant_validate_expiry'] < RC_Time::gmtime()) {
				return new ecjia_error('validate_code_time_out', '校验码已过期！');
			}
			return array('message' => '校验成功！');
		}

		if (($_SESSION['merchant_validate_expiry'] - 1740) > $time && empty($validate_code)) {
		    return new ecjia_error('restrict_times', '您发送验证码的频率过高，请稍等一分钟！');
		}

        // 发送验证码
        $result = ecjia_app::validate_application('sms');
        /* 判断是否有短信app*/
        if (!is_ecjia_error($result)) {
            //发送短信
            $code     = rand(100000, 999999);
            $tpl_name = 'sms_get_validate';
            $tpl      = RC_Api::api('sms', 'sms_template', $tpl_name);
            /* 判断短信模板是否存在*/
            if (!empty($tpl)) {
// 					if ($validate_type == 'signup') {
// 						ecjia_api::$controller->assign('action', '申请入驻认证');
// 					} else {
// 						ecjia_api::$controller->assign('action', '查询入驻审核进度');
// 					}

                ecjia_api::$controller->assign('code', $code);
                ecjia_api::$controller->assign('service_phone', ecjia::config('service_phone'));

                $content = ecjia_api::$controller->fetch_string($tpl['template_content']);
                $options = array(
                        'mobile' 		=> $value,
                        'msg'			=> $content,
                        'template_id' 	=> $tpl['template_id'],
                );
                $time     = RC_Time::gmtime();
                $response = RC_Api::api('sms', 'sms_send', $options);
            }
        }

        /* 判断是否发送成功*/
        if (isset($response) && $response === true) {
            $time = RC_Time::gmtime();
            $_SESSION['merchant_validate_code'] = $code;
            $_SESSION['merchant_validate_mobile'] = $value;
            $_SESSION['merchant_validate_expiry'] = $time + 1800;//设置有效期30分钟
            // RC_Logger::getLogger('error')->error($_SESSION['merchant_validate_code']);
            return array('message' => '验证码发送成功！');
        } else {
            return new ecjia_error('send_code_error', __('验证码发送失败！'));
        }
    }

}

//end