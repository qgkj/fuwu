<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 找回密码
 */
class get_password extends ecjia_merchant {
	public function __construct() {
		parent::__construct();

		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-form');		
		//禁止以下css加载
		RC_Style::dequeue_style(array(
		'ecjia-mh-owl-theme',
		'ecjia-mh-owl-transitions',
		'ecjia-mh-table-responsive',
		'ecjia-mh-jquery-easy-pie-chart',
		'ecjia-mh-function',
		'ecjia-mh-page',
		));
		
		$this->assign('shop_name', ecjia::config('shop_name'));
		$this->assign('ur_here_mobile','手机号找回密码');
		$this->assign('ur_here_email','邮箱找回密码');
		$this->assign('logo_display', RC_Hook::apply_filters('ecjia_admin_logo_display', '<div class="logo"></div>'));
	}

	/**
	 * 邮箱找回密码页面
	 */
	public function forget_pwd() {
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		
		RC_Loader::load_app_class('hooks.plugin_captcha', 'captcha', false);
		
		if ((intval(ecjia::config('captcha')) & CAPTCHA_ADMIN) && RC_ENV::gd_version() > 0) {
			$this->assign('gd_version', RC_ENV::gd_version());
			$this->assign('random',     mt_rand());
		}
		
    	$this->assign('form_act', 'forget_pwd');
		
		$this->display('get_pwd.dwt');
	}
	
