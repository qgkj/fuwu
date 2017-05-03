<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class bind_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authSession();	
		$open_id      = $this->requestData('openid');
		$connect_code = $this->requestData('code');
		$username	  = $this->requestData('username');
		$password	  = $this->requestData('password');
		$profile	  = $this->requestData('profile');
		$device		  = $this->device;
		
		if (empty($open_id) || empty($connect_code) || empty($username) || empty($password)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}
		
		RC_Loader::load_app_class('connect_user', 'connect', false);
		$connect_user = new connect_user($connect_code, $open_id);
		if ($connect_user->check_openid_exist()) {
			return new ecjia_error('connect_userbind', '您已绑定过会员用户！');
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
		RC_Loader::load_app_class('integrate', 'user', false);
		$user = integrate::init_users();
		
		$is_mobile = false;
		
		/* 判断是否为手机号*/
		if (is_numeric($username) && strlen($username) == 11 && preg_match( '/^1[3|4|5|7|8][0-9]\d{8}$/', $username)) {
			$db_user     = RC_Model::model('user/users_model');
			$user_count  = $db_user->where(array('mobile_phone' => $username))->count();
			if ($user_count > 1) {
				return new ecjia_error('user_repeat', '用户重复，请与管理员联系！');
			}
			$check_user = $db_user->where(array('mobile_phone' => $username))->get_field('user_name');
			/* 获取用户名进行判断验证*/
			if (!empty($check_user)) {
				if ($user->login($check_user, $password)) {
					$is_mobile = true;
				}
			}
		}
		
		/* 如果不是手机号码*/
		if (!$is_mobile) {
			if (!$user->login($username, $password)) {
				return new ecjia_error('password_error', '密码错误！');
			}
		}
		
		/* 用户帐号是否已被关联使用过*/
		$connect_user_exit = RC_Model::model('connect/connect_user_model')->where(array('connect_code' => $connect_code, 'user_id' => $_SESSION['user_id']))->find();
		if (!empty($connect_user_exit)) {
			return new ecjia_error('connect_userbind', '您已绑定过会员用户！');
		}
		$curr_time = RC_Time::gmtime();
		$data = array(
			'connect_code'	=> $connect_code,
			'open_id'		=> $open_id,
			'create_at'     => $curr_time,
			'user_id'		=> $_SESSION['user_id'],
			'profile'		=> serialize($profile)
		);
		RC_Model::model('connect/connect_user_model')->insert($data);
		
		/* 获取远程用户头像信息*/
		RC_Api::api('connect', 'update_user_avatar', array('avatar_url' => $profile['avatar_img']));
		
		RC_Loader::load_app_func('admin_user', 'user');
		$user_info = EM_user_info($_SESSION['user_id']);
		update_user_info(); // 更新用户信息
		RC_Loader::load_app_func('cart','cart');
		recalculate_price(); // 重新计算购物车中的商品价格
		
		$out = array(
			'token' => RC_Session::session_id(),
			'user' => $user_info
		);
		
		feedback_batch_userid($_SESSION['user_id'], $_SESSION['user_name'], $device);
		
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
		return $out;
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