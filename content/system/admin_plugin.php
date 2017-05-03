<?php
  
/**
 * ECJIA 支付方式管理
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_plugin extends ecjia_admin {
	private $addon_model;	
	
	public function __construct() {
		parent::__construct();
		
		RC_Style::enqueue_style('jquery-stepy');

		RC_Script::enqueue_script('ecjia-admin');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-stepy');
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		RC_Script::enqueue_script('jquery-dataTables-sorting');
	}

	/**
	 * 插件列表
	 */
	public function init () {
		$this->admin_priv('plugin_manage', ecjia::MSGTYPE_JSON);
		
		RC_Script::enqueue_script('ecjia-admin_plugin');
		
		$admin_plugin_jslang = array(
				'error_intasll'		=> __('参数错误，无法安装！'),
				'error_unintasll'	=> __('参数错误，无法卸载！'),
				'confirm_unintall'	=> __('您确定要卸载这个插件吗？'),
				'ok'				=> __('确定'),
				'cancel'			=> __('取消'),
				'delete_unintall'	=> __('您确定要删除这个插件吗？'),
				'no_delete'			=> __('此插件暂时不能删除。'),	
				'home'				=> __('首页'),
				'last_page'			=> __('尾页'),
				'previous'			=> __('上一页'),
				'next_page'			=> __('下一页'),
				'no_record'			=> __('没有找到任何记录'),	
				'count_num'			=> __('共_TOTAL_条记录 第_START_ 到 第_END_条'),
				'total'				=> __('共0条记录'),
				'retrieval'			=> __('（从_MAX_条数据中检索）')
		);
		RC_Script::localize_script('ecjia-admin_plugin', 'admin_plugin_lang', $admin_plugin_jslang );
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('插件管理')));
		$this->assign('ur_here', __('插件管理'));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
		'id'        => 'overview',
		'title'     => __('概述'),
		'content'   =>
		'<p>' . __('欢迎访问ECJia智能后台插件管理页面，系统中所有的插件都会显示在此列表中。') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:插件管理" target="_blank">关于插件管理帮助文档</a>') . '</p>'
		);

		// 弹窗UI
		RC_Script::enqueue_script('smoke');
		// 下拉框css
		RC_Style::enqueue_style('chosen');
		// 下拉框插件
		RC_Script::enqueue_script('jquery-chosen');
		
		if (!empty($_GET['reload'])) {
			RC_Plugin::clean_plugins_cache();
		}
		
		$active_plugins = ecjia_config::instance()->get_addon_config('active_plugins', true);
		
		/* 取得所有插件列表 */
		$plugins = RC_Plugin::get_plugins();
		
		$use_plugins_num = 0;
		$unuse_plugins_num = 0;
		$this->assign('plugins_num', count($plugins));
		
		foreach ($plugins as $_key => $_value) {
			$true = in_array($_key, $active_plugins);
			$true ? $use_plugins_num++ : $unuse_plugins_num++;
			
			//如果是已安装或未安装，卸载当前项
			if(!empty($_GET['usepluginsnum'])) {
				if (($_GET['usepluginsnum'] == 1 && !$true) || ($_GET['usepluginsnum'] == 2 && $true)) {
					unset($plugins[$_key]);
					continue;
				}
			}
			$plugins[$_key]['install'] = $true ? 1 : 0;
		}

		$this->assign('use_plugins_num', $use_plugins_num);
		$this->assign('unuse_plugins_num', $unuse_plugins_num);
		$this->assign('plugins', $plugins);
		
		$this->display('plugin_list.dwt');
	}

	/**
	* 安装插件
	*/
	public function install() {
		$this->admin_priv('plugin_install', ecjia::MSGTYPE_JSON);
		
		$id = trim($_GET['id']);
		$result = ecjia_plugin::activate_plugin($id);
		if ( is_ecjia_error( $result ) ) {
			if ( 'unexpected_output' == $result->get_error_code() ) {
				return $this->showmessage($result->get_error_data(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} elseif ('plugin_install_error' == $result->get_error_code()) {
				return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		$plugins = RC_Plugin::get_plugins();
		$data = $plugins[$id];
		
		ecjia_admin::admin_log($data['Name'], 'install', 'plugin');
		return $this->showmessage(sprintf(__('%s 插件安装成功！'), $data['Name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl'=>RC_Uri::url('@admin_plugin/init')));
	}

	/**
	 * 卸载插件
	 */
	public function uninstall() {
		$this->admin_priv('plugin_uninstall', ecjia::MSGTYPE_JSON);
		
		$id = trim($_GET['id']);

		$result = ecjia_plugin::deactivate_plugins(array($id));

		if ( is_ecjia_error( $result ) ) {
			if ( 'unexpected_output' == $result->get_error_code() ) {
				return $this->showmessage($result->get_error_data(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			} elseif ('plugin_uninstall_error' == $result->get_error_code()) {
				return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}
		}

		$plugins = RC_Plugin::get_plugins();
		$data = $plugins[$id];
		
		ecjia_admin::admin_log($data['Name'], 'uninstall', 'plugin');
		return $this->showmessage(sprintf(__('%s 插件卸载成功！'), $data['Name']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl'=>RC_Uri::url('@admin_plugin/init')));
	}
	
}

// end