	/**
	 * 核对用户名和邮箱
	 */
	public function reset_pwd_mail(){
		$validator = RC_Validator::make($_POST, array(
			'email' => 'required|email',
			'name' => 'required',
		));
		if ($validator->fails()) {
			return $this->showmessage(__('输入的信息不正确！'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}
	
		$admin_name = trim($_POST['name']);
		$admin_email    = trim($_POST['email']);
	
		/* 管理员用户名和邮件地址是否匹配，并取得原密码 */
		$admin_info = RC_DB::TABLE('staff_user')->where('name', $admin_name)->where('email', $admin_email)->select('user_id', 'password','name')->first();//多个
		
		if (!empty($admin_info)) {
			/* 生成验证的code */
			$admin_id = $admin_info['user_id'];
			$code     = md5($admin_id . $admin_info['password']);
			$reset_email = RC_Uri::url('staff/get_password/reset_pwd_form', array('uid' => $admin_id, 'code' => $code));
			/* 设置重置邮件模板所需要的内容信息 */
			$tpl_name = 'send_password';
			$template   = RC_Api::api('mail', 'mail_template', $tpl_name);
	
			$this->assign('user_name',   $admin_info['name']);
			$this->assign('reset_email', $reset_email);
			$this->assign('shop_name',   ecjia::config('shop_name'));
			$this->assign('send_date',   RC_Time::local_date(ecjia::config('date_format')));
				
			$state = ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON;
				
			if (RC_Mail::send_mail('', $admin_email, $template['template_subject'], $this->fetch_string($template['template_content']), $template['is_html'])) {
				$msg = __('重置密码的邮件已经发到您的邮箱：') . $admin_email;
				$state = ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON;
			} else {
				$msg = __('重置密码邮件发送失败!请与管理员联系');
			}
			//提示信息
			$link[0]['text'] = __('返回');
			$link[0]['href'] = RC_Uri::url('staff/privilege/login');
			return $this->showmessage($msg, $state, array('links' => $link));
		} else {
			/* 提示信息 */
			return $this->showmessage(__('用户名与Email地址不匹配,请重新输入！'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}
	}
	
	//处理逻辑
	public function reset_pwd_form(){
		$code = ! empty($_GET['code']) ? trim($_GET['code']) : '';
		$adminid = ! empty($_GET['uid']) ? intval($_GET['uid']) : 0;
	
		if ($adminid == 0 || empty($code)) {
			$href = RC_Uri::url('staff/privilege/login');
			$this->header("Location: $href\n");
			exit;
		}
	
		/* 以用户的原密码，与code的值匹配 */
		$password = RC_DB::TABLE('staff_user')->where('user_id', $adminid)->pluck('password');
		if (md5($adminid . $password) != $code) {
			// 此链接不合法
			$link[0]['text'] =  __('返回');
			$link[0]['href'] = RC_Uri::url('staff/privilege/login');
			return $this->showmessage(__('此链接不合法!'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		} else {
			$this->assign('adminid', $adminid);
			$this->assign('code', $code);
			$this->assign('form_act', 'reset_pwd');
		}
	
		$this->assign('ur_here', __('修改密码'));
		$this->display('get_pwd.dwt');
	}
	
	//重置新密码完成
	public function reset_pwd(){
		$new_password = isset($_POST['password']) ? trim($_POST['password']) : '';
		$confirm_pwd = isset($_POST['confirm_pwd']) ? trim($_POST['confirm_pwd']) : '';
		
		$adminid = isset($_POST['adminid']) ? intval($_POST['adminid']) : 0;
		$code = isset($_POST['code']) ? trim($_POST['code']) : '';
		 
		if (empty($new_password) || empty($code) || $adminid == 0) {
			$href = RC_Uri::url('staff/privilege/login');
			$this->header("Location: $href\n");
			exit();
		}


		/* 以用户的原密码，与code的值匹配 */
		$password = RC_DB::TABLE('staff_user')->where('user_id', $adminid)->pluck('password');
	
		if (md5($adminid . $password) != $code) {
			// 此链接不合法
			$link[0]['text'] =  __('返回');
			$link[0]['href'] = RC_Uri::url('staff/privilege/login');
			return $this->showmessage(__('此链接不合法!'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		} else {
			if($new_password != $confirm_pwd){
				return $this->showmessage(__('新密码和确认密码须保持一致'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
			}
			
			// 更新管理员的密码
			$salt = rand(1, 9999);
			$data = array(
				'password' => md5(md5($new_password) . $salt),
				'salt' => $salt
			);
	
			$result = RC_DB::table('staff_user')->where('user_id', $adminid)->update($data);
	
			if ($result) {
				$link[0]['text'] = __('返回');
				$link[0]['href'] = RC_Uri::url('staff/privilege/login');
				return $this->showmessage(__('密码修改成功!'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON);
			} else {
				return $this->showmessage(__('密码修改失败!'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
			}
		}
	}
	
	/**
	 * 手机快速找回页面,只输入手机号那个页面
	 */
	public function forget_fast() {
	
		$this->assign('form_act', 'reset_fast_pwd');
		
		$this->display('get_pwd.dwt');
	}
	
	/**
	 * 找回密码页面
	 */
	public function fast_reset_pwd() {
		$mobile = $_POST['mobile'];
		if(!empty($mobile)){
			if (RC_DB::table('staff_user')->where('mobile', $mobile)->count() == 0) {
				return $this->showmessage('该手机账号不存在，无法进行重置密码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}else{
				$back_url = RC_Uri::url('staff/get_password/get_code', array('mobile' => $mobile));
				return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $back_url));
			}
		}else{
			return $this->showmessage('手机号不能为空', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 手机快速找回页面
	 */
	public function get_code() {
		$this->assign('form_act', 'get_code');
		$mobile = $_GET['mobile'];
		$this->assign('mobile', $mobile);
		
		$this->display('get_pwd.dwt');
	}
	
	public function get_code_value() {
		$mobile = $_GET['mobile'];
		$user_id = RC_DB::TABLE('staff_user')->where('mobile', $mobile)->pluck('user_id'); 
		$code = rand(100000, 999999);
		$tpl_name = 'sms_get_validate';
		$tpl = RC_Api::api('sms', 'sms_template', $tpl_name);
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
			if($response === true){
				$_SESSION['user_id'] 	= $user_id;
				$_SESSION['temp_code'] 	= $code;
				$_SESSION['temp_code_time'] = RC_Time::gmtime();
				return $this->showmessage('手机验证码发送成功，请注意查收', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}else{
				return $this->showmessage('手机验证码发送失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		};		
	}

	/**
	 * 第二步：再次验证校验码是否正确
	 */
	public function get_code_form() {
		$code = $_POST['code'];
		$time = RC_Time::gmtime() - 6000*3;
		
		if (!empty($code) && $code == $_SESSION['temp_code'] && $time < $_SESSION['temp_code_time']) {
			$back_url = RC_Uri::url('staff/get_password/mobile_reset', array('form_act' => 'reset_pwd'));
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $back_url));
		}else{
			return $this->showmessage('请输入正确的手机校验码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	public function mobile_reset(){
		$this->assign('form_act', 'mobile_reset');
		$this->display('get_pwd.dwt');
	}
	
	public function mobile_reset_pwd(){
		$new_password = isset($_POST['password']) ? trim($_POST['password']) : '';
		$confirm_pwd  = isset($_POST['confirm_pwd']) ? trim($_POST['confirm_pwd']) : '';
		if($new_password != $confirm_pwd){
			return $this->showmessage(__('新密码和确认密码须保持一致'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}
		
		// 更新管理员的密码
		$salt = rand(1, 9999);
		$data = array(
			'password' => md5(md5($new_password) . $salt),
			'salt'     => $salt
		);
		$result = RC_DB::table('staff_user')->where('user_id', $_SESSION['user_id'])->update($data);
		if ($result) {
			$back_url = RC_Uri::url('staff/privilege/login');
			return $this->showmessage('密码重置成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $back_url));
		} else {
			return $this->showmessage('密码修改失败!', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}
	}
}

//end