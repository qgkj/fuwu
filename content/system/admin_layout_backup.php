<?php
  
/**
 * ECJIA 管理中心模版管理程序
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_layout_backup extends ecjia_admin {
    
	private $db_template;

	/**
	 * 当前主题对象
	 *
	 * @var \Ecjia\System\Theme\Theme;
	 */
	private $theme;

	public function __construct() {
		parent::__construct();

		$this->db_template    = RC_Loader::load_model('template_widget_model');

		$this->theme          = Ecjia_ThemeManager::driver();

		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('外观'), RC_Uri::url('@admin_template/init')));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('布局设置备份'), RC_Uri::url('@admin_layout_backup/init')));
	}

	/**
	 * 布局备份
	 */
	public function init() {
		$this->admin_priv('backup_setting');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('备份')));
		$this->assign('ur_here',      __('模板布局备份'));

		$template_files = $this->theme->getAllowSettingTemplates();

		
		$settingFiles = $this->db_template->getTemplateFiles($this->theme->getThemeCode());

        $files = array();
        foreach ($settingFiles as $file) {
            if (isset($template_files[$file]))
                $files[$file] = $template_files[$file]['Name'];
        }
		
		$this->assign('files', $files);
		$this->assign('action', 'backup');
		
		$this->assign('form_action', RC_Uri::url('admincp/admin_layout_backup/backup_setting'));

		$this->display('template_backup.dwt');
	}


	/**
	 * 模板备份
	 */
	public function backup_setting() {
	    $this->admin_priv('backup_setting');
	    
	    $links = array(array('text'=>__('备份布局设置'), 'href' => RC_Uri::url('@admin_layout_backup/init')));
	    
		$remarks = empty($_POST['remarks']) ? RC_Time::local_date(ecjia::config('time_format')) : trim($_POST['remarks']);
		
		$files = array_get($_POST, 'files', array());
		
		if (empty($files)) {
		    return $this->showmessage(__('没有选择任何模板文件'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
		}
		
		if ($this->db_template->hasTemplateSettingBackup()) {
		    return $this->showmessage(sprintf(__('备份注释 %s 已经用过，请换个注释名称'), $remarks), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
		}
		
		$this->db_template->backupTemplateFiles($this->theme->getThemeCode(), $files, $remarks);

		return $this->showmessage(__('备份设置成功'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_SUCCESS, array('links' => $links));
	}

    /**
     * 删除备份
     */
	public function delete() {
	    $this->admin_priv('backup_setting');
	    
		$remarks = empty($_GET['remarks']) ? '' : trim($_GET['remarks']);
		if ($remarks) {
            $this->db_template->where('theme', $this->theme->getThemeCode())->where('remarks', $remarks)->delete();
		}
		
		$links = array(array('text' => __('备份模板设置'), 'href' => RC_Uri::url('@admin_layout_backup/restore')));
		
		return $this->showmessage(__('备份删除成功'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_SUCCESS, array('links' => $links));
    }

    
    /**
     * 还原备份
     */
    public function restore()
    {
        $this->admin_priv('backup_setting');
        
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('还原')));
        $this->assign('ur_here',      __('模板布局还原'));
        
        
        $rows = $this->db_template->getBackupRemarks($this->theme->getThemeCode());
        
        $remarks = array();
        foreach ($rows as $val) {
            $remarks[] = array('content' => $val['remarks'], 'url' => urlencode($val['remarks']));
        }
        
        $this->assign('list',  $remarks);
        $this->assign('screenshot',  $this->theme->getDefaultStyle()->getScreenshot());
        
        $this->display('template_backup.dwt');
    }

	public function restore_backup() {
	    $this->admin_priv('backup_setting');
	    
		$remarks = empty($_GET['remarks']) ? '' : trim($_GET['remarks']);
		$remarks = urldecode($remarks);
		
		if ($remarks) {
		    $result = $this->db_template->restoreTemplateFiles($this->theme->getThemeCode(), $remarks);

		    $links = array(array('text'=>__('备份布局设置'), 'href' => RC_Uri::url('@admin_layout_backup/restore')));
		    
			if (is_ecjia_error($result)) {
			    return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
			} else {
			    $links = array(array('text'=>__('还原布局设置'), 'href' => RC_Uri::url('@admin_layout_backup/restore')));
			     
			    return $this->showmessage(__('恢复备份成功'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_SUCCESS, array('links' => $links));
			}
			
		}
		
		return $this->showmessage(__('备份数据不存在或参数有误'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
		
	}

}

// end