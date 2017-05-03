<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 结算管理
 */
class merchant extends ecjia_merchant {

	private $db_user;
	private $db_store_bill;
	private $db_store_bill_day;
	private $db_store_bill_detail;
	private $db_store_bill_paylog;
	public function __construct() {
		parent::__construct();

		$this->db_user				= RC_Model::model('user/users_model');
		$this->db_store_bill        = RC_Model::model('commission/store_bill_model');
		$this->db_store_bill_day    = RC_Model::model('commission/store_bill_day_model');
		$this->db_store_bill_detail = RC_Model::model('commission/store_bill_detail_model');
		$this->db_store_bill_paylog = RC_Model::model('commission/store_bill_paylog_model');
		
		/* 加载所全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('ecjia-region');
		RC_Script::enqueue_script('smoke');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
        /*自定义js*/
        RC_Script::enqueue_script('bill-init', RC_App::apps_url('statics/js/bill.js',__FILE__), array('ecjia-merchant'), false, 1);
        ecjia_merchant_screen::get_current_screen()->set_parentage('commission');
	}
	
	/**
	 * 结算账单列表
	 */
	public function init() {
		/* 检查权限 */
		$this->admin_priv('commission_manage');
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家结算'), RC_Uri::url('commission/merchant/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('结算账单')));
		
		$this->assign('ur_here', '结算账单');
		$this->assign('search_action', RC_Uri::url('commission/merchant/init'));
		
		/* 时间参数 */
		$filter['start_date'] = empty($_GET['start_date']) ? null : RC_Time::local_date('Y-m', RC_Time::local_strtotime($_GET['start_date']));
		$filter['end_date'] = empty($_GET['end_date']) ? null : RC_Time::local_date('Y-m', RC_Time::local_strtotime($_GET['end_date']));
		
		$bill_list = $this->db_store_bill->get_bill_list_merchant($_SESSION['store_id'], $_GET['page'], 15, $filter);
		
		foreach ($bill_list['item'] as &$val) {
		    if ($val['pay_status'] == 2) {
		        $val['pay_count'] = $this->db_store_bill_paylog->get_paylog_count($val['bill_id']);
		    }
		}
		$this->assign('bill_list', $bill_list);
		
		$this->display('bill_list.dwt');
	}
	
	public function detail() {
	    /* 检查权限 */
        $this->admin_priv('commission_detail');
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家结算'), RC_Uri::url('commission/merchant/init')));
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('账单详情')));
	    $this->assign('action_link', array('href' => RC_Uri::url('commission/merchant/init'), 'text' => '账单列表'));
	    
	    $bill_id = empty($_GET['id']) ? null : intval($_GET['id']);
	    if (empty($bill_id)) {
	        return $this->showmessage('参数异常', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    
	    $bill_info = $this->db_store_bill->get_bill($bill_id, $_SESSION['store_id']);
	    if (empty($bill_info)) {
	        return $this->showmessage('没有数据', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    }
	    $bill_info['pay_count'] = $this->db_store_bill_paylog->get_paylog_count($bill_info['bill_id']);
	    
	    $this->assign('ur_here', $bill_info['bill_month'].'账单详情');
	    $this->assign('bill_info', $bill_info);
	    
	    //明细
	    $filter['start_date'] = RC_Time::local_strtotime($bill_info['bill_month']);
	    $filter['end_date'] = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d', strtotime('+1 month', $filter['start_date']))) - 1;
	    
	    $record_list = $this->db_store_bill_detail->get_bill_record($_SESSION['store_id'], $_GET['page'], 30, $filter);
	    
	    $this->assign('lang_os', RC_Lang::get('orders::order.os'));
	    $this->assign('lang_ps', RC_Lang::get('orders::order.ps'));
	    $this->assign('lang_ss', RC_Lang::get('orders::order.ss'));
	    $this->assign('record_list', $record_list);
	    
	    $this->display('bill_detail.dwt');
	    //模板顶部表格，月账单情况
	    //底部详单列表，可翻页，30条一页
	}
	
	
	//订单分成
	public function record() {
	    /* 检查权限 */
	    $this->admin_priv('commission_order');
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家结算'), RC_Uri::url('commission/merchant/init')));
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('订单分成')));
	    
	    $this->assign('ur_here', '订单分成');
	    $this->assign('search_action', RC_Uri::url('commission/merchant/record'));
	    
	    /* 时间参数 */
	    $filter['start_date'] = empty($_GET['start_date']) ? null : RC_Time::local_strtotime($_GET['start_date']);
	    $filter['end_date'] = empty($_GET['end_date']) ? null : RC_Time::local_strtotime($_GET['end_date']) + 86399;
	    
	    $record_list = $this->db_store_bill_detail->get_bill_record($_SESSION['store_id'], $_GET['page'], 15, $filter);
	    $this->assign('lang_os', RC_Lang::get('orders::order.os'));
	    $this->assign('lang_ps', RC_Lang::get('orders::order.ps'));
	    $this->assign('lang_ss', RC_Lang::get('orders::order.ss'));
	    $this->assign('record_list', $record_list);
	    
	    $this->display('bill_record.dwt');
	}
	
	//结算统计
	public function count() {
	    /* 检查权限 */
	    $this->admin_priv('commission_count');
	    
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商家结算'), RC_Uri::url('commission/merchant/init')));
	    ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('结算统计')));
	     
	    $this->assign('ur_here', '结算统计');
	    $this->assign('search_action', RC_Uri::url('commission/merchant/count'));
	     
	    /* 时间参数 */
	    $filter['start_date'] = empty($_GET['start_date']) ? null : $_GET['start_date'];
	    $filter['end_date'] = empty($_GET['end_date']) ? null : $_GET['end_date'];
	    
	    $bill_day_list = $this->db_store_bill_day->get_billday_list($_SESSION['store_id'], $_GET['page'], 31, $filter);
	    $this->assign('bill_day_list', $bill_day_list);
	     
	    $this->display('bill_count.dwt');
	}
}

// end