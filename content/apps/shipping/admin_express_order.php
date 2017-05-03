<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 配送方式管理程序
 */
class admin_express_order extends ecjia_admin {

	public function __construct() {
		parent::__construct();
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('admin_express_order', RC_App::apps_url('statics/js/admin_express_order.js', __FILE__));
		RC_Script::enqueue_script('shipping', RC_App::apps_url('statics/js/shipping.js', __FILE__));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Script::enqueue_script('ecjia.utils');
		RC_Script::enqueue_script('ecjia.common');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shipping::shipping.express_order_list'), RC_Uri::url('shipping/admin_express_order/init')));
	}
	
	/**
	 * 配送列表
	 */
	public function init() {
		$this->admin_priv('admin_express_order_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shipping::shipping.express_order_list')));
		$this->assign('ur_here', RC_Lang::get('shipping::shipping.express_order_list'));
		
		$this->assign('search_action', RC_Uri::url('shipping/admin_express_order/init'));
		$express_list = $this->get_express_order_list();
		
		$this->assign('express_list', $express_list);
		
		$this->display('express_order_list.dwt');
	}
	

	public function info() {
		$this->admin_priv('admin_express_order_manage');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shipping::shipping.admin_express_info')));
	
		$express_id = isset($_GET['express_id']) ? intval($_GET['express_id']) : 0;
	
		$express_info = RC_DB::table('express_order as eo')
		->where(RC_DB::raw('express_id'), $express_id)
		->first();
	
		$express_info['formatted_add_time']		= RC_Time::local_date(ecjia::config('time_format'), $express_info['add_time']);
		$express_info['formatted_receive_time']	= $express_info['receive_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $express_info['receive_time']) : '';
		$express_info['formatted_express_time']	= $express_info['express_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $express_info['express_time']) : '';
		$express_info['formatted_signed_time']	= $express_info['signed_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $express_info['signed_time']) : '';
		$express_info['formatted_update_time']	= $express_info['update_time'] > 0 ? RC_Time::local_date(ecjia::config('time_format'), $express_info['update_time']) : '';
	
		if ($express_info['from'] == 'assign') {
			$express_info['label_from'] = RC_Lang::get('shipping::shipping.admin_assign');
		} elseif ($express_info['from'] == 'grab') {
			$express_info['label_from'] = RC_Lang::get('shipping::shipping.admin_grab');
		} elseif ($express_info['from'] == 'grab' && $express_info['staff_id'] == 0) {
			$express_info['label_from'] = RC_Lang::get('shipping::shipping.wait_assign');
		}
	
		switch ($express_info['status']) {
			case 0 :
				$express_info['label_status'] = RC_Lang::get('shipping::shipping.admin_wait_assign_express');
				break;
			case 1 :
				$express_info['label_status'] = RC_Lang::get('shipping::shipping.admin_wait_pick_up');
				break;
			case 2 :
				$express_info['label_status'] = RC_Lang::get('shipping::shipping.admin_express_delivery');
				break;
			case 3 :
				$express_info['label_status'] = RC_Lang::get('shipping::shipping.admin_return_express');
				break;
			case 4 :
				$express_info['label_status'] = RC_Lang::get('shipping::shipping.admin_refused');
				break;
			case 5 :
				$express_info['label_status'] = RC_Lang::get('shipping::shipping.admin_already_signed');
				break;
			case 6 :
				$express_info['label_status'] = RC_Lang::get('shipping::shipping.admin_has_returned');
				break;
		}
	
		/* 取得发货单商品 */
		$goods_list = RC_DB::table('delivery_goods')->where('delivery_id', $express_info['delivery_id'])->get();
	
		/* 取得区域名 */
		$region = RC_DB::table('express_order as eo')
		->leftJoin('region as c', RC_DB::raw('eo.country'), '=', RC_DB::raw('c.region_id'))
		->leftJoin('region as p', RC_DB::raw('eo.province'), '=', RC_DB::raw('p.region_id'))	
		->leftJoin('region as t', RC_DB::raw('eo.city'), '=', RC_DB::raw('t.region_id'))
		->leftJoin('region as d', RC_DB::raw('eo.district'), '=', RC_DB::raw('d.region_id'))
		->select(RC_DB::raw("concat(IFNULL(c.region_name, ''), '  ', IFNULL(p.region_name, ''),'  ', IFNULL(t.region_name, ''), '  ', IFNULL(d.region_name, '')) AS region"))
		->where(RC_DB::raw('eo.express_id'), $express_id)
		->first();
	
		$express_info['region'] = $region['region'];
	
		if ($express_info['staff_id'] > 0) {
			$express_info['staff_user'] = RC_DB::table('staff_user')->where('user_id', $express_info['staff_id'])->pluck('name');
		}
	
		$staff_list = RC_DB::table('staff_user')->get();
	
		$this->assign('staff_user', $staff_list);

		$this->assign('express_info', $express_info);
		$this->assign('goods_list', $goods_list);
	
		$this->assign('ur_here', RC_Lang::get('shipping::shipping.admin_express_info'));
		$this->assign('action_link',array('href' => RC_Uri::url('shipping/admin_express_order/init'),'text' => RC_Lang::get('shipping::shipping.express_order_list')));
	
		$this->display('express_info.dwt');
	}
	
	
	/**
	 * 获取配送列表
	 */
	private function get_express_order_list() {
		$filter['keywords']				= empty($_GET['keywords'])			? '' 	: trim($_GET['keywords']);
		$filter['merchant_keywords']	= empty($_GET['merchant_keywords'])	? '' 	: trim($_GET['merchant_keywords']);
		
		$db_view = RC_DB::table('express_order as eo')->leftJoin('store_franchisee as sf', RC_DB::raw('eo.store_id'), '=', RC_DB::raw('sf.store_id'));
		
		if (!empty($filter['keywords'])) {
			$db_view->where(RC_DB::raw('eo.express_sn'), 'like', '%' . $filter['keywords'] . '%')
					->orWhere(RC_DB::raw('eo.delivery_sn'), 'like', '%' . $filter['keywords'] . '%')
					->orWhere(RC_DB::raw('eo.order_sn'), 'like', '%' .$filter['keywords']. '%');
		}
		
		if (!empty($filter['merchant_keywords'])) {
			$db_view->where(RC_DB::raw('sf.merchants_name'), 'like', '%' .$filter['merchant_keywords']. '%');
		}
		
		$count = $db_view->count();
		$filter['limit']				= 15;
		$page = new ecjia_page($count, $filter['limit'], 5);
		$filter['skip']					= $page->start_id-1;
		
		$express_list = $db_view->orderBy('express_id', 'desc')->take($filter['limit'])->skip($filter['skip'])->get();
		
		if (!empty($express_list)) {
			foreach ($express_list as $key => $val) {
				$express_list[$key]['formatted_add_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['add_time']);
				if ($val['from'] == 'assign') {
					$express_list[$key]['label_from'] = RC_Lang::get('shipping::shipping.admin_assign');
				} elseif ($val['from'] == 'grab') {
					$express_list[$key]['label_from'] = RC_Lang::get('shipping::shipping.admin_grab');
				} else {
					$express_list[$key]['label_from'] = RC_Lang::get('shipping::shipping.admin_wait_assign');
				}		
				switch ($val['status']) {
					case 0 :
						$express_list[$key]['label_status'] = RC_Lang::get('shipping::shipping.admin_wait_assign_express');
						break;
					case 1 :
						$express_list[$key]['label_status'] = RC_Lang::get('shipping::shipping.admin_wait_pick_up');
						break;
					case 2 :
						$express_list[$key]['label_status'] = RC_Lang::get('shipping::shipping.admin_express_delivery');
						break;
					case 3 :
						$express_list[$key]['label_status'] = RC_Lang::get('shipping::shipping.admin_return_express');
						break;
					case 4 :
						$express_list[$key]['label_status'] = RC_Lang::get('shipping::shipping.admin_refused');
						break;
					case 5 :
						$express_list[$key]['label_status'] = RC_Lang::get('shipping::shipping.admin_already_signed');
						break;
					case 6 :
						$express_list[$key]['label_status'] = RC_Lang::get('shipping::shipping.admin_has_returned');
						break;
				}
			}
		}
		return array('list'=> $express_list, 'filter'	=> $filter, 'page'=> $page->show(2), 'desc'=> $page->page_desc());
	}
	
}	

// end