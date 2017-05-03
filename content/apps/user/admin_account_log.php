<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 会员帐户变动记录
 */
class admin_account_log extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('admin_user');
		RC_Loader::load_app_func('global');
		assign_adminlog();
		
		/* 加载所需js */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('user_info', RC_App::apps_url('statics/js/user_info.js', __FILE__));
		RC_Script::enqueue_script('jquery-peity');
		
		$account_log_jslang = array(
			'change_desc_required' => RC_Lang::get('user::account_log.js_languages.no_change_desc')
		);
		RC_Script::localize_script('user_info', 'account_log_jslang', $account_log_jslang );
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::users.user_list'), RC_Uri::url('user/admin/init')));
	}
	
	/**
	 * 账户明细列表
	 */
	public function init() {
		$this->admin_priv('account_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::account_log.account_change_desc')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=> '<p>' . RC_Lang::get('user::users.user_account_log_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('user::users.more_info')  . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员列表#.E6.9F.A5.E7.9C.8B.E8.B4.A6.E7.9B.AE.E6.98.8E.E7.BB.86" target="_blank">'.RC_Lang::get('user::users.about_user_account_log').'</a>') . '</p>'
		);
		
		/* 检查参数 */
		$user_id = empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']);
		$user = get_user_info($user_id);
		
		$this->assign('ur_here', RC_Lang::get('user::account_log.account_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('user::account_log.add_account'), 'href' => RC_Uri::url('user/admin_account_log/edit', array('user_id' => $user_id))));
		
		if (empty($_REQUEST['account_type']) || !in_array($_REQUEST['account_type'], array('user_money', 'frozen_money', 'rank_points', 'pay_points'))) {
			$account_type = '';
		} else {
			$account_type = $_REQUEST['account_type'];
		}
		$account_list = get_account_log_list($user_id, $account_type);
		
		$this->assign('user',			$user);
		$this->assign('account_type',	$account_type);
		$this->assign('account_list',	$account_list);
		$this->assign('form_action',	RC_Uri::url('user/admin_account_log/init', array('user_id' => $user_id)));

		$this->display('account_log_list.dwt');
	}
	
	/**
	 * 调节帐户
	 */
	public function edit() {
		$this->admin_priv('account_manage');
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=> '<p>' . RC_Lang::get('user::users.add_account_log_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('user::users.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员列表#.E6.9F.A5.E7.9C.8B.E8.B4.A6.E7.9B.AE.E6.98.8E.E7.BB.86" target="_blank">'.RC_Lang::get('user::users.about_add_account_log').'</a>') . '</p>'
		);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::account_log.account_change_desc'), RC_Uri::url('user/admin_account_log/init', 'user_id='.$user_id)));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::account_log.add_account')));
		
		$user_id = empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']);
		$user = get_user_info($user_id);

		/* 显示模板 */
		$this->assign('user',			$user);
		$this->assign('ur_here',		RC_Lang::get('user::account_log.add_account'));
		$this->assign('action_link',	array('href' => RC_Uri::url('user/admin_account_log/init', array('user_id' => $user_id)), 'text' => RC_Lang::get('user::account_log.account_list')));
		$this->assign('form_action',	RC_Uri::url('user/admin_account_log/update', array('user_id' => $user_id)));
		
		$this->display('account_log_edit.dwt');
	}
	
	/**
	 * 调节会员账户
	 */
	public function update() {
		$this->admin_priv('account_manage', ecjia::MSGTYPE_JSON);

		$user_id = empty($_REQUEST['user_id']) ? 0 : intval($_REQUEST['user_id']);
		$user    = get_user_info($user_id);
		
		if (empty($user)) {			
			return $this->showmessage(RC_Lang::get('user::account_log.user_not_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$user_money		= !empty($_POST['user_money']) ? intval($_POST['user_money']): 0;
		$frozen_money	= $_POST['frozen_money'] ? intval($_POST['frozen_money']): 0;
		$rank_points	= $_POST['rank_points'] ? intval($_POST['rank_points']): 0;
		$pay_points		= $_POST['pay_points'] ? intval($_POST['pay_points']): 0;

		/* 参数验证 */
		if ($user_money < 0 || !is_numeric($user_money) || !isset($user_money)) {
			return $this->showmessage(RC_Lang::get('user::account_log.user_money_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if ($frozen_money < 0 || !is_numeric($frozen_money) || !isset($frozen_money)) {
			return $this->showmessage(RC_Lang::get('user::account_log.frozen_money_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if ($rank_points < 0 || !is_numeric($rank_points) || !isset($rank_points)) {
			return $this->showmessage(RC_Lang::get('user::account_log.rank_points_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if ($pay_points < 0 || !is_numeric($pay_points) || !isset($pay_points)) {
			return $this->showmessage(RC_Lang::get('user::account_log.pay_points_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if ($user_money == 0 && $frozen_money == 0 && $rank_points == 0 && $pay_points == 0) {
			return $this->showmessage(RC_Lang::get('user::account_log.null_msg'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$change_desc	= RC_String::sub_str($_POST['change_desc'], 255, false);
		$user_money		= floatval($_POST['add_sub_user_money']) * abs(floatval($user_money));
		$frozen_money	= floatval($_POST['add_sub_frozen_money']) * abs(floatval($frozen_money));
		$rank_points	= floatval($_POST['add_sub_rank_points']) * abs(floatval($rank_points));
		$pay_points		= floatval($_POST['add_sub_pay_points']) * abs(floatval($pay_points));
		
		if ($_POST['add_sub_user_money'] == 1) {
			$usermoney = '+';
		} else {
			$usermoney = '-';
		}
	
		if ($_POST['add_sub_frozen_money'] == 1) {
			$frozenmoney = '+';
		} else {
			$frozenmoney = '-';
		}

		if ($_POST['add_sub_rank_points'] == 1) {
			$rankpoints = '+';
		} else {
			$rankpoints = '-';
		}
	
		if ($_POST['add_sub_pay_points'] == 1) {
			$paypoints = '+';
		} else {
			$paypoints = '-';
		}
		
		/* 保存 */
		change_account_log($user_id, $user_money, $frozen_money, $rank_points, $pay_points, $change_desc, ACT_ADJUSTING);
		
		ecjia_admin::admin_log($user['user_name'].'，'.RC_Lang::get('user::account_log.usermoney').$usermoney.$user_money.
			RC_Lang::get('user::account_log.frozenmoney').$frozenmoney.$frozen_money.
			RC_Lang::get('user::account_log.rankpoints').$rankpoints.$rank_points.
			RC_Lang::get('user::account_log.paypoints').$paypoints.$pay_points.'，'.
			RC_Lang::get('user::account_log.change_desc').$change_desc, 'edit', 'usermoney');
		
		$links[] = array('href' => RC_Uri::url('user/admin_account_log/init', array('user_id' => $user_id)), 'text' => RC_Lang::get('user::account_log.account_list'));
		return $this->showmessage(RC_Lang::get('user::account_log.log_account_change_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/admin_account_log/edit', array('user_id' => $user_id)), 'links' => $links));
	}
}

// end