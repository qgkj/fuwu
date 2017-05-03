<?php
  
/**
 * ECJIA 找回管理员密码
 */
defined('IN_ECJIA') or exit('No permission resources.');

class get_password extends ecjia_admin {
	private $db;
	public function __construct() {
		parent::__construct();
		
		$this->db = RC_Loader::load_model('admin_user_model');
		RC_Script::enqueue_script('jquery-form');
			
		// 禁止以下css加载
		RC_Style::dequeue_style ( array (
			'ecjia',
			'general',
			'main',
			'style',
			'color',
			'ecjia-skin-blue',
			'bootstrap-responsive',
			'jquery-ui-aristo',
			'jquery-qtip',
			'jquery-jBreadCrumb',
			'jquery-colorbox',
			'jquery-sticky',
			'google-code-prettify',
			'splashy',
			'flags',
			'datatables-TableTools',
			'fontello',
			'chosen',
			'jquery-stepy' 
		) );
		// 加载'bootstrap','jquery-uniform','jquery-migrate','jquery-form',
		// 禁止以下js加载
		RC_Script::dequeue_script ( array (
			'ecjia',
			'ecjia-addon',
			'ecjia-autocomplete',
			'ecjia-browser',
			'ecjia-colorselecter',
			'ecjia-common',
			'ecjia-compare',
			'ecjia-cookie',
			'ecjia-flow',
			'ecjia-goods',
			'ecjia-lefttime',
			'ecjia-listtable',
			'ecjia-listzone',
			'ecjia-message',
			'ecjia-orders',
			'ecjia-region',
			'ecjia-selectbox',
			'ecjia-selectzone',
			'ecjia-shipping',
			'ecjia-showdiv',
			'ecjia-todolist',
			'ecjia-topbar',
			'ecjia-ui',
			'ecjia-user',
			'ecjia-utils',
			'ecjia-validator',
			'ecjia-editor',
			'jquery-ui-touchpunch',
			'jquery',
			'jquery-pjax',
			'jquery-peity',
			'jquery-mockjax',
			'jquery-wookmark',
			'jquery-cookie',
			'jquery-actual',
			'jquery-debouncedresize',
			'jquery-easing',
			'jquery-mediaTable',
			'jquery-imagesloaded',
			'jquery-gmap3',
			'jquery-autosize',
			'jquery-counter',
			'jquery-inputmask',
			'jquery-progressbar',
			'jquery-ui-totop',
			'ecjia-admin',
			'jquery-ui',
			'jquery-validate',
			'smoke',
			'jquery-chosen',
			'bootstrap-placeholder',
			'jquery-flot',
			'jquery-flot-curvedLines',
			'jquery-flot-multihighlight',
			'jquery-flot-orderBars',
			'jquery-flot-pie',
			'jquery-flot-pyramid',
			'jquery-flot-resize',
			'jquery-mousewheel',
			'antiscroll',
			'jquery-colorbox',
			'jquery-qtip',
			'jquery-sticky',
			'jquery-jBreadCrumb',
			'ios-orientationchange',
			'google-code-prettify',
			'selectnav',
			'jquery-dataTables',
			'jquery-dataTables-sorting',
			'jquery-dataTables-bootstrap',
			'jquery-stepy',
			'tinymce' 
		) );
	}
	
	public function forget_pwd(){
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		
		RC_Loader::load_app_class('hooks.plugin_captcha', 'captcha', false);
		
		if ((intval(ecjia::config('captcha')) & CAPTCHA_ADMIN) && RC_ENV::gd_version() > 0) {
			$this->assign('gd_version', RC_ENV::gd_version());
			$this->assign('random',     mt_rand());
		}
    	$this->assign('form_act', 'forget_pwd');
		
		$this->display('get_pwd.dwt.php');
	}
	
