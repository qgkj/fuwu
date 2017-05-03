<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 管理中心模版管理程序
 * @author songqian
 */
class admin extends ecjia_admin {
	private $db_mail;
	
	public function __construct() {
		parent::__construct();
		
		$this->db_mail = RC_Model::model('mail/mail_templates_model');
		
		RC_Lang::load('mail_template');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		RC_Script::enqueue_script('mail_template', RC_App::apps_url('statics/js/mail_template.js', __FILE__), array(), false, false);
		
		RC_Script::localize_script('mail_template', 'js_lang', RC_Lang::get('mail::mail_template.js_lang'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mail::mail_template.mail_template'), RC_Uri::url('mail/admin/init')));
	}
	
	/**
	 * 模版列表
	 */
	public function init() {
		$this->admin_priv('mail_template_manage');

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mail::mail_template.mail_template')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('mail::mail_template.overview'),
			'content'	=> '<p>' . RC_Lang::get('mail::mail_template.template_list_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('mail::mail_template.overview') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:邮件模板" target="_blank">'. RC_Lang::get('mail::mail_template.about_template_list') .'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('mail::mail_template.mail_template'));
		
		$cur = null;
		$data = $this->db_mail->mail_templates_select('template', array('template_id', 'template_code'));

		$data or $data = array();
		foreach ($data as $key => $row) {
			//todo 语言包方法待确认
			$data[$key]['template_name'] = RC_Lang::lang($row['template_code']);
		}
		$this->assign('templates', $data);
		
		$this->assign_lang();
		$this->display('mail_template_list.dwt');
	}

	/**
	 * 模版修改
	 */
	public function edit() {
		$this->admin_priv('mail_template_update');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mail::mail_template.mail_edit')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('mail::mail_template.overview'),
			'content'	=> '<p>' . RC_Lang::get('mail::mail_template.edit_template_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('mail::mail_template.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:邮件模板" target="_blank">'.RC_Lang::get('mail::mail_template.about_edit_template').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('mail::mail_template.mail_edit'));
		$this->assign('action_link', array('href'=>RC_Uri::url('mail/admin/init'), 'text' => RC_Lang::get('system::system.mail_template_manage')));
		
		$tpl 		= safe_replace($_GET['tpl']);
		$mail_type 	= isset($_GET['mail_type']) ? $_GET['mail_type'] : -1;
		$content 	= $this->db_mail->load_template($tpl);
		
		if ($content === NULL || empty($tpl)) {
			return $this->showmessage(RC_Lang::get('mail::mail_template.template_not_exist'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => RC_Lang::get('system::system.back'), 'href' => 'javascript:window.history.back(-1);'))));
		}
		//todo 语言包方法待确认
		$content['template_name'] = RC_Lang::lang($tpl) . " [$tpl]";
		$content['template_code'] = $tpl;
		
		if (($mail_type == -1 && $content['is_html'] == 1) || $mail_type == 1) {
			$content['is_html'] = 1;
		} elseif ($mail_type == 0) {
			$content['is_html'] = 0;
		}
		if (!empty($content['template_content'])) {
			$content['template_content'] = stripslashes($content['template_content']);
		}
		$this->assign('tpl', $tpl);
		$this->assign('template', $content);
		
		$this->assign_lang();
		$this->display('mail_template_info.dwt');
	}
	
	/**
	 * 保存模板内容
	 */
	public function save_template() {
		$this->admin_priv('mail_template_update', ecjia::MSGTYPE_JSON);
		
		if (empty($_POST['subject'])) {
			return $this->showmessage(RC_Lang::get('mail::mail_template.subject_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$subject = trim($_POST['subject']);
		}
		
		if (empty($_POST['content'])) {
			return $this->showmessage(RC_Lang::get('mail::mail_template.content_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$content = trim($_POST['content']);
		}
		
		$type   	= intval($_POST['mail_type']);
		$tpl_code 	= safe_replace($_POST['tpl']);

		$data = array(
			'template_subject' => str_replace('\\\'\\\'', '\\\'', $subject),
			'template_content' => str_replace('\\\'\\\'', '\\\'', $content),
			'is_html'          => $type,
			'last_modify'      => RC_Time::gmtime()
		);

	    if ($this->db_mail->mail_templates_update($tpl_code, $data)) {
			//todo 语言包方法待确认
			ecjia_admin::admin_log(RC_Lang::lang($tpl_code), 'edit', 'email_template');
			return $this->showmessage(RC_Lang::get('mail::mail_template.update_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('mail::mail_template.update_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 载入指定模版
	 */
	public function loat_template() {
		$this->admin_priv('mail_template_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mail::mail_template.mail_edit')));
		
		$tpl       = safe_replace($_GET['tpl']);
		$mail_type = isset($_GET['mail_type']) ? $_GET['mail_type'] : -1;
	
		$content   = $this->db_mail->load_template($tpl);

		//todo 语言包方法待确认
		$content['template_name'] = RC_Lang::lang($tpl) . " [$tpl]";
		$content['template_code'] = $tpl;
	
		if (($mail_type == -1 && $content['is_html'] == 1) || $mail_type == 1) {
			$content['is_html'] = 1;
		} elseif ($mail_type == 0) {
			$content['is_html'] = 0;
		}
		
		$this->assign('ur_here', RC_Lang::get('system::system.mail_template_manage'));
		$this->assign('tpl', $tpl);
		$this->assign('action_link', array('href'=> RC_Uri::url('mail/admin/init'), 'text' => RC_Lang::get('system::system.mail_template_manage')));
		$this->assign('template', $content);

		$this->assign_lang();
		$this->display('mail_template_info.dwt');
	}
}

// end