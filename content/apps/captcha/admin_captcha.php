<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 验证码显示
 */

class admin_captcha extends ecjia_admin {
	public function __construct() {
		parent::__construct();
	}

	public function init() {
		$code = isset($_GET['code']) ? trim($_GET['code']) : '';

		$captcha = RC_Loader::load_app_class('captcha_method');
		$image = $captcha->captcha_style_image($code);
		echo $image;
	}

	public function check_validate() {
		if (isset($_POST['captcha']) && $_SESSION['captcha_word'] != strtolower($_POST['captcha'])) {
			return $this->showmessage(RC_Lang::get('captcha::captcha_manage.captcha_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			return $this->showmessage(RC_Lang::get('captcha::captcha_manage.captcha_right'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}

}

// end
