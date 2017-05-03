<?php
  
/**
 * ECJIA 管理中心模版管理程序
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_template extends ecjia_admin {

    /**
     * 当前主题对象
     *
     * @var \Ecjia\System\Theme\Theme;
     */
	private $theme;

	public function __construct() {
		parent::__construct();

		$this->theme = Ecjia_ThemeManager::driver();

		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('外观'), RC_Uri::url('@admin_template/init')));
	}

	/**
	 * 模版列表
	 */
	public function init() {
		$this->admin_priv('template_select');

		RC_Script::enqueue_script('ecjia-admin_template');

		$admin_template_lang = array(
			'choosetemplate'     => __("启用新的模板将覆盖原来的模板。\n您确定要启用选定的模板吗？"),
			'choosetemplateFG'   => __('您确定要启用选定的模板风格吗？'),
			'abandon'            => __('您确定要放弃本次修改吗？'),
			'write'              => __('请先输入内容！'),
			'ok'                 => __('确定'),
			'cancel'             => __('取消')
		);
		RC_Script::localize_script('ecjia-admin_template', 'admin_template_lang', $admin_template_lang );

		/* 获得当前的模版的信息 */
		$curr_style = Ecjia_ThemeManager::getStyleName(); 
		$template = $this->theme->loadSpecifyStyle($curr_style)->process();

		$template_styles = $this->theme->getThemeStyles();
		
		/* 获得可用的模版 */
		$availables = Ecjia_ThemeManager::getAvailableThemes();

		/* 获得可用的模版的可选风格数组 */
		$available_templates = array();
		if (count($availables) > 0) {
			foreach ($availables as $key => $theme) {
			    if ($key == $this->theme->getThemeCode()) {
			        continue;
			    }
				$templates_style[$key] = $theme->getThemeStyles();
				$available_templates[$key] = $theme->getDefaultStyle()->process();
			}
		}

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('主题管理')));
		
		$this->assign('ur_here',                  __('主题管理'));
		$this->assign('curr_tpl_style',           $curr_style);
		$this->assign('template_style',           $templates_style);
		$this->assign('curr_template',            $template);
		$this->assign('available_templates',      $available_templates);
		$this->assign('available_templates_count',  count($available_templates));
		$this->assign('curr_template_styles',     $template_styles);

		$this->display('template_list.dwt');
	}

	/**
	 * 安装模版
	 */
	public function install() {
		$this->admin_priv('backup_setting');

		$tpl_name = trim($_GET['tpl_name']);
		$tpl_fg   = trim($_GET['tpl_fg']) ?: ''; 
		
		if ($tpl_name != Ecjia_ThemeManager::getTemplateName()) {
		    $step_template = ecjia_config::instance()->write_config(Ecjia_ThemeManager::getTemplateCode(), $tpl_name);
		} else {
		    $step_template = true;
		}
		
        if ($tpl_fg != Ecjia_ThemeManager::getStyleName()) {
            $step_stylename = ecjia_config::instance()->write_config(Ecjia_ThemeManager::getStyleCode(), $tpl_fg);
        } else {
            $step_stylename = true;
        }

		if ($step_template && $step_stylename) {
			return $this->showmessage(__('启用模板成功。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('@admin_template/init')));
		} else {
			return $this->showmessage(__('启用模板时出现异常。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

}

// end
