<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 广告位置管理程序
 * @author songqian
 */
class admin_position extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);
		RC_Script::enqueue_script('adsense', RC_App::apps_url('statics/js/adsense.js', __FILE__));
		RC_Script::enqueue_script('ad_position', RC_App::apps_url('statics/js/ad_position.js', __FILE__));
		$js_lang = array(
			'position_name_required' => RC_Lang::get('adsense::adsense.position_name_required'),
			'ad_width_required' => RC_Lang::get('adsense::adsense.ad_width_required'),
			'ad_height_required' => RC_Lang::get('adsense::adsense.ad_height_required') 
		);
		RC_Script::localize_script('ad_position', 'js_lang', $js_lang);
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('adsense::adsense.ads_position'), RC_Uri::url('adsense/admin_position/init')));
	}
	
	/**
	 * 广告位置列表页面
	 */
	public function init() {
		$this->admin_priv('ad_position_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('adsense::adsense.ads_position')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id' => 'overview',
			'title' => RC_Lang::get('adsense::adsense.overview'),
			'content' => '<p>' . RC_Lang::get('adsense::adsense.position_list_help') . '</p>' 
		));
		ecjia_screen::get_current_screen()->set_help_sidebar('<p><strong>' . RC_Lang::get('adsense::adsense.more_info') . '</strong></p>' . '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:广告位置" target="_blank">' . RC_Lang::get('adsense::adsense.about_position_list') . '</a>') . '</p>');
		
		$this->assign('ur_here', RC_Lang::get('adsense::adsense.position_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('adsense::adsense.position_add'), 'href' => RC_Uri::url('adsense/admin_position/add')));
		$this->assign('search_action', RC_Uri::url('adsense/admin_position/init'));
		
		$position_list = $this->get_ad_position_list();
		$this->assign('position_list', $position_list);
		$this->display('adsense_position_list.dwt');
	}
	
	/**
	 * 添加广告位页面
	 */
	public function add() {
		$this->admin_priv('ad_position_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('adsense::adsense.position_add')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id' => 'overview',
			'title' => RC_Lang::get('adsense::adsense.overview'),
			'content' => '<p>' . RC_Lang::get('adsense::adsense.position_add_help') . '</p>' 
		));
		ecjia_screen::get_current_screen()->set_help_sidebar('<p><strong>' . RC_Lang::get('adsense::adsense.more_info') . '</strong></p>' . '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:广告位置#.E6.B7.BB.E5.8A.A0.E5.B9.BF.E5.91.8A.E4.BD.8D.E7.BD.AE" target="_blank">' . RC_Lang::get('adsense::adsense.about_add_position') . '</a>') . '</p>');
		
		$this->assign('ur_here', RC_Lang::get('adsense::adsense.position_add'));
		$this->assign('action_link', array('href' => RC_Uri::url('adsense/admin_position/init'), 'text' => RC_Lang::get('adsense::adsense.position_list')));
		$this->assign('posit_arr', array('position_style' => '<table cellpadding="0" cellspacing="0">' . "\n" . '{foreach from=$ads item=ad}' . "\n" . '<tr><td>{$ad}</td></tr>' . "\n" . '{/foreach}' . "\n" . '</table>'));
		$this->assign('action', 'insert');
		$this->assign('form_action', RC_Uri::url('adsense/admin_position/insert'));
		$this->display('adsense_position_info.dwt');
	}
	
	/**
	 * 添加广告位页面
	 */
	public function insert() {
		$this->admin_priv('ad_position_update', ecjia::MSGTYPE_JSON);
		
		$position_name = !empty($_POST['position_name']) ? trim($_POST['position_name']) : '';
		$position_desc = !empty($_POST['position_desc']) ? nl2br(htmlspecialchars($_POST['position_desc'])) : '';
		$ad_width = !empty($_POST['ad_width']) ? intval($_POST['ad_width']) : 0;
		$ad_height = !empty($_POST['ad_height']) ? intval($_POST['ad_height']) : 0;
		$position_style = !empty($_POST['position_style']) ? $_POST['position_style'] : '';
		
		/* 查看广告位是否有重复 */
		if (RC_DB::table('ad_position')->where('position_name', $position_name)->count() == 0) {
			$data = array(
				'position_name' => $position_name,
				'ad_width' => $ad_width,
				'ad_height' => $ad_height,
				'position_desc' => $position_desc,
				'position_style' => $position_style 
			);
			$position_id = RC_DB::table('ad_position')->insertGetId($data);
			ecjia_admin::admin_log($position_name, 'add', 'ads_position');
			$links[] = array('text' => RC_Lang::get('adsense::adsense.back_position_list'), 'href' => RC_Uri::url('adsense/admin_position/init'));
			$links[] = array('text' => RC_Lang::get('adsense::adsense.continue_add_position'), 'href' => RC_Uri::url('adsense/admin_position/add'));
			return $this->showmessage(RC_Lang::get('adsense::adsense.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('adsense/admin_position/edit', array('id' => $position_id))));
		} else {
			return $this->showmessage(RC_Lang::get('adsense::adsense.posit_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 广告位编辑页面
	 */
	public function edit() {
		$this->admin_priv('ad_position_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('adsense::adsense.position_edit')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id' => 'overview',
			'title' => RC_Lang::get('adsense::adsense.overview'),
			'content' => '<p>' . RC_Lang::get('adsense::adsense.position_edit_help') . '</p>' 
		));
		ecjia_screen::get_current_screen()->set_help_sidebar('<p><strong>' . RC_Lang::get('adsense::adsense.more_info') . '</strong></p>' . '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:广告位置#.E7.BC.96.E8.BE.91.E5.B9.BF.E5.91.8A.E4.BD.8D.E7.BD.AE" target="_blank">' . RC_Lang::get('adsense::adsense.about_edit_position') . '</a>') . '</p>');
		$this->assign('ur_here', RC_Lang::get('adsense::adsense.position_edit'));
		$this->assign('action_link', array(
			'href' => RC_Uri::url('adsense/admin_position/init'),
			'text' => RC_Lang::get('adsense::adsense.position_list') 
		));
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$posit_arr = RC_DB::table('ad_position')->where('position_id', $id)->first();
		$this->assign('posit_arr', $posit_arr);
		$this->assign('action', 'update');
		$this->assign('form_action', RC_Uri::url('adsense/admin_position/update'));
		$this->display('adsense_position_info.dwt');
	}
	
	/**
	 * 广告位编辑处理
	 */
	public function update() {
		$this->admin_priv('ad_position_update', ecjia::MSGTYPE_JSON);
		
		$position_name 	= !empty($_POST['position_name']) 	? trim($_POST['position_name']) 					: '';
		$position_desc 	= !empty($_POST['position_desc']) 	? nl2br(htmlspecialchars($_POST['position_desc'])) 	: '';
		$ad_width 		= !empty($_POST['ad_width']) 		? intval($_POST['ad_width']) 						: 0;
		$ad_height 		= !empty($_POST['ad_height']) 		? intval($_POST['ad_height']) 						: 0;
		$position_style = !empty($_POST['position_style']) 	? $_POST['position_style'] 							: '';
		$position_id 	= !empty($_POST['id']) 				? intval($_POST['id']) 								: 0;
		
		$count = RC_DB::table('ad_position')->where('position_name', $position_name)->where('position_id', '!=', $position_id)->count();
		if ($count == 0) {
			$data = array(
				'position_name' 	=> $position_name,
				'ad_width' 			=> $ad_width,
				'ad_height' 		=> $ad_height,
				'position_desc' 	=> $position_desc,
				'position_style' 	=> $position_style 
			);
			RC_DB::table('ad_position')->where('position_id', $position_id)->update($data);
			ecjia_admin::admin_log($position_name, 'edit', 'ads_position');
			return $this->showmessage(RC_Lang::get('adsense::adsense.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('adsense::adsense.posit_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑广告位置名称
	 */
	public function edit_position_name() {
		$this->admin_priv('ad_position_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['pk']);
		$position_name = trim($_POST['value']);
		if (!empty($position_name)) {
			if (RC_DB::table('ad_position')->where('position_name', $position_name)->count() != 0) {
				return $this->showmessage(sprintf(RC_Lang::get('adsense::adsense.posit_name_exist'), $position_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$data = array(
					'position_name' => $position_name 
				);
				RC_DB::table('ad_position')->where('position_id', $id)->update($data);
				ecjia_admin::admin_log($position_name, 'edit', 'ads_position');
				return $this->showmessage(RC_Lang::get('adsense::adsense.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($position_name)));
			}
		} else {
			return $this->showmessage(RC_Lang::get('adsense::adsense.ad_name_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑广告位宽
	 */
	public function edit_ad_width() {
		$this->admin_priv('ad_position_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['pk']);
		$ad_width = trim($_POST['value']);
		if (!empty($ad_width)) {
			if (!preg_match('/^[\\.0-9]+$/', $ad_width)) {
				return $this->showmessage(RC_Lang::get('adsense::adsense.width_number'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if ($ad_width > 1024 || $ad_width < 1) {
				return $this->showmessage(RC_Lang::get('adsense::adsense.width_value'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$data = array(
				'ad_width' => $ad_width 
			);
			RC_DB::table('ad_position')->where('position_id', $id)->update($data);
			ecjia_admin::admin_log($ad_width, 'edit', 'ads_position');
			return $this->showmessage(RC_Lang::get('adsense::adsense.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($ad_width)));
		} else {
			return $this->showmessage(RC_Lang::get('adsense::adsense.ad_width_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑广告位宽
	 */
	public function edit_ad_height() {
		$this->admin_priv('ad_position_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['pk']);
		$ad_height = trim($_POST['value']);
		if (!empty($ad_height)) {
			if (!preg_match('/^[\\.0-9]+$/', $ad_height)) {
				return $this->showmessage(RC_Lang::get('adsense::adsense.height_number'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			if ($ad_height > 1024 || $ad_height < 1) {
				return $this->showmessage(RC_Lang::get('adsense::adsense.height_value'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$data = array(
				'ad_height' => $ad_height 
			);
			RC_DB::table('ad_position')->where('position_id', $id)->update($data);
			ecjia_admin::admin_log($ad_height, 'edit', 'ads_position');
			return $this->showmessage(RC_Lang::get('adsense::adsense.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => stripslashes($ad_height)));
		} else {
			return $this->showmessage(RC_Lang::get('adsense::adsense.ad_height_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 删除广告位置
	 */
	public function remove() {
		$this->admin_priv('ad_position_delete', ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		if (RC_DB::table('ad')->where('position_id', $id)->count() != 0) {
			return $this->showmessage(RC_Lang::get('adsense::adsense.not_del_adposit'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$position_name = RC_DB::table('ad_position')->where('position_id', $id)->pluck('position_name');
			ecjia_admin::admin_log($position_name, 'remove', 'ads_position');
			RC_DB::table('ad_position')->where('position_id', $id)->delete();
		}
		return $this->showmessage(RC_Lang::get('adsense::adsense.drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 获取广告位置列表
	 */
	private function get_ad_position_list() {
		$db_ad_position = RC_DB::table('ad_position');
		
		$filter = $where = array();
		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		if ($filter['keywords']) {
			$db_ad_position->where('position_name', 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
		}
		$count = $db_ad_position->count();
		$page = new ecjia_page($count, 10, 5);
		$db_ad_position->orderby('position_id', 'desc')->take(10)->skip($page->start_id - 1);
		$data = $db_ad_position->get();
		
		$arr = array();
		if (!empty($data)) {
			foreach ($data as $rows) {
				$position_desc = !empty($rows['position_desc']) ? RC_String::sub_str($rows['position_desc'], 50, true) : '';
				$rows['position_desc'] = nl2br(htmlspecialchars($position_desc));
				$arr[] = $rows;
			}
		}
		return array('item' => $arr, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
}

// end