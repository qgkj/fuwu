<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 支付方式管理
 */
class admin_payment_record extends ecjia_admin {
	
	private $db;	
	public function __construct() {
		parent::__construct();
		
		$this->db = RC_Model::model('payment/payment_model');
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');		
		
		/* 支付方式 列表页面 js/css */

		RC_Script::enqueue_script('payment_admin', RC_App::apps_url('statics/js/payment_admin.js',__FILE__),array(), false, true);
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));

		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');

		RC_Loader::load_app_class('payment_factory', null, false);
	}

	/**
	 * 支付方式列表
	 */
	public function init() {
	    $this->admin_priv('payment_manage');
	    
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here((RC_Lang::get('payment::payment.transaction_flow_record'))));
		
		$filter = array();
		$filter['order_sn']		= empty($_GET['order_sn'])		? ''		: trim($_GET['order_sn']);
		$filter['trade_no']		= empty($_GET['trade_no'])		? 0			: trim($_GET['trade_no']);
		$filter['pay_status']	= empty($_GET['pay_status'])	? ''		: $_GET['pay_status'];
		
		RC_Loader::load_app_func('global');
	    $db_payment_record = get_payment_record_list($filter);
	    
	    $this->assign('modules', $db_payment_record);
	    $this->assign('search_action', RC_Uri::url('payment/admin_payment_record/init'));
		$this->assign('ur_here', RC_Lang::get('payment::payment.transaction_flow_record'));
		
		$this->display('payment_record_list.dwt');
	}

	/**
	 * 禁用支付方式
	 */
	public function info() {
		$this->admin_priv('payment_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here((RC_Lang::get('payment::payment.transaction_flow_record')), RC_Uri::url('payment/admin_payment_record/init')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('payment::payment.view_flow_record')));
		RC_Loader::load_app_func('global');
		$id = $_REQUEST['id'];
		$order_sn = RC_DB::table('payment_record')->select('order_sn')->where('id', $id)->pluck();
		$order = order_info($order_sn);

		$db_payment_record = RC_DB::table('payment_record')->where('order_sn', $order_sn)->first();

		if ($db_payment_record['trade_type'] == 'buy') {
			$db_payment_record['trade_type'] = RC_Lang::get('payment::payment.buy');
			$this->assign('check_modules', $order);
		} elseif ($db_payment_record['trade_type'] == 'refund') {
			$db_payment_record['trade_type'] = RC_Lang::get('payment::payment.refund');
		} elseif ($db_payment_record['trade_type'] == 'deposit') {
			$db_payment_record['trade_type'] = RC_Lang::get('payment::payment.deposit');
		} elseif ($db_payment_record['trade_type'] == 'withdraw') {
			$db_payment_record['trade_type'] = RC_Lang::get('payment::payment.withdraw');
		}

		if ($db_payment_record['pay_status'] == 0) {
			$db_payment_record['pay_status'] = RC_Lang::get('payment::payment.wait_for_payment');;
		} elseif ($db_payment_record['pay_status'] == 1) {
			$db_payment_record['pay_status'] = RC_Lang::get('payment::payment.payment_success');;
		}

		$db_payment_record['create_time'] = RC_Time::local_date(ecjia::config('time_format'), $db_payment_record['create_time']);
		$db_payment_record['update_time'] = RC_Time::local_date(ecjia::config('time_format'), $db_payment_record['update_time']);
		$db_payment_record['pay_time']    = RC_Time::local_date(ecjia::config('time_format'), $db_payment_record['pay_time']);

		$this->assign('order', $order);
		$this->assign('ur_here', RC_Lang::get('payment::payment.view_flow_record'));
		$this->assign('action_link', array('text' => RC_Lang::get('payment::payment.transaction_flow_record'), 'href' => RC_Uri::url('payment/admin_payment_record/init')));
		$this->assign('modules', $db_payment_record);

		$this->display('payment_record_info.dwt');
	}
}

// end