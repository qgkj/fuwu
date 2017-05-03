<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 销售概况
*/
class mh_sale_general extends ecjia_merchant {
	private $db_order_info;
	private $db_orderinfo_view;
	public function __construct() {
		parent::__construct();
		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');

		/*自定义*/
		RC_Lang::load('statistic');
		RC_Loader::load_app_func('global', 'orders');
		
		$this->db_order_info = RC_Loader::load_app_model('order_info_model', 'orders');
        $this->db_orderinfo_view = RC_Loader::load_app_model('order_info_viewmodel', 'orders');
        
        RC_Script::enqueue_script('acharts-min', RC_App::apps_url('statics/js/acharts-min.js', __FILE__), array('ecjia-merchant'), false, 1);
        RC_Script::enqueue_script('sale_general', RC_App::apps_url('statics/js/merchant_sale_general.js', __FILE__), array('ecjia-merchant'), false, 1);
        RC_Script::enqueue_script('sale_general_chart', RC_App::apps_url('statics/js/merchant_sale_general_chart.js', __FILE__), array('ecjia-merchant'), false, 1);
        
        RC_Style::enqueue_style('orders-css', RC_App::apps_url('statics/css/merchant_orders.css', __FILE__));
        RC_Style::enqueue_style('stats-css', RC_App::apps_url('statics/css/merchant_stats.css', __FILE__));
        
        ecjia_merchant_screen::get_current_screen()->set_parentage('stats');
	}
	
	/**
	 * 显示统计信息
	 */
	public function init() {
		/*权限判断 */ 
		$this->admin_priv('sale_general_stats');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('报表统计', RC_Uri::url('stats/mh_keywords_stats/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('销售概况')));
		
		$this->assign('ur_here', RC_Lang::get('orders::statistic.report_sell'));
		$this->assign('action_link', array('text' => RC_Lang::get('orders::statistic.down_sales_stats'), 'href' => RC_Uri::url('orders/mh_sale_general/download')));
		
		if (empty($_GET['query_type'])) {
			$query_type = 'month';
			$start_time 		= RC_Time::local_mktime(0, 0, 0, 1, 1, intval(date('Y')-3));
			$end_time   		= RC_Time::local_mktime(23, 59, 59, 12, 31, intval(date('Y')));
			$start_month_time 	= RC_Time::local_mktime(0, 0, 0, 1, 1, intval(date('Y')-3));
			$end_month_time   	= RC_Time::local_mktime(23, 59, 59, 12, 31, intval(date('Y')));
		}
		if ($_GET['query_by_year']) {
			$query_type = 'year';
			$start_time 		= RC_Time::local_mktime(0, 0, 0, 1, 1, intval($_GET['year_beginYear']));
			$end_time   		= RC_Time::local_mktime(23, 59, 59, 12, 31, intval($_GET['year_endYear']));
			$start_month_time 	= RC_Time::local_mktime(0, 0, 0, 1, 1, intval($_GET['year_beginYear']));
			$end_month_time   	= RC_Time::local_mktime(23, 59, 59, 12, 31, intval($_GET['year_endYear']));
		} elseif ($_GET['query_by_month']) {
			$start_time 		= RC_Time::local_mktime(0, 0, 0, intval($_GET['month_beginMonth']), 1, intval($_GET['month_beginYear']));
			$end_time   		= RC_Time::local_mktime(23, 59, 59, intval($_GET['month_endMonth']), 31, intval($_GET['month_endYear']));
			$start_month_time 	= RC_Time::local_mktime(0, 0, 0, intval($_GET['month_beginMonth']), 1, intval($_GET['month_beginYear']));
			$end_month_time   	= RC_Time::local_mktime(23, 59, 59, intval($_GET['month_endMonth']), 31, intval($_GET['month_endYear']));
		}
		
		$this->assign('query_type', $query_type);
        
        $this->assign('start_time', RC_Time::local_date('Y-m-d', $start_time));
        $this->assign('end_time', RC_Time::local_date('Y-m-d', $end_time));
        
        $this->assign('form_action', RC_Uri::url('orders/mh_sale_general/init'));
        $this->assign('start_month_time', RC_Time::local_date('Y-m-d', $start_month_time));
        $this->assign('end_month_time', RC_Time::local_date('Y-m-d', $end_month_time));
        $this->assign('page', 'init');
		
		$this->assign_lang();
		$this->display('sale_general.dwt');
	}
	
	/**
	 * 显示销售额走势
	 */
	public function sales_trends() {
		/*权限判断 */
		$this->admin_priv('sale_general_stats');
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('销售概况')));
	
		$this->assign('ur_here', RC_Lang::get('orders::statistic.report_sell'));
		$this->assign('action_link',array('text' => RC_Lang::get('orders::statistic.down_sales_stats'),'href' => RC_Uri::url('orders/mh_sale_general/download')));
	
		if (empty($_GET['query_type'])) {
			$query_type = 'month';
			$start_time 		= RC_Time::local_mktime(0, 0, 0, 1, 1, intval(date('Y')-3));
			$end_time   		= RC_Time::local_mktime(23, 59, 59, 12, 31, intval(date('Y')));
			$start_month_time 	= RC_Time::local_mktime(0, 0, 0, 1, 1, intval(date('Y')-3));
			$end_month_time   	= RC_Time::local_mktime(23, 59, 59, 12, 31, intval(date('Y')));
		}
		if ($_GET['query_by_year']) {
			$query_type = 'year';
			$start_time 		= RC_Time::local_mktime(0, 0, 0, 1, 1, intval($_GET['year_beginYear']));
			$end_time   		= RC_Time::local_mktime(23, 59, 59, 12, 31, intval($_GET['year_endYear']));
			$start_month_time 	= RC_Time::local_mktime(0, 0, 0, 1, 1, intval($_GET['year_beginYear']));
			$end_month_time   	= RC_Time::local_mktime(23, 59, 59, 12, 31, intval($_GET['year_endYear']));
		} elseif ($_GET['query_by_month']) {
			$start_time 		= RC_Time::local_mktime(0, 0, 0, intval($_GET['month_beginMonth']), 1, intval($_GET['month_beginYear']));
			$end_time   		= RC_Time::local_mktime(23, 59, 59, intval($_GET['month_endMonth']), 31, intval($_GET['month_endYear']));
			$start_month_time 	= RC_Time::local_mktime(0, 0, 0, intval($_GET['month_beginMonth']), 1, intval($_GET['month_beginYear']));
			$end_month_time   	= RC_Time::local_mktime(23, 59, 59, intval($_GET['month_endMonth']), 31, intval($_GET['month_endYear']));
		}
	
		$this->assign('query_type', $query_type);
	
		$this->assign('start_time', RC_Time::local_date('Y-m-d', $start_time));
		$this->assign('end_time', RC_Time::local_date('Y-m-d', $end_time));
	
		$this->assign('form_action', RC_Uri::url('orders/mh_sale_general/sales_trends'));
		$this->assign('start_month_time', RC_Time::local_date('Y-m-d', $start_month_time));
		$this->assign('end_month_time', RC_Time::local_date('Y-m-d', $end_month_time));
		$this->assign('page', 'sales_trends');
		
		$this->assign_lang();
		$this->display('sale_general.dwt');
	}
	
