<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA授权登陆
 */
class admin_oauth extends ecjia_admin {
	private $db_oauth;
	private $db_platform_account;

	public function __construct() {
		parent::__construct();
		
		RC_Lang::load('wechat');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->db_oauth = RC_Loader::load_app_model('wechat_oauth_model');
		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');

		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Loader::load_app_class('platform_account', 'platform', false);
		RC_Script::enqueue_script('wechat_oauth', RC_App::apps_url('statics/js/wechat_oauth.js', __FILE__), array(), false, true);
		
		RC_Script::localize_script('wechat_oauth', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js') );
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
	}

	public function info() {
		$this->admin_priv('wechat_oauth_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.configure_oauth')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.configure_oauth'));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=> '<p>' . RC_Lang::get('wechat::wechat.configure_oauth_content') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:授权登陆" target="_blank">'. RC_Lang::get('wechat::wechat.configure_oauth_help') .'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			$data = $this->db_platform_account->field('type, uuid')->find(array('id' => $wechat_id));
			$this->assign('type', $data['type']);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_service_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$data['type'])));
			
			$wechat_oauth = $this->db_oauth->find(array('wechat_id' => $wechat_id));
			if ($wechat_oauth) {
				$wechat_oauth['last_time'] = RC_Time::local_date(ecjia::config('time_format'), $wechat_oauth['last_time']);
				$this->assign('wechat_oauth', $wechat_oauth);
				$this->assign('form_action', RC_Uri::url('wechat/admin_oauth/update'));
			} else {
				$this->assign('form_action', RC_Uri::url('wechat/admin_oauth/insert'));
			}
			$weshop_url = RC_Uri::site_url().'/index.php?m=platform&c=plugin&a=show&handle=mp_userbind/bind_auth&uuid='.$data['uuid'];
			$this->assign('weshop_url', $weshop_url);
			$oauth_url = RC_Uri::site_url().'/index.php?m=platform&c=plugin&a=show&handle=mp_userbind/bind_callback&uuid='.$data['uuid'];
			$this->assign('oauth_url', $oauth_url);
		}
		
		$this->assign_lang();
		$this->display('wechat_oauth_edit.dwt');
	}
	
	/**
	 * 添加处理
	 */
	public function insert() {
		$this->admin_priv('wechat_oauth_update', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$oauth_status 		= isset($_POST['oauth_status']) 		? $_POST['oauth_status'] 		: '';
		$oauth_redirecturi 	= isset($_POST['oauth_redirecturi']) 	? $_POST['oauth_redirecturi'] 	: '';
		$oauth_count 		= isset($_POST['oauth_count']) 			? $_POST['oauth_count'] 		: '';
		$last_time 			= RC_Time::gmtime();
		
		$data = array(
			'wechat_id' 		=>	$wechat_id,
			'oauth_status'  	=>	$oauth_status,
   			'oauth_redirecturi'	=>	$oauth_redirecturi,
		 	'oauth_count'		=>	$oauth_count,
			'last_time'			=>	$last_time,
		);
	
		$id = $this->db_oauth->insert($data);
		
		ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.oauth_login'), 'add', 'config');
		return $this->showmessage(RC_Lang::get('wechat::wechat.oauth_login_succcess'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_oauth/info')));
	}
	
	/**
	 * 编辑处理
	 */
	public function update() {
		$this->admin_priv('wechat_oauth_update', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$oauth_status 		= isset($_POST['oauth_status']) 		? $_POST['oauth_status'] 		: '';
		$oauth_redirecturi 	= isset($_POST['oauth_redirecturi']) 	? $_POST['oauth_redirecturi'] 	: '';
		$oauth_count 		= isset($_POST['oauth_count']) 			? $_POST['oauth_count'] 		: '';
		$last_time 			= RC_Time::gmtime();
		
		$data = array(
			'oauth_status'  	=>	$oauth_status,
   			'oauth_redirecturi'	=>	$oauth_redirecturi,
		 	'oauth_count'		=>	$oauth_count,
			'last_time'			=>	$last_time,
		);
	
		$this->db_oauth->where(array('wechat_id' => $wechat_id))->update($data);
		
		ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.oauth_login'), 'edit', 'config');
		return $this->showmessage(RC_Lang::get('wechat::wechat.oauth_login_succcess'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_oauth/info')));
	}
}

//end