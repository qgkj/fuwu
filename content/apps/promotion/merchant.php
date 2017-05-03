<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 促销管理程序
 */
class merchant extends ecjia_merchant {
	public function __construct() {
        parent::__construct();
        
        RC_Loader::load_app_func('global');
        assign_adminlog_content();
        
        RC_Script::enqueue_script('jquery-validate');
        RC_Script::enqueue_script('jquery-form');
        RC_Script::enqueue_script('smoke');
      
        RC_Style::enqueue_style('uniform-aristo');
        
      	/*时间控件*/
        RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
		RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
        
        RC_Script::enqueue_script('promotion', RC_App::apps_url('statics/js/promotion_merchant.js', __FILE__), array(), false, true);
        
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('促销管理'), RC_Uri::url('promotion/merchant/init')));
        ecjia_merchant_screen::get_current_screen()->set_parentage('promotion', 'promotion/merchant.php');
    }
    	
	/**
	 * 促销商品列表页
	 */
	public function init() {
		$this->admin_priv('promotion_manage');
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('promotion::promotion.promotion')));
		
		$this->assign('ur_here', RC_Lang::get('promotion::promotion.promotion_list'));
		$this->assign('action_link', array('href' => RC_Uri::url('promotion/merchant/add'), 'text' => RC_Lang::get('promotion::promotion.add_promotion')));
		
		$type = isset($_GET['type']) && in_array($_GET['type'], array('on_sale', 'coming', 'finished', 'merchant')) ? trim($_GET['type']) : '';
		$promotion_list = $this->promotion_list($type);
		$time = RC_Time::gmtime();

		$this->assign('promotion_list', $promotion_list);
		$this->assign('type_count', $promotion_list['count']);
		$this->assign('filter', $promotion_list['filter']);
		
		$this->assign('type', $type);
		$this->assign('time', $time);
		$this->assign('form_search', RC_Uri::url('promotion/merchant/init'));
		
		$this->display('promotion_list.dwt');
	}

	/**
	 * 添加促销商品
	 */
	public function add() {
		$this->admin_priv('promotion_update');
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('promotion::promotion.add_promotion')));
		$this->assign('ur_here', RC_Lang::get('promotion::promotion.add_promotion'));
		$this->assign('action_link', array('href' => RC_Uri::url('promotion/merchant/init'), 'text' => RC_Lang::get('promotion::promotion.promotion_list')));
		$date = array();
		$date['sdate'] = RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime());
		$date['edate'] = RC_Time::local_date(ecjia::config('time_format'), RC_Time::local_strtotime("+1 months", RC_Time::local_strtotime($date['sdate']) + 28800));
		$this->assign('date', $date);
		$this->assign('form_action', RC_Uri::url('promotion/merchant/insert'));	
		$this->display('promotion_info.dwt');
	}
	
	/**
	 * 处理添加促销商品
	 */
	public function insert() {
		$this->admin_priv('promotion_update', ecjia::MSGTYPE_JSON);
		
		$goods_id 	= intval($_POST['goods_id']);
		$price		= $_POST['price'];
		
		if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			RC_DB::table('goods')->where(RC_DB::raw('store_id'), $_SESSION['store_id']);
		}
		
		$time = RC_Time::gmtime();
		$info = RC_DB::table('goods')
			->where('is_promote', 1)
			->where('goods_id', $goods_id)
			->where('promote_start_date', '<=', $time)
			->where('promote_end_date', '>=', $time)
			->first();
		
		if (!empty($info)) {
			return $this->showmessage(RC_Lang::get('promotion::promotion.promotion_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$goods_name = RC_DB::table('goods')->where('goods_id', $goods_id)->pluck('goods_name');
		
		$start_time = RC_Time::local_strtotime($_POST['start_time']);
		$end_time 	= RC_Time::local_strtotime($_POST['end_time']);
		
		if ($start_time >= $end_time) {
			return $this->showmessage(RC_Lang::get('promotion::promotion.promotion_invalid'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		RC_DB::table('goods')->where('goods_id', $goods_id)->update(array('is_promote' => 1, 'promote_price' => $price, 'promote_start_date' => $start_time, 'promote_end_date' => $end_time));
		
		/* 释放app缓存*/
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		
		ecjia_merchant::admin_log($goods_name, 'add', 'promotion');
		$links[] = array('text' => RC_Lang::get('promotion::promotion.return_promotion_list'), 'href'=> RC_Uri::url('promotion/merchant/init'));
		$links[] = array('text' => RC_Lang::get('promotion::promotion.continue_add_promotion'), 'href'=> RC_Uri::url('promotion/merchant/add'));
		return $this->showmessage(RC_Lang::get('promotion::promotion.add_promotion_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('promotion/merchant/edit', array('id' => $goods_id))));
	}
	
	/**
	 * 编辑促销商品
	 */
	public function edit() {	
		$this->admin_priv('promotion_update');
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('promotion::promotion.edit_promotion')));
		
		$this->assign('ur_here', RC_Lang::get('promotion::promotion.edit_promotion'));
		$this->assign('action_link', array('href' => RC_Uri::url('promotion/merchant/init'), 'text' => RC_Lang::get('promotion::promotion.promotion_list')));
		
		$id = intval($_GET['id']);
		$db = RC_DB::table('goods');
		$db->where(RC_DB::raw('goods_id'), $id);
		if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			$db->where(RC_DB::raw('store_id'), $_SESSION['store_id']);
		}
		$promotion_info = $db
		->select('goods_id', 'goods_name', 'promote_price', 'promote_start_date', 'promote_end_date')
		->first();
		
		$promotion_info['promote_start_date'] 	= RC_Time::local_date('Y-m-d H:i:s', $promotion_info['promote_start_date']);
		$promotion_info['promote_end_date'] 	= RC_Time::local_date('Y-m-d H:i:s', $promotion_info['promote_end_date'] );
		$date = array();
		$date['sdate'] = RC_Time::local_date(ecjia::config('time_format'), RC_Time::gmtime());
		$date['edate'] = RC_Time::local_date(ecjia::config('time_format'), RC_Time::local_strtotime("+1 months", RC_Time::local_strtotime($date['sdate'])  + 28800));
		$this->assign('date', $date);
		$this->assign('promotion_info', $promotion_info);
		$this->assign('form_action', RC_Uri::url('promotion/merchant/update'));

		$this->display('promotion_info.dwt');
	}
	
	/**
	 * 更新促销商品
	 */
	public function update() {
		$this->admin_priv('promotion_update', ecjia::MSGTYPE_JSON);
		
		$goods_id		= intval($_POST['goods_id']);
		$price	  	  	= $_POST['price'];
		$goods_name 	= RC_DB::table('goods')->where('goods_id', $goods_id)->pluck('goods_name');
		
		$start_time 	= RC_Time::local_strtotime($_POST['start_time']);
		$end_time 		= RC_Time::local_strtotime($_POST['end_time']);
		$old_goods_id   = intval($_POST['old_goods_id']);

		$db = RC_DB::table('goods');
		if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			$db->where('store_id', $_SESSION['store_id']);
		}
		if ($start_time >= $end_time) {
			return $this->showmessage(RC_Lang::get('promotion::promotion.promotion_invalid'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$db->where('goods_id', $goods_id)->update(array('is_promote' => 1, 'promote_price' => $price, 'promote_start_date' => $start_time, 'promote_end_date' => $end_time));
		
		//更新原来的商品为非促销商品
		if ($goods_id != $old_goods_id) {
			RC_DB::table('goods')->where('goods_id', $old_goods_id)->update(array('is_promote' => 0, 'promote_price' => 0, 'promote_start_date' => 0, 'promote_end_date' => 0));
		}
		
		/* 释放app缓存*/
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		
		ecjia_merchant::admin_log($goods_name, 'edit', 'promotion');
		return $this->showmessage(RC_Lang::get('promotion::promotion.edit_promotion_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('promotion/merchant/edit', array('id' => $goods_id))));
	}
	
	/**
	 * 删除促销商品
	 */
	public function remove() {
		$this->admin_priv('promotion_delete', ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		$db = RC_DB::table('goods');
		if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			$db->where(RC_DB::raw('store_id'), $_SESSION['store_id']);
		}
		$goods_name = $db->where('goods_id', $id)->pluck('goods_name');
		
		//更新商品为非促销商品
		$db->where('goods_id', $id)->update(array('is_promote' => 0, 'promote_price' => 0, 'promote_start_date' => 0, 'promote_end_date' => 0));
		
		/* 释放app缓存*/
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		
		ecjia_merchant::admin_log($goods_name, 'remove', 'promotion');
		return $this->showmessage(RC_Lang::get('promotion::promotion.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 添加/编辑页搜索商品
	 */
	public function search_goods() {
		$goods_list = array();
		$row = RC_Api::api('goods', 'get_goods_list', array('keyword' => $_POST['keyword'], 'store_id' => $_SESSION['store_id']));
		if (!is_ecjia_error($row)) {
			if (!empty($row)) {
				foreach ($row AS $key => $val) {
					$goods_list[] = array(
						'value' => $val['goods_id'],
						'text'  => $val['goods_name'],
						'data'  => $val['shop_price']
					);
				}
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $goods_list));
	}
	
	
	/**
	 * 获取活动列表
	 *
	 * @access  public
	 *
	 * @return void
	 */
	private function promotion_list($type = '') {
		$filter['keywords'] 			= empty($_GET['keywords']) 	? '' : stripslashes(trim($_GET['keywords']));
		
		$db_goods = RC_DB::table('goods as g');
		
		$db_goods->where('is_promote', '1')->where('is_delete', '!=', 1);
		if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			$db_goods->where(RC_DB::raw('store_id'), $_SESSION['store_id']);
		}
		
		if (!empty($filter['keywords'])) {
			$db_goods->where('goods_name', 'like', '%'.mysql_like_quote($filter['keywords']).'%');
		}
		
		$time = RC_Time::gmtime();
		$type_count = $db_goods->select(RC_DB::raw('count(*) as count'),
				RC_DB::raw('SUM(IF(promote_start_date <'.$time.' and promote_end_date > '.$time.', 1, 0)) as on_sale'),
				RC_DB::raw('SUM(IF(promote_start_date >'.$time.', 1, 0)) as coming'),
				RC_DB::raw('SUM(IF(promote_end_date <'.$time.', 1, 0)) as finished'))->first();
		
		if ($type == 'on_sale') {
			$db_goods->where('promote_start_date', '<=', $time)->where('promote_end_date', '>=', $time);
		}
		
		if ($type == 'coming') {
			$db_goods->where('promote_start_date', '>=', $time);
		}
		
		if ($type == 'finished') {
			$db_goods->where('promote_end_date', '<=', $time);
		}

		if ($type == 'merchant') {
			$db_goods->where(RC_DB::raw('g.store_id'), '>', 0);
		}
		
		$count = $db_goods->count();
		$page = new ecjia_merchant_page($count, 10, 5);
		
		$result = $db_goods
			->select('goods_id', 'goods_name', 'promote_price', 'promote_start_date', 'promote_end_date', 'goods_thumb')->take(10)->skip($page->start_id-1)->get();
		
		if (!empty($result)) {
			foreach ($result as $key => $val) {
				$result[$key]['start_time'] = RC_Time::local_date('Y-m-d H:i:s', $val['promote_start_date']);
				$result[$key]['end_time']   = RC_Time::local_date('Y-m-d H:i:s', $val['promote_end_date']);
				if (!file_exists(RC_Upload::upload_path() . $val['goods_thumb']) || empty($val['goods_thumb'])) {
					$result[$key]['goods_thumb'] = RC_Uri::admin_url('statics/images/nopic.png');
				} else {
					$result[$key]['goods_thumb'] = RC_Upload::upload_url() . '/' . $val['goods_thumb'];
				}
			}
		}
		return array('item' => $result, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'count' => $type_count);
	}
}

// end