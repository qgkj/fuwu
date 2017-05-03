<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA短信模板模块
 * @author songqian
 */
class admin_template extends ecjia_admin {
	private $db_mail;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->db_mail = RC_Model::model('sms/mail_templates_model');
	
		RC_Script::enqueue_script('tinymce');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('jquery-uniform');
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		RC_Script::enqueue_script('sms_template', RC_App::apps_url('statics/js/sms_template.js', __FILE__), array(), false, false);
		RC_Script::localize_script('sms_template', 'js_lang', RC_Lang::get('sms::sms.js_lang'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.sms_template'), RC_Uri::url('sms/admin_template/init')));
	}
	
	/**
	 * 短信模板
	 */
	public function init () {
		$this->admin_priv('sms_template_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.sms_template')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('sms::sms.overview'),
			'content'	=> '<p>' . RC_Lang::get('sms::sms.sms_template_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('sms::sms.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:短信模板" target="_blank">'. RC_Lang::get('sms::sms.about_sms_template') .'</a>') . '</p>'
		);
		$this->assign('ur_here', RC_Lang::get('sms::sms.sms_template_list'));
		$this->assign('action_link', array('href'=>RC_Uri::url('sms/admin_template/add'), 'text' => RC_Lang::get('sms::sms.add_sms_template')));

		$data = $this->db_mail->mail_templates_select(array('template_id', 'template_code', 'template_subject', 'template_content'), array('type' => 'sms'));

		$this->assign('templates', $data);

		$this->display('sms_template_list.dwt');
	}

	/**
	 * 添加模板页面
	 */
	public function add() {
		$this->admin_priv('sms_template_update');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.add_sms_template')));
		ecjia_screen::get_current_screen()->add_help_tab( array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('sms::sms.overview'),
			'content'	=> '<p>' . RC_Lang::get('sms::sms.add_template_help') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('sms::sms.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:短信模板#.E6.B7.BB.E5.8A.A0.E7.9F.AD.E4.BF.A1.E6.A8.A1.E6.9D.BF" target="_blank">'. RC_Lang::get('sms::sms.about_add_template') .'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('sms::sms.add_sms_template'));
		$this->assign('action_link', array('href'=>RC_Uri::url('sms/admin_template/init'), 'text' => RC_Lang::get('sms::sms.sms_template_list')));
		
		$this->assign('form_action', RC_Uri::url('sms/admin_template/insert'));
		$this->assign('action', 'insert');
		
		$this->display('sms_template_info.dwt');
	}
	
	
	/**
	 * 添加模板处理
	 */
	public function insert() {
		$this->admin_priv('sms_template_update', ecjia::MSGTYPE_JSON);
		
		$template_code = trim($_POST['template_code']);
		$subject       = trim($_POST['subject']);
		$content       = trim($_POST['content']);
		
		$titlecount = $this->db_mail->is_only(array('template_code' => $template_code, 'type' => 'sms'));

		if ($titlecount > 0) {
			return $this->showmessage(RC_Lang::get('sms::sms.template_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
			'template_code'    => $template_code,
			'template_subject' => $subject,
			'template_content' => $content,
			'last_modify'      => RC_Time::gmtime(),
			'type'             =>'sms'
		);
		
		$tid = $this->db_mail->mail_templates_manage($data);

		ecjia_admin::admin_log(sprintf(RC_Lang::get('sms::sms.template_code_is'), $template_code).'，'.sprintf(RC_Lang::get('sms::sms.template_subject_is'), $subject), 'add', 'sms_template');
		
		$links[] = array('text' => RC_Lang::get('sms::sms.return_template_list'), 'href'=> RC_Uri::url('sms/admin_template/init'));
		$links[] = array('text' => RC_Lang::get('sms::sms.continue_add_template'), 'href'=> RC_Uri::url('sms/admin_template/add'));
		return $this->showmessage(RC_Lang::get('sms::sms.add_template_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('sms/admin_template/edit', array('id' => $tid))));
	}
	
	/**
	 * 模版修改
	 */
	public function edit() {
		$this->admin_priv('sms_template_update');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.edit_sms_template')));
		ecjia_screen::get_current_screen()->add_help_tab( array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('sms::sms.overview'),
			'content'	=> '<p>' . RC_Lang::get('sms::sms.edit_template_help') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('sms::sms.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:短信模板#.E7.BC.96.E8.BE.91.E7.9F.AD.E4.BF.A1.E6.A8.A1.E6.9D.BF" target="_blank">'. RC_Lang::get('sms::sms.about_edit_template') .'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('sms::sms.edit_sms_template'));
		$this->assign('action_link', array('href' => RC_Uri::url('sms/admin_template/init'), 'text' => RC_Lang::get('sms::sms.sms_template_list')));
		
		$tid = intval($_GET['id']);
		$template = $this->db_mail->mail_templates_find(array('template_id' => $tid));

		$this->assign('template', $template);
		$this->assign('form_action', RC_Uri::url('sms/admin_template/update'));
		
		$this->display('sms_template_info.dwt');
	}
	
	/**
	 * 保存模板内容
	 */
	public function update() {
		$this->admin_priv('sms_template_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['id']);
		$template_code = trim($_POST['template_code']);
		$subject       = trim($_POST['subject']);
		$content       = trim($_POST['content']);
	
		$old_template_code = trim($_POST['old_template_code']);
		if ($template_code != $old_template_code) {
			$titlecount = $this->db_mail->is_only(array('template_code' => $template_code, 'type' => 'sms'));
			if ($titlecount > 0) {
				return $this->showmessage(RC_Lang::get('sms::sms.template_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		$data = array(
			'template_id' 		=> $id,
			'template_code'    	=> $template_code,
			'template_subject' 	=> $subject,
			'template_content' 	=> $content,
			'last_modify'      	=> RC_Time::gmtime(),
			'type'             	=>'sms'
		);
		
		$this->db_mail->mail_templates_manage($data);
		
		ecjia_admin::admin_log(sprintf(RC_Lang::get('sms::sms.template_code_is'), $template_code).'，'.sprintf(RC_Lang::get('sms::sms.template_subject_is'), $subject), 'edit', 'sms_template');
	  	return $this->showmessage(RC_Lang::get('sms::sms.edit_template_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 删除短信模板
	 */
	public function remove() {
		$this->admin_priv('sms_template_delete', ecjia::MSGTYPE_JSON);
	
		$id = intval($_GET['id']);
		$info = $this->db_mail->mail_templates_find(array('template_id' => $id));
		$this->db_mail->mail_templates_remove(array('template_id' => $id));

		ecjia_admin::admin_log(sprintf(RC_Lang::get('sms::sms.template_code_is'), $info['template_code']).'，'.sprintf(RC_Lang::get('sms::sms.template_subject_is'), $info['template_subject']), 'remove', 'sms_template');
		return $this->showmessage(RC_Lang::get('sms::sms.remove_template_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
}

//end