<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 账单 日统计
 */
class store_bill_day_model extends Component_Model_Model {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'store_bill_day';
		parent::__construct();
	}
	//TODO::大数据处理
	public function add_bill_day($options) {
	    //已有账单数据
	    $data = RC_Model::model('commission/store_bill_detail_model')->count_bill_day($options);

	    //获取结算店铺列表
// 	    $store_list = RC_DB::table('store_franchisee')->select('store_id')->where('status', 1)->get();
        if (! $data) {
            return false;
        }
	    return RC_DB::table('store_bill_day')->insert($data);
	}
	
	public function get_billday_list($store_id, $page = 1, $page_size = 15, $filter) {
	    $db_bill_day = RC_DB::table('store_bill_day');
	    
	    if ($store_id) {
	        $db_bill_day->whereRaw('store_id ='.$store_id);
	    }
	    
	    if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
	        $db_bill_day->whereRaw("day BETWEEN '".$filter['start_date']."' AND '".$filter['end_date']."'");
	    } else {
	        if (!empty($filter['start_date']) && empty($filter['end_date'])) {
	            $db_bill_day->whereRaw("day >= '".$filter['start_date']."'");
	        }
	        if (empty($filter['start_date']) && !empty($filter['end_date'])) {
	            $db_bill_day->whereRaw("day <= '".$filter['end_date']."'");
	        }
	    }
	    $count = $db_bill_day->count();
	    if (ROUTE_M == 'admin') {
	        $page = new ecjia_page($count, $page_size, 6);
	    } else {
	        $page = new ecjia_merchant_page($count, $page_size, 6);
	    }
	    
	    if ($page_size) {
	        $db_bill_day->take($page_size)->skip($page->start_id-1);
	    }
	     
	    $row = $db_bill_day
	    ->orderBy('day', 'desc')
	    ->get();
	     
	    if ($row) {
	        foreach ($row as $key => &$val) {
	            $val['add_time_formate'] = RC_Time::local_date('Y-m-d H:i', $val['add_time']);
	        }
	    }
	    return array('item' => $row, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	    
	}
	
	public function count_bill_month($options) {
	    $filter = array();
	    if ($options['month']) {
	        $filter['start_date'] = $options['month'].'-01';
	        $filter['end_date'] = $options['month'].'-31';
	    }
	    
	    $db_bill_day = RC_DB::table('store_bill_day')->groupBy('store_id');
	     
	    if (isset($options['store_id'])) {
	        $db_bill_day->having('store_id', $options['store_id']);
	    }
	     
	    if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
	        $db_bill_day->whereRaw("day BETWEEN '".$filter['start_date']."' AND '".$filter['end_date']."'");
	    } else {
	        return new ecjia_error('error_params');
	    }
// 	    $count = $db_bill_day->count();
// 	    if (ROUTE_M == 'admin') {
// 	        $page = new ecjia_page($count, $page_size, 6);
// 	    } else {
// 	        $page = new ecjia_merchant_page($count, $page_size, 6);
// 	    }
	     
// 	    if ($page_size) {
// 	        $db_bill_day->take($page_size)->skip($page->start_id-1);
// 	    }
	    
	    return $row = $db_bill_day->select("store_id", RC_DB::raw("'".$options['month']."' as bill_month"), RC_DB::raw('SUM(order_count) as order_count'), RC_DB::raw('SUM(order_amount) as order_amount'), 
	        RC_DB::raw('SUM(refund_count) as refund_count'), RC_DB::raw('SUM(refund_amount) as refund_amount'), RC_DB::raw('SUM(brokerage_amount) as available_amount'), RC_DB::raw('SUM(brokerage_amount) as bill_amount'),
	         'percent_value')
	    ->get();
	}
}

// end