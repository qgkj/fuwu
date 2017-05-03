<?php
  
/**
 * ECJIA 留言管理 -管理员留言程序
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_message extends ecjia_admin {
	private $db_admin;
	private $db_message;
	private $db_session;
	private $db_view;
	
	public function __construct() {
		parent::__construct();
		
		$this->db_session	= RC_Loader::load_model('session_model');
		$this->db_admin		= RC_Model::model('admin_user_model');
		$this->db_message	= RC_Loader::load_model('admin_message_model');
		$this->db_view		= RC_Loader::load_model('admin_message_user_viewmodel');
	}
	
	
	/**
	 * 留言列表页面
	 */
	public function init() {
		
		/* 加载所需js */
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('ecjia-admin_cleditor', RC_Uri::admin_url() . '/statics/lib/CLEditor/jquery.cleditor.js', array('ecjia-admin'), false, true);
		RC_Script::enqueue_script('ecjia-admin_message_list');

		/* 页面所需CSS加载 */
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('bootstrap-responsive');
		RC_Style::enqueue_style('admin_cleditor_style', RC_Uri::admin_url() . '/statics/lib/CLEditor/jquery.cleditor.css');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('管理员留言')));	
		$this->assign('ur_here', __('管理员留言'));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
		'id'        => 'overview',
		'title'     => __('概述'),
		'content'   =>
		'<p>' . __('欢迎访问ECJia智能后台管理员留言页面，所有管理员可以在此进行留言交谈方便管理。') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:管理员留言" target="_blank">关于管理员留言帮助文档</a>') . '</p>'
		);

		//交谈用户id
		$chat_id = isset($_GET['chat_id'])	? intval($_GET['chat_id']) : 0;
		
		$chat_list = ecjia_admin_message::get_admin_chat();
		/* 获取管理员列表 */
		$admin_list = $this->db_admin->field('user_id, user_name')->select();
		$tmp_online = $this->db_session->field('adminid')->where(array('adminid' => array('gt' => 0)))->select();

        $admin_online_sort = $admin_id_sort = $admin_online = array();

		foreach ($tmp_online as $v) {
			$admin_online[] = $v['adminid'];
		}
		if (!empty($admin_list)) {
			foreach ($admin_list as $k => $v) {
				$admin_list[$k]['is_online'] = in_array($v['user_id'], $admin_online) ? 1 : 0;
				$v['user_id'] == $_SESSION['admin_id'] && $admin_list[$k]['is_online'] = 2;
				$v['user_id'] == $chat_id && $this->assign('chat_name' , $v['user_name']);
				
				$admin_list[$k]['icon'] = in_array($v['user_id'], $admin_online) ? RC_Uri::admin_url('statics/images/humanoidIcon_online.png') : RC_Uri::admin_url('statics/images/humanoidIcon.png');

				$admin_online_sort[$k] = $admin_list[$k]['is_online'];
				$admin_id_sort[$k] = $v['user_id'];
			}
		}
		//排序用户数组
		array_multisort($admin_online_sort, SORT_DESC, $admin_id_sort, SORT_ASC, $admin_list);

		$this->assign('admin_list',		$admin_list);
		$this->assign('message_list',	$chat_list['item']);
		$this->assign('message_lastid',	$chat_list['last_id']);
		
		$this->display('message_list.dwt');
	}
	
	/**
	 * 获取已读的留言
	 */
	public function readed_message() {
		/* 获取留言 */
		$list = ecjia_admin_message::get_admin_chat();
		$message = count($list['item']) < 10 ? __('没有更多消息了') : __('搜索到了');
		if (!empty($list['item'])) {
			return $this->showmessage($message, ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('msg_list' => $list['item'], 'last_id' => $list['last_id']));
		} else {
			return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 处理留言的发送
	 */
	public function insert() {
		$id = !empty($_REQUEST['chat_id']) ? intval($_REQUEST['chat_id']) : 0;
		$title = !empty($_POST['title']) ? $_POST['title'] : '';
		$data = array (
			'sender_id'		=> $_SESSION['admin_id'],
			'receiver_id'	=> $id,
			'sent_time'		=> RC_Time::gmtime(),
			'read_time'		=> '0',
			'readed'		=> '0',
			'deleted'		=> '0',
			'title'			=> $title,
			'message'		=> $_POST['message'],
		);
	
		if (!empty($_POST['message'])) {
			$messageone_id = $this->db_message->insert($data);
		}
		
		if ($messageone_id) {
			//回复消息之前，所有收到的消息设为已读
			ecjia_admin_message::read_meg($id);
			ecjia_admin::admin_log(__('发送留言'), 'add', 'admin_message');
			return $this->showmessage(__('发送成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('sent_time' => RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime())));
		} else {
			return $this->showmessage(__('发送失败'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
}

// end