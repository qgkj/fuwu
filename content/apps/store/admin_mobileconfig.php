<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class admin_mobileconfig extends ecjia_admin {
	private $db_ad_position;
	public function __construct() {
		parent::__construct();
		
		$this->db_ad_position = RC_Loader::load_app_model('ad_position_model', 'adsense');
		
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
		
		RC_Script::enqueue_script('admin_mobileconfig', RC_App::apps_url('statics/js/admin_mobileconfig.js', __FILE__), array(), false, true);
	}

					
	/**
	 * 移动应用设置
	 */
	public function init() {
	    $this->admin_priv('store_mobileconfig_manage');
	   
		$this->assign('ur_here', '店铺街移动应用设置');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('店铺街移动应用设置')));
		
		$ad_position_list = RC_DB::table('ad_position')->select(RC_DB::raw('position_id, position_name'))->get();
		
    	$this->assign('mobile_store_home_adsense', ecjia::config('mobile_store_home_adsense'));
    	$this->assign('ad_position_list', $ad_position_list);
		$this->assign('form_action', RC_Uri::url('store/admin_mobileconfig/update'));
		
		$this->display('store_mobileconfig.dwt');
	}
		
	/**
	 * 处理后台设置
	 */
	public function update() {
		$this->admin_priv('store_mobileconfig_manage', ecjia::MSGTYPE_JSON);
		
		ecjia_config::instance()->write_config('mobile_store_home_adsense', $_POST['mobile_store_home_adsense']);

		ecjia_admin::admin_log('店铺街移动应用>店铺街首页配置', 'setup', 'store_mobileconfig');
		return $this->showmessage(__('更新店铺街首页配置设置成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('store/admin_mobileconfig/init')));
	}
	
}

//end