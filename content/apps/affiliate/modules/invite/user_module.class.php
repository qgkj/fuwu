<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 推荐用户基本信息
 * @author will.chen
 */
class user_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
		$this->authSession();
		if ($_SESSION['user_id'] <= 0 ) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$user_invite_code = RC_Api::api('affiliate', 'user_invite_code');
		
		$tpl = ecjia::config('invite_template');
		$invite_template = '';
		if (!empty($tpl)) {
			$this->assign('user_name', $_SESSION['user_name']);
			$this->assign('shop_name', ecjia::config('shop_name'));
			$invite_template = $this->fetch_string($tpl);
		}
		$invite_info = array(
			'invite_code'			=> $user_invite_code,
			'invite_qrcode_image'	=> RC_Uri::site_url().'/index.php?m=affiliate&c=mobile&a=qrcode_image&invite_code='. $user_invite_code,
			'invite_template'		=> $invite_template,
			'invite_explain'		=> ecjia::config('invite_explain'),
			'invite_url'			=> RC_Uri::site_url().'/index.php?m=affiliate&c=mobile&a=init&invite_code='. $user_invite_code
		);
		return $invite_info;
	}
}

// end