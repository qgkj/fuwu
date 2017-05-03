<?php
  
/**
 * ECJIA 管理中心模版管理程序
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_library extends ecjia_admin {

	private $theme;

	public function __construct() {
		parent::__construct();

		$this->db_template    = RC_Loader::load_model('template_model');
		$this->db_plugins     = RC_Loader::load_model('plugins_model');
		$this->db_shop        = RC_Loader::load_model('shop_config_model');
		$this->theme          = Ecjia_ThemeManager::driver();

		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-form');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('外观'), RC_Uri::url('@admin_template/init')));
	}

	/**
	 * 管理库项目
	 */
	public function init() {
		$this->admin_priv('library_manage');
		
		RC_Script::enqueue_script('ecjia-admin_template');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('ecjia-utils');
        RC_Script::enqueue_script('acejs', RC_Uri::admin_url() . '/statics/lib/acejs/ace.js');
        RC_Script::enqueue_script('acejs-emmet', RC_Uri::admin_url() . '/statics/lib/acejs/ext-emmet.js');
        
        $admin_template_lang = array(
        		'editlibrary'       	=> __('您确定要保存编辑内容吗？'),
        		'choosetemplate'    	=> __('使用这个模板'),
        		'choosetemplateFG'  	=> __('使用这个模板风格'),
        		'abandon'           	=> __('您确定要放弃本次修改吗？'),
        		'write'             	=> __('请先输入内容！'),
        		'ok'                	=> __('确定'),
        		'cancel'            	=> __('取消'),
        		'confirm_leave'			=> __('您的修改内容还没有保存，您确定离开吗？'),
        		'confirm_leave'			=> __('连接错误，请重新选择!'),
        		'confirm_edit_project'	=> __('修改库项目是危险的高级操作，修改错误可能会导致前台无法正常显示。您依然确定要修改库项目吗？')
        );
        
        RC_Script::localize_script('ecjia-admin_template', 'admin_template_lang', $admin_template_lang);

        $full = isset($_GET['full']) && !empty($_GET['full']) ? 1 : 0;
        $lib = isset($_GET['lib']) ? $_GET['lib'] : '';
        $lib = str_replace(array('.lbi.php', '.php', '.lbi'), '', $lib);

		$libraries = $this->theme->getAllLibraryFiles();
		
        if (empty($lib) && !empty($libraries) && is_array($libraries)) {
            $lib = key($libraries);
        }

        $library = new Ecjia\System\Theme\ThemeLibrary($this->theme, trim($lib) . '.lbi.php');
		$library_info = $library->loadLibrary();

        $library_info['file'] = '';
        $library_info['name'] = '';
        if (isset($libraries[$lib])) {
            $library_info['file'] = $libraries[$lib]['File'];
            $library_info['name'] = $libraries[$lib]['File'].' - '.$libraries[$lib]['Name'];
            $libraries[$lib]['choose'] = 1;
        }

        $is_writable        = royalcms('files')->isWritable($library->getFilePath());
        $library_file       = str_replace(SITE_ROOT, '', $library_file);

        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('库项目管理')));
        $this->assign('ur_here'         , __('库项目管理'));
        $this->assign('lib'             , $lib);
        $this->assign('libraries'       , $libraries);
        $this->assign('full'            , $full);// 是否全屏
        $this->assign('is_writable'     , $is_writable);// library能否写入
        $this->assign('library_dir'     , $library_file);// library目录地址

        $this->assign('library_name'    , $library_info['name']);
        $this->assign('library_html'    , json_encode($library_info['html']));
        
        $this->assign('form_action', RC_Uri::url('admincp/admin_library/update_library'));

		$this->display('template_library.dwt');
	}

	/**
	 * 更新库项目内容
	 */
	public function update_library() {
		$this->admin_priv('library_manage');

		$html = stripslashes($_POST['html']);

		$library = new Ecjia\System\Theme\ThemeLibrary($this->theme, trim($_POST['lib']) . '.lbi.php');
		
		if ($library->updateLibrary($html)) {
			return $this->showmessage(__('库项目内容已经更新成功。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
            $templates          = $this->theme->get_theme_info();
            $libraries          = $this->theme->get_libraries();
            $library_file_name  = isset($libraries[$_POST['lib']]['File']) ? $libraries[$_POST['lib']]['File'] : '';
            $library_file       = str_replace(SITE_ROOT, '', SITE_THEME_PATH) . $templates['code'] . DS . 'library' . DS . $library_file_name;
			return $this->showmessage(sprintf(__('编辑库项目内容失败。请检查 %s 目录是否可以写入。'), $library_file), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

}

// end
