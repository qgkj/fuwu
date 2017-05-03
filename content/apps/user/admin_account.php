<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 会员充值提现管理
*/
class admin_account extends ecjia_admin {
	private $db_payment;
	private $db_user_account;
	private $db_users;
	private $db_pay_log;
	private $db_view;
	
	public function __construct() {
		parent::__construct();

		RC_Lang::load('user_account');
		RC_Loader::load_app_func('admin_user');
		RC_Loader::load_app_func('global', 'goods');
		RC_Loader::load_app_func('global');
		assign_adminlog();
		
		$this->db_payment		= RC_Model::model('payment/payment_model');
		$this->db_user_account	= RC_Model::model('user/user_account_model');
		$this->db_users			= RC_Model::model('user/users_model');
		$this->db_pay_log		= RC_Model::model('orders/pay_log_model');
		$this->db_view			= RC_Model::model('user/user_account_user_viewmodel');
		
		/* 加载所需js */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('admin_account', RC_App::apps_url('statics/js/admin_account.js', __FILE__));
		
		$account_jslang = array(
			'keywords_required'			=> RC_Lang::get('user::user_account.keywords_required'),
			'username_required'			=> RC_Lang::get('user::user_account.username_required'),
			'amount_required'			=> RC_Lang::get('user::user_account.amount_required'),
			'check_time'				=> RC_Lang::get('user::user_account.check_time'),
		);
		RC_Script::localize_script('admin_account', 'account_jslang', $account_jslang);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account.recharge_withdrawal_apply'), RC_Uri::url('user/admin_account/init')));
	}

	/**
	 * 充值提现申请列表
	 */
	public function init() {
		$this->admin_priv('surplus_manage');
		
		RC_Loader::load_app_func('global');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account.recharge_withdrawal_apply')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=> '<p>' . RC_Lang::get('user::users.user_account_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('user::users.more_info')  . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:充值和提现申请" target="_blank">'.RC_Lang::get('user::users.about_user_account').'</a>') . '</p>'
		);
		$this->assign('ur_here',		RC_Lang::get('user::user_account.recharge_withdrawal_apply'));
		$this->assign('action_link',	array('text' => RC_Lang::get('user::user_account.surplus_add'), 'href' => RC_Uri::url('user/admin_account/add')));
		
		$user_id = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		$payment = get_payment();
		$list = get_account_list($_REQUEST);

		$this->assign('id',				$user_id);
		$this->assign('payment',		$payment);
		$this->assign('list',			$list);
		