	/**
	 * 获取销售概况图表数据
	 */
	public function get_order_status () {
	    /* 权限判断 */
	    $this->admin_priv('sale_general_stats', ecjia::MSGTYPE_JSON);
		$query_type = $_GET['query_type'] == 'year' ? 'year' : 'month';
		if ($query_type =='year') {
			/*时间参数*/
			$start_time = RC_Time::local_strtotime($_GET['start_time']);
			$end_time   = RC_Time::local_strtotime($_GET['end_time']);
		} else {
			$start_time = RC_Time::local_strtotime($_GET['start_month_time']);
			$end_time   = RC_Time::local_strtotime($_GET['end_month_time']);
		}
		$format = ($query_type == 'year') ? '%Y' : '%Y-%m';
		$where = "oi.store_id = ". $_SESSION['store_id'] ." AND (order_status = '" . OS_CONFIRMED . "' OR order_status >= '" . OS_SPLITED . "' ) AND ( pay_status = '" . PS_PAYED . "' OR pay_status = '" . PS_PAYING . "') AND (shipping_status = '" . SS_SHIPPED . "' OR shipping_status = '" . SS_RECEIVED . "' ) AND (shipping_time >= ' ". $start_time ."' AND shipping_time <= '" .$end_time. "'  )";
		$where .= " AND oi.is_delete = 0";
		
		$templateCount = $this->db_orderinfo_view->field("DATE_FORMAT(FROM_UNIXTIME(shipping_time), '". $format ."') AS period, COUNT(DISTINCT order_sn) AS order_count, SUM(goods_amount + shipping_fee + insure_fee + pay_fee + pack_fee + card_fee - discount) AS order_amount")
		                                         ->where($where)->group('period')->select();
		if ($_GET['order_type'] == 1) {
		    if ($templateCount) {
		        foreach ($templateCount as $k => $v) {
		            unset($templateCount[$k]['order_amount']);
		        }
		    } else {
				$templateCount = null;
			}
			
		} else {
		    if ($templateCount) {
		        foreach ($templateCount as $k => $v) {
		            unset($templateCount[$k]['order_count']);
		        }
		    } else {
				$templateCount = null;
			}
		}
		echo json_encode($templateCount);
	}

