<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA抽奖记录
 */
class admin_prize extends ecjia_admin {
	private $db_prize;
	private $db_platform_account;
	private $custom_message_viewdb;

	public function __construct() {
		parent::__construct();
		
		RC_Lang::load('wechat');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->db_prize = RC_Loader::load_app_model('wechat_prize_model');
		$this->custom_message_viewdb = RC_Loader::load_app_model('wechat_custom_message_viewmodel');
		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
		
		RC_Loader::load_app_class('platform_account', 'platform', false);
		RC_Loader::load_app_class('wechat_method', 'wechat', false);

		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('wechat_prize', RC_App::apps_url('statics/js/wechat_prize.js', __FILE__));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js') );
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::localize_script('wechat_prize', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
	}

	/**
	 * 抽奖记录页面
	 */
	public function init() {
		$this->admin_priv('wechat_prize_manage');
	
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.mail_record_list'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.draw_record')));
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();

		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			$this->assign('form_action', RC_Uri::url('wechat/admin_prize/init'));
			
			$list = $this->get_prize();
			$this->assign('list', $list);
			
			//获取公众号类型 0未认证 1订阅号 2服务号 3认证服务号 4企业号
			$types = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $types);
		}
		
		$this->assign_lang();
		$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.subscription_service_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
		$this->display('wechat_prize_list.dwt');
	}
	
	
	/**
	 * 发放奖品
	 */
	public function winner_issue(){
		$this->admin_priv('wechat_prize_manage', ecjia::MSGTYPE_JSON);
		
		$id 	= isset($_GET['id'])		?	intval($_GET['id'])		:0;
		$cancel = isset($_GET['cancel']) 	? 	intval($_GET['cancel']) : 0;
		$type 	= isset($_GET['type']) 		? 	$_GET['type'] 			: '';
		
		$url = RC_Uri::url('wechat/admin_prize/init');
		if ($type) {
			$url =  RC_Uri::url('wechat/admin_prize/init', array('type' =>$type));
		}
		if (!empty($cancel)) {
			$data['issue_status'] = 0;
			$this->db_prize->where(array('id' => $id))->update($data);
			return $this->showmessage(RC_Lang::get('wechat::wechat.close_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
		} else {
			$data['issue_status'] = 1;
			$this->db_prize->where(array('id' => $id))->update($data);
			return $this->showmessage(RC_Lang::get('wechat::wechat.provide_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
		}
	}
	
	
	/**
	 * 删除记录
	 */
	public function remove(){
		$this->admin_priv('wechat_prize_manage', ecjia::MSGTYPE_JSON);
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$delete = $this->db_prize->where(array('id' => $id))->delete();
		
		if ($delete) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('wechat::wechat.remove_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}	
	
	/**
	 * 发送消息通知用户
	 */
	public function send_message() {
		$this->admin_priv('wechat_custom_message_add', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.send_fail_platform'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$openid = !empty($_POST['openid']) ? $_POST['openid'] : '';
		$data['msg'] = !empty($_POST['message_content']) ? $_POST['message_content'] : '';
		$data['uid'] = !empty($_POST['uid']) ? intval($_POST['uid']) : 0;
		
		if (empty($openid)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.pls_select_user'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (empty($data['msg'])) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.content_require'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$data['send_time'] = RC_Time::gmtime();
		$data['iswechat'] = 1;
		
		// 微信端发送消息
		$msg = array(
			'touser' => $openid,
			'msgtype' => 'text',
			'text' => array(
				'content' => $data['msg']
			)
		);
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$rs = $wechat->sendCustomMessage($msg);
		if (RC_Error::is_error($rs)) {
			return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		// 添加数据
		$message_id = $this->custom_message_viewdb->join(null)->insert($data);
		
		ecjia_admin::admin_log($data['msg'], 'send', 'subscribe_message');
		if ($message_id) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.send_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_prize/init')));
		} else {
			return $this->showmessage(RC_Lang::get('wechat::wechat.send_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
	}

	/**
	 * 获取抽奖记录信息
	 */
	private function get_prize() {
		$db_prize = RC_Loader::load_app_model('wechat_prize_model');
		$db_wechat_user = RC_Loader::load_app_model('wechat_user_model');
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$where = array('wechat_id' => $wechat_id, 'prize_type' => 1);
		
		$activity_type = !empty($_GET['type']) ? trim($_GET['type']) : '';
		if ($activity_type) {
			$where['activity_type'] = $activity_type;
		}
		$count = $db_prize->where($where)->count ();
		$page = new ecjia_page($count, 10, 5);
		
		$data = $db_prize->where($where)->order('dateline DESC')->limit($page->limit())->select();
		
		$arr = array();
		if (isset($data)) {
			foreach($data as $row){
				$info = $db_wechat_user->find(array('wechat_id' => $wechat_id, 'openid' => $row['openid']));
				$row['winner']	 = unserialize($row['winner']);
				$row['nickname'] = $info['nickname'];
				$row['uid']		 = $info['uid'];
				$row['dateline'] = RC_Time::local_date(ecjia::config('time_format'), $row['dateline']-8*3600);
				$arr[] = $row;
			}
		}
		return array('prize_list' => $arr, 'page' => $page->show (5), 'desc' => $page->page_desc());
	}
}

//end