		$this->assign('form_action',	RC_Uri::url('user/admin_account/init'));
		$this->assign('batch_action',	RC_Uri::url('user/admin_account/batch_remove'));
		$this->display('admin_account_list.dwt');
	}
	
	/**
	 * 添加充值提现
	 */
	public function add() {
		$this->admin_priv('surplus_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account.surplus_add')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=> '<p>' .RC_Lang::get('user::users.add_account_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('user::users.more_info')  . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:充值和提现申请#.E6.B7.BB.E5.8A.A0.E7.94.B3.E8.AF.B7" target="_blank">'.RC_Lang::get('user::users.about_add_account').'</a>') . '</p>'
		);
		$this->assign('ur_here',		RC_Lang::get('user::user_account.surplus_add'));
		$this->assign('action_link',	array('href' => RC_Uri::url('user/admin_account/init'), 'text' => RC_Lang::get('user::user_account.recharge_withdrawal_apply')));
				
		/* 获得支付方式列表, 不包括“货到付款” */
		$payment = get_payment();
		
		$this->assign('payment',		$payment);
		$this->assign('form_action',	RC_Uri::url('user/admin_account/insert'));
		
		$this->display('admin_account_edit.dwt');
	}

	/**
	 * 添加充值提现申请
	 */
	public function insert() {
		/* 权限判断 */
		$this->admin_priv('surplus_manage', ecjia::MSGTYPE_JSON);
		
		/* 初始化变量 */
		$id				= isset($_POST['id'])				? intval($_POST['id'])				: 0;
		$is_paid		= !empty($_POST['is_paid'])			? intval($_POST['is_paid'])			: 0;
		$amount			= !empty($_POST['amount'])			? floatval($_POST['amount'])		: 0;
		$process_type	= !empty($_POST['process_type'])	? intval($_POST['process_type'])	: 0;
		$username		= !empty($_POST['username'])		? trim($_POST['username'])			: '';
		$admin_note		= !empty($_POST['admin_note'])		? trim($_POST['admin_note'])		: '';
		$user_note		= !empty($_POST['user_note'])		? trim($_POST['user_note'])			: '';
		$payment		= !empty($_POST['payment'])			? trim($_POST['payment'])			: '';
		$amount_count   = $amount;

		/* 验证参数有效性  */
		if (!is_numeric($amount) || empty($amount) || $amount <= 0 || strpos($amount, '.') > 0) {
			return $this->showmessage(RC_Lang::get('user::user_account.js_languages.deposit_amount_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$user_id = RC_DB::table('users')->where('user_name', $username)->pluck('user_id');
		/* 此会员是否存在 */
		if ($user_id == 0) {
			return $this->showmessage(RC_Lang::get('user::user_account.username_not_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (empty($payment)) {
			return $this->showmessage(RC_Lang::get('user::user_account.js_languages.pay_code_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 退款，检查余额是否足够 */
		if ($process_type == 1) {
			$user_account = get_user_surplus($user_id);
			/* 如果扣除的余额多于此会员拥有的余额，提示 */
			if ($amount > $user_account) {
				return $this->showmessage(RC_Lang::get('user::user_account.surplus_amount_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		/* 入库的操作 */
		if ($process_type == 1) {
			$amount = (-1) * $amount;
		}

		$data = array(
			'user_id'		=> $user_id,
			'admin_user'	=> $_SESSION['admin_name'],
			'amount'		=> $amount,
			'add_time'		=> RC_Time::gmtime(),
			'admin_note'	=> $admin_note,
			'user_note'		=> $user_note,
			'process_type'	=> $process_type,
			'payment'		=> $payment,
			'is_paid'		=> $is_paid,
		);
		if ($is_paid == 1) {
			$data['pay_time']		= RC_Time::gmtime();
		}
		
		RC_DB::table('user_account')->insert($data);
		
		/* 更新会员余额数量 */
		if ($is_paid == 1) {
			$change_desc = $amount > 0 ? RC_Lang::get('user::user_account.surplus_type.0') : RC_Lang::get('user::user_account.surplus_type.1');
			$change_type = $amount > 0 ? ACT_SAVING : ACT_DRAWING;
			change_account_log($user_id , $amount , 0 , 0 , 0 , $change_desc , $change_type);
		}
		
		/* 如果是预付款并且未确认，向pay_log插入一条记录 */
		if ($process_type == 0 && $is_paid == 0) {
			/* 取支付方式信息 */
			$payment_info = array();
			$payment_info = RC_DB::table('payment')->where('pay_name', $payment)->where('enabled', 1)->first();
			RC_Loader::load_app_func('admin_order', 'orders');
			/* 计算支付手续费用 */
			$pay_fee	  = pay_fee($payment_info['pay_id'], $amount, 0);
			$total_fee	  = $pay_fee + $amount;
		
			/* 插入 pay_log */
			$data = array(
				'order_id'		=> $id,
				'order_amount'	=> $total_fee,
				'order_type'	=> PAY_SURPLUS,
				'is_paid'		=> 0,
			);
			RC_DB::table('pay_log')->insert($data);
		}
		if ($process_type == 0) {
			$account = RC_Lang::get('user::user_account.deposit');
		} else {
			$account = RC_Lang::get('user::user_account.withdraw');
		}
		
		ecjia_admin::admin_log(RC_Lang::get('user::user_account.log_username').$username.','.$account.$amount, 'add', 'user_account');

		$links[0]['text'] = RC_Lang::get('user::user_account.back_list');
		$links[0]['href'] = RC_Uri::url('user/admin_account/init');
		$links[1]['text'] = RC_Lang::get('user::user_account.continue_add');
		$links[1]['href'] = RC_Uri::url('user/admin_account/add');
		
		return $this->showmessage(RC_Lang::get('user::user_account.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('user/admin_account/init')));
	}
	
	/**
	 * 编辑充值提现申请
	 */
	public function edit() {
		$this->admin_priv('surplus_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account.surplus_edit')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=> '<p>' . RC_Lang::get('user::users.edit_account_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('user::users.more_info')  . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:充值和提现申请#.E6.B7.BB.E5.8A.A0.E7.94.B3.E8.AF.B7" target="_blank">'.RC_Lang::get('user::users.about_edit_account').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('user::user_account.surplus_edit'));
		$this->assign('action_link', array('text' => RC_Lang::get('user::user_account.recharge_withdrawal_apply'), 'href' => RC_Uri::url('user/admin_account/init')));
		
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	
		/* 查询当前的预付款信息 */
		$account = array();
		$account = RC_DB::table('user_account')->where('id', $id)->first();
		
		$account['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $account['add_time']);
		$user_name = RC_DB::table('users')->where('user_id', $account['user_id'])->pluck('user_name');
		
		$account['user_note']	= htmlspecialchars($account['user_note']);
		$account['payment']		= strip_tags($account['payment']);
		$account['amount']		= abs($account['amount']);

		/* 模板赋值 */
		$this->assign('surplus', $account);
		$this->assign('user_name', $user_name);
		$this->assign('id', $id);
		
		$this->assign('form_action', RC_Uri::url('user/admin_account/update'));

		$this->display('admin_account_check.dwt');
	}
	
	/**
	 * 更新充值提现申请
	 */
	public function update() {
		/* 权限判断 */
		$this->admin_priv('surplus_manage', ecjia::MSGTYPE_JSON);
		
		$id				= isset($_POST['id'])			? intval($_POST['id'])			: 0;	
		$admin_note		= !empty($_POST['admin_note'])	? trim($_POST['admin_note'])	: '';
		$user_note		= !empty($_POST['user_note'])	? trim($_POST['user_note'])		: '';
		$user_name		= !empty($_POST['user_name'])	? trim($_POST['user_name'])		: '';
		/* 更新数据表 */
		$data = array(
			'admin_note'	=> $admin_note,
			'user_note'		=> $user_note
		);
		RC_DB::table('user_account')->where('id', $id)->update($data);
		
		$info = RC_DB::table('user_account')->where('id', $id)->first();
		
		if ($info['process_type'] == 0) {
			$account = RC_Lang::get('user::user_account.deposit');
		} else {
			$account = RC_Lang::get('user::user_account.withdraw');
			$info['amount'] = abs($info['amount']);
		}
		
		ecjia_admin::admin_log(RC_Lang::get('user::user_account.log_username').$user_name.','.$account.$info['amount'], 'edit', 'user_account');
		$links[0]['text'] = RC_Lang::get('user::user_account.back_list');
		$links[0]['href'] = RC_Uri::url('user/admin_account/init');
		return $this->showmessage(RC_Lang::get('user::user_account.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links));
	}
	
	/**
	 * 审核会员余额页面
	 */
	public function check() {
		$this->admin_priv('surplus_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_account.check')));
		$this->assign('ur_here', RC_Lang::get('user::user_account.check'));
		$this->assign('action_link', array('text' => RC_Lang::get('system::system.09_user_account'), 'href' => RC_Uri::url('user/admin_account/init')));
				
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

		/* 查询当前的预付款信息 */
		$account = array();
		$account = RC_DB::table('user_account')->where('id', $id)->first();
		
		$account['add_time']    = RC_Time::local_date(ecjia::config('time_format'), $account['add_time']);
		$account['user_note']	= htmlspecialchars($account['user_note']);
		
		$user_name    = RC_DB::table('users')->where('user_id', $account['user_id'])->pluck('user_name');
		$payment_name = RC_DB::table('payment')->where('pay_code', $account['payment'])->pluck('pay_name');
		
		$account['payment']	= empty($payment_name) ? strip_tags($account['payment']) : strip_tags($payment_name);
		$account['amount']	= abs($account['amount']);
		
		$this->assign('surplus',		$account);
		$this->assign('user_name',		$user_name);
		$this->assign('id',				$id);
		$this->assign('check_action',	RC_Uri::url('user/admin_account/action'));
		$this->assign('is_check',		1);

		$this->display('admin_account_check.dwt');
	}
	
	/**
	 * 更新会员余额的状态
	 */
	public function action() {
		/* 检查权限 */
		$this->admin_priv('surplus_manage', ecjia::MSGTYPE_JSON);
		
		/* 初始化 */
		$id			= isset($_POST['id'])			? intval($_POST['id'])			: 0;
		$is_paid	= isset($_POST['is_paid'])		? intval($_POST['is_paid'])		: 0;
		$admin_note	= isset($_POST['admin_note'])	? trim($_POST['admin_note'])	: '';

		/* 查询当前的预付款信息 */
		$account	= array();
		$account	= RC_DB::table('user_account')->where('id', $id)->first();
		$amount		= $account['amount'];
		
		/* 如果是退款申请, 并且已完成,更新此条记录,扣除相应的余额 */
		if ($is_paid == '1') {
			if ($account['process_type'] == '1') {
				$user_account = get_user_surplus($account['user_id']);
				$fmt_amount   = str_replace('-', '', $amount);
				
				/* 如果扣除的余额多于此会员拥有的余额，提示 */
				if ($fmt_amount > $user_account) {
					return $this->showmessage(RC_Lang::get('user::user_account.surplus_amount_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				
				update_user_account($id, $amount, $admin_note, 1);
				
				/* 更新会员余额数量 */
				change_account_log($account['user_id'], $amount, 0, 0, 0, RC_Lang::get('user::user_account.surplus_type.1'), ACT_DRAWING);
			} else {
				/* 如果是预付款，并且已完成, 更新此条记录，增加相应的余额 */
				update_user_account($id, $amount, $admin_note, 1);
				
				/* 更新会员余额数量 */
				change_account_log($account['user_id'], $amount, 0, 0, 0, RC_Lang::get('user::user_account.surplus_type.0'), ACT_SAVING);
			}
		} else {
			/* 否则更新信息 */
			$data = array(
				'admin_user'	=> $_SESSION['admin_name'],
				'admin_note'	=> $admin_note,
				'is_paid'		=> $is_paid,
			);
			RC_DB::table('user_account')->where('id', $id)->update($data);
		}
		
		ecjia_admin::admin_log('(' . addslashes(RC_Lang::get('user::user_account.check')) . ')' . $admin_note, 'check', 'user_surplus');
		
		$links[0]['text'] = RC_Lang::get('user::user_account.back_list');
		$links[0]['href'] = RC_Uri::url('user/admin_account/init');
		return $this->showmessage(RC_Lang::get('user::user_account.attradd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links));
	}
	
	/**
	 * ajax删除一条信息
	 */
	public function remove() {
		$db_view    = RC_Model::model('user_account_viewmodel', ecjia::MSGTYPE_JSON);
		/* 检查权限 */
		$this->admin_priv('surplus_manage', ecjia::MSGTYPE_JSON);
		
		$id 		= intval($_REQUEST['id']);
		$user_name 	= empty($data['user_name']) ? RC_Lang::get('user::users.no_name') : $data['user_name'];
		
		RC_DB::table('user_account')->where('id', $id)->delete();
		ecjia_admin::admin_log(addslashes($user_name), 'remove', 'user_account');
		return $this->showmessage(RC_Lang::get('user::user_account.drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 批量删除
	 */
	public function batch_remove() {
		/* 检查权限 */
		$this->admin_priv('surplus_manage', ecjia::MSGTYPE_JSON);
		
		if (!empty($_SESSION['ru_id'])) {
			return $this->showmessage(RC_Lang::get('user::user_account.merchants_notice'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (isset($_POST['checkboxes'])) {
			$idArr = explode(',', $_POST['checkboxes']);
			$count = count($idArr);
			$data = RC_DB::table('user_account AS ua')
			->leftJoin('users as u', RC_DB::raw('ua.user_id'), '=', RC_DB::raw('u.user_id'))
			->select(RC_DB::raw('ua.*, u.user_name'))
			->whereIn(RC_DB::raw('ua.id'), $idArr)
			->get();
			
			if (RC_DB::table('user_account')->whereIn('id', $idArr)->delete()) {
				foreach ($data as $v) {
					if ($v['process_type'] == 1) {
						$amount = (-1) * $v['amount'];
						ecjia_admin::admin_log(sprintf(RC_Lang::get('user::user_account.user_name_is'), $v['user_name']).sprintf(RC_Lang::get('user::user_account.money_is'), price_format($amount)), 'batch_remove', 'withdraw_apply');
					} else {
						ecjia_admin::admin_log(sprintf(RC_Lang::get('user::user_account.user_name_is'), $v['user_name']).sprintf(RC_Lang::get('user::user_account.money_is'), price_format($v['amount'])), 'batch_remove', 'pay_apply');
					}
				}
				return $this->showmessage(sprintf(RC_Lang::get('user::user_account.delete_record_count'), $count), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/admin_account/init')));
			}
		} else {
			return $this->showmessage(RC_Lang::get('user::user_account.select_operate_item'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
}

// end