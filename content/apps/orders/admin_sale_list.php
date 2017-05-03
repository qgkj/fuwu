<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 销售明细列表程序
*/
class admin_sale_list extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_func('global', 'orders');

		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));

        RC_Script::enqueue_script('sale_list', RC_App::apps_url('statics/js/sale_list.js', __FILE__));
        RC_Script::localize_script('sale_list', 'js_lang', RC_Lang::get('orders::statistic.js_lang'));
	}

	/**
	 * 销售明细
	 */
	public function init() {
		/* 权限判断 */
		$this->admin_priv('sale_list_stats');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::statistic.sales_list')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('orders::statistic.overview'),
			'content'	=> '<p>' . RC_Lang::get('orders::statistic.sale_list_help') . '</p>'
		));

		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('orders::statistic.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:销售明细" target="_blank">'. RC_Lang::get('orders::statistic.about_sale_list') .'</a>') . '</p>'
		);
		$this->assign('ur_here', RC_Lang::get('orders::statistic.sales_list'));
		$this->assign('action_link', array('text' => '下载销售明细报表', 'href' => RC_Uri::url('orders/admin_sale_list/download')));

		/* 时间参数 */
		$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : RC_Time::local_date(ecjia::config('date_format'), strtotime('-1 month')-8*3600);
		$end_date = !empty($_GET['end_date']) ? $_GET['end_date'] : RC_Time::local_date(ecjia::config('date_format'));
		
		function get_url_args($get_or_post, $args=array()) {
		    $url_string = '';
		    if ($get_or_post && $args) {
		        foreach ($get_or_post as $key => $value) {
		            if ($value != '' && in_array($key, $args)) {
		                $url_string .= "&".$key."=".$value;
		            }
		        }
		    }
		    return $url_string;
		}
		$url_args = get_url_args($_GET, array('start_date', 'end_date'));
		$this->assign('url_args', $url_args);
		
		if(!empty($_GET['store_id'])) {
		    $store_info = RC_DB::table('store_franchisee')->where('store_id', $_GET['store_id'])->first();
		    $this->assign('ur_here', $store_info['merchants_name'] . ' - ' . RC_Lang::get('orders::statistic.sales_list'));
		}

		$sale_list_data = $this->get_sale_list();
		$this->assign('sale_list_data', $sale_list_data);
		$this->assign('start_date', $start_date);
		$this->assign('end_date', $end_date);
		$this->assign('search_action', RC_Uri::url('orders/admin_sale_list/init'));

		$this->display('sale_list.dwt');
	}

	/**
	 * 下载销售明细
	 */
	public function download() {
		/* 检查权限 */
		$this->admin_priv('sale_list_stats', ecjia::MSGTYPE_JSON);

		/* 时间参数 */
		$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : RC_Time::local_date(ecjia::config('date_format'),RC_Time::local_strtotime('-7 days'));
		$end_date = !empty($_GET['end_date']) ? $_GET['end_date'] : RC_Time::local_date(ecjia::config('date_format'),RC_Time::local_strtotime('today'));
		if(!empty($_GET['store_id'])) {
		    $store_info = RC_DB::table('store_franchisee')->where('store_id', $_GET['store_id'])->first();
		    $file_name = mb_convert_encoding(RC_Lang::get('orders::statistic.sales_list_statement').'_'.$store_info['merchants_name'].'_'.$_GET['start_date'].'-'.$_GET['end_date'], "GBK", "UTF-8");
		} else {
		    $file_name = mb_convert_encoding(RC_Lang::get('orders::statistic.sales_list_statement').'_'.$_GET['start_date'].'-'.$_GET['end_date'], "GBK", "UTF-8");
		}
		
		/*文件名*/
		$goods_sales_list = $this->get_sale_list(false);

		/*强制下载,下载类型EXCEL*/
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=$file_name.xls");

		$data = RC_Lang::get('orders::statistic.goods_name')."\t商家名称\t".RC_Lang::get('orders::statistic.order_sn')."\t".RC_Lang::get('orders::statistic.amount')."\t".RC_Lang::get('orders::statistic.sell_price')."\t".RC_Lang::get('orders::statistic.sell_date')."\n";
		if (!empty($goods_sales_list['item'])) {
			foreach ($goods_sales_list['item'] as $v) {
				$data .= mb_convert_encoding($v['goods_name']."\t".$v['merchants_name']."\t".$v['order_sn']."\t".$v['goods_num']."\t".$v['sales_price']."\t".$v['sales_time']."\n",'UTF-8','auto');
			}
		}
		echo mb_convert_encoding($data."\t","GBK","UTF-8");
		exit;
	}

	/**
	 * 取得销售明细数据信息
	 * @param   bool  $is_pagination  是否分页
	 * @return  array   销售明细数据
	 */
	private function get_sale_list($is_pagination = true) {
		/* 时间参数 */
	    $filter['start_date'] = empty($_REQUEST['start_date']) ? RC_Time::local_strtotime('-7 days') : RC_Time::local_strtotime($_REQUEST['start_date']);
	    $filter['end_date'] = empty($_REQUEST['end_date']) ? RC_Time::local_strtotime('today') : RC_Time::local_strtotime($_REQUEST['end_date']);
	    $filter['merchant_keywords'] = empty ($_GET['merchant_keywords']) ? '' : trim($_GET['merchant_keywords']);
	    $where = "1" .order_query_sql('finished', 'oi.') ." AND oi.add_time >= '".$filter['start_date']."' AND oi.add_time < '" . ($filter['end_date'] + 86400) . "'";
        if($_GET['store_id']){
            $where .= ' AND sf.store_id = '.$_GET['store_id'];
        } else {
            if($filter['merchant_keywords']) {
                $where .= " AND sf.merchants_name like '%".$filter['merchant_keywords']."%'";
            }
        }
        $where .= " AND oi.is_delete = 0";
        
	    $db_goods = RC_DB::table('goods as g')
	    	->leftJoin('order_goods as og', RC_DB::raw('og.goods_id'), '=', RC_DB::raw('g.goods_id'))
	    	->leftJoin('order_info as oi', RC_DB::raw('oi.order_id'), '=', RC_DB::raw('og.order_id'))
            ->leftJoin('store_franchisee as sf', RC_DB::raw('g.store_id'), '=', RC_DB::raw('sf.store_id'))
	    	->whereRaw($where);

	    $count = $db_goods->count(RC_DB::raw('og.goods_id'));
		$page = new ecjia_page($count, 15, 5);
		if ($is_pagination) {
			$db_goods->take(15)->skip($page->start_id-1);
		}

	    $sale_list_data = $db_goods->select(RC_DB::raw('og.goods_id, og.goods_sn, og.goods_name, og.goods_number AS goods_num, og.goods_price '.
           'AS sales_price, oi.add_time AS sales_time, oi.order_id, oi.order_sn, sf.merchants_name, sf.store_id'))->orderby('sales_time', 'desc')->orderby('goods_num', 'desc')->get();
	    if (!empty($sale_list_data)) {
	    	foreach ($sale_list_data as $key => $item) {
	    		$sale_list_data[$key]['sales_price'] = price_format($sale_list_data[$key]['sales_price']);
	    		$sale_list_data[$key]['sales_time']  = RC_Time::local_date(ecjia::config('date_format'), $sale_list_data[$key]['sales_time']);
	    	}
	    }
	    return array('item' => $sale_list_data, 'filter' => $filter, 'desc' => $page->page_desc(), 'page' => $page->show(2));
	}
}

// end