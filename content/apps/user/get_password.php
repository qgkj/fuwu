<?php
  
defined('IN_ROYALCMS') or exit('No permission resources.');

RC_Loader::load_app_class('integrate', 'user', false);

class get_password extends ecjia_front {
	private $db_users;

	public function __construct() {	
		parent::__construct();	
		
  		$this->db_users = RC_Model::model('user/users_model');
  		/* js加载ecjia.js*/
  		$this->assign('ecjia_js', RC_Uri::admin_url('statics/ecjia.js/ecjia.js'));
  		/* js与css加载路径*/
  		$this->assign('front_url', RC_App::apps_url('templates/front', __FILE__));
	}
	
	/* 找回密码信息填写界面 */
	public function forget_pwd() {
		$captcha = RC_Loader::load_app_class('captcha_method', 'captcha');
		if ($captcha->check_activation_captcha()) {
			$captcha_url =  $captcha->current_captcha_url();
			$this->assign('captcha_url', $captcha_url);
		}
		
		$type = empty($_GET['type']) ? 'email' : $_GET['type'];
		$this->assign('type', $type);
		$this->assign('action', 'forget_pwd');
		$this->display('forget_password.dwt');
	}
	
	/* 验证用户信息是否正确*/
	public function check_userinfo() {
		
		$username	= isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
		$email		= isset($_POST['email']) ? trim($_POST['email']) : '';
		$type 		= isset($_POST['type']) ? trim($_POST['type']) : 'email';
		$captcha    = RC_Loader::load_app_class('captcha_method', 'captcha');
		
		/* 检查验证码是否正确 */
		$captcha_error = false;
		if ( !empty($_SESSION['captcha_word']) ) {
			$captcha_code	= isset($_POST['captcha']) ? trim($_POST['captcha']) : '';
			RC_Loader::load_app_class('captcha_factory', 'captcha', false);
			$validator = new captcha_factory(ecjia::config('captcha_style'));
			if (isset($captcha_code) && !$validator->verify_word($captcha_code)) {
				$captcha_error = true;
			}
		} 
		
		$check_email = $type == 'email' ? (empty($email) ? true : false) : false;//判断是否是邮箱找回
		
		if (empty($username) || $check_email || $captcha_error) {
			if ($captcha->check_activation_captcha()) {
				$captcha_url =  $captcha->current_captcha_url();
				$this->assign('captcha_url', $captcha_url);
			}
			$error_msg = $captcha_error ? __("验证码错误！") : __("请填全用户信息！");
			$this->assign('error_msg', $error_msg);
			$this->assign('type', $type);
			$this->assign('action', 'forget_pwd');
			$this->display('forget_password.dwt');
			exit;
		}
		if ($type == 'email') {
			$userinfo = RC_DB::table('users')->where('user_name', $username)
					->where('email', $email)
					->select('user_id', 'user_name', 'email', 'passwd_question', 'passwd_answer')
					->first();
		} elseif ($type == 'mobile') {
			$user_count = RC_DB::table('users')->where('mobile_phone', $username)->count();
			//如果用户数量大于1
			if ($user_count > 1) {
				if ($captcha->check_activation_captcha()) {
					$captcha_url =  $captcha->current_captcha_url();
					$this->assign('captcha_url', $captcha_url);
				}
				$error_msg = __('手机号绑定多个用户，请联系管理员！');
				$this->assign('error_msg', $error_msg);
				$this->assign('type', $type);
				$this->assign('action', 'forget_pwd');
				$this->display('forget_password.dwt');
				exit;
			}
			$userinfo =  RC_DB::table('users')->where('mobile_phone', $username)->select('user_id', 'user_name', 'email', 'passwd_question', 'passwd_answer')->first();
		}
		
		if (empty($userinfo)) {
			if ($captcha->check_activation_captcha()) {
				$captcha_url =  $captcha->current_captcha_url();
				$this->assign('captcha_url', $captcha_url);
			}
			$this->assign('error_msg', __("用户信息不正确！"));
			$this->assign('type', $type);
			$this->assign('action', 'forget_pwd');
			$this->display('forget_password.dwt');
			exit;
		} 
		
		$_SESSION['temp_user_id']			= $userinfo['user_id'];			//设置临时用户，不具有有效身份
		$_SESSION['temp_user_name']			= $userinfo['user_name'];		//设置临时用户，不具有有效身份
		$_SESSION['temp_email']				= $userinfo['email'];			//设置临时用户，不具有有效身份
		$_SESSION['temp_passwd_question']	= $userinfo['passwd_question'];	//存储密码问题，减少一次数据库访问
		$_SESSION['temp_passwd_answer'] 	= $userinfo['passwd_answer'];	//存储密码问题答案，减少一次数据库访问
		
		if ($type == 'email') {
			$this->assign('passwd_answer', !empty($userinfo['passwd_answer']));
			$this->assign('type', $type);
			$this->assign('action', 'editpassword_method');
			$this->display('forget_password.dwt');
			exit;
		} elseif ($type == 'mobile') {
			$result = ecjia_app::validate_application('sms');
			if (!is_ecjia_error($result)) {
				//发送短信
				$tpl_name = 'sms_get_validate';
				$tpl   = RC_Api::api('sms', 'sms_template', $tpl_name);
				$code = rand(111111, 999999);
				
				ecjia_front::$controller->assign('mobile', $username);
				ecjia_front::$controller->assign('service_phone', ecjia::config('service_phone'));
				ecjia_front::$controller->assign('code', $code);
				ecjia_front::$controller->assign('action', '短信找回密码');
				
				$content = ecjia_front::$controller->fetch_string($tpl['template_content']);
				
				$options = array(
					'mobile' 		=> $username,
					'msg'			=> $content,
					'template_id' 	=> $tpl['template_id'],
				);
				$response = RC_Api::api('sms', 'sms_send', $options);
				if (!is_ecjia_error($result)) {
					$_SESSION['temp_code'] = $code;
					$_SESSION['temp_code_time'] = RC_Time::gmtime();
					$user_email = '请输入<font style="color:#f00;">'.$username.'</font>收到的手机校验码。';
					$this->assign('email_msg', $user_email);
					$this->assign('type', $type);
					$this->assign('action', 'reset_pwd_mail');
					$this->display('forget_password.dwt');
				} else {
					if ($captcha->check_activation_captcha()) {
						$captcha_url =  $captcha->current_captcha_url();
						$this->assign('captcha_url', $captcha_url);
					}
					$this->assign('error_msg', __("短信发送失败！"));
					$this->assign('type', $type);
					$this->assign('action', 'forget_pwd');
					$this->display('forget_password.dwt');
				}
			}
		}
	}

