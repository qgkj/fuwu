<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class signin_module extends api_front implements api_interface {
	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {		
		$this->authSession();
		$open_id      = $this->requestData('openid');
		$connect_code = $this->requestData('code');
		$device       = $this->device;
		$profile	  = $this->requestData('profile');
		
		if (empty($open_id) || empty($connect_code)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
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
		
		RC_Loader::load_app_class('connect_user', 'connect', false);
		$connect_user = new connect_user($connect_code, $open_id);
		//判断已绑定授权登录用户 直接登录
		if ($connect_user->check_openid_exist()) {
			$connect_user_id = $connect_user->get_openid();
			$user_info = RC_Api::api('user', 'user_info', array('user_id' => $connect_user_id['user_id']));
			RC_Loader::load_app_class('integrate', 'user', false);
			$user = integrate::init_users();
			$user->set_session($user_info['user_name']);
			$user->set_cookie($user_info['user_name']);
			
			$data = array(
				'profile' => serialize($profile)
			);
			RC_Model::model('connect/connect_user_model')->where(array('connect_code' => $connect_user->connect_code, 'open_id' => $connect_user->open_id, 'user_id' => $_SESSION['user_id']))->update($data);
			
			/* 获取远程用户头像信息*/
			RC_Api::api('connect', 'update_user_avatar', array('avatar_url' => $profile['avatar_img']));
		} else {
			return new ecjia_error('connect_no_userbind', '请关联或注册一个会员用户！');
			//新用户注册并登录
// // 			$username = $connect_user->get_username();
// 			$username = $username . rc_random(4, 'abcdefghijklmnopqrstuvwxyz0123456789');
// 			$password = md5(rc_random(9, 'abcdefghijklmnopqrstuvwxyz0123456789'));
// // 			$email = $connect_user->get_email();
// 			$email = rc_random(8, 'abcdefghijklmnopqrstuvwxyz0123456789').'@'.$connect_code.'.com';
// 			$user = integrate::init_users();
// 			$result = $user->add_user($username, $password, $email);
// 			$user->set_session($username);
// 			$user->set_cookie($username);
// 			$curr_time = RC_Time::gmtime();
// 			$data = array(
// 					'connect_code'	=> $connect_user->connect_code,
// 					'open_id'		=> $connect_user->open_id,
// 					'create_at'     => $curr_time,
// 					'user_id'		=> $_SESSION['user_id']
// 			);
// 			RC_Model::model('connect/connect_user_model')->insert($data);
		}
		
		// 1、同步会员信息
		// 2、修正咨询信息	
		
		feedback_batch_userid($_SESSION['user_id'], $_SESSION['user_name'], $device);

		RC_Loader::load_app_func('admin_user', 'user');
		$user_info = EM_user_info($_SESSION['user_id']);
		
		update_user_info(); // 更新用户信息
		RC_Loader::load_app_func('cart','cart');
		recalculate_price(); // 重新计算购物车中的商品价格
		
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