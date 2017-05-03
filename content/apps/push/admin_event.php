<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA消息事件
 */
class admin_event extends ecjia_admin {

	private $db_push_event;
	private $dbview_push_event;
	private $db_mail;
	private $db_mobile_manage;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
	
		$this->db_push_event = RC_Model::model('push/push_event_model');
		$this->dbview_push_event = RC_Model::model('push/push_event_viewmodel');
		$this->db_mail = RC_Model::model('push/mail_templates_model');
		$this->db_mobile_manage = RC_Model::model('mobile/mobile_manage_model');
		
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('bootstrap-placeholder');
		
		RC_Style::enqueue_style('push_event', RC_App::apps_url('statics/css/push_event.css', __FILE__), array(), false, false);
		RC_Script::enqueue_script('push_event', RC_App::apps_url('statics/js/push_event.js', __FILE__), array(), false, true);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.msg_event'), RC_Uri::url('push/admin_event/init')));
	}
					
	/**
	 * 消息事件列表页面
	 */
	public function init () {
		$this->admin_priv('push_event_manage');
		/* 加载分页类 */
		RC_Loader::load_sys_class('ecjia_page', false);
		
		$count = $this->db_push_event->group(array('event_code'))->count();
		$page = new ecjia_page ($count, 10, 5);
		
		$push_event = $this->dbview_push_event->field(array('pe.*', 'app_name', 'template_subject'))->join(array('mobile_manage', 'mail_templates'))->limit($page->limit())->group(array('event_code'))->select();
		
		if (!empty($push_event)) {
			foreach ($push_event as $key => $val) {
				$app_name = $this->dbview_push_event->join(array('mobile_manage'))->where(array('event_code' => $val['event_code']))->get_field('app_name', true);
				$push_event[$key]['appname'] = $app_name;
				$push_event[$key]['create_time'] = RC_Time::local_date(ecjia::config('date_format'), $val['create_time']);
			}
		}
		
		$this->assign('push_event', $push_event);
		$this->assign('push_event_page', $page->show(5));
		$this->assign('action_link', array('text' => RC_Lang::get('push::push.add_msg_event'), 'href' => RC_Uri::url('push/admin_event/add')));
		ecjia_screen::$current_screen->remove_last_nav_here();
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.msg_event')));
		$this->assign('ur_here', RC_Lang::get('push::push.msg_event'));
		
		$this->display('push_event_list.dwt');
	}
	
	/**
	 * 消息事件添加页面
	 */
	public function add() {
		$this->admin_priv('push_event_update');
		/* 获取推送模板*/
		$template_data = $this->db_mail->field('template_id, template_subject')->where(array('type' => 'push'))->select();
		
		/* 获取客户端应用*/
		$mobile_manage = $this->db_mobile_manage->where(array('status' => 1))->select();
		
		$this->assign('template_data', $template_data);
		$this->assign('mobile_manage', $mobile_manage);
		$this->assign('action_link', array('text' => RC_Lang::get('push::push.msg_event'), 'href' => RC_Uri::url('push/admin_event/init')));
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.add_msg_event')));
		$this->assign('ur_here', RC_Lang::get('push::push.add_msg_event'));
		
		$this->assign('insert_form_action', RC_Uri::url('push/admin_event/insert_code'));
		$this->display('push_event_info.dwt');
	}
	
	/**
	 * 消息事件添加执行
	 */
	public function insert_code() {
		$this->admin_priv('push_event_update', ecjia::MSGTYPE_JSON);
	
		$name = trim($_POST['name']);
		$code = trim($_POST['code']);
		
		$count = $this->db_push_event->where(array('event_code' => $code))->count();
		if ($count > 0) {
			return $this->showmessage(RC_Lang::get('push::push.push_event_code_exists'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$data = array(
			'event_name'	=> $name,
			'event_code'	=> $code,
			'create_time'	=> RC_Time::gmtime(),
		);
		$id = $this->db_push_event->insert($data);
	
		ecjia_admin::admin_log($data['event_name'], 'add', 'push_evnet');
	
		$links[] = array('text' => RC_Lang::get('push::push.msg_event'), 'href' => RC_Uri::url('push/admin_event/init'));
		return $this->showmessage(RC_Lang::get('push::push.add_push_event_code_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('push/admin_event/edit', 'code='.$code)));
		
	}
	
	/**
	 * 消息事件添加执行
	 */
	public function insert() {
		$this->admin_priv('push_event_update', ecjia::MSGTYPE_JSON);
		
		$name = trim($_POST['event_name']);
		$code = trim($_POST['event_code']);
		$app_id = intval($_POST['app_id']);
		$template_id = intval($_POST['template_id']);
		$status = isset($_POST['status']) ? $_POST['status'] : 0;
		
		if (empty($name) || empty($code)) {
			return $this->showmessage(RC_Lang::get('system::system.invalid_parameter'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$exists_event = $this->db_push_event->find(array('event_code' => $code, 'app_id' => $app_id));
		if ($exists_event) {
			return $this->showmessage(RC_Lang::get('push::push.msg_event_bind_app_exists'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$event_push = $this->db_push_event->find(array('event_code' => $code, 'app_id' => 0, 'template_id' => 0));
		
		if (!empty($event_push)) {
			$data = array(
				'event_name'	=> $name,
				'app_id'		=> $app_id,
				'template_id'	=> $template_id,
				'is_open'		=> $status,
			);
			$this->db_push_event->where(array('event_id' => $event_push['event_id']))->update($data);
		} else {
			$data = array(
				'event_name'	=> $name,
				'event_code'	=> $code,
				'app_id'		=> $app_id,
				'template_id'	=> $template_id,
				'is_open'		=> $status,
				'create_time'	=> RC_Time::gmtime(),
			);
			$this->db_push_event->insert($data);
		}
		$this->db_push_event->where(array('event_code' => $code))->update(array('event_name' => $name));
		
		ecjia_admin::admin_log($data['event_name'], 'add', 'push_evnet');
		$links[] = array('text' => RC_Lang::get('push::push.msg_event'), 'href' => RC_Uri::url('push/admin_event/init'));
		
		return $this->showmessage(RC_Lang::get('push::push.add_push_event_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('push/admin_event/edit', 'code='.$code)));
	}
	
	/**
	 * 消息事件编辑页面
	 */
	public function edit() {
		$this->admin_priv('push_event_update');
		$push_event = $this->db_push_event->find(array('event_code' => trim($_GET['code'])));

		$push_event_group = $this->dbview_push_event
    			->field(array('pe.*', 'app_name', 'template_subject'))
    			->join(array('mobile_manage', 'mail_templates'))
    			->where(array('type' => 'push', 'event_code' => $push_event['event_code']))
    			->select();
		/* 获取推送模板*/
		$template_data = $this->db_mail->field('template_id, template_subject')->where(array('type' => 'push'))->select();
		
		/* 获取客户端应用*/
		$mobile_manage = $this->db_mobile_manage->where(array('status' => 1))->select();
		
		$this->assign('push_event', $push_event);
		$this->assign('push_event_group', $push_event_group);
		$this->assign('template_data', $template_data);
		$this->assign('mobile_manage', $mobile_manage);
		$this->assign('action_link', array('text' => RC_Lang::get('push::push.msg_event'), 'href' => RC_Uri::url('push/admin_event/init')));
		ecjia_screen::$current_screen->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.edit_msg_event')));
		$this->assign('ur_here', RC_Lang::get('push::push.edit_msg_event'));
		
		$this->assign('update_form_action', RC_Uri::url('push/admin_event/update'));
		$this->assign('insert_form_action', RC_Uri::url('push/admin_event/insert'));
		$this->display('push_event_info.dwt');
	}
	
	/**
	 * 消息事件编辑执行
	 */
	public function update() {
		$this->admin_priv('push_event_update', ecjia::MSGTYPE_JSON);
		$id = intval($_POST['id']);
		$name = trim($_POST['event_name']);
		$app_id = intval($_POST['app_id']);
		$template_id = intval($_POST['template_id']);
		$status = isset($_POST['status']) ? $_POST['status'] : 0;
		$code	= trim($_POST['code']);
		
		if (empty($name)) {
			return $this->showmessage(RC_Lang::get('system::system.invalid_parameter'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$exists_event = $this->db_push_event->find(array('event_code' => $code, 'app_id' => $app_id, 'event_id' => array('neq' => $id)));
		if ($exists_event) {
			return $this->showmessage(RC_Lang::get('push::push.msg_event_bind_app_exists'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
			'event_name'	=> $name,
			'app_id'		=> $app_id,
			'template_id'	=> $template_id,
			'is_open'		=> $status,
			'create_time'	=> RC_Time::gmtime(),
		);
		$this->db_push_event->where(array('event_id' => $id))->update($data);
		$event_code = $this->db_push_event->where(array('event_id' => $id))->get_field('event_code');
		
		$this->db_push_event->where(array('event_code' => $event_code))->update(array('event_name' => $name));
		ecjia_admin::admin_log($data['event_name'], 'edit', 'push_evnet');
		
		return $this->showmessage(RC_Lang::get('push::push.edit_msg_event_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('push/admin_event/edit', 'code='.$event_code)));
	}
	
	/**
	 * 消息事件删除执行（按code删除）
	 */
	public function remove() {
		
		$this->admin_priv('push_event_delete', ecjia::MSGTYPE_JSON);
		
		$code = trim($_GET['code']);
		$name = $this->db_push_event->where(array('event_code' => $code))->get_field('event_name');
		$this->db_push_event->delete(array('event_code' => $code));
		
		ecjia_admin::admin_log($name, 'remove', 'push_evnet');
		return $this->showmessage(RC_Lang::get('push::push.remove_msg_event_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('push/admin_event/init')));
	}
	
	/**
	 * 消息事件删除执行（按id删除）
	 */
	public function delete() {
		$this->admin_priv('push_event_delete', ecjia::MSGTYPE_JSON);
	
		$id = intval($_GET['id']);
		$push_event = $this->db_push_event->where(array('event_id' => $id))->find();
		
		$this->db_push_event->delete(array('event_id' => $id));
		ecjia_admin::admin_log($push_event['event_name'], 'remove', 'push_evnet');
		$count = $this->db_push_event->where(array('event_code' => $push_event['event_code']))->count();
		if ($count > 0 ) {
			return $this->showmessage(RC_Lang::get('push::push.remove_msg_event_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('push/admin_event/edit', 'code='.$push_event['event_code'])));
		} else {
			return $this->showmessage(RC_Lang::get('push::push.remove_msg_event_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('push/admin_event/init')));
		}
	}
}

//end