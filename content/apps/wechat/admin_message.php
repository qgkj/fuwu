<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA消息管理
 */
class admin_message extends ecjia_admin {
	private $db_platform_account;
	private $wu_viewdb;
	private $wechat_user_tag;
	private $wechat_user_group;
	private $wechat_tag;
	
	public function __construct() {
		parent::__construct();
		
		RC_Lang::load('wechat');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
		$this->wu_viewdb = RC_Loader::load_app_model('wechat_user_viewmodel');
		$this->wechat_user_tag = RC_Loader::load_app_model('wechat_user_tag_model');
		$this->wechat_user_group = RC_Loader::load_app_model('wechat_user_group_model');
		$this->wechat_tag = RC_Loader::load_app_model('wechat_tag_model');
		
		RC_Loader::load_app_class('platform_account', 'platform', false);
		RC_Loader::load_app_class('wechat_method', 'wechat', false);
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('bootstrap-responsive');
		RC_Script::enqueue_script('admin_subscribe', RC_App::apps_url('statics/js/admin_subscribe.js', __FILE__));
		RC_Style::enqueue_style('admin_subscribe', RC_App::apps_url('statics/css/admin_subscribe.css', __FILE__));
		
		RC_Script::localize_script('admin_subscribe', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.message_manage'), RC_Uri::url('wechat/admin_subscribe/init')));
	}

	public function init() {
		$this->admin_priv('wechat_subscribe_message_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.message_manage')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.message_manage'));

		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			$list = $this->get_message_list();
			$this->assign('list', $list);
			
			//获取公众号类型 0未认证 1订阅号 2服务号 3认证服务号 4企业号
			$types = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $types);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_certification_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$types)));
		}

		$this->assign_lang();
		$this->display('wechat_message_list.dwt');
	}
	
	//获取消息列表
	public function get_message_list() {
		$custom_message_viewdb = RC_Loader::load_app_model('wechat_custom_message_viewmodel');
		$db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
		$wechat_user_db = RC_Loader::load_app_model('wechat_user_model');

		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$where = 'wu.subscribe = 1 and m.iswechat = 0 and wu.wechat_id = '.$wechat_id;
		$filter['status'] = !empty($_GET['status']) ? intval($_GET['status']) : 1;
		
		$time_1 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')-4, date('Y'));
		$time_2 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')+1, date('Y'));
		$time_3 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$time_4 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')+1, date('Y'));
		$time_5 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')-1, date('Y'));
		$time_6 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$time_7 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')-2, date('Y'));
		$time_8 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')-1, date('Y'));
		$time_9 = RC_Time::local_mktime(0, 0, 0, date('m'), date('d')-4, date('Y'));

		$where1 = $where.' and m.send_time > '.$time_1.' and m.send_time < '.$time_2;
		$where2 = $where.' and m.send_time > '.$time_3.' and m.send_time < '.$time_4;
		$where3 = $where.' and m.send_time > '.$time_5.' and m.send_time < '.$time_6;
		$where4 = $where.' and m.send_time > '.$time_7.' and m.send_time < '.$time_8;
		$where5 = $where.' and m.send_time > 0'.' and m.send_time < '.$time_9;
		
		switch ($filter['status']) {
			case '1' :
				$start_date = $time_1;
				$end_date = $time_2;
				break;
			case '2' :
				$start_date = $time_3;
				$end_date = $time_4;
				break;
			case '3' :
				$start_date = $time_5;
				$end_date = $time_6;
				break;
			case '4' :
				$start_date = $time_7;
				$end_date = $time_8;
				break;
			case '5' :
				$start_date = 0;
				$end_date = $time_9;
				break;
		}
		$where .= ' and m.send_time > '.$start_date.' and m.send_time < '.$end_date;
		
		$filter['last_five_days'] 			= count($custom_message_viewdb->join('wechat_user')->field('max(m.id) as id')->where($where1)->group('m.uid')->select());
		$filter['today'] 					= count($custom_message_viewdb->join('wechat_user')->field('max(m.id) as id')->where($where2)->group('m.uid')->select());
		$filter['yesterday'] 				= count($custom_message_viewdb->join('wechat_user')->field('max(m.id) as id')->where($where3)->group('m.uid')->select());
		$filter['the_day_before_yesterday'] = count($custom_message_viewdb->join('wechat_user')->field('max(m.id) as id')->where($where4)->group('m.uid')->select());
		$filter['earlier'] 					= count($custom_message_viewdb->join('wechat_user')->field('max(m.id) as id')->where($where5)->group('m.uid')->select());
		
		$count = count($custom_message_viewdb->join('wechat_user')->field('max(m.id) as id')->where($where)->group('m.uid')->select());
		$page  = new ecjia_page($count, 10, 5);
		$list  = $custom_message_viewdb->join('wechat_user')->field('max(m.id) as id, wu.uid, wu.nickname, wu.headimgurl')->where($where)->group('m.uid')->limit($page->limit())->select();
		
		$row = array();
		if (!empty($list)) {
			foreach ($list as $key => $val) {
				$info = $custom_message_viewdb->join(null)->find(array('id' => $val['id']));
				$list[$key]['send_time']	= RC_Time::local_date(ecjia::config('time_format'), $info['send_time']);
				$list[$key]['msg'] 		 	= $info['msg'];
				$list[$key]['uid'] 		 	= $info['uid'];
			}
			$row = $this->array_sequence($list, 'send_time');
		}
		return array('item' => $row, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'filter' => $filter);
	}
	
	public function get_user_info() {
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$uid = !empty($_GET['uid']) ? intval($_GET['uid']) : 0;
		$info = $this->wu_viewdb->join(array('users'))->field('u.*, us.user_name')->find(array('u.uid' => $uid, 'u.wechat_id' => $wechat_id));
		if ($info['subscribe_time']) {
			$info['subscribe_time'] = RC_Time::local_date(ecjia::config('time_format'), $info['subscribe_time']-8*3600);
			$tag_list = $this->wechat_user_tag->where(array('userid' => $info['uid']))->get_field('tagid', true);
			$name_list = $this->wechat_tag->where(array('tag_id' => $tag_list, 'wechat_id' => $wechat_id))->order(array('tag_id' => 'desc'))->get_field('name', true);
			if (!empty($name_list)) {
				$info['tag_name'] = implode('，', $name_list);
			} else {
	 			$info['tag_name'] = RC_Lang::get('wechat::wechat.no_tag');
	 		}
		}

		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $info));
	}

	//排序
	public function array_sequence($array, $field, $sort = 'SORT_DESC') {
		$arrSort = array();
		foreach ($array as $uniqid => $row) {
			foreach ($row as $key => $value) {
				$arrSort[$key][$uniqid] = $value;
			}
		}
		array_multisort($arrSort[$field], constant($sort), $array);
		return $array;
	}
}

//end