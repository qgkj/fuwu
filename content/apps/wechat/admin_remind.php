<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA提醒设置
 */
class admin_remind extends ecjia_admin {
	private $db_platform_account;
// 	private $wechat_template;
	
	public function __construct() {
		parent::__construct();
		
		RC_Lang::load('wechat');
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
		RC_Loader::load_app_class('platform_account', 'platform', false);
// 		$this->wechat_template = RC_Loader::load_app_model('wechat_template_model');

		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js') );
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('admin_remind', RC_App::apps_url('statics/js/admin_remind.js', __FILE__), array(), false, true);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.remind_set'), RC_Uri::url('wechat/admin_remind/init')));
		
	}

	/**
	 * 提醒设置
	 */
	public function init() {
		$this->admin_priv('wechat_remind_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.remind_set')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.remind_set'));
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else { 
			$this->assign('warn', 'warn');
			$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $type);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_subscribe_nonsupport'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
			
			$tab = !empty($_GET['tab']) ? $_GET['tab'] : 'order_remind';
			$this->assign('tab', $tab);
			$this->assign('form_action', RC_Uri::url('wechat/admin_remind/init', array('tab' => $tab)));
			
			if (!empty($_POST)) {
				$template_code = isset($_POST['template_code']) ? $_POST['template_code'] : '';
				$data = isset($_POST['data']) ? $_POST['data'] : '';
				$config = isset($_POST['config']) ? $_POST['config'] : '';
				if (!empty($config)) {
					$data['config'] = serialize($config);
				}
				$data['wechat_id'] = $wechat_id;
				$where = array('template_code' => $template_code, 'wechat_id' => $wechat_id);
				$count = $this->wechat_template->where($where)->count();
				if ($count > 0) {
					$this->wechat_template->where($where)->update($data);
				} else {
					$data['template_code'] = $template_code;
					$this->wechat_template->insert($data);
				}
				return $this->showmessage(RC_Lang::get('wechat::wechat.set_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_remind/init', array('tab' => $tab))));
			}
			$order_remind 		= $this->wechat_template->find(array('template_code' => 'order_remind', 'wechat_id' => $wechat_id));
			$pay_remind 		= $this->wechat_template->find(array('template_code' => 'pay_remind', 'wechat_id' => $wechat_id));
			$send_remind 		= $this->wechat_template->find(array('template_code' => 'send_remind', 'wechat_id' => $wechat_id));
			$register_remind 	= $this->wechat_template->find(array('template_code' => 'register_remind', 'wechat_id' => $wechat_id));
			
			if ($register_remind['config']) {
				$register_remind['config'] = unserialize($register_remind['config']);
			}
			$this->assign('order_remind', $order_remind);
			$this->assign('pay_remind', $pay_remind);
			$this->assign('send_remind', $send_remind);
			$this->assign('register_remind', $register_remind);
		}
		$this->assign_lang();
		$this->display('wechat_remind_list.dwt');
	}
}

//end