<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 员工组管理
 */
class mh_group extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('uniform-aristo');

		RC_Script::enqueue_script('staff_group', RC_App::apps_url('statics/js/staff_group.js', __FILE__));
		
		ecjia_merchant_screen::get_current_screen()->set_parentage('staff', 'staff/merchant.php');
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('员工管理', RC_Uri::url('staff/merchant/init')));
	}

	
	/**
	 * 员工组列表页面
	 */
	public function init() {
	    $this->admin_priv('staff_group_manage');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('员工组列表'));
	    $this->assign('ur_here', RC_Lang::get('staff::staff.group_list'));
	    $this->assign('action_link', array('text' => RC_Lang::get('staff::staff.staff_group_add'), 'href' => RC_Uri::url('staff/mh_group/add')));
	    
	    $staff_group_list = $this->staff_group_list($_SESSION['store_id']);
	    $this->assign('staff_group_list', $staff_group_list);
	    
	    $this->assign('search_action',RC_Uri::url('staff/mh_group/init'));
	    
	    $this->display('staff_group_list.dwt');
	}
	
	/**
	 * 添加员工组页面
	 */
	public function add() {
		$this->admin_priv('staff_group_update');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('staff::staff.group_list'), RC_Uri::url('staff/mh_group/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('staff::staff.staff_group_add')));
		$this->assign('ur_here', RC_Lang::get('staff::staff.staff_group_add'));
		$this->assign('action_link',array('href' => RC_Uri::url('staff/mh_group/init'),'text' => RC_Lang::get('staff::staff.group_list')));
		
		$priv_group = ecjia_merchant_purview::load_purview();
		$this->assign('priv_group',$priv_group);
		
		$this->assign('form_action',RC_Uri::url('staff/mh_group/insert'));
	
		$this->display('staff_group_edit.dwt');

	}
	
	/**
	 * 处理添加员工组
	 */
	public function insert() {
		$this->admin_priv('staff_group_update', ecjia::MSGTYPE_JSON);
		
		if (RC_DB::table('staff_group')->where('group_name', $_POST['group_name'])->where('store_id',$_SESSION['store_id'])->count() > 0) {
			return $this->showmessage('该员工组名称已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$action_list = join(",", $_POST['action_code']);
		$data = array(
			'store_id' 		=> $_SESSION['store_id'],
			'group_name' 	=> !empty($_POST['group_name']) 		? $_POST['group_name'] : '',
			'groupdescribe' => !empty($_POST['groupdescribe']) 		? $_POST['groupdescribe'] : '',
			'action_list'	=> $action_list,
		);
		
		$group_id = RC_DB::table('staff_group')->insertGetId($data);
		ecjia_merchant::admin_log($_POST['group_name'], 'add', 'staff_group');
		
		$links[] = array('text' => RC_Lang::get('staff::staff.back_staff_group_list'), 'href' => RC_Uri::url('staff/mh_group/init'));
		$links[] = array('text' => RC_Lang::get('staff::staff.continue_add_staff_group'), 'href' => RC_Uri::url('staff/mh_group/add'));
		return $this->showmessage(RC_Lang::get('staff::staff.staff_add_group_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('staff/mh_group/edit', array('group_id' => $group_id))));
	}
	
	/**
	 * 编辑员工组页面
	 */
	public function edit() {
		$this->admin_priv('staff_group_update');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('staff::staff.group_list'), RC_Uri::url('staff/mh_group/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('staff::staff.staff_group_update')));
		$this->assign('ur_here',RC_Lang::get('staff::staff.staff_group_update'));
		$this->assign('action_link',array('href' => RC_Uri::url('staff/mh_group/init'),'text' => RC_Lang::get('staff::staff.group_list')));
		
		$group_id = intval($_GET['group_id']);
		$staff_group = RC_DB::table('staff_group')->where('group_id', $group_id)->where('store_id', $_SESSION['store_id'])->first();
		if (empty($staff_group)) {
			$links[] = array('text' => '返回员工组列表', 'href' => RC_Uri::url('staff/mh_group/init'));
			return $this->showmessage('该员工组不存在', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => $links));
		}
		
		$this->assign('staff_group', $staff_group);
		$this->assign('edit', 'edit');
		$priv_group = ecjia_merchant_purview::load_purview($staff_group['action_list']);
		$this->assign('priv_group',$priv_group);
		
		$this->assign('form_action',RC_Uri::url('staff/mh_group/update'));

		$this->display('staff_group_edit.dwt');
	}
	
	/**
	 * 编辑员工组信息处理
	 */
	public function update() {
		$this->admin_priv('staff_group_update', ecjia::MSGTYPE_JSON);
		
		$action_list = join(",", $_POST['action_code']);
		$group_id = intval($_POST['group_id']);
		if (RC_DB::table('staff_group')->where('group_name', $_POST['group_name'])->where('group_id', '!=', $group_id)->where('store_id',$_SESSION['store_id'])->count() > 0) {
			return $this->showmessage('该员工组名称已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$data = array(
			'group_name' 	=> !empty($_POST['group_name']) 		? $_POST['group_name'] : '',
			'groupdescribe' => !empty($_POST['groupdescribe']) 		? $_POST['groupdescribe'] : '',
			'action_list'	=> $action_list,
		);
		RC_DB::table('staff_group')->where('group_id', $group_id)->where('store_id', $_SESSION['store_id'])->update($data);
		ecjia_merchant::admin_log($_POST['group_name'], 'edit', 'staff_group');
		return $this->showmessage(RC_Lang::get('staff::staff.staff_update_group_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('staff/mh_group/edit', array('group_id' => $group_id))));
	}
	

	/**
	 * 删除员工组
	 */
	public function remove() {
		$this->admin_priv('staff_group_remove', ecjia::MSGTYPE_JSON);

		$group_id = intval($_GET['group_id']);
		$remove_num = RC_DB::table('staff_user')->where('group_id', $group_id)->count();
		if ($remove_num > 0) {
			return $this->showmessage(RC_Lang::get('staff::staff.confirm_remove'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$name = RC_DB::table('staff_group')->where(RC_DB::raw('group_id'), $group_id)->pluck('group_name');
			RC_DB::table('staff_group')->where('group_id', $group_id)->delete();
			ecjia_merchant::admin_log($name, 'remove', 'staff_group');
			return $this->showmessage(RC_Lang::get('staff::staff.remove_success'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('staff/mh_group/init')));
		}
	}
	
	/**
	 * 获取员工组列表信息
	 */
	private function staff_group_list($store_id) {
		$db_staff_group = RC_DB::table('staff_group');
		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		if ($filter['keywords']) {
			$db_staff_group->where('group_name', 'like', '%'.mysql_like_quote($filter['keywords']).'%');
		}
		
		$count = $db_staff_group->count();
		$page = new ecjia_merchant_page($count, 10, 5);
		
		$data = $db_staff_group
    		->selectRaw('group_id,group_name,groupdescribe')
    		->where('store_id', $store_id)
    		->orderby('group_id', 'asc')
    		->take(10)
    		->skip($page->start_id-1)
    		->get();
		$res = array();
		if (!empty($data)) {
			foreach ($data as $row) {
				$res[] = $row;
			}
		}
		return array('staff_group_list' => $res, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
}

//end