	/**
	 * 下载EXCEL报表
	 */
	public function download() {
		/* 权限判断 */ 
		$this->admin_priv('sale_general_stats', ecjia::MSGTYPE_JSON);
		
		$start_time = RC_Time::local_strtotime($_GET['start_time']);
		$end_time   = RC_Time::local_strtotime($_GET['end_time']);
		
		if (empty($_GET['query_type'])) {
		    $query_type = 'month';
		    $start_time 		= RC_Time::local_mktime(0, 0, 0, 1, 1, intval(date('Y')-3));
		    $end_time   		= RC_Time::local_mktime(23, 59, 59, 12, 31, intval(date('Y')));
		    $start_month_time 	= RC_Time::local_mktime(0, 0, 0, 1, 1, intval(date('Y')-3));
		    $end_month_time   	= RC_Time::local_mktime(23, 59, 59, 12, 31, intval(date('Y')));
		}
		if ($_GET['query_by_year']) {
		    $query_type = 'year';
		    $start_time 		= RC_Time::local_mktime(0, 0, 0, 1, 1, intval($_GET['year_beginYear']));
		    $end_time   		= RC_Time::local_mktime(23, 59, 59, 12, 31, intval($_GET['year_endYear']));
		    $start_month_time 	= RC_Time::local_mktime(0, 0, 0, 1, 1, intval($_GET['year_beginYear']));
		    $end_month_time   	= RC_Time::local_mktime(23, 59, 59, 12, 31, intval($_GET['year_endYear']));
		} elseif ($_GET['query_by_month']) {
		    $start_time 		= RC_Time::local_mktime(0, 0, 0, intval($_GET['month_beginMonth']), 1, intval($_GET['month_beginYear']));
		    $end_time   		= RC_Time::local_mktime(23, 59, 59, intval($_GET['month_endMonth']), 31, intval($_GET['month_endYear']));
		    $start_month_time 	= RC_Time::local_mktime(0, 0, 0, intval($_GET['month_beginMonth']), 1, intval($_GET['month_beginYear']));
		    $end_month_time   	= RC_Time::local_mktime(23, 59, 59, intval($_GET['month_endMonth']), 31, intval($_GET['month_endYear']));
		}
		
		$query_type = $_GET['query_type'];
		/* 分组统计订单数和销售额：已发货时间为准 */	
		$format = ($query_type == 'year') ? '%Y' : '%Y-%m';
		if ($start_time < 0 || $end_time < 0) {
		    return $this->showmessage('参数错误', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
		}
		$where =  " (order_status = '" . OS_CONFIRMED . "' OR order_status >= '" . OS_SPLITED . "' ) AND ( pay_status = '" . PS_PAYED . "' OR pay_status = '" . PS_PAYING . "') AND (shipping_status = '" . SS_SHIPPED . "' OR shipping_status = '" . SS_RECEIVED . "' ) AND (shipping_time >= '". $start_time ."' AND shipping_time <= '" .$end_time. "'  )";
		$where .= " AND store_id = ". $_SESSION['store_id'];
		$where .= " AND is_delete = 0";
		
		$data_list = $this->db_order_info->field("DATE_FORMAT(FROM_UNIXTIME(shipping_time), '". $format ."') AS period, COUNT(DISTINCT order_sn) AS order_count, SUM(goods_amount + shipping_fee + insure_fee + pay_fee + pack_fee + card_fee - discount) AS order_amount")
		                                 ->where($where)->group('period')->select();
		/* 文件名 */
		$filename = RC_Lang::get('orders::statistic.sale_general_statement');
		
		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=$filename.xls");
		
		/* 文件标题 */
		echo mb_convert_encoding($filename . RC_Lang::get('orders::statistic.sales_statistics'),'UTF-8', 'UTF-8') . "\t\n";
		
		/* 订单数量, 销售出商品数量, 销售金额 */
		echo mb_convert_encoding(RC_LANG::lang('period'),'UTF-8', 'UTF-8') . "\t";
		echo mb_convert_encoding(RC_LANG::lang('order_count_trend'),'UTF-8', 'UTF-8') . "\t";
		echo mb_convert_encoding(RC_LANG::lang('order_amount_trend'),'UTF-8', 'UTF-8') . "\t\n";
		foreach ($data_list AS $data) {
			echo mb_convert_encoding($data['period'],'UTF-8', 'UTF-8') . "\t";
			echo mb_convert_encoding($data['order_count'],'UTF-8', 'UTF-8') . "\t";
			echo mb_convert_encoding($data['order_amount'],'UTF-8', 'UTF-8') . "\t";
			echo "\n";
		}
		exit;
	}
}

// end