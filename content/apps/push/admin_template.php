<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA消息模板模块
 */
class admin_template extends ecjia_admin {
	private $db_mail;
	
	public function __construct() {
		parent::__construct();
		
		$this->db_mail = RC_Model::model('push/mail_templates_model');
	
		RC_Script::enqueue_script('tinymce');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('jquery-uniform');
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		RC_Script::enqueue_script('push_template', RC_App::apps_url('statics/js/push_template.js', __FILE__), array(), false, false);
		
		RC_Script::localize_script('push_template', 'js_lang', RC_Lang::get('push::push.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.msg_template'), RC_Uri::url('push/admin_template/init')));
	}

	/**
	 * 消息模板
	 */
	public function init () {
		$this->admin_priv('push_template_manage');
		
		$this->assign('ur_here', RC_Lang::get('push::push.msg_template'));
		$this->assign('action_link', array('href' => RC_Uri::url('push/admin_template/add'), 'text' => RC_Lang::get('push::push.add_msg_template')));
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.msg_template')));

        $data = RC_DB::table('mail_templates')->where('type', 'push')->select('template_id', 'template_code', 'template_subject', 'template_content')->get();

		$this->assign('templates', $data);

		$this->display('push_template_list.dwt');
	}
	
	/**
	 * 添加模板页面
	 */
	public function add() {
		$this->admin_priv('push_template_update');
	
		$this->assign('ur_here', RC_Lang::get('push::push.add_msg_template'));
		$this->assign('action_link', array('href' => RC_Uri::url('push/admin_template/init'), 'text' => RC_Lang::get('push::push.msg_template_list')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.add_msg_template')));
		
		$this->assign('form_action', RC_Uri::url('push/admin_template/insert'));
		$this->assign('action', 'insert');
		
		$this->display('push_template_info.dwt');
	}
	
	/**
	 * 添加模板处理
	 */
	public function insert() {
		$this->admin_priv('push_template_update', ecjia::MSGTYPE_JSON);
		
		$template_code = trim($_POST['template_code']);
		$subject       = trim($_POST['subject']);
		$content       = trim($_POST['content']);

        $titlecount = RC_DB::table('mail_templates')->where('template_code', $template_code)->where('type', 'push')->count();
		if($titlecount > 0) {
			return $this->showmessage(RC_Lang::get('push::push.template_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
			'template_code'    => $template_code,
			'template_subject' => $subject,
			'template_content' => $content,
			'last_modify'      => RC_Time::gmtime(),
			'type'             => 'push'
		);
		
		$tid = $this->db_mail->template_manage($data);
		
		$links[] = array('text' => RC_Lang::get('push::push.back_template_list'), 'href' => RC_Uri::url('push/admin_template/init'));
		$links[] = array('text' => RC_Lang::get('push::push.continue_add_template'), 'href' => RC_Uri::url('push/admin_template/add'));
		return $this->showmessage(RC_Lang::get('push::push.add_template_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('push/admin_template/edit', array('id' => $tid))));
	}
	
	/**
	 * 模版修改
	 */
	public function edit() {
		$this->admin_priv('push_template_update');

		$this->assign('ur_here', RC_Lang::get('push::push.edit_msg_template'));
		$this->assign('action_link', array('href' => RC_Uri::url('push/admin_template/init'), 'text' => RC_Lang::get('push::push.msg_template_list')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.edit_msg_template')));
		
		$tid = intval($_GET['id']);
        $template = RC_DB::table('mail_templates')->where('template_id', $tid)->first();
		
		$this->assign('template', $template);
		$this->assign('form_action', RC_Uri::url('push/admin_template/update'));
		
		$this->display('push_template_info.dwt');
	}
	
	/**
	 * 保存模板内容
	 */
	public function update() {
		$this->admin_priv('push_template_update', ecjia::MSGTYPE_JSON);
		
		$id				= intval($_POST['id']);
		$template_code 	= trim($_POST['template_code']);
		$subject       	= trim($_POST['subject']);
		$content       	= trim($_POST['content']);
	
		$old_template_code = trim($_POST['old_template_code']);
		if ($template_code != $old_template_code) {
            $titlecount = RC_DB::table('mail_templates')->where('template_code', $template_code)->where('type', 'push')->count();
			if ($titlecount > 0) {
				return $this->showmessage(RC_Lang::get('push::push.template_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		$data = array(
			'template_id' 	   => $id,
			'template_code'    => $template_code,
			'template_subject' => $subject,
			'template_content' => $content,
			'last_modify'      => RC_Time::gmtime(),
			'type'             => 'push'
		);
		
		$this->db_mail->template_manage($data);
	  	return $this->showmessage(RC_Lang::get('push::push.update_template_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);

	}
	
	/**
	 * 删除消息模板
	 */
	public function remove() {
		$this->admin_priv('push_template_delete', ecjia::MSGTYPE_JSON);
	
		$id = intval($_GET['id']);
        RC_DB::table('mail_templates')->where('template_id', $id)->delete();
        return $this->showmessage(RC_Lang::get('push::push.remove_template_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
}

//end