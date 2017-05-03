<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 会员资金管理程序
*/
class admin_account_manage extends ecjia_admin {
	private $db_account_log;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('admin_user');
		RC_Loader::load_app_func('global', 'goods');
		
		$this->db_account_log	= RC_Model::model('user/account_log_model');
		
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');

		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('user_surplus', RC_App::apps_url('statics/js/user_surplus.js' , __FILE__));
		RC_Script::enqueue_script('jquery-peity');
		
		$surplus_jslang = array(
			'keywords_required'	=> RC_Lang::get('user::user_account_manage.keywords_required'),
			'check_time'		=> RC_Lang::get('user::user_account_manage.check_time'),
		);
		RC_Script::localize_script('user_surplus', 'surplus_jslang' , $surplus_jslang);
	}

	/**
	 * 资金管理
	 */
	public function init() {
		$this->admin_priv('account_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account_manage.user_account_manage')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=>
			'<p>' . RC_Lang::get('user::users.user_account_manage_help')  . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('user::users.more_info')  . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:资金管理" target="_blank">'.RC_Lang::get('user::users.about_user_account_manage').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('user::user_account_manage.user_account_manage'));
		
		/* 时间参数 */
		$start_date = $end_date = '';
		if (isset($_POST) && !empty($_POST)) {
			$start_date	= RC_Time::local_strtotime($_POST['start_date']);
			$end_date	= RC_Time::local_strtotime($_POST['end_date']);
			
		} elseif (isset($_GET['start_date']) && !empty($_GET['end_date'])) {
			$start_date	= RC_Time::local_strtotime($_GET['start_date']);
			$end_date	= RC_Time::local_strtotime($_GET['end_date']);
			
		} else {
			$today		= RC_Time::local_strtotime(RC_Time::local_date('Y-m-d'));
			$start_date	= $today - 86400 * 7;
			$end_date	= $today;
		}

		$account = $money_list = array();
		$account['voucher_amount'] = get_total_amount($start_date, $end_date);		//	充值总额
		$account['to_cash_amount'] = get_total_amount($start_date, $end_date, 1);	//	提现总额
		
		$db_account_log = RC_DB::table('account_log');
		$money_list = $db_account_log->select(RC_DB::raw('IFNULL(SUM(user_money), 0) AS user_money, IFNULL(SUM(frozen_money), 0) AS frozen_money'))
				->where('change_time', '>=', $start_date)
				->where('change_time', '<', $end_date + 86400)
				->first();

		$account['user_money']		= price_format($money_list['user_money']);	//	用户可用余额
		$account['frozen_money']	= price_format($money_list['frozen_money']);	//	用户冻结金额		
		
		$db_order_info = RC_DB::table('order_info');
		$money = $db_order_info->select(RC_DB::raw('IFNULL(SUM(surplus), 0) AS surplus, IFNULL(SUM(integral_money), 0) AS integral_money'))
				->where('add_time', '>=', $start_date)
				->where('add_time', '<', $end_date + 86400)
				->first();

		$account['surplus']			= price_format($money['surplus']);		//	交易使用余额
		$account['integral_money']	= price_format($money['integral_money']); //	积分使用余额

		/* 赋值到模板 */
		$this->assign('account',		$account);
		$this->assign('start_date',		RC_Time::local_date('Y-m-d', $start_date));
		$this->assign('end_date',		RC_Time::local_date('Y-m-d', $end_date));
		$this->assign('form_action',	RC_Uri::url('user/admin_account_manage/init'));
		
		$this->display('admin_account_manage.dwt');
	}
	
	/**
	 * 积分余额订单
	 */
	public function surplus() {
		$this->admin_priv('account_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account_manage.user_account_manage'), RC_Uri::url('user/admin_account_manage/init')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account_manage.integral_order')));
		
		$this->assign('ur_here', RC_Lang::get('user::user_account_manage.integral_order'));
		$this->assign('action_link', array('text' => RC_Lang::get('user::user_account_manage.user_account_manage'), 'href' => RC_Uri::url('user/admin_account_manage/init')));
		
		$order_list = get_user_order($_REQUEST);
		/* 赋值到模板 */
		$this->assign('order_list', $order_list);
		$this->assign('form_action', RC_Uri::url('user/admin_account_manage/surplus'));
		
		$this->display('user_surplus_list.dwt');
	}
}

// end 