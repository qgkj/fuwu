<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class admin_config extends ecjia_admin {

	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
	
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('bootstrap-placeholder');
		
		RC_Script::enqueue_script('admin_config', RC_App::apps_url('statics/js/admin_config.js', __FILE__), array(), false, true);
	}
					
	/**
	 * 后台设置
	 */
	public function init() {
	    $this->admin_priv('store_config_manage');
	   
		$this->assign('ur_here', '后台配置');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('后台配置')));

//     	$this->assign('config_cpname', ecjia::config('merchant_admin_cpname')); //需删除
    	
    	$this->assign('config_logoimg', RC_Upload::upload_url(ecjia::config('merchant_admin_login_logo')));
    	$this->assign('config_logo', ecjia::config('merchant_admin_login_logo'));
    	$this->assign('current_code', 'store');
		$this->assign('form_action', RC_Uri::url('store/admin_config/update'));
		$this->display('store_config_info.dwt');
	}
		
	/**
	 * 处理后台设置
	 */
	public function update() {
		$this->admin_priv('store_config_manage', ecjia::MSGTYPE_JSON);
		
		$merchant_admin_cpname 	= !empty($_POST['merchant_admin_cpname']) 	? trim($_POST['merchant_admin_cpname']) : '';
		//后台名称
		ecjia_config::instance()->write_config('merchant_admin_cpname', $merchant_admin_cpname);
		
		$upload = RC_Upload::uploader('image', array('save_path' => 'data/assets', 'save_name' => 'merchant_admin_logo', 'replace' => true, 'auto_sub_dirs' => false));
		
		//登录logo
		$image_info = $upload->upload($_FILES['merchant_admin_login_logo']);		
		/* 判断是否上传成功 */
		if (!empty($image_info)) {
			$old_logo = ecjia::config('merchant_admin_login_logo');
			if (!empty($old_logo)) {
				$upload->remove($old_logo);
			}
			$logo = $upload->get_position($image_info);	
			ecjia_config::instance()->write_config('merchant_admin_login_logo', $logo);
		}
		
		ecjia_admin::admin_log('商家入驻>后台设置', 'setup', 'config');
		return $this->showmessage(__('更新后台设置成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_config/init')));
	}
	
	/**
	 * 删除上传文件
	 */
	public function del() {
		$this->admin_priv('store_config_manage', ecjia::MSGTYPE_JSON);
		$type = !empty($_GET['type']) ? $_GET['type'] : '';
		
		if (!empty($type)) {
			$disk = RC_Filesystem::disk();
			if ($type == 'logo') {
				$disk->delete(RC_Upload::upload_path() . ecjia::config('merchant_admin_login_logo'));
				ecjia_config::instance()->write_config('merchant_admin_login_logo', '');
			}
		}
		return $this->showmessage(__('删除图片成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_config/init')));
	}
}

//end