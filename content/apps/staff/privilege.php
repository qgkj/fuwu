<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 员工登录、退出、找回密码
 */
class privilege extends ecjia_merchant {
	public function __construct() {
		parent::__construct();

		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-form');		
	}

	/**
	 * 登录
	 */
	public function login() {
		
		//禁止以下css加载
		RC_Style::dequeue_style(array(
			'ecjia-mh-owl-theme',
			'ecjia-mh-owl-transitions',
			'ecjia-mh-table-responsive',
			'ecjia-mh-jquery-easy-pie-chart',
			'ecjia-mh-function',
			'ecjia-mh-page',
		));

		$this->assign('ur_here', '商家登录');
		$this->assign('shop_name', ecjia::config('shop_name'));
		$this->assign('logo_display', RC_Hook::apply_filters('ecjia_admin_logo_display', '<div class="logo"></div>'));
		
		$this->assign('form_action',RC_Uri::url('staff/privilege/signin'));
		
		$this->display('login.dwt');
	}
	
	/**
	 * 验证登陆信息
	 */
	public function signin() {
		$validate_error = RC_Hook::apply_filters('merchant_login_validate', $_POST);
		if (!empty($validate_error) && is_string($validate_error)) {
			return $this->showmessage($validate_error, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	
		$mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
		$password= isset($_POST['password']) ? trim($_POST['password']) : '';
		$row = RC_DB::table('staff_user')->where('mobile', $mobile)->first();
		if (!empty($row['salt'])) {
			if (!($row['mobile'] == $mobile && $row['password'] == md5(md5($password) . $row['salt']))) {
				$row = null;
			}
		} else {
			if (!($row['mobile'] == $mobile && $row['password'] == md5($password))) {
				$row = null;
			}
		}
		RC_Hook::do_action('ecjia_merchant_login_before', $row);
		if ($row) {
			$status = RC_DB::TABLE('store_franchisee')->where('store_id', $row['store_id'])->pluck('status');
			if ($status == 1) {
				$row['merchants_name'] = RC_DB::TABLE('store_franchisee')->where('store_id', $row['store_id'])->pluck('merchants_name');
				$this->admin_session($row['store_id'], $row['merchants_name'], $row['user_id'], $row['mobile'], $row['name'], $row['action_list'], $row['last_login']);
				if (empty($row['salt'])) {
					$salt = rand(1, 9999);
					$new_possword = md5(md5($password) . $salt);
					$data = array(
							'salt'	=> $salt,
							'password'	=> $new_possword
					);
					RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update($data);
				
					$row['salt'] = $data['salt'];
					$row['password'] = $data['password'];
				}
				
				if ($row['action_list'] == 'all' && empty($row['last_login'])) {
						$_SESSION['shop_guide'] = true; //商家开店导航设置开关
				}
				
				$data = array(
						'last_login' 	=> RC_Time::gmtime(),
						'last_ip'		=> RC_Ip::client_ip(),
				);
				RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update($data);
				$row['last_login'] = $data['last_login'];
				$row['last_ip'] = $data['last_ip'];
				
				if (isset($_POST['remember'])) {
					$time = 3600 * 24 * 7;
					RC_Cookie::set('ECJAP.staff_id', $row['user_id'], array('expire' => $time));
					RC_Cookie::set('ECJAP.staff_pass', md5($row['password'] . ecjia::config('hash_code')), array('expire' => $time));
				}
				RC_Hook::do_action('ecjia_merchant_login_after', $row);
				if(array_get($_SESSION, 'shop_guide')) {
					$back_url = RC_Uri::url('shopguide/merchant/init');
				}else{
					if (RC_Cookie::has('admin_login_referer')) {
						$back_url = RC_Cookie::get('admin_login_referer');
						RC_Cookie::delete('admin_login_referer');
					} else {
						$back_url = RC_Uri::url('merchant/dashboard/init');
					}
				}
				return $this->showmessage(__('登录成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $back_url));
			} else {
				return $this->showmessage(__('该店铺已被锁定，暂无法登录'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			return $this->showmessage(__('您输入的帐号信息不正确。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 退出
	 */
	public function logout() {
		/* 清除cookie */
		RC_Cookie::delete('ECJAP.staff_id');
		RC_Cookie::delete('ECJAP.staff_pass');
		
		RC_Session::destroy();
		return $this->redirect(RC_Uri::url('staff/privilege/login'));
	}
}

//end