	/* 密码找回（方式一）-->发送密码修改 验证码邮件 */
	public function reset_pwd_mail(){
		$uid = $_SESSION['temp_user_id'];
		$user_name = $_SESSION['temp_user_name'];
		$email = $_SESSION['temp_email'];
	
		$tmp_mail = explode("@", $email);
		if (strlen($tmp_mail) > 5 ) {
			
		} else {
				
		}
		$user_email = '请输入<font style="color:#f00;">'.$email.'</font>收到的邮箱校验码。';
		
		$code = rand(111111, 999999);
		$content = "[".ecjia::config('shop_name')."]您的账户正在变更账户信息，校验码：".$code."，打死都不能告诉别人哦！唯一热线".ecjia::config('service_phone');
		/* 发送确认重置密码的确认邮件 */
		if (RC_Mail::send_mail($user_name, $email, '账户变更校验码', $content, 1)) {
			$_SESSION['temp_code'] = $code;
			$_SESSION['temp_code_time'] = RC_Time::gmtime();
			$this->assign('action', 'reset_pwd_mail');
			$this->assign('email_msg', $user_email);
			$this->display('forget_password.dwt');
		} else {
			return false;
		}
	}
	
	/* 密码找回（方式一）-->根据提交的邮箱验证码进行相应处理 */
	public function check_code(){
	
		$code = $_POST['code'];
		$type = $_POST['type'];
		$time = RC_Time::gmtime() - 6000*3;//三分有效期
		if (!empty($code) && $code == $_SESSION['temp_code'] && $time < $_SESSION['temp_code_time']) {
			$_SESSION['user_id']   = $_SESSION['temp_user_id'];
			$_SESSION['user_name'] = $_SESSION['temp_user_name'];
			unset($_SESSION['temp_user']);
			unset($_SESSION['temp_user_name']);
			
			$this->assign('uid', $_SESSION['user_id']);
			$this->assign('action', 'reset_pwd_form');
			$this->display('forget_password.dwt');
		} else {
			if ($type == 'mobile') {
				$user_email = '请输入<font style="color:#f00;">'.$_SESSION['temp_user_name'].'</font>收到的手机校验码。';
			} else {
				$user_email = '请输入<font style="color:#f00;">'.$_SESSION['temp_email'].'</font>收到的邮箱校验码。';
			}
			$this->assign('error_msg', __("校验码错误！"));
			$this->assign('action', 'reset_pwd_mail');
			$this->assign('type', $type);
			$this->assign('email_msg', $user_email);
			$this->display('forget_password.dwt');
		}
	}
	
