<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 销售明细列表程序
*/
class mh_sale_list extends ecjia_merchant {
	private $order_goods_view;
	private $order_info_view;
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global','orders');
		$this->order_info_view = RC_Loader::load_app_model('order_info_viewmodel','orders');
		$this->order_goods_view = RC_Loader::load_app_model('order_goods_viewmodel','orders');
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
        RC_Script::enqueue_script('sale_list',RC_App::apps_url('statics/js/merchant_sale_list.js',__FILE__), array('ecjia-merchant'), false, 1);
        
        ecjia_merchant_screen::get_current_screen()->set_parentage('stats');
	}
	
	/**
	 * 商品明细列表
	 */
	public function init() {
		/* 权限判断 */ 
		$this->admin_priv('sale_list_stats');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('报表统计', RC_Uri::url('stats/mh_keywords_stats/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::statistic.sales_list')));
		
		$this->assign('ur_here', RC_Lang::get('orders::statistic.sales_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('orders::statistic.down_sales'), 'href' => RC_Uri::url('orders/mh_sale_list/download')));
		
		/* 时间参数 */
		$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : RC_Time::local_date(ecjia::config('date_format'),RC_Time::local_strtotime('-7 days'));
		$end_date = !empty($_GET['end_date']) ? $_GET['end_date'] : RC_Time::local_date(ecjia::config('date_format'));
		
		$sale_list_data = $this->get_sale_list();
        /* 赋值到模板 */
        $this->assign('sale_list_data', $sale_list_data);
        
        $this->assign('start_date', $start_date);
        $this->assign('end_date', $end_date);
        
        $this->assign('search_action', RC_Uri::url('orders/mh_sale_list/init'));
        
        $this->assign_lang();
		$this->display('sale_list.dwt');
	}

	/**
	 * 下载销售明细
	 */
	public function download() {
		/* 检查权限 */
		$this->admin_priv('sale_list_stats', ecjia::MSGTYPE_JSON);
		
		/* 时间参数 */
		$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : RC_Time::local_date(ecjia::config('date_format'), RC_Time::local_strtotime('-7 days'));
		$end_date = !empty($_GET['end_date']) ? $_GET['end_date'] : RC_Time::local_date(ecjia::config('date_format'), RC_Time::local_strtotime('today'));

		/*文件名*/
		$file_name = RC_Lang::get('orders::statistic.sales_list');
		$goods_sales_list = $this->get_sale_list(false);
		/*强制下载,下载类型EXCEL*/
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=$file_name.xls");
		
		echo mb_convert_encoding($filename . RC_LANG::lang('sales_list_statement'),'UTF-8', 'UTF-8') . "\t\n";
		$data = RC_Lang::get('orders::statistic.goods_name')."\t".RC_Lang::get('orders::statistic.order_sn')."\t".RC_Lang::get('orders::statistic.amount')."\t".RC_Lang::get('orders::statistic.sell_price')."\t".RC_Lang::get('orders::statistic.sell_date')."\n";
		
		foreach ($goods_sales_list as $row) {
			foreach ($row as $v) {
				$data .= mb_convert_encoding("$v[goods_name]\t$v[order_sn]\t$v[goods_num]\t$v[sales_price]\t$v[sales_time]\n",'UTF-8','auto');
			}
		}
		echo mb_convert_encoding($data."\t",'UTF-8','auto');
		exit;
	}

	/**
	 * 取得销售明细数据信息
	 * @param   bool  $is_pagination  是否分页
	 * @return  array   销售明细数据
	 */
	private function get_sale_list($is_pagination = true) {
		/* 时间参数 */
	    $filter['start_date'] = empty($_GET['start_date']) ? RC_Time::local_strtotime('-7 days') : RC_Time::local_strtotime($_GET['start_date']);
	    $filter['end_date'] = empty($_GET['end_date']) ? RC_Time::local_strtotime('today') : RC_Time::local_strtotime($_GET['end_date']);
	    $where = "oi.store_id = " . $_SESSION['store_id'] .order_query_sql('finished', 'oi.') ." AND oi.add_time >= '".$filter['start_date']."' AND oi.add_time < '" . ($filter['end_date'] + 86400) . "'";
	    $where .= " AND oi.is_delete = 0";
	    
	    $count = $this->order_goods_view->where($where)->count('og.goods_id');
		$page = new ecjia_merchant_page($count,20,5);
	    if ($is_pagination) {
           $limit = $page->limit();
	    }
	    $sale_list_data = $this->order_goods_view->field('og.goods_id, og.goods_sn, og.goods_name, og.goods_number AS goods_num, og.goods_price '.
           'AS sales_price, oi.add_time AS sales_time, oi.order_id, oi.order_sn ')->where($where)->order(array( 'sales_time'=> 'DESC', 'goods_num'=> 'DESC'))->limit($limit)->select();
	    
	    foreach ($sale_list_data as $key => $item) {
	        $sale_list_data[$key]['sales_price'] = price_format($sale_list_data[$key]['sales_price']);
	        $sale_list_data[$key]['sales_time']  = RC_Time::local_date(ecjia::config('date_format'), $sale_list_data[$key]['sales_time']);
	    }
	    $arr = array('item' => $sale_list_data, 'filter' => $filter, 'desc' => $page->page_desc(), 'page' => $page->show(2));
	    return $arr;
	}
}

// end