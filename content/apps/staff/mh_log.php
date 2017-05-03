<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 员工日志管理
 */
class mh_log extends ecjia_merchant {
	public function __construct() {
		parent::__construct();

		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');

		RC_Script::enqueue_script('staff_logs', RC_App::apps_url('statics/js/staff_logs.js', __FILE__), array(), false, true);
		RC_Script::localize_script('staff_logs', 'js_lang', RC_Lang::get('staff::staff.js_lang'));

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('员工管理', RC_Uri::url('staff/merchant/init')));
		ecjia_merchant_screen::get_current_screen()->set_parentage('staff', 'staff/merchant.php');
	}


	/**
	 * 员工日志列表页面
	 */
	public function init() {
		$this->admin_priv('staff_log_manage');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('员工日志'));
		$this->assign('ur_here', RC_Lang::get('staff::staff.log_list'));

		$logs = $this->get_admin_logs($_REQUEST);

		/* 查询IP地址列表 */
		$ip_list = array();
		$data = RC_DB::table('staff_log')->selectRaw('distinct ip_address')->get();
		if (!empty($data)) {
			foreach ($data as $row) {
				$ip_list[] = $row['ip_address'];
			}
		}

		/* 查询管理员列表 */
		$user_list = array();
		$userdata = RC_DB::table('staff_user')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->get();
		if (!empty($userdata)) {
			foreach ($userdata as $row) {
				if (!empty($row['user_id']) && !empty($row['name'])) {
					$user_list[$row['user_id']] = $row['name'];
				}
			}
		}

		$this->assign('form_search_action', RC_Uri::url('staff/mh_log/init'));

		$this->assign('logs', $logs);
		$this->assign('ip_list', $ip_list);
		$this->assign('user_list', $user_list);

		$this->display('staff_log_list.dwt');
	}

	/**
	 *  获取管理员操作记录
	 *  @param array $_GET , $_POST, $_REQUEST 参数
	 * @return array 'list', 'page', 'desc'
	 */
	private function get_admin_logs($args = array()) {
		$db_staff_log = RC_DB::table('staff_log as sl')
						->leftJoin('staff_user as su', RC_DB::raw('sl.user_id'), '=', RC_DB::raw('su.user_id'));

		$user_id  = !empty($args['user_id']) ? intval($args['user_id']) : 0;
		$ip = !empty($args['ip']) ? $args['ip'] : '';


		$filter = array();
		$filter['sort_by']      = !empty($args['sort_by']) ? safe_replace($args['sort_by']) :  RC_DB::raw('sl.log_id');
		$filter['sort_order']   = !empty($args['sort_order']) ? safe_replace($args['sort_order']) : 'DESC';

		$keyword = !empty($args['keyword']) ? trim(htmlspecialchars($args['keyword'])) : '';

		//查询条件
		$where = array();
		if (!empty($ip)) {
			$db_staff_log->where(RC_DB::raw('sl.ip_address'), $ip);
		}

		if(!empty($keyword)) {
			$db_staff_log->where(RC_DB::raw('sl.log_info'), 'like', '%'.$keyword.'%');
		}

		if (!empty($user_id)) {
			$db_staff_log->where(RC_DB::raw('su.user_id'), $user_id);
		}
		
		if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			$db_staff_log->where(RC_DB::raw('sl.store_id'), $_SESSION['store_id']);
		}
		

		$count = $db_staff_log->count();
		$page = new ecjia_merchant_page($count, 15, 5);
		$data = $db_staff_log
    		->selectRaw('sl.log_id,sl.log_time,sl.log_info,sl.ip_address,sl.ip_location,su.name')
    		->orderby($filter['sort_by'], $filter['sort_order'])
    		->take(10)
    		->skip($page->start_id-1)
    		->get();
		/* 获取管理员日志记录 */
		$list = array();
		if (!empty($data)) {
			foreach ($data as $rows) {
				$rows['log_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['log_time']);
				$list[] = $rows;
			}
		}
		return array('list' => $list, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
}

//end
