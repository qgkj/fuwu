<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class signup_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$this->authSession();
		$open_id      = $this->requestData('openid');
		$connect_code = $this->requestData('code');
		$username	  = $this->requestData('username');
		$mobile		  = $this->requestData('mobile');
		$password	  = $this->requestData('password');
		$device       = $this->device;
		$invite_code  = $this->requestData('invite_code');
		$code		  = $this->requestData('validate_code');
		$profile	  = $this->requestData('profile');

		RC_Loader::load_app_class('connect_user', 'connect', false);
		$connect_user = new connect_user($connect_code, $open_id);
		if ($connect_user->check_openid_exist()) {
			return new ecjia_error('connect_userbind', '您已绑定过会员用户！');
		}

		if (empty($open_id) || empty($password) || empty($connect_code)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}

		//判断校验码是否过期
		if (!empty($mobile) && (!isset($_SESSION['bindcode_lifetime']) || $_SESSION['bindcode_lifetime'] + 180 < RC_Time::gmtime())) {
			//过期
			return new ecjia_error('code_timeout', '验证码已过期，请重新获取！');
		}
		//判断校验码是否正确
		if (!empty($mobile) && (!isset($_SESSION['bindcode_lifetime']) || $code != $_SESSION['bind_code'] )) {
			return new ecjia_error('code_error', '验证码错误，请重新填写！');
		}

		/**
		 * $code
		 * login_weibo
		 * sns_qq
		 * sns_wechat
		 * login_mobile
		 * login_mail
		 * login_username
		 * login_alipay
		 * login_taobao
		 **/
		/* 如有手机号判断手机号是否被绑定过*/
		if (!empty($mobile)) {
			$mobile_count = RC_Model::model('user/users_model')->where(array('mobile_phone' => $mobile))->count();
			if ($mobile_count > 0 ) {
				return new ecjia_error('mobile_exists', '您的手机号已使用');
			}
		}
		RC_Loader::load_app_class('integrate', 'user', false);
		$user = integrate::init_users();
		if ($user->check_user($username)) {
			$username = $username . rc_random(4, 'abcdefghijklmnopqrstuvwxyz0123456789');
		}
		//新用户注册并登录
		$email = rc_random(8, 'abcdefghijklmnopqrstuvwxyz0123456789').'@'.$connect_code.'.com';

		$result = $user->add_user($username, $password, $email);

		if ($result) {
			$user->set_session($username);
			$user->set_cookie($username);
			/* 注册送积分 */
			if (ecjia::config('register_points' , ecjia::CONFIG_EXISTS)) {
				$options = array(
					'user_id'		=> $_SESSION['user_id'],
					'rank_points'	=> ecjia::config('register_points'),
					'pay_points'	=> ecjia::config('register_points'),
					'change_desc'	=> RC_Lang::get('connect::connect.register_points')
				);
				$result = RC_Api::api('user', 'account_change_log',$options);
			}

			if (!empty($mobile)) {
				RC_Model::model('user/users_model')->where(array('user_id' => $_SESSION['user_id']))->update(array('mobile_phone' => $mobile));
			}
			RC_Model::model('user/users_model')->where(array('user_id' => $_SESSION['user_id']))->update(array('reg_time' => RC_Time::gmtime()));
			
			$curr_time = RC_Time::gmtime();
			$data = array(
				'connect_code'	=> $connect_user->connect_code,
				'open_id'		=> $connect_user->open_id,
				'create_at'     => $curr_time,
				'user_id'		=> $_SESSION['user_id'],
				'profile'		=> serialize($profile)
			);
			RC_Model::model('connect/connect_user_model')->insert($data);

			/* 获取远程用户头像信息*/
			RC_Api::api('connect', 'update_user_avatar', array('avatar_url' => $profile['avatar_img']));

// 			/*注册送红包*/
// 			RC_Api::api('bonus', 'send_bonus', array('type' => SEND_BY_REGISTER));

			RC_Api::api('affiliate', 'invite_bind', array('invite_code' => $invite_code, 'mobile_phone' => $mobile));

			// 1、同步会员信息
			// 2、修正咨询信息
// 			feedback_batch_userid($_SESSION['user_id'], $_SESSION['user_name'], $device);

			RC_Loader::load_app_func('admin_user', 'user');
			$user_info = EM_user_info($_SESSION['user_id']);
			update_user_info(); // 更新用户信息
			RC_Loader::load_app_func('cart','cart');
			recalculate_price(); // 重新计算购物车中的商品价格

			unset($_SESSION['bind_code']);
			unset($_SESSION['bindcode_lifetime']);
			unset($_SESSION['bind_value']);
			unset($_SESSION['bind_type']);

			//修正关联设备号
			$result = ecjia_app::validate_application('mobile');
			if (!is_ecjia_error($result)) {
				if (!empty($device['udid']) && !empty($device['client']) && !empty($device['code'])) {
					$db_mobile_device = RC_Model::model('mobile/mobile_device_model');
					$device_data = array(
						'device_udid'	=> $device['udid'],
						'device_client'	=> $device['client'],
						'device_code'	=> $device['code'],
						'user_type'		=> 'user',
					);
					$db_mobile_device->where($device_data)->update(array('user_id' => $_SESSION['user_id'], 'update_time' => RC_Time::gmtime()));
				}
			}

			$out = array(
				'token' => RC_Session::session_id(),
				'user'	=> $user_info
			);
			return $out;
		} else {
			if (is_ecjia_error($user->error)) {
				return $user->error;
			}
		}
	}
}

/**
 * 修正咨询信息
 * @param string $user_id
 * @param string $device
 */
function feedback_batch_userid($user_id, $user_name, $device) {
	$device_udid	  = $device['udid'];
	$device_client	  = $device['client'];
	$db_term_relation = RC_Model::model('term_relationship_model');

	$object_id = $db_term_relation->where(array(
		'object_type'	=> 'ecjia.feedback',
		'object_group'	=> 'feedback',
		'item_key2'		=> 'device_udid',
		'item_value2'	=> $device_udid
	))->get_field('object_id', true);
	//更新未登录用户的咨询
	$db_term_relation->where(array('item_key2' => 'device_udid', 'item_value2' => $device_udid))->update(array('item_key2' => '', 'item_value2' => ''));

	if (!empty($object_id)) {
		$db = RC_Model::model('feedback/feedback_model');
		$db->where(array('msg_id' => $object_id, 'msg_area' => '4'))->update(array('user_id' => $user_id, 'user_name' => $user_name));
		$db->where(array('parent_id' => $object_id, 'msg_area' => '4'))->update(array('user_id' => $user_id, 'user_name' => $user_name));
	}
}

// end