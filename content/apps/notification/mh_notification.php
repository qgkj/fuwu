<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 通知
 * by wutifang
 */
class mh_notification extends ecjia_merchant {
	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Script::enqueue_script('mh-notification', RC_App::apps_url('statics/js/mh-notification.js', __FILE__));
		RC_Style::enqueue_style('mh-notification', RC_App::apps_url('statics/css/mh-notification.css', __FILE__), array());
		
	}

	/**
	 * 通知逻辑处理
	 */
	public function init() {
	    $this->admin_priv('notification_manage');
	    
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('通知'));

		$status = !empty($_GET['status']) ? $_GET['status'] : 'all';

		$db_notifications = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id']);
		if ($status == 'not_read') {
			$db_notifications->whereNull('read_at');
		}
		$type_list = $db_notifications->selectRaw('distinct type')->get();
		if (!empty($type_list)) {
			foreach ($type_list as $k => $v) {
				
				$db_notification = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id']);
				if ($status == 'not_read') {
					$db_notification->whereNull('read_at');
				}
				$list = $db_notification->select('*')->where('type', $v['type'])->orderby('created_at', 'desc')->get();

				if (!empty($list)) {
					foreach ($list as $key => $val) {
						$arr = json_decode($val['data'], true);
						$list[$key]['content'] = $arr['body'];
						
						$created_time = $this->format_date($val['created_at']);
						$list[$key]['created_time'] = $created_time;
					}
				}
				$type_list[$k]['list']  = $list;
				$type_list[$k]['count'] = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id'])->where('type', $v['type'])->whereNull('read_at')->count();
				$type_list[$k]['type_title'] = $v['type'];
				$type_list[$k]['type'] = mix_substr($v['type'], 15);
			}
		}
		$count = RC_DB::table('notifications')
    			->select(RC_DB::raw('count(*) as count'), RC_DB::raw('SUM(IF(read_at != "", 0, 1)) as not_read'))
    			->where('notifiable_id', $_SESSION['staff_id'])
    			->first();

		$this->assign('count', $count);
		$this->assign('list', $type_list);
		$this->assign('ur_here', '通知');
		
		$this->display('notification_list.dwt');
	}
	
	//标记通知为已读
	public function mark_read() {
	    $this->admin_priv('notification_update', ecjia::MSGTYPE_JSON);
	    
		$time = RC_Time::local_date('Y-m-d H:i:s', RC_Time::gmtime());
		$data = array(
			'read_at' => $time
		);
		$type = isset($_POST['type']) ? $_POST['type'] : '';

		$status = !empty($_GET['status']) ? $_GET['status'] : 'all';
		//标记全部
		if ($type == 'mark_all') {
			$notice_list = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id'])->whereNull('read_at')->get();
			if (!empty($notice_list)) {
				foreach ($notice_list as $v) {
					$arr   = json_decode($v['data'], true);
					$title = $arr['body'];
					ecjia_merchant::admin_log($title, 'batch_mark', 'notice');
				}
			}
			$update = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id'])->whereNull('read_at')->update($data);
		} else {
			//标记该类型下全部通知为已读
			if (!empty($type)) {
				$notice_list = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id'])->where('type', $type)->whereNull('read_at')->get();
				if (!empty($notice_list)) {
					foreach ($notice_list as $v) {
						$arr   = json_decode($v['data'], true);
						$title = $arr['body'];
						ecjia_merchant::admin_log($title, 'batch_mark', 'notice');
					}
				}
				
				$update = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id'])->where('type', $type)->whereNull('read_at')->update($data);
			} else {
				//标记单个
				$id     = isset($_POST['val']) ? $_POST['val'] : '';
				$info   = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id'])->where('id', $id)->whereNull('read_at')->first();
				$arr    = json_decode($info['data'], true);
				$title  = $arr['body'];
				ecjia_merchant::admin_log($title, 'mark', 'notice');
				
				if (!empty($id)) {
					$update = RC_DB::table('notifications')->where('notifiable_id', $_SESSION['staff_id'])->where('id', $id)->whereNull('read_at')->update($data);
				}
			}
		}
		if ($update) {
			return $this->showmessage('标记成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('notification/mh_notification/init', array('status' => $status))));
		} else {
			return $this->showmessage('没有未读通知', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	private function format_date($time){
		$time = RC_Time::local_strtotime($time);
		$t = RC_Time::gmtime()-$time;
		$f = array(
			'31536000'	=>'年',
			'2592000'	=>'月',
			'604800'	=>'周',
			'86400'		=>'天',
			'3600'		=>'小时',
			'60'		=>'分钟',
			'1'			=>'秒'
		);
		foreach ($f as $k=>$v)    {
			if (0 != $c = floor($t/(int)$k)) {
				return $c.$v.'前';
			}
		}
	}
}
	
//end