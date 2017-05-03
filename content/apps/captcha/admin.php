<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 验证码管理
 */

class admin extends ecjia_admin {
	private $captcha;

	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_config('constant', null, false);
		$this->captcha = RC_Loader::load_app_class('captcha_method');

		if (!ecjia::config('captcha_style', ecjia::CONFIG_CHECK)) {
			ecjia_config::instance()->insert_config('hidden', 'captcha_style', '', array('type' => 'hidden'));
		}

		RC_Style::enqueue_style('fontello');
		RC_Script::enqueue_script('smoke');
		// 单选复选框css
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
	}

	public function init () {
		$this->admin_priv('shop_config');
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('captcha', RC_App::apps_url('statics/js/captcha.js', __FILE__), array());
		
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(RC_Lang::get('captcha::captcha_manage.captcha_setting')));
		$this->assign('ur_here', RC_Lang::get('captcha::captcha_manage.captcha_setting'));

		$admin_captcha_lang = RC_Lang::get('captcha::captcha_manage.admin_captcha_lang');
		RC_Script::localize_script( 'captcha', 'admin_captcha_lang', $admin_captcha_lang );

		$captcha = intval(ecjia::config('captcha'));
		$captcha_check = array();
		if ($captcha & CAPTCHA_REGISTER) {
			$captcha_check['register'] = 'checked="checked"';
		}
		if ($captcha & CAPTCHA_LOGIN) {
			$captcha_check['login'] = 'checked="checked"';
		}
		if ($captcha & CAPTCHA_COMMENT) {
			$captcha_check['comment'] = 'checked="checked"';
		}
		if ($captcha & CAPTCHA_ADMIN) {
			$captcha_check['admin'] = 'checked="checked"';
		}
		if ($captcha & CAPTCHA_MESSAGE) {
			$captcha_check['message'] = 'checked="checked"';
		}

		if ($captcha & CAPTCHA_LOGIN_FAIL) {
			$captcha_check['login_fail_yes'] = 'checked="checked"';
		} else {
			$captcha_check['login_fail_no'] = 'checked="checked"';
		}

		$captcha_check['captcha_width'] = ecjia::config('captcha_width');
		$captcha_check['captcha_height'] = ecjia::config('captcha_height');
		$this->assign('captcha',          $captcha_check);

		$captchas = $this->captcha->captcha_list();
		$this->assign('captchas', $captchas);
		
		$this->assign('current_captcha', ecjia::config('captcha_style'));
		
		$this->assign('form_action',RC_Uri::url('captcha/admin/save_config'));

		$this->assign_lang();
		$this->display('captcha_list.dwt');
	}


	/**
	 * 保存设置
	 */
	public function save_config() {
		if (RC_ENV::gd_version() == 0) {
			return $this->showmessage(RC_Lang::get('captcha::captcha_manage.captcha_note'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$captcha = 0;
		$captcha = empty($_POST['captcha_register'])    ? $captcha : $captcha | CAPTCHA_REGISTER;
		$captcha = empty($_POST['captcha_login'])       ? $captcha : $captcha | CAPTCHA_LOGIN;
		$captcha = empty($_POST['captcha_comment'])     ? $captcha : $captcha | CAPTCHA_COMMENT;
		$captcha = empty($_POST['captcha_tag'])         ? $captcha : $captcha | CAPTCHA_TAG;
		$captcha = empty($_POST['captcha_admin'])       ? $captcha : $captcha | CAPTCHA_ADMIN;
		$captcha = empty($_POST['captcha_login_fail'])  ? $captcha : $captcha | CAPTCHA_LOGIN_FAIL;
		$captcha = empty($_POST['captcha_message'])     ? $captcha : $captcha | CAPTCHA_MESSAGE;

		$captcha_width = empty($_POST['captcha_width'])     ? 145 : intval($_POST['captcha_width']);
		$captcha_height = empty($_POST['captcha_height'])   ? 20 : intval($_POST['captcha_height']);

		ecjia_config::instance()->write_config('captcha', $captcha);
		ecjia_config::instance()->write_config('captcha_width', $captcha_width);
		ecjia_config::instance()->write_config('captcha_height', $captcha_height);

        /* 记录日志 */
        ecjia_admin_log::instance()->add_object('captcha', RC_Lang::get('captcha::captcha_manage.captcha'));
        ecjia_admin::admin_log(RC_Lang::get('captcha::captcha_manage.modify_code_parameter'), 'edit', 'captcha');

		return $this->showmessage(RC_Lang::get('captcha::captcha_manage.save_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 切换验证码展示样式
	 */
	public function apply() {
		$this->admin_priv('captcha_manage', ecjia::MSGTYPE_JSON);

		$captcha_code = trim($_GET['code']);
		if (ecjia::config('current_captcha') != $captcha_code) {
			$result = ecjia_config::instance()->write_config('captcha_style', $captcha_code);
			if ($result) {
                /* 记录日志 */
                ecjia_admin_log::instance()->add_object('captcha', RC_Lang::get('captcha::captcha_manage.captcha'));
                ecjia_admin::admin_log($captcha_code, 'use', 'captcha');

				return $this->showmessage(RC_Lang::get('captcha::captcha_manage.install_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('captcha/admin/init')));
			} else {
				return $this->showmessage(RC_Lang::get('captcha::captcha_manage.install_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}
}

// end