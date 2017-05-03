<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商家佣金设置
 */
class admin_percent extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		
		RC_Lang::load('merchants_percent');
		RC_Script::enqueue_script('commission', RC_App::apps_url('statics/js/commission.js', __FILE__));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('佣金比例'),RC_Uri::url('store/admin_percent/init')));
		
		ecjia_admin_log::instance()->add_object('merchants_percent', '佣金比例');
	}
	
	/**
	 * 商家佣金列表
	 */
	public function init() {
		$this->admin_priv('store_percent_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('佣金比例')));
		
		$this->assign('ur_here', __('佣金比例')); // 当前导航				
		$this->assign('add_percent', array('href' => RC_Uri::url('store/admin_percent/add'), 'text' => __('添加佣金比例')));
		
		$percent_list = $this->get_percent_list();
		$this->assign('percent_list',$percent_list);
		
		/* 显示模板 */
		$this->assign_lang();
		$this->display('store_percent_list.dwt');
	}
	
	/**
	 * 添加佣金百分比页面
	 */
	public function add() {
		$this->admin_priv('store_percent_add');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加佣金比例')));		
		
		$this->assign('ur_here', __('添加佣金比例'));
		$this->assign('action_link', array('href' =>RC_Uri::url('store/admin_percent/init'), 'text' => __('佣金比例')));
		$this->assign('form_action', RC_Uri::url('store/admin_percent/insert'));

		$this->assign_lang();
		$this->display('store_percent_info.dwt');
	}
	
	/**
	 * 添加佣金百分比加载
	 */
	public function insert() {
		$this->admin_priv('store_percent_add', ecjia::MSGTYPE_JSON);
		
		if (empty($_POST['percent_value'])) {
			return $this->showmessage('奖励额度不能为空',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (!is_numeric($_POST['percent_value'])) {
			return $this->showmessage('奖励额度必须为数字',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if ($_POST['percent_value'] > 100 || $_POST['percent_value'] < 0) {
		    return $this->showmessage('奖励额度范围为0-100，请修改',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$data = array(
			'percent_value'	=> trim($_POST['percent_value']),
			'sort_order'	=> trim($_POST['sort_order']),
			'add_time'		=> RC_Time::gmtime()
		);
		
		$result = RC_DB::table('store_percent')
					->where('percent_value', $data['percent_value'])
					->get();
		if (!empty($result)) {
			return $this->showmessage('该奖励额度已存在！',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
			
		$percent_id = RC_DB::table('store_percent')->insertGetId($data);
		if ($percent_id) {
			ecjia_admin::admin_log($_POST['percent_value'].'%', 'add', 'merchants_percent');
			$links = array(
				array('href' => RC_Uri::url('store/admin_percent/init'), 'text' => __('返回佣金比例列表')),
				array('href' => RC_Uri::url('store/admin_percent/add'), 'text' => __('继续添加佣金比例')),
			);
			return $this->showmessage('添加佣金比例成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS , array('links' => $links , 'pjaxurl' => RC_Uri::url('store/admin_percent/edit',array('id' => $percent_id))));	
		} else {
			return $this->showmessage('添加佣金比例失败！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 佣金百分比编辑页面
	 */
	public function edit() {
		$this->admin_priv('store_percent_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑佣金比例')));
		
		$this->assign('ur_here', __('编辑佣金比例'));
		$this->assign('action_link', array('href' =>RC_Uri::url('store/admin_percent/init'), 'text' => __('佣金比例')));
		$this->assign('form_action', RC_Uri::url('store/admin_percent/update'));
		
		/* 取得奖励额度信息 */
		$id = $_GET['id'];
		$this->assign('id',$id);
		
		$percent = RC_DB::table('store_percent')
					->where('percent_id', $id)
					->first();
		if ($percent['add_time']) {
			$percent['add_time'] = RC_Time::local_strtotime($percent['add_time']);
		}
		$this->assign('percent',$percent);
		
		$this->assign_lang();
		$this->display('store_percent_info.dwt');
	}
	
	/**
	 * 佣金百分比 编辑 加载
	 */
	public function update() {
		$this->admin_priv('store_percent_update', ecjia::MSGTYPE_JSON);
		
		$percent_id = $_POST['id'];
		if ($_POST['percent_value'] > 100 || $_POST['percent_value'] < 0) {
		    return $this->showmessage('奖励额度范围为0-100，请修改',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$data = array( 
			'percent_value' => trim($_POST['percent_value']),
			'sort_order' => trim($_POST['sort_order'])
		);
		
		/* 取得奖励额度信息 */
		$percent_info = RC_DB::table('store_percent')->where('percent_id', $percent_id)->first();
		
		/* 判断名称是否重复 */
		$is_only = RC_DB::table('store_percent')
					->where('percent_value', $data['percent_value'])
					->where('percent_id', '<>', $percent_id)
					->first();
		if (!empty($is_only)) {
			return $this->showmessage('该奖励额度已存在！',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 保存奖励额度信息 */
		$percent_update = RC_DB::table('store_percent')->where('percent_id', $percent_id)->update($data);
		/* 提示信息 */
		ecjia_admin::admin_log($_POST['percent_value'].'%', 'edit', 'merchants_percent');
		return $this->showmessage('编辑成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS , array('pjaxurl' => RC_Uri::url('store/admin_percent/edit',array('id' => $percent_id))));
	}
	
	//删除佣金百分比
	public function remove() {
		$this->admin_priv('store_percent_delete', ecjia::MSGTYPE_JSON);
		
		$id = $_GET['id'];
		$percent_value = RC_DB::table('store_percent')->where('percent_id', $id)->pluck('percent_value');
		$percent_delete = RC_DB::table('store_percent')->where('percent_id', $id)->delete();
						
		if ($percent_delete) {
			ecjia_admin::admin_log($percent_value.'%', 'remove', 'merchants_percent');
			return $this->showmessage('删除成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage('删除失败',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	//批量删除佣金百分比
	public function batch() {
		$this->admin_priv('store_percent_delete', ecjia::MSGTYPE_JSON);
		
		/* 对批量操作进行权限检查  END */
		$id = $_POST['id'];
		$ids = explode(',', $id);
		
		$info = RC_DB::table('store_percent')->whereIn('percent_id', $ids)->select('percent_value')->get();
		
		$percent_delete = RC_DB::table('store_percent')->whereIn('percent_id', $ids)->delete();
		
		foreach ($info as $v) {
			ecjia_admin::admin_log($v['percent_value'].'%', 'batch_remove', 'merchants_percent');
		}
		return $this->showmessage('批量删除成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_percent/init')));
		
	}
	
	//获取佣金百分比列表
	private function get_percent_list() {
		$filter['sort_by']    = empty($_GET['sort_by']) ? 'sort_order' : trim($_GET['sort_by']);
		$filter['sort_order'] = empty($_GET['sort_order']) ? 'asc' : trim($_GET['sort_order']);
		
		$count = RC_DB::table('store_percent')->count();
		$page = new ecjia_page($count,20,5);
		
		$data = RC_DB::table('store_percent')
				->orderBy($filter['sort_by'], $filter['sort_order'])
				->limit($page->limit($page->limit()))
				->get();
		if (!empty($data)) {
			foreach ($data as $k => $v) {
				$data[$k]['add_time'] = RC_Time::local_date('Y-m-d',$v['add_time']);
			}
		}
		
		return array('item' => $data, 'filter'=>$filter, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'current_page' => $page->current_page);
	}
}

//end