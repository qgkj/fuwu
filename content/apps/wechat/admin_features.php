<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA功能扩展
 */
class admin_features extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		
		RC_Lang::load('wechat');
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
	}

	/**
	 * 显示插件信息
	 */
	public function init() {
		$this->admin_priv('wechat_features_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.features')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.features_list'));
	
		$listdb = $this->get_featureslist();
		$this->assign('listdb', $listdb);
		
		$this->assign_lang();
		$this->display('features_list.dwt');
	}
	
	
	/**
	 * 取得插件信息
	 */
	private function get_featureslist() {
		$db_wechat_extend = RC_Loader::load_app_model('wechat_extend_model');
		
		$where = array(
			'type'	=> 'function',
			'enable'=> '1'
		);
		$count = $db_wechat_extend->where($where)->count();
		$page  = new ecjia_page($count, 15, 5);
		$arr   = array ();
		$data  = $db_wechat_extend->where($where)->order('id ASC')->limit($page->limit())->select();
		if (isset($data)) {
			foreach ($data as $rows) {
				$arr[] = $rows;
			}
		}
		return array('features_list' => $arr, 'page' => $page->show (5), 'desc' => $page->page_desc());
	}
}

//end