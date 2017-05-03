<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA短信模块
 * @author songqian
 */
class admin extends ecjia_admin {
	private $db_mail;
	private $db_sms_sendlist;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->db_mail 			= RC_Model::model('sms/mail_templates_model');
		$this->db_sms_sendlist 	= RC_Model::model('sms/sms_sendlist_model');
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('sms', RC_App::apps_url('statics/js/sms.js', __FILE__), array(), false, true);
		RC_Script::localize_script('sms', 'js_lang', RC_Lang::get('sms::sms.js_lang'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.sms_record_list'), RC_Uri::url('sms/admin/init')));
	}
					
	/**
	 * 发送短信页面
	 */
	public function display_send_ui() {
	    $this->admin_priv('sms_send_manage');
	    
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.send_sms')));
	    $this->assign('action_link', array('text' => RC_Lang::get('sms::sms.sms_record_list'), 'href'=> RC_Uri::url('sms/admin/init')));
		$this->assign('ur_here', RC_Lang::get('sms::sms.send_sms'));

		$special_ranks = RC_Model::Model('sms/sms_user_rank_model')->get_rank_list();
		$send_rank['1_0'] = RC_Lang::get('sms::sms.user_list');
		
		foreach ($special_ranks as $rank_key => $rank_value) {
			$send_rank['2_' . $rank_key] = $rank_value;
		}
		$this->assign('send_rank', $send_rank);
		$this->assign('form_action', RC_Uri::url('sms/admin/send_sms'));
		
		$this->display('sms_send.dwt');
	}
			
	/**
	 * 发送短信处理
	 */
	public function send_sms() {	
		$send_num = isset($_POST['send_num']) ? $_POST['send_num'] : '';
		
		if (isset($send_num)) {
			$phone = $send_num.',';
		}
		$send_rank = isset($_POST['send_rank']) ? $_POST['send_rank'] : 0;
		
		if ($send_rank != 0) {
			$rank_array = explode('_', $send_rank);
			if ($rank_array['0'] == 1) {
				$data = RC_DB::table('users')->where('mobile_phone', '!=', '')->select('mobile_phone')->get();
				
				if (!empty($data)) {
					foreach ($data as $rank_rs) {
						$value[] = $rank_rs['mobile_phone'];
					}
				}
			} else {
				$rank_row = RC_DB::table('user_rank')->where('rank_id', $rank_array['1'])->first();
				
				foreach ($data as $rank_rs) {
					$value[] = $rank_rs['mobile_phone'];
				}
			}
			if (isset($value)) {
				$phone .= implode(',', $value);
			}
		}
		$msg       = isset($_POST['msg'])       ? $_POST['msg']         : '';
		$send_date = isset($_POST['send_date']) ? $_POST['send_date']   : '';
		$link[]    = array('text' => RC_Lang::get('system::system.back') .  RC_Lang::get('sms::sms.sms_record'), 'href' => 'index.php?m=admincp&c=admin&a=display_send_ui');
	}
		
	/**
	 * 显示发送记录的
	 */
	public function init() {
		$this->admin_priv('sms_history_manage');
	
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.sms_record')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('sms::sms.overview'),
			'content'	=> '<p>' . RC_Lang::get('sms::sms.sms_history_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('sms::sms.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:短信记录" target="_blank">'. RC_Lang::get('sms::sms.about_sms_history') .'</a>') . '</p>'
		);
		
		$this->assign('action_link', array('text' => RC_Lang::get('sms::sms.add_sms_send'), 'href'=> RC_Uri::url('sms/admin/display_send_ui')));
		$this->assign('ur_here', RC_Lang::get('sms::sms.sms_record_list'));
		
		$listdb = $this->db_sms_sendlist->get_sendlist();

		$this->assign('listdb', $listdb);
		$this->assign('search_action', RC_Uri::url('sms/admin/init'));
	
		$this->display('sms_send_history.dwt');
	}
	
	/**
	 * 再次发送短信
	 */
	public function resend() {
		$this->admin_priv('sms_history_manage', ecjia::MSGTYPE_JSON);
		
		$resendclass  = RC_Loader::load_app_class('sms_send', 'sms');
		$smsid        = intval($_GET['id']);
		$result       = $resendclass->resend($smsid);

		$info         = $this->db_sms_sendlist->sms_sendlist_find($smsid);

		ecjia_admin::admin_log(sprintf(RC_Lang::get('sms::sms.receive_number_is'), $info['mobile']), 'setup', 'sms_record');
		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('sms/admin/init')));
		}
		
		return $this->showmessage(RC_Lang::get('sms::sms.send_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('sms/admin/init')));
	}
	
	/**
	 * 批量再次发送短信记录
	 */
	public function batch_resend() {
		$this->admin_priv('sms_history_manage', ecjia::MSGTYPE_JSON);
		
		$batchresendclass = RC_Loader::load_app_class('sms_send', 'sms');
		$smsids           = explode(",", $_POST['sms_id']);

		$info             = $this->db_sms_sendlist->sms_sendlist_select(array('id' => $smsids), true);

		if (!empty($info)) {
			foreach ($info as $v) {
				ecjia_admin::admin_log(sprintf(RC_Lang::get('sms::sms.receive_number_is'), $v['mobile']), 'batch_setup', 'sms_record');
			}	
		}
		$batchresendclass->batch_resend($smsids);
		return $this->showmessage(RC_Lang::get('sms::sms.batch_send_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('sms/admin/init')));
	}
}

//end