<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 订单-卖家催单
 */
class mh_reminder extends ecjia_merchant {
	private $dbview_order_reminder;
	
	public function __construct() {
		parent::__construct();
		
		RC_Script::enqueue_script('smoke');
// 		RC_Script::enqueue_script('order_back', RC_Uri::home_url('content/apps/orders/statics/js/order_delivery.js'));
		RC_Script::enqueue_script('order_delivery', RC_App::apps_url('statics/js/merchant_order_delivery.js', __FILE__));
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		
		$this->dbview_order_reminder = RC_Model::Model('orders/order_reminder_viewmodel');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('订单管理'), RC_Uri::url('orders/merchant/init')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::order.reminder_list'), RC_Uri::url('orders/admin_order_remind/init')));
		ecjia_merchant_screen::get_current_screen()->set_parentage('order', 'order/mh_reminder.php');
	}
	
	/**
	 * 发货提醒列表
	 */
	public function init() {
		$this->admin_priv('delivery_view');

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::order.reminder_list')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('orders::order.overview'),
			'content'	=> '<p>' . RC_Lang::get('orders::order.order_reminder_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('orders::order.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:发货提醒列表" target="_blank">'. RC_Lang::get('orders::order.about_order_reminder') .'</a>') . '</p>'
		);
		
		/* 查询 */
		$db_order_reminder = RC_DB::table('order_reminder as r')
			->leftJoin('order_info as o', RC_DB::raw('o.order_id'), '=', RC_DB::raw('r.order_id'))
			->leftJoin('users as a', RC_DB::raw('o.user_id'), '=', RC_DB::raw('a.user_id'));
		
		isset($_SESSION['store_id']) ? $db_order_reminder->where(RC_DB::raw('r.store_id'), $_SESSION['store_id']) : '';
		
		$keywords = $_GET['keywords'];
		$keywords = empty($keywords) ? '' : trim($keywords);

		if (!empty($keywords)) {
		    $db_order_reminder->whereRaw('(o.order_sn like "%'.mysql_like_quote($keywords).'%" or o.consignee like "%'.mysql_like_quote($keywords).'%")');
		}
        
		$count = $db_order_reminder->count();
		$page = new ecjia_merchant_page($count, 10, 6);
		
		$result = $db_order_reminder->take(10)->skip($page->start_id-1)->get();
		$result_list = array('list' => $result, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'keywords' => $keywords);

		if (!empty($result_list['list'])) {
			foreach ($result_list['list'] as $key => $val) {
		 		$result_list['list'][$key]['order_status'] = $val[order_status] == 1 ? RC_Lang::get('orders::order.processed') : RC_Lang::get('orders::order.untreated');
	    		$result_list['list'][$key]['confirm_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['confirm_time']);
			}
		} 

		/* 模板赋值 */
		$this->assign('ur_here', RC_Lang::get('orders::order.reminder_list'));
		$this->assign('form_action', RC_Uri::url('orders/mh_reminder/remove&type=batch'));
		$this->assign('order_remind', $result_list['list']);
		$this->assign('result_list', $result_list);
		$this->display('remind_list.dwt');
	}
	

	/* 催货单删除 */
	public function remove() {
		/* 检查权限 */
		$this->admin_priv('order_os_edit', ecjia::MSGTYPE_JSON);
	 
		$order_id = !empty($_GET['order_id']) ? $_GET['order_id'] : $_POST['order_id'];
		$order_id = explode(',',$order_id);
	
		/* 记录日志 */
		RC_DB::table('order_reminder')->whereIn('order_id', $order_id)->delete();
		return $this->showmessage(RC_Lang::get('orders::order.tips_back_del'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('orders/mh_reminder/init')));
	}
}

// end