<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 邮件订阅---模块的逻辑处理
 * @author songqian
 */
class admin_email_list extends ecjia_admin {
	private $db_email_list;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		$this->db_email_list = RC_Model::model('mail/email_list_model');
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('email_list', RC_App::apps_url('statics/js/email_list.js', __FILE__), array(), false, true);
	}

	public function init() {
		$this->admin_priv('email_list_manage');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mail::email_list.email_list')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('mail::email_list.overview'),
			'content'	=> '<p>' . RC_Lang::get('mail::email_list.email_list_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('mail::email_list.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:邮件订阅管理" target="_blank">'. RC_Lang::get('mail::email_list.about_email_list') .'</a>') . '</p>'
		);
		$this->assign('ur_here', RC_Lang::get('mail::email_list.email_list'));

		$emaildb = $this->get_email_list();
		$this->assign('emaildb', $emaildb);
		$this->assign('stat', RC_Lang::get('mail::email_list.stat'));
		
		$this->assign('form_action', RC_Uri::url('mail/admin_email_list/batch'));
		
		$this->display('email_list.dwt');
	}
	
	public function export() {
		$this->admin_priv('email_list_manage', ecjia::MSGTYPE_JSON);
		
		$emails = $this->db_email_list->email_list_select(1, 'email');

		$out = '';
		if (!empty($emails)) {
			foreach ($emails as $key => $val) {
				$out .= $val['email']."\r\n";
			}
		}

		$contentType = 'text/plain';
		$len = strlen($out);
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s',time()+31536000) .' GMT');
		header('Pragma: no-cache');
		header('Content-Encoding: none');
		header('Content-type: ' . $contentType);
		header('Content-Length: ' . $len);
		header('Content-Disposition: attachment; filename="email_list.txt"');
		echo $out;
		exit;
	}
	
	public function query() {
		$this->admin_priv('email_list_manage', ecjia::MSGTYPE_JSON);
		
		$emaildb = $this->get_email_list();

		$this->assign('emaildb', $emaildb['emaildb']);
		$this->assign('filter', $emaildb['filter']);
		$this->assign('record_count', $emaildb['record_count']);
		$this->assign('page_count', $emaildb['page_count']);
		
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $this->fetch('email_list.dwt.php'), 'filter' => $emaildb['filter'], 'page_count' => $emaildb['page_count']));
	}
	
	/**
	 * 批量操作
	 */
	public function batch() {
		$action = isset($_GET['sel_action']) ? trim($_GET['sel_action']) : ''; 
		
		if (empty($action)) {
			return $this->showmessage(RC_Lang::get('mail::email_list.select_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} elseif ($action == 'remove') {
			$this->admin_priv('email_list_delete', ecjia::MSGTYPE_JSON);
		} else {
			$this->admin_priv('email_list_update', ecjia::MSGTYPE_JSON);
		}
		$ids = !empty($_POST['checkboxes']) ? $_POST['checkboxes'] : '';
		$ids = explode(',', $ids);
		
		if (!empty($ids)){
			$info = $this->db_email_list->email_list_batch($ids, 'select');

			switch ($action) {
				case 'remove':
					$this->db_email_list->email_list_batch($ids, 'delete');

					foreach ($info as $key => $v) {
						ecjia_admin::admin_log(sprintf(RC_Lang::get('mail::email_list.email_address'), $v['email']).'，'.sprintf(RC_Lang::get('mail::email_list.email_id'), $v['id']), 'batch_remove', 'subscription_email');
					}
					
					return $this->showmessage(RC_Lang::get('mail::email_list.batch_remove_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mail/admin_email_list/init')));
					break;
	
				case 'exit' :
					$data = array('stat' => 2);
					$update = $this->db_email_list->email_list_batch($ids, 'update', $data);

					foreach ($info as $key => $v) {
						ecjia_admin::admin_log(sprintf(RC_Lang::get('mail::email_list.email_address'), $v['email']).'，'.sprintf(RC_Lang::get('mail::email_list.email_id'), $v['id']), 'batch_exit', 'subscription_email');
					}
					
					return $this->showmessage(RC_Lang::get('mail::email_list.batch_exit_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mail/admin_email_list/init')));
					break;
	
				case 'ok' :
					$data = array('stat' => 1);
					$update = $this->db_email_list->email_list_batch($ids, 'update', $data);

					foreach ($info as $key => $v) {
						ecjia_admin::admin_log(sprintf(RC_Lang::get('mail::email_list.email_address'), $v['email']).'，'.sprintf(RC_Lang::get('mail::email_list.email_id'), $v['id']), 'batch_ok', 'subscription_email');
					}
					
					return $this->showmessage(RC_Lang::get('mail::email_list.batch_unremove_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mail/admin_email_list/init')));
					break;
						
				default :
					break;
			}
		}
	}
	
	/**
	 * 获取邮件列表
	 * @return array
	 */
	private function get_email_list() {
		$db_email = RC_DB::table('email_list');
		
		$filter['sort_by']    = empty($_GET['sort_by']) ? 'id' : trim($_GET['sort_by']);
		$filter['sort_order'] = empty($_GET['sort_order']) ? 'desc' : trim($_GET['sort_order']);
		
		$count        = $db_email->count();
		$page         = new ecjia_page($count, 15, 5);
		$email_list   = $db_email->orderby($filter['sort_by'], $filter['sort_order'])->take(15)->skip($page->start_id-1)->get();
		
		return array('item' => $email_list, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
}

//end