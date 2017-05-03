<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 功能扩展
 */
class admin_extend extends ecjia_admin {
	private $db_extend;
	private $db_command;
	private $db_platform_account;
	
	public function __construct() {
		parent::__construct();

		RC_Lang::load('platform');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		$this->db_extend = RC_Loader::load_app_model('platform_extend_model');
		$this->db_command = RC_Loader::load_app_model('platform_command_model');
		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model');
		
		RC_Loader::load_app_class('platform_factory', null, false);
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');		
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');
		
		RC_Script::enqueue_script('platform', RC_App::apps_url('statics/js/platform.js', __FILE__), array(), false, true);
		RC_Script::localize_script('platform', 'js_lang', RC_Lang::get('platform::platform.js_lang'));
		
		RC_Style::enqueue_style('wechat_extend', RC_App::apps_url('statics/css/wechat_extend.css', __FILE__));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('platform::platform.function_extend'), RC_Uri::url('platform/admin_extend/init')));
	}

	/**
	 * 功能扩展列表
	 */
	public function init () {
		$this->admin_priv('extend_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('platform::platform.function_extend')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('platform::platform.summarize'),
			'content'	=>
			'<p>' . RC_Lang::get('platform::platform.welcome_fun_ext') . '</p>'
		));
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:功能扩展#.E5.8A.9F.E8.83.BD.E6.89.A9.E5.B1.95" target="_blank">'.RC_Lang::get('platform::platform.function_extend_help').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('platform::platform.function_extend'));
		
		$modules = $this->exts_list();
		$this->assign('modules', $modules);

		$this->assign_lang();
		$this->display('extend_list.dwt');
	}
	
	/**
	 * 编辑扩展功能页面
	 */
	public function edit() {
		$this->admin_priv('extend_update');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('platform::platform.edit_function')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('platform::platform.summarize'),
			'content'	=>
			'<p>' . RC_Lang::get('platform::platform.welcome_fun_edit') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('platform::platform.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:功能扩展#.E7.BC.96.E8.BE.91.E5.8A.9F.E8.83.BD.E6.89.A9.E5.B1.95" target="_blank">'.RC_Lang::get('platform::platform.edit_extend_help').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('platform::platform.edit_function'));
		$this->assign('action_link', array('text' =>RC_Lang::get('platform::platform.function_extend'), 'href' => RC_Uri::url('platform/admin_extend/init')));
		$this->assign('form_action', RC_Uri::url('platform/admin_extend/save'));
	
		$code = trim($_GET['code']);
		$bd = $this->db_extend->where(array('ext_code' => $code))->find();
		$ext_config = unserialize($bd['ext_config']);
		$code_list = array();
		if (!empty($ext_config)) {
			foreach ($ext_config as $key => $value) {
				$code_list[$value['name']] = $value['value'];
			}
		}
		$payment_handle = new platform_factory($code);
		$bd['ext_config'] = $payment_handle->configure_forms($code_list, true);
		$this->assign('bd', $bd);
		
		$this->assign_lang();
		$this->display('extend_edit.dwt');
	}
	
	/**
	 * 编辑扩展功能处理
	 */
	public function save() {
		$this->admin_priv('extend_update', ecjia::MSGTYPE_JSON);

		$data['ext_name'] = trim($_POST['ext_name']);
		$data['ext_desc'] = trim($_POST['ext_desc']);
		$ext_code = trim($_POST['ext_code']);

		/* 取得配置信息 */
		$ext_config = array();
		if (isset($_POST['cfg_value']) && is_array($_POST['cfg_value'])) {
			for ($i = 0; $i < count($_POST['cfg_value']); $i++) {
				$ext_config[] = array(
					'name'  => trim($_POST['cfg_name'][$i]),
					'type'  => trim($_POST['cfg_type'][$i]),
					'value' => trim($_POST['cfg_value'][$i])
				);
			}
		}
		$data['ext_config'] = serialize($ext_config);
		$this->db_extend->where(array('ext_code' => $ext_code))->update($data);
		
		ecjia_admin::admin_log($data['ext_name'], 'edit', 'platform_extend');
		return $this->showmessage(RC_Lang::get('platform::platform.edit_fun_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin_extend/edit', array('code' => $ext_code))));
	}
	
	/**
	 * 禁用扩展处理
	 */
	public function disable() {
		$this->admin_priv('extend_update', ecjia::MSGTYPE_JSON);
	
		$code = trim($_GET['code']);
		$ext_name = $this->db_extend->where(array('ext_code' =>$code))->get_field('ext_name');
		$data = array(
			'enabled' => 0
		);
		$this->db_extend->where(array('ext_code' => $code))->update($data);
		
		ecjia_admin::admin_log($ext_name, 'stop', 'platform_extend');
		return $this->showmessage(RC_Lang::get('platform::platform.plugin').'<strong>'.RC_Lang::get('platform::platform.disabled').'</strong>', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin_extend/init')));
	}
	
	/**
	 * 启用扩展处理
	 */
	public function enable() {
		$this->admin_priv('extend_update', ecjia::MSGTYPE_JSON);
	
		$code = trim($_GET['code']);
		$ext_name = $this->db_extend->where(array('ext_code' =>$code))->get_field('ext_name');
		$data = array(
			'enabled' => 1
		);
		$this->db_extend->where(array('ext_code' => $code))->update($data);
	
		ecjia_admin::admin_log($ext_name, 'use', 'platform_extend');
		return $this->showmessage(RC_Lang::get('platform::platform.plugin').'<strong>'.RC_Lang::get('platform::platform.enabled').'</strong>', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('platform/admin_extend/init')));
	}
	
	/**
	 * 扩展列表
	 */
	private function exts_list() {
		$db_ext = RC_Loader::load_app_model('platform_extend_model');
		
		$count = $db_ext->count();
		$filter['record_count'] = $count;
		$page = new ecjia_page($count, 10, 5);
		
		$arr = array();
		$data = $db_ext->order('ext_id DESC')->limit($page->limit())->select();
		if (isset($data)) {
			foreach ($data as $rows) {
				$arr[] = $rows;
			}
		}
		return array('module' => $arr, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
}

// end