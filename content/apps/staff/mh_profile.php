<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 个人信息
 */
class mh_profile extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');

		RC_Script::enqueue_script('bootstrap-editable-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.js', array());
		RC_Style::enqueue_style('bootstrap-fileupload', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/bootstrap-fileupload/bootstrap-fileupload.css', array(), false, false);
		RC_Script::enqueue_script('migrate', RC_App::apps_url('statics/js/migrate.js', __FILE__) , array() , false, true);
	
		RC_Script::enqueue_script('profile', RC_App::apps_url('statics/js/profile.js', __FILE__));
		
		RC_Style::enqueue_style('style', RC_App::apps_url('statics/css/style.css', __FILE__), array());
		RC_Script::enqueue_script('cropbox', RC_App::apps_url('statics/js/cropbox.js', __FILE__));
	}

	
	/**
	 * 个人资料
	 */
	public function init() {	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('个人资料')));
		$this->assign('ur_here', __('个人资料'));
		
		$user_info = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->first();
		$user_info['add_time']  = RC_Time::local_date(ecjia::config('date_format'), $user_info['add_time']);
		$user_info['last_login']= RC_Time::local_date('Y-m-d H:i', $user_info['last_login']);
		$this->assign('user_info', $user_info);

		$this->assign('form_action', RC_Uri::url('staff/mh_profile/update_self'));
		
		$this->display('profile_info.dwt');
	}
	
	/**
	 * 处理更新资料逻辑
	 */
	public function update_self() {
		$user_ident = !empty($_POST['user_ident'])	? trim($_POST['user_ident']) 	: '';
		$name 		= !empty($_POST['name'])		? trim($_POST['name']) 			: '';
		$_SESSION['staff_name'] = $name;
		$nick_name 	= !empty($_POST['nick_name'])	? trim($_POST['nick_name']) 	: '';
		$todolist	= !empty($_POST['todolist'])	? trim($_POST['todolist'])	 	: '';
		$introduction = !empty($_POST['introduction'])	 ? trim($_POST['introduction'])	 	: '';
	
		if (RC_DB::table('staff_user')->where('name', $name)->where('user_id', '!=', $_SESSION['staff_id'])->count() > 0) {
			return $this->showmessage('该员工名称已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
			'user_ident'	=> $user_ident,
			'name'			=> $name,
			'nick_name'		=> $nick_name,
			'todolist'		=> $todolist,
			'introduction'	=> $introduction,
		);
		RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update($data);
		ecjia_merchant::admin_log('', 'edit', 'staff_profile');
		return $this->showmessage('编辑个人资料成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/mh_profile/init')));
	}
	
	/**
	 * 修改账户
	 */
	public function setting() {
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('账户设置')));
		$this->assign('ur_here', __('账户设置'));

		$user_info = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->first();
		$user_info['add_time']  = RC_Time::local_date(ecjia::config('date_format'), $user_info['add_time']);
		$user_info['last_login']= RC_Time::local_date('Y-m-d H:i', $user_info['last_login']);
		$this->assign('user_info', $user_info);
		
		$this->assign('form_action', RC_Uri::url('staff/mh_profile/update_set'));
		
		$this->display('profile_setting.dwt');
	}
	
	/**
	 * 处理账户逻辑
	 */
	public function update_set() {
		$staff_id		= $_SESSION['staff_id'];
		$salt			= rand(1, 9999);
		$password		= !empty($_POST['new_password']) ? md5(md5($_POST['new_password']) . $salt) : '';
		$mobile 		= !empty($_POST['mobile'])		? trim($_POST['mobile']) 		: '';
		$email 			= !empty($_POST['email'])		? trim($_POST['email']) 		: '';
		
		$admin_oldemail = RC_DB::TABLE('staff_user')->where('user_id', $staff_id)->pluck('email');  //单个
		/* Email地址是否有重复 */
		if ($email && $email != $admin_oldemail) {
			$is_only = RC_DB::table('staff_user')->where('email', $email)->count();
			if ($is_only != 0) {
				return $this->showmessage(sprintf(__('该Email地址 %s 已经存在！'), stripslashes($email)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		$pwd_modified = false;
		if (!empty($_POST['new_password'])) {
			$old_password	= RC_DB::TABLE('staff_user')->where('user_id', $staff_id)->pluck('password'); 
			$old_salt		= RC_DB::TABLE('staff_user')->where('user_id', $staff_id)->pluck('salt'); 
			
			if (empty($_POST['old_password'])) {
				return $this->showmessage('请输入当前密码进行核对之后才可以修改新密码',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} 
			
			if (empty($old_salt)) {
				$old_ecjia_password = md5($_POST['old_password']);
			} else {
				$old_ecjia_password = md5(md5($_POST['old_password']).$old_salt);
			}
			
			if ($old_password != $old_ecjia_password) {
				return $this->showmessage('输入的旧密码错误！',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			/* 比较新密码和确认密码是否相同 */
			if ($_POST['new_password'] == $_POST['pwd_confirm']) {
				$pwd_modified = true;
			} 
		}
		//更新管理员信息
		if ($pwd_modified) {
			$data = array(
				'salt'		=> $salt,
				'password'	=> $password,
				'mobile'	=> $mobile,
				'email'		=> $email,
			);
		} else {
			$data = array(
				'mobile'	=> $mobile,
				'email'		=> $email,
			);
		}
		
		RC_DB::table('staff_user')->where('user_id', $staff_id)->update($data);
		ecjia_merchant::admin_log('', 'edit', 'account_set');
		/* 清除用户缓存 */
		RC_Cache::userdata_cache_delete('admin_navlist', $staff_id, true);
		
		if ($pwd_modified) {
			/* 如果修改了密码，则需要将session中该管理员的数据清空 */
			RC_Session::session()->delete_spec_admin_session($_SESSION['staff_id']); // 删除session中该管理员的记录
			
			$msg = __('您已经成功的修改了密码，因此您必须重新登录！');
		} else {
			$msg = __('修改个人资料成功！');
		}
		
		return $this->showmessage($msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/mh_profile/setting')));	
	}
	
	//获取短信验证码
	public function get_mobile_code(){
		$newmobile = $_GET['newmobile'];
		if(empty($newmobile)){
			return $this->showmessage('请输入新的手机账号', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (RC_DB::table('staff_user')->where('mobile', $newmobile)->count() > 0) {
			return $this->showmessage('该手机账号已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$code = rand(100000, 999999);
		$tpl_name = 'sms_get_validate';
		$tpl = RC_Api::api('sms', 'sms_template', $tpl_name);
		if (!empty($tpl)) {
			$this->assign('code', $code);
			$this->assign('service_phone', 	ecjia::config('service_phone'));
			$content = $this->fetch_string($tpl['template_content']);
			$options = array(
				'mobile' 		=> $newmobile,
				'msg'			=> $content,
				'template_id' 	=> $tpl['template_id'],
			);
			$response = RC_Api::api('sms', 'sms_send', $options);
			if($response === true){
				$_SESSION['temp_code'] 	= $code;
				$_SESSION['temp_code_time'] = RC_Time::gmtime();
				return $this->showmessage('手机验证码发送成功，请注意查收', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}else{
				return $this->showmessage('手机验证码发送失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		};
		
	}

	
	//更换手机账号
	public function update_mobile(){
		
		$code = $_POST['mobilecode'];
		$newmobile = $_POST['newmobile'];
		if (RC_DB::table('staff_user')->where('mobile', $newmobile)->count() > 0) {
			return $this->showmessage('该手机账号已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$time = RC_Time::gmtime() - 6000*3;
		if (!empty($code) && $code == $_SESSION['temp_code'] && $time < $_SESSION['temp_code_time']) {
			$data = array(
				'mobile'  => $newmobile,
			);
			RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update($data);
			ecjia_merchant::admin_log('', 'edit', 'account_set');
			return $this->showmessage('更改手机账号成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/mh_profile/setting')));
		}else{
			return $this->showmessage('请输入正确的手机校验码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	
	//获取邮箱验证码
	public function get_email_code(){
		$newemail = $_GET['newemail'];
		
		if(empty($newemail)){
			return $this->showmessage('请输入新的邮件账号', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (RC_DB::table('staff_user')->where('email', $newemail)->count() > 0) {
			return $this->showmessage('该邮件账号已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$code = rand(100000, 999999);
		$tpl_name = 'send_validate';
		$template   = RC_Api::api('mail', 'mail_template', $tpl_name);
		if (!empty($template)) {
			$this->assign('user_name',   $_SESSION['staff_name']);
			$this->assign('code',   $code);
			$this->assign('shop_name',   ecjia::config('shop_name'));
			$this->assign('send_date',   RC_Time::local_date(ecjia::config('date_format')));
			$this->assign('service_phone', 	ecjia::config('service_phone'));
			
			if (RC_Mail::send_mail('', $newemail, $template['template_subject'], $this->fetch_string($template['template_content']), $template['is_html'])) {
				$_SESSION['temp_code'] 	= $code;
				$_SESSION['temp_code_time'] = RC_Time::gmtime();
				return $this->showmessage('邮件验证码发送成功，请注意查收', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			} else {
				return $this->showmessage('邮件验证码验证码发送失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
	}
	
	
	//更换邮箱账号
	public function update_email(){
		
		$code = $_POST['emailcode'];
		$newemail = $_POST['newemail'];
		if (RC_DB::table('staff_user')->where('email', $newemail)->count() > 0) {
			return $this->showmessage('该邮件账号已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$time = RC_Time::gmtime() - 6000*3;
		if (!empty($code) && $code == $_SESSION['temp_code'] && $time < $_SESSION['temp_code_time']) {
			$data = array(
				'email'  => $newemail,
			);
			RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update($data);
			ecjia_merchant::admin_log('', 'edit', 'account_set');
			return $this->showmessage('更改邮件账号成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/mh_profile/setting')));
		}else{
			return $this->showmessage('请输入正确的验证码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 个人资料
	 */
	public function avatar() {
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('个人资料')));
		$this->assign('ur_here', __('个人资料'));
	
		$user_info = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->first();
		$user_info['add_time']  = RC_Time::local_date(ecjia::config('date_format'), $user_info['add_time']);
		$user_info['last_login']= RC_Time::local_date('Y-m-d H:i', $user_info['last_login']);
		$this->assign('user_info', $user_info);
	
		$this->assign('form_action', RC_Uri::url('staff/mh_profile/avatar_update'));
	
		$this->display('profile_avatar.dwt');
		
	}	
	/**
	 * 个人资料
	 */
	public function avatar_update() {
		$img = $_POST['img'];
		$staff_id = $_SESSION['staff_id'];
		$store_id = $_SESSION['store_id'];
		
		$path = RC_Upload::upload_path('merchant/'.$store_id.'/data/avatar');
		$filename_path = $path.'/'. $staff_id."_".'avatar.png';
		RC_Filesystem::mkdir($path, 0777, true, true);
		$img = base64_decode($img);
		file_put_contents($filename_path, $img);
		$file_url = 'merchant/'.$store_id.'/data/avatar/'. $staff_id."_".'avatar.png';
		$data = array(
			'avatar' => $file_url,
		);
		RC_DB::table('staff_user')->where('user_id',$staff_id)->update($data);
		return $this->showmessage('上传新头像成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/mh_profile/avatar')));
	}
}

//end