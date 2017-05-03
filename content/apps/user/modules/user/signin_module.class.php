<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class signin_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
	    RC_Loader::load_app_class('integrate', 'user', false);
	    $user = integrate::init_users();
		RC_Loader::load_app_func('admin_user','user');
		RC_Loader::load_app_func('cart','cart');
		$name = $this->requestData('name');
		$password = $this->requestData('password');
		
		$is_mobile = false;

		/* 判断是否为手机号*/
		if (is_numeric($name) && strlen($name) == 11 && preg_match( '/^1[3|4|5|7|8][0-9]\d{8}$/', $name)) {
			$db_user    = RC_Model::model('user/users_model');
			$user_count = $db_user->where(array('mobile_phone' => $name))->count();
			if ($user_count > 1) {
				return new ecjia_error('user_repeat', '用户重复，请与管理员联系！');
			}
			$check_user = $db_user->where(array('mobile_phone' => $name))->get_field('user_name');
			/* 获取用户名进行判断验证*/
			if (!empty($check_user)) {
				if ($user->login($check_user, $password)) {
					$is_mobile = true;
				}
			}
		}
		
		/* 如果不是手机号码*/
		if (!$is_mobile) {
			if (!$user->login($name, $password)) {
				return new ecjia_error('userinfo_error', '您输入的账号信息不正确 ！');
			}
		}
		
		$user_info = EM_user_info($_SESSION['user_id']);
		$out = array(
				'session' => array(
						'sid' => RC_Session::session_id(),
						'uid' => $_SESSION['user_id']
				),
		
				'user' => $user_info
		);
		
		update_user_info();
		recalculate_price();
		
		//修正咨询信息
		if($_SESSION['user_id'] > 0) {
			$device		      = $this->device;
			$device_id	      = $device['udid'];
			$device_client    = $device['client'];
			$db_term_relation = RC_Model::model('goods/term_relationship_model');
				
			$object_id = $db_term_relation->where(array(
					'object_type'	=> 'ecjia.feedback',
					'object_group'	=> 'feedback',
					'item_key2'		=> 'device_udid',
					'item_value2'	=> $device_id ))
					->get_field('object_id', true);
			//更新未登录用户的咨询
			$db_term_relation->where(array('item_key2' => 'device_udid', 'item_value2' => $device_id))->update(array('item_key2' => '', 'item_value2' => ''));
				
			if(!empty($object_id)) {
				$db = RC_Model::model('feedback/feedback_model');
				$db->where(array('msg_id' => $object_id, 'msg_area' => '4'))->update(array('user_id' => $_SESSION['user_id'], 'user_name' => $_SESSION['user_name']));
				$db->where(array('parent_id' => $object_id, 'msg_area' => '4'))->update(array('user_id' => $_SESSION['user_id'], 'user_name' => $_SESSION['user_name']));
			}
			
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
		}
		return $out;
	}
}

// end