	public function reset_pwd_mail(){
		$validator = RC_Validator::make($_POST, array(
		    'email' => 'required|email',
		    'username' => 'required',
		    ));
		if ($validator->fails()) {
		    return $this->showmessage(__('输入的信息不正确！'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}

		$admin_username = trim($_POST['username']);
		$admin_email    = trim($_POST['email']);

		/* 管理员用户名和邮件地址是否匹配，并取得原密码 */
		$admin_info = $this->db->field('user_id, password')->find(array('user_name' => $admin_username, 'email' => $admin_email));

		if (!empty($admin_info)) {
			/* 生成验证的code */
			$admin_id = $admin_info['user_id'];
			$code     = md5($admin_id . $admin_info['password']);

			$reset_email = RC_Uri::url('@get_password/reset_pwd_form', array('uid' => $admin_id, 'code' => $code));
			
			/* 设置重置邮件模板所需要的内容信息 */
			//$template    = get_mail_template('send_password');
			$tpl_name = 'send_password';
			$template   = RC_Api::api('mail', 'mail_template', $tpl_name);

			$this->assign('user_name',   $admin_username);
			$this->assign('reset_email', $reset_email);
			$this->assign('shop_name',   ecjia::config('shop_name'));
			$this->assign('send_date',   RC_Time::local_date(ecjia::config('date_format')));
			$this->assign('sent_date',   RC_Time::local_date(ecjia::config('date_format')));
			
			$state = ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON;
			
			if (RC_Mail::send_mail('', $admin_email, $template['template_subject'], $this->fetch_string($template['template_content']), $template['is_html'])) {
				$msg = __('重置密码的邮件已经发到您的邮箱：') . $admin_email;
				$state = ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON;
			} else {
				$msg = __('重置密码邮件发送失败!请与管理员联系');
			}
			//提示信息
			$link[0]['text'] = __('返回');
			$link[0]['href'] = RC_Uri::url('@privilege/login');
			return $this->showmessage($msg, $state, array('links' => $link));
		} else {
			/* 提示信息 */
			return $this->showmessage(__('用户名与Email地址不匹配,请返回！'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}
	}
	
	public function reset_pwd_form(){
		$code = ! empty($_GET['code']) ? trim($_GET['code']) : '';
		$adminid = ! empty($_GET['uid']) ? intval($_GET['uid']) : 0;
		
		if ($adminid == 0 || empty($code)) {
			$url = RC_Uri::url('@privilege/login');
			return $this->redirect($url);
			exit;
		}
		
		/* 以用户的原密码，与code的值匹配 */
		$password = $this->db->field('password')->where(array('user_id' => $adminid))->find();
		$password = $password['password'];
		
    	if (md5($adminid . $password) != $code) {
    		// 此链接不合法
    		$link[0]['text'] =  __('返回');
    		$link[0]['href'] = RC_Uri::url('@privilege/login');
			return $this->showmessage(__('此链接不合法!'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
    	} else {
    		$this->assign('adminid', $adminid);
    		$this->assign('code', $code);
    		$this->assign('form_act', 'reset_pwd');
    	}

    	$this->assign('ur_here', __('修改密码'));
        $this->display('get_pwd.dwt');
	}
	
	public function reset_pwd(){
    	$new_password = isset($_POST['password']) ? trim($_POST['password']) : '';
    	$adminid = isset($_POST['adminid']) ? intval($_POST['adminid']) : 0;
    	$code = isset($_POST['code']) ? trim($_POST['code']) : '';
    	
    	if (empty($new_password) || empty($code) || $adminid == 0) {
			$url = RC_Uri::url('@privilege/login');
			return $this->redirect($url);
    		exit();
    	}
    	
    	/* 以用户的原密码，与code的值匹配 */
		$password = $this->db->field('password')->where(array('user_id' => $adminid))->find();
		$password = $password['password'];

		if (md5($adminid . $password) != $code) {
			// 此链接不合法
			$link[0]['text'] =  __('返回');
			$link[0]['href'] = RC_Uri::url('@privilege/login');
			return $this->showmessage(__('此链接不合法!'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		} else {
	    	// 更新管理员的密码
	    	$ec_salt = rand(1, 9999);
	    	$data = array(
	    		'password' => md5(md5($new_password) . $ec_salt),
	    		'ec_salt' => $ec_salt
	    	);

	    	$result = $this->db->where(array('user_id' => $adminid))->update($data);
	    	
	    	if ($result) {
	    		$link[0]['text'] = __('返回');
	    		$link[0]['href'] = RC_Uri::url('@privilege/login');
				return $this->showmessage(__('密码修改成功!'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON);
	    	} else {
				return $this->showmessage(__('密码修改失败!'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    	}
		}
	}
	
}

// end