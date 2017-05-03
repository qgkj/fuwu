<?php
  
/**
 * ECJIA 应用管理
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_application extends ecjia_admin {

	public function __construct() {
		parent::__construct();
		RC_Lang::load('application');

		RC_Style::enqueue_style('jquery-stepy');

		RC_Script::enqueue_script('ecjia-admin');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-stepy');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		RC_Script::enqueue_script('jquery-dataTables-sorting');

		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');

		// 下拉框css
		RC_Style::enqueue_style('chosen');
		//数字input框css
		RC_Style::enqueue_style('jquery-ui-aristo');
		// 下拉框插件
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('ecjia-admin_application');
		
		$admin_application_jslang = array(
				'no_message'		=> __('未找到搜索内容!'),	
				'start_installation'=> __('开始安装'),
				'retreat'			=> __('后退'),
				'home'				=> __('首页'),
				'last_page'			=> __('尾页'),
				'previous'			=> __('上一页'),
				'next_page'			=> __('下一页'),
				'no_record'			=> __('没有找到任何记录'),	
				'count_num'			=> __('共_TOTAL_条记录 第_START_ 到 第_END_条'),
				'total'				=> __('共0条记录'),
				'retrieval'			=> __('（从_MAX_条数据中检索）'),
				'installing'		=> __('安装中...'),
				'start_install'		=> __('开始安装')
		);
		RC_Script::localize_script('ecjia-admin_application', 'admin_application', $admin_application_jslang );
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('应用管理'), RC_Uri::url('@admin_application/init')));
	}

	/**
	 * 应用列表
	 */
	public function init() {		
		$this->admin_priv('application_manage', ecjia::MSGTYPE_JSON);
				
		if (! empty($_GET['reload'])) {
		    RC_App::clean_applications_cache();
		}

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('应用管理')));
		$this->assign('ur_here', __('应用管理'));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
		'id'        => 'overview',
		'title'     => __('概述'),
		'content'   =>
		'<p>' . __('欢迎访问ECJia智能后台应用管理页面，系统中所有的应用都会显示在此列表中。') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:应用管理" target="_blank">关于应用管理帮助文档</a>') . '</p>'
		);

		$active_applications = ecjia_config::instance()->get_addon_config('active_applications', true);
		$apps_list = $apps = ecjia_app::builtin_app_floders();

		/* 取得所有应用列表 */
		$applications = RC_App::get_apps();
		$core_list = $extend_list = array();

		$application_num = 0;
		$use_application_num = 0;
		$unuse_application_num = 0;
		$application_core_num = 0;

		foreach ($applications as $_key => $_value) {
			RC_Lang::load($_value['directory'] . '/package');
			if (in_array($_value['directory'], $apps_list) ) {
				$core_list[$_key] = RC_App::get_app_package($_value['directory']);
					$application_core_num++;
			} else {
				if (!in_array($_value['directory'], $apps_list)) {
					$application_num++;
					$true = in_array($_key, $active_applications);
					$true ? $use_application_num++ : $unuse_application_num++;

					if (isset($_GET['useapplicationnum']) && (($true && $_GET['useapplicationnum'] == 2) || (!$true && $_GET['useapplicationnum'] == 1))) {
						unset($applications[$_key]);
						continue;
					}
				}
				
				$extend_list[$_key] = RC_App::get_app_package($_value['directory']);
				
				$extend_list[$_key]['install'] 			= $true ? 1 : 0;
			}
		}
		
		unset($applications);
		
		$applications = array(
			'core_list' 	=> $core_list,
			'extend_list' 	=> $extend_list,
		);

		$this->assign('application_num',			$application_num);
		$this->assign('use_application_num',		$use_application_num);
		$this->assign('unuse_application_num',		$unuse_application_num);
		$this->assign('application_core_num',		$application_core_num);
		$this->assign('applications',	$applications);
		
		$this->display('application_list.dwt');
	}
	
	
	/**
	 * 查看应用
	 */
	public function detail() {
		$this->admin_priv('application_manage', ecjia::MSGTYPE_JSON);
				
		$id = trim($_GET['id']);
		
		$app_dir = ecjia_app::get_app_dir($id);
		$result = ecjia_app::validate_application($app_dir);
		if (is_ecjia_error($result)) {
			//@todo 报错
		}
		
		$package = RC_App::get_app_package($app_dir);

		if (isset($_GET['step']) && $_GET['step'] == 'install') {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('应用安装')));
			$this->assign('ur_here', __('应用安装'));
			$this->assign('is_install', true);
		} else {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('应用详情')));
			$this->assign('ur_here', __('应用详情'));
			$this->assign('action_link',	array('href' => RC_Uri::url('@admin_application/init'), 'text' => __('返回应用列表')));
		}
		$this->assign('application', $package);
		
		$this->display('application_detail.dwt');
	}
	
	/**
	 * 安装应用
	 */
	public function install() {
		$this->admin_priv('application_install', ecjia::MSGTYPE_JSON);
				
		$id = $_GET['id'];
		
		$result = ecjia_app::install_application($id);
		
		if ( is_ecjia_error( $result ) ) {
			if ( 'unexpected_output' == $result->get_error_code() ) {
				return $this->showmessage($result->get_error_data(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		$app_dir = ecjia_app::get_app_dir($id);
		$package = RC_App::get_app_package($app_dir);
		
		/* 清除缓存 */
		ecjia_admin_menu::singleton()->clean_admin_menu_cache();
		
		/* 记录日志 */
		ecjia_admin::admin_log($package['format_name'], 'install', 'app');
		
		return $this->showmessage(sprintf(__('%s 应用安装成功'), $package['format_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 卸载应用
	 */
	public function uninstall() {
		$this->admin_priv('application_uninstall', ecjia::MSGTYPE_JSON);
				
		$id = $_GET['id'];

		$result = ecjia_app::uninstall_application($id);
		
		if ( is_ecjia_error( $result ) ) {
			if ( 'unexpected_output' == $result->get_error_code() ) {
				return $this->showmessage($result->get_error_data(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		$app_dir = ecjia_app::get_app_dir($id);
		$package = RC_App::get_app_package($app_dir);
		/* 记录日志 */
		ecjia_admin::admin_log($package['format_name'], 'uninstall', 'app');

		return $this->showmessage(sprintf(__('%s 应用卸载成功'), $package['format_name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('@admin_application/init')));
	}
}

// end