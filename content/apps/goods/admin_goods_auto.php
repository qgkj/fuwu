<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 商品自动发布
 */
class admin_goods_auto extends ecjia_admin {
	private $db_auto_manage;
	private $db_goods;
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->db_auto_manage = RC_Loader::load_app_model('auto_manage_model', 'goods');
		$this->db_goods = RC_Loader::load_app_model('goods_model', 'goods');
		
		/*加载全局JS及CSS*/
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('goods_auto', RC_App::apps_url('statics/js/goods_auto.js', __FILE__));
	}

	public function init() {
		$this->admin_priv('goods_auto_manage');
		
		$this->assign('ur_here', RC_Lang::get('system::system.goods_auto'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::goods_auto.goods_auto')));
		$this->assign('search_action', RC_Uri::url('goods/admin_goods_auto/init'));
		
		$goodsdb = $this->get_auto_goods();
		$this->assign('goodsdb', $goodsdb);
		
		$crons_enable = RC_Api::api('cron', 'cron_info', array('cron_code' => 'cron_auto_manage'));
		$this->assign('crons_enable', $crons_enable['enable']);
		
		$this->display('goods_auto.dwt');
	}
	
	/**
	 * 批量上架
	 */
	public function batch_start() {
		$this->admin_priv('goods_auto_update', ecjia::MSGTYPE_JSON);
	
		$goods_id = !empty($_POST['goods_id']) ? $_POST['goods_id'] : '';
		$time = !empty($_POST['select_time']) ? RC_Time::local_strtotime($_POST['select_time']) : '';
		
		if (empty($goods_id)) {
			return $this->showmessage(RC_Lang::get('goods::goods_auto.select_start_goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		 
		if (empty($time)) {
			return $this->showmessage(RC_Lang::get('goods::goods_auto.select_time'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$goods_list = $this->db_auto_manage->where(array('type' => 'goods'))->get_field('item_id', true);
		$id_arr = explode(',', $goods_id);
		
		foreach ($id_arr as $k => $v) {
			$data = array(
				'item_id' 	=> $v,
				'type' 		=> 'goods',
				'starttime' => $time
			);
			
			if (!empty($goods_list)) {
				if (in_array($v, $goods_list)) {
					$this->db_auto_manage->where(array('item_id' => $v, 'type' => 'goods'))->update($data);
				} else {
					$this->db_auto_manage->insert($data);
				}
			} else {
				$this->db_auto_manage->insert($data);
			}
		}
		$goods_name_list = $this->db_goods->where(array('goods_id' => $id_arr))->get_field('goods_name', true);
		
		if (!empty($goods_name_list)) {
			foreach ($goods_name_list as $v) {
				ecjia_admin::admin_log(RC_Lang::get('goods::goods_auto.goods_name_is').$v, 'batch_start', 'goods');
			} 
		}
		return $this->showmessage(RC_Lang::get('goods::goods_auto.batch_start_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/admin_goods_auto/init')));
	}
	
	/**
	 * 批量下架
	 */
	public function batch_end() {
		$this->admin_priv('goods_auto_update', ecjia::MSGTYPE_JSON);
	
		$goods_id = !empty($_POST['goods_id']) ? $_POST['goods_id'] : '';
		$time = RC_Time::local_strtotime($_POST['select_time']);
		
		if (empty($goods_id)) {
			return $this->showmessage(RC_Lang::get('goods::goods_auto.select_end_goods'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		 
		if (empty($time)) {
			return $this->showmessage(RC_Lang::get('goods::goods_auto.select_time'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$goods_list = $this->db_auto_manage->where(array('type' => 'goods'))->get_field('item_id', true);
		 
		$id_arr = explode(',', $goods_id);
		foreach ($id_arr as $k => $v) {
			$data = array(
				'item_id' 	=> $v,
				'type' 		=> 'goods',
				'endtime' 	=> $time
			);
			if (!empty($goods_list)) {
				if (in_array($v, $goods_list)) {
					$this->db_auto_manage->where(array('item_id' => $v, 'type' => 'goods'))->update($data);
				} else {
					$this->db_auto_manage->insert($data);
				}
			} else {
				$this->db_auto_manage->insert($data);
			}
		}
		
		$goods_name_list = $this->db_goods->where(array('goods_id' => $id_arr))->get_field('goods_name', true);

		if (!empty($goods_name_list)) {
			foreach ($goods_name_list as $v) {
				ecjia_admin::admin_log(RC_Lang::get('goods::goods_auto.goods_name_is').$v, 'batch_end', 'goods');
			}
		}
		return $this->showmessage(RC_Lang::get('goods::goods_auto.batch_end_succeed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/admin_goods_auto/init')));
	}
	
	//撤销
	public function del() {
		$this->admin_priv('goods_auto_delete', ecjia::MSGTYPE_JSON);
		
		$goods_id = (int)$_GET['id'];
		$goods_name = $this->db_goods->where(array('goods_id' => $goods_id))->get_field('goods_name');
		$this->db_auto_manage->where(array('item_id' => $goods_id, 'type' => 'goods'))->delete();
		
		ecjia_admin::admin_log(RC_Lang::get('goods::goods_auto.goods_name_is').$goods_name, 'cancel', 'goods_auto');
		return $this->showmessage(RC_Lang::get('goods::goods_auto.delete_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	public function edit_starttime() {
		$this->admin_priv('goods_auto_update');
		
		$id		= !empty($_POST['pk']) 	? intval($_POST['pk']) : 0;
		$value 	= !empty($_POST['value']) ? trim($_POST['value']) : '';
		
		$val = '';
		if (!empty($value)) {
			$val = RC_Time::local_strtotime($value);
		}
		if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) || $value == '0000-00-00' || $val <= 0) {
			return $this->showmessage(RC_Lang::get('goods::goods_auto.time_format_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
		    'starttime' => $val
		);
		$this->db_auto_manage->where(array('item_id' => $id, 'type' => 'goods'))->update($data);
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/admin_goods_auto/init')));
	}
	
	public function edit_endtime() {
		$this->admin_priv('goods_auto_update', ecjia::MSGTYPE_JSON);
		
		$id		= !empty($_POST['pk']) 	? intval($_POST['pk']) : 0;
		$value 	= !empty($_POST['value']) ? trim($_POST['value']) : '';
		
		$val = '';
		if (!empty($value)) {
			$val = RC_Time::local_strtotime($value);
		}
		if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) || $value == '0000-00-00' || $val <= 0) {
			return $this->showmessage(RC_Lang::get('goods::goods_auto.time_format_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
		    'endtime' => $val
		);
		$this->db_auto_manage->where(array('item_id' => $id, 'type' => 'goods'))->update($data);
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/admin_goods_auto/init')));
	}
	
    private function get_auto_goods() {
    	$dbview = RC_Loader::load_app_model('goods_auto_viewmodel', 'goods');
    	$where = 'g.is_delete <> 1 ';
    	
    	if (!empty($_GET['keywords'])) {
    		$goods_name = trim($_GET['keywords']);
    		$where .= "AND g.goods_name LIKE '%$goods_name%'";
    		$filter['goods_name'] = $goods_name;
    	}
    
    	$filter['sort_by']      = empty($_REQUEST['sort_by']) 		? 'last_update' : trim($_REQUEST['sort_by']);
    	$filter['sort_order']   = empty($_REQUEST['sort_order'])	? 'DESC' 		: trim($_REQUEST['sort_order']);
    
    	$count = $dbview->where($where)->count();
    	$page = new ecjia_page($count, 15, 5);
    
    	$data = $dbview->where($where)->order(array('goods_id' => 'asc', $filter['sort_by'] => $filter['sort_order']))->limit($page->limit())->select();
    	$goodsdb = array();
    
    	if (!empty($data)) {
    		foreach ($data as $key => $rt) {
    			if (!empty($rt['starttime'])) {
    				$rt['starttime'] = RC_Time::local_date('Y-m-d', $rt['starttime']);
    			}
    			if (!empty($rt['endtime'])) {
    				$rt['endtime'] = RC_Time::local_date('Y-m-d', $rt['endtime']);
    			}
    			$goodsdb[] = $rt;
    		}
    	}
    	$arr = array('item' => $goodsdb, 'page' => $page->show(2), 'desc' => $page->page_desc());
    	return $arr;
    }
}
// end