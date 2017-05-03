<?php
  
/**
 * ECJIA 记录管理员操作日志
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_logs extends ecjia_admin {
	private $admin_log;
	
	public function __construct() {
		parent::__construct();

		$this->admin_log = RC_Loader::load_model('admin_log_model');
		
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('ecjia-admin_logs');
		
		$admin_logs_jslang = array(
			'choose_delet_time'	=> __('请先选择删除日志的时间！'),
			'delet_ok_1'		=> __('确定删除'),
			'delet_ok_2'		=> __('的日志吗？'),
			'ok'				=> __('确定'),
			'cancel'			=> __('取消')
		);
		RC_Script::localize_script('ecjia-admin_logs', 'admin_logs_lang', $admin_logs_jslang );
	}
	
	/**
	 * 获取所有日志列表
	 */
	public function init() {
		$this->admin_priv('logs_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('管理员日志')));
		$this->assign('ur_here', __('管理员日志'));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
		'id'        => 'overview',
		'title'     => __('概述'),
		'content'   =>
		'<p>' . __('欢迎访问ECJia智能后台管理员日志页面，可以在此查看管理员操作的一些记录信息。') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:系统设置#.E7.AE.A1.E7.90.86.E5.91.98.E6.97.A5.E5.BF.97" target="_blank">关于管理员日志帮助文档</a>') . '</p>'
		);
		
		$logs = $this->get_admin_logs($_REQUEST);
		/* 查询IP地址列表 */
		$ip_list = array();
		$data = $this->admin_log->field('DISTINCT ip_address')->select();
		if (!empty($data)) {
			foreach ($data as $row) {
				$ip_list[] = $row['ip_address'];
			}
		}
		$this->assign('ip_list',   $ip_list);
		$viewmodel = RC_Loader::load_model('admin_log_viewmodel');
		$viewmodel->view['admin_user']['field'] = 'DISTINCT au.user_name , au.user_id';
		$viewmodel->join('admin_user');
		
		/* 查询管理员列表 */
		$user_list = array();
		$userdata = $viewmodel->select();
		if (!empty($userdata)) {
			foreach ($userdata as $row) {
				if (!empty($row['user_id']) && !empty($row['user_name'])) {
					$user_list[$row['user_id']] = $row['user_name'];
				}
			}
		}
		$this->assign('user_list',   $user_list);
		$this->assign('logs', $logs);
		
		$this->display('admin_logs.dwt');
	}
	
	/**
	 * 批量删除日志记录
	 */
	public function batch_drop() {
		$this->admin_priv('logs_drop');
		
		$drop_type_date = isset($_POST['drop_type_date']) ? $_POST['drop_type_date'] : '';
		
		/* 按日期删除日志 */
		if ($drop_type_date) {				
			if ($_POST['log_date'] > 0) {
				$where = array();
				switch ($_POST['log_date']) {
					case 1:
						$a_week = RC_Time::gmtime() - (3600 * 24 * 7);
						$where['log_time'] = array('elt' => $a_week); 
						$deltime = __('一周之前');
					break;
					case 2:
						$a_month = RC_Time::gmtime() - (3600 * 24 * 30);
						$where['log_time'] = array('elt' => $a_month);
						$deltime = __('一个月前');
					break;
					case 3:
						$three_month = RC_Time::gmtime() - (3600 * 24 * 90);
						$where['log_time'] = array('elt' => $three_month);
						$deltime = __('三个月前');
					break;
					case 4:
						$half_year = RC_Time::gmtime() - (3600 * 24 * 180);
						$where['log_time'] = array('elt' => $half_year);
						$deltime = __('半年之前');
					break;
					case 5:
					default:
						$a_year = RC_Time::gmtime() - (3600 * 24 * 365);
						$where['log_time'] = array('elt' => $a_year);
						$deltime = __('一年之前');
					break;
				}

				$this->admin_log->where($where)->delete();
                /* 记录日志 */
                ecjia_admin::admin_log(sprintf(__('删除 %s 的日志。'), $deltime), 'remove', 'adminlog');

				return $this->showmessage(sprintf(__('%s 的日志成功删除。'), $deltime), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('@admin_logs/init')));
			}
			
			return $this->redirect(RC_Uri::url('@admin_logs/init'));
		}
	}
	
	
	/**
	 *  获取管理员操作记录
	 *  @param array $_GET , $_POST, $_REQUEST 参数
	 * @return array 'list', 'page', 'desc'
	 */
	private function get_admin_logs($args = array()) {
		$viewmodel = RC_Loader::load_model('admin_log_viewmodel');

		$user_id  = !empty($args['user_id']) ? intval($args['user_id']) : 0;
		$ip = !empty($args['ip']) ? $args['ip'] : '';

		$filter = array();
		$filter['sort_by']      = !empty($args['sort_by']) ? safe_replace($args['sort_by']) : 'al.log_id';
		$filter['sort_order']   = !empty($args['sort_order']) ? safe_replace($args['sort_order']) : 'DESC';

		$keyword = !empty($args['keyword']) ? trim(htmlspecialchars($args['keyword'])) : '';

		//查询条件
		$where = array();
		if (!empty($ip)) {
			$where['ip_address'] = $ip;
		}

		if(!empty($keyword)) {
			$where['log_info'] = array('like' => "%$keyword%");
		}

		if (!empty($user_id)) {
			$where['au.user_id'] = $user_id;	
		}
		
		$viewmodel->join('admin_user');

		/* 获得总记录数据 */
		$filter['record_count'] = $viewmodel->where($where)->count();

		$page = new ecjia_page($filter['record_count'], 15, 6);

		$data = $viewmodel->where($where)->order(array($filter['sort_by'] => $filter['sort_order']))->limit($page->limit())->select();

		/* 获取管理员日志记录 */
		$list = array();
		if (!empty($data)) {
			foreach ($data as $rows) {
				$rows['log_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['log_time']);
				$list[] = $rows;
			}
		}
		return array('list' => $list, 'page' => $page->show(5), 'desc' => $page->page_desc());	
	}
	
}


// end