<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商品销售排行
*/
class mh_sale_order extends ecjia_merchant {
	private $db_order_goods_view;
	public function __construct() {
		parent::__construct();
		
		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		/*自定义js*/
		RC_Script::enqueue_script('sale_order',RC_App::apps_url('statics/js/merchant_sale_order.js',__FILE__), array('ecjia-merchant'), false, 1);
		
		RC_Lang::load('statistic');
		RC_Loader::load_app_func('global','orders');
		$this->db_order_goods_view = RC_Loader::load_app_model('order_goods_viewmodel','orders');
		
		ecjia_merchant_screen::get_current_screen()->set_parentage('stats');
	}
	
	public function init() {
		/* 权限检查 */ 
		$this->admin_priv('sale_order_stats');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('报表统计', RC_Uri::url('stats/mh_keywords_stats/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('销售排行')));
		
		/* 赋值到模板 */
		$this->assign('ur_here', RC_Lang::get('orders::order.sale_order_stats'));
		$this->assign('action_link', array('text' => '销售排行报表下载', 'href' => RC_Uri::url('orders/mh_sale_order/download')));
		
		/*时间参数*/
		$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : RC_Time::local_date(ecjia::config('date_format'),RC_Time::local_strtotime('-1 month'));
		$end_date   = !empty($_GET['end_date']) ? $_GET['end_date'] : RC_Time::local_date(ecjia::config('date_format'),RC_Time::local_strtotime('+1 day'));
		
		$filter['start_date'] 	= RC_Time::local_strtotime($start_date);
		$filter['end_date'] 	= RC_Time::local_strtotime($end_date);
		
		$filter['sort_by'] 		= empty($_GET['sort_by']) ? 'goods_num' : trim($_GET['sort_by']);
	    $filter['sort_order'] 	= empty($_GET['sort_order']) ? 'DESC' : trim($_GET['sort_order']);
		
		$goods_order_data = $this->get_sales_order(true, $filter);
        
        $this->assign('start_date', $start_date);
        $this->assign('end_date', $end_date);
        $this->assign('filter', $filter);
        
        $this->assign('goods_order_data', $goods_order_data);
        $this->assign('search_action', RC_Uri::url('orders/mh_sale_order/init'));
		
		$this->display('sale_order.dwt');
	}
	
	/**
	 * 商品销售排行报表下载
	 */
	public function download() {
		/* 检查权限 */
		$this->admin_priv('sale_order_stats', ecjia::MSGTYPE_JSON);
		
		/*时间参数*/
		$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : RC_Time::local_date(ecjia::config('date_format'),RC_Time::local_strtotime('-1 month'));
		$end_date   = !empty($_GET['end_date']) ? $_GET['end_date'] : RC_Time::local_date(ecjia::config('date_format'),RC_Time::local_strtotime('+1 day'));
		
		$filter['start_date'] 	= RC_Time::local_strtotime($start_date);
		$filter['end_date'] 	= RC_Time::local_strtotime($end_date);
		$filter['sort_by'] 		= empty($_GET['sort_by']) ? 'goods_num' : trim($_GET['sort_by']);
	    $filter['sort_order'] 	= empty($_GET['sort_order']) ? 'DESC' : trim($_GET['sort_order']);
		
		$goods_order_data = $this->get_sales_order(false,$filter);
		$filename = RC_Lang::get('orders::statistic.sale_order_statement');
		
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=$filename.xls");
		
		echo mb_convert_encoding($filename . RC_Lang::get('orders::statistic.sale_order_statement'),'UTF-8', 'UTF-8') . "\t\n";
		$data = RC_Lang::get('orders::statistic.order_by')."\t".RC_Lang::get('orders::statistic.goods_name')."\t".RC_Lang::get('orders::statistic.goods_sn')."\t".RC_Lang::get('orders::statistic.sell_amount')."\t".RC_Lang::get('orders::statistic.sell_sum')."\t".RC_Lang::get('orders::statistic.percent_count')."\n";
		foreach ($goods_order_data['item'] as $k => $v) {
			$order_by = $k + 1;
			$data .= "$order_by\t$v[goods_name]\t$v[goods_sn]\t$v[goods_num]\t$v[turnover]\t$v[wvera_price]\n";
		}
		echo mb_convert_encoding($data."\t",'UTF-8','auto');
		exit;
	}
	
	/**
	 * 取得销售排行数据信息
	 * @param   bool  $is_pagination  是否分页
	 * @return  array   销售排行数据
	 */
	private function get_sales_order($is_pagination,$filter) {
	    $where = 'oi.store_id = ' . $_SESSION['store_id'] . order_query_sql('finished', 'oi.');
	    if ($filter['start_date']) {
	    	$where .= " AND oi.add_time >= '" . $filter['start_date'] . "'";
	    }
        if ($filter['end_date']) {
        	$where .= " AND oi.add_time <= '" . $filter['end_date'] . "'";
        }
        $where .= " AND oi.is_delete = 0";
        
	    $count = $this->db_order_goods_view->where($where)->count('distinct(og.goods_id)');
		$page = new ecjia_merchant_page($count, 20, 5);
		
		if ($is_pagination) {
			$limit = $page->limit();
		}
	    $sales_order_data = $this->db_order_goods_view->field('og.goods_id, og.goods_sn, og.goods_name, oi.order_status,SUM(og.goods_number) AS goods_num, SUM(og.goods_number * og.goods_price) AS turnover')->where($where)->group('og.goods_id')->order(array($filter['sort_by']=>$filter['sort_order']))->limit($limit)->select();
	    foreach ($sales_order_data as $key => $item)
	    {
	        $sales_order_data[$key]['wvera_price'] = price_format($item['goods_num'] ? $item['turnover'] / $item['goods_num'] : 0);
	        $sales_order_data[$key]['short_name']  = sub_str($item['goods_name'], 30, true);
	        $sales_order_data[$key]['turnover']    = price_format($item['turnover']);
	        $sales_order_data[$key]['taxis']       = $key + 1;
	    }
	    RC_Loader::load_sys_class('ecjia_page',false);
	    $arr = array('item' => $sales_order_data, 'filter' => $filter, 'desc' => $page->page_desc(), 'page'=>$page->show(2));
	    return $arr;
	}
}

// end