	/* 密码找回（方式一）-->再次发送邮箱验证码邮件 */
	public function reset_pwd_mail_repeat() {
		$uid       = $_SESSION['temp_user_id'];
		$user_name = $_SESSION['temp_user_name'];
		$email     = $_SESSION['temp_email'];
		$type      = isset($_GET['type']) ? $_GET['type'] : 'email';
		
		$code = rand(111111, 999999);
		if ($type == 'email') {
			$content = "[".ecjia::config('shop_name')."]您的账户正在变更账户信息，校验码：".$code."，打死都不能告诉别人哦！唯一热线".ecjia::config('service_phone');
			/* 发送确认重置密码的确认邮件 */
			if (RC_Mail::send_mail($user_name, $email, '账户变更校验码', $content, 1)) {
				$_SESSION['temp_code'] = $code;
				$_SESSION['temp_code_time'] = RC_Time::gmtime();
				return $this->showmessage('' , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			} else {
				return $this->showmessage('' , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$result = ecjia_app::validate_application('sms');
			if (!is_ecjia_error($result)) {
				//发送短信
				$tpl_name = 'sms_get_validate';
				$tpl   = RC_Api::api('sms', 'sms_template', $tpl_name);
				$code = rand(111111, 999999);
			
				ecjia_front::$controller->assign('mobile', $user_name);
				ecjia_front::$controller->assign('service_phone', ecjia::config('service_phone'));
				ecjia_front::$controller->assign('code', $code);
				ecjia_front::$controller->assign('action', '短信找回密码');
			
				$content = ecjia_front::$controller->fetch_string($tpl['template_content']);
					
				$options = array(
					'mobile' 		=> $user_name,
					'msg'			=> $content,
					'template_id' 	=> $tpl['template_id'],
				);
				$response = RC_Api::api('sms', 'sms_send', $options);
				if (!is_ecjia_error($result)) {
					$_SESSION['temp_code'] = $code;
					$_SESSION['temp_code_time'] = RC_Time::gmtime();
				} 
			}
		}
	}
	
	/* 密码找回（方式二）-->根据注册用户名取得密码提示问题界面 */
	public function reset_pwd_question(){
		$this->assign('action', 'reset_pwd_question');
		RC_Lang::load('user');
		$this->assign('passwd_question', RC_Lang::get('user::user.passwd_questions.'.$_SESSION['temp_passwd_question']));
	
		$this->display('forget_password.dwt');
	}
	
	/* 密码找回（方式二）-->根据提交的密码答案进行相应处理 */
	public function check_answer(){
		if (!empty($_POST['passwd_answer']) && $_POST['passwd_answer'] == $_SESSION['temp_passwd_answer']) {
			$_SESSION['user_id'] = $_SESSION['temp_user_id'];
			$_SESSION['user_name'] = $_SESSION['temp_user_name'];
			unset($_SESSION['temp_user']);
			unset($_SESSION['temp_user_name']);
			$this->assign('uid', $_SESSION['user_id']);
			$this->assign('action', 'reset_pwd_form');
			$this->display('forget_password.dwt');
		} else {
			$this->assign('error_msg', __("问题答案错误！"));
			$this->assign('action', 'reset_pwd_question');
			RC_Lang::load('user');
			$this->assign('passwd_question', RC_Lang::get('user::user.passwd_questions.'.$_SESSION['temp_passwd_question']));
			$this->display('forget_password.dwt');
		}
	}
	
	/* 切换密码找回方式*/
	public function change_reset_pwd() {
		$this->assign('passwd_answer', !empty($_SESSION['temp_passwd_answer']));
		$this->assign('action', 'editpassword_method');
		$this->display('forget_password.dwt');
	}
	
	/* 修改会员密码 */
	public function reset_pwd() {
		RC_Loader::load_app_class('integrate', 'user', false);
		$user = integrate::init_users();
		
		$old_password     = isset($_POST['old_password']) 	? trim($_POST['old_password']) 	: null;
		$new_password     = isset($_POST['new_password']) 	? trim($_POST['new_password']) 	: '';
		$confirm_password = isset($_POST['confirm_password']) 	? trim($_POST['confirm_password']) 	: '';
		$user_id          = isset($_POST['uid'])  			? intval($_POST['uid']) 		: $_SESSION['user_id'];
		$code             = isset($_POST['code']) 			? trim($_POST['code'])  		: '';
		if (strlen($new_password) < 6 ) {
			$this->assign('error_msg', __("密码长度最少6位！"));
			$this->assign('uid', $_SESSION['user_id']);
			$this->assign('action', 'reset_pwd_form');
			$this->display('forget_password.dwt');
		} elseif ( $new_password != $confirm_password) {
			$this->assign('error_msg', __("两次密码不一致！"));
			$this->assign('uid', $_SESSION['user_id']);
			$this->assign('action', 'reset_pwd_form');
			$this->display('forget_password.dwt');
		} else {
			$user_info = $user->get_profile_by_id($user_id); //论坛记录
			if (($user_info && (!empty($code) && md5($user_info['user_id'] . ecjia::config('hash_code') . $user_info['reg_time']) == $code)) || 
				($_SESSION['user_id'] > 0 && $_SESSION['user_id'] == $user_id && $user->check_user($_SESSION['user_name'], $old_password))) {
				
				if ($user->edit_user(array('username'=> (empty($code) ? $_SESSION['user_name'] : $user_info['user_name']), 'old_password'=>$old_password, 'password'=>$new_password), $forget_pwd = 1)) {
					
					$data = array(
						'ec_salt' => '0'		
					);
					RC_DB::table('users')->where('user_id', $user_id)->update($data);
					$user->logout();
					$this->assign('action', 'success');
					$this->display('forget_password.dwt');
				} else {
					$this->assign('error_msg', __("处理失败！请重新操作！"));
					$this->assign('action', 'forget_pwd');
					$this->display('forget_password.dwt');
				}
			} else {
				$this->assign('error_msg', __("处理失败！请重新操作！"));
				$this->assign('action', 'forget_pwd');
				$this->display('forget_password.dwt');
			}
		}
	}
	
	/* 密码找回(密码提示问题)-->输入用户名界面   暂时没用到*/
	public function qpassword_name() {
		$this->assign('action', 'qpassword_name');
		$this->display('forget_password.dwt');
	}
	
	/* 密码找回-->修改密码界面  赞无用到*/
	public function get_password() {
		$this->assign('action', 'get_password');
		$this->display('forget_password.dwt');
	}
}

// end