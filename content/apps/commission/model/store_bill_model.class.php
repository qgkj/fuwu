<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 账单
 */
class store_bill_model extends Component_Model_Model {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'store_bill';
		parent::__construct();
	}
	
	/**
	 * 获取账单列表
	 * @param integer $store_id
	 * @param array $filter
	 */
	public function get_bill_list ($store_id, $page = 1, $page_size = 15, $filter = array()) {
	    $db_store_bill = RC_DB::table('store_bill as b')->leftJoin('store_franchisee as s', RC_DB::raw('s.store_id'), '=', RC_DB::raw('b.store_id'));
	    
	    if ($store_id) {
	        $db_store_bill->whereRaw('b.store_id=' . $store_id);
	    }
	    
	    if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
	        $db_store_bill->whereBetween('bill_month', array($filter['start_date'], $filter['end_date']));
	    } else {
	        if (!empty($filter['start_date']) && empty($filter['end_date'])) {
	            $db_store_bill->where('bill_month', '>=', $filter['start_date']);
	        }
	        if (empty($filter['start_date']) && !empty($filter['end_date'])) {
	            $db_store_bill->where('bill_month', '<=', $filter['end_date']);
	        }
	    }
	    if (!empty($filter['keywords'])) {
	        $db_store_bill->whereRaw('b.bill_sn=' . $filter['keywords']);
	    }
	    if (!empty($filter['merchant_keywords'])) {
	        $db_store_bill->whereRaw("s.merchants_name LIKE '%". $filter['merchant_keywords']."%'");
	    }
	    
	    $filter_count = $db_store_bill
	    ->select(RC_DB::raw('count(*) as count_all'),
	        RC_DB::raw('SUM(pay_status = 1) as count_unpay'),
	        RC_DB::raw('SUM(pay_status = 2) as count_paying'),
	        RC_DB::raw('SUM(pay_status = 3) as count_payed'))
	        ->first();
	    $filter ['count_all'] 	= $filter_count['count_all'] > 0 ? $filter_count['count_all'] : 0;
	    $filter ['count_unpay'] = $filter_count['count_unpay'] > 0 ? $filter_count['count_unpay'] : 0;
	    $filter ['count_paying'] 	= $filter_count['count_paying'] > 0 ? $filter_count['count_paying'] : 0;
	    $filter ['count_payed'] 	= $filter_count['count_payed'] > 0 ? $filter_count['count_payed'] : 0;
	    
	    if (!empty($filter['type'])) {
	        $db_store_bill->whereRaw('b.pay_status=' . intval($filter['type']));
	    }
	   
	    $page = new ecjia_page($filter_count['count_all'], $page_size, 6);
	    
	    $row = $db_store_bill
		    ->select(RC_DB::raw('b.*, s.merchants_name '))
		    ->take($page_size)
		    ->orderBy('bill_month', 'desc')
		    ->skip($page->start_id-1)
		    ->get();
	    
	    if ($row) {
	        foreach ($row as $key => &$val) {
	            $val['pay_time_formate'] = RC_Time::local_date('Y-m-d H:i', $val['pay_time']);
	            $val['add_time_formate'] = RC_Time::local_date('Y-m-d H:i', $val['add_time']);
	        }
	    }
	    return array('item' => $row, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
	
	/**
	 * 获取账单列表
	 * @param integer $store_id
	 * @param array $filter
	 */
	public function get_bill_list_merchant ($store_id, $page = 1, $page_size = 15, $filter = array()) {
	    $db_store_bill = RC_DB::table('store_bill');
	     
	    if ($store_id) {
	        $db_store_bill->where('store_id', $store_id);
	    }
	     
	    if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
	        $db_store_bill->whereBetween('bill_month', array($filter['start_date'], $filter['end_date']));
	    } else {
	        if (!empty($filter['start_date']) && empty($filter['end_date'])) {
	            $db_store_bill->where('bill_month', '>=', $filter['start_date']);
	        }
	        if (empty($filter['start_date']) && !empty($filter['end_date'])) {
	            $db_store_bill->where('bill_month', '<=', $filter['end_date']);
	        }
	    }
	     
	    $count = $db_store_bill->count();
	    $page = new ecjia_merchant_page($count, $page_size, 6);
	     
	    $row = $db_store_bill
		    ->take($page_size)
		    ->orderBy('bill_month', 'desc')
		    ->skip($page->start_id-1)
		    ->get();
	     
	    if ($row) {
	        foreach ($row as $key => &$val) {
	            $val['pay_time_formate'] = RC_Time::local_date('Y-m-d H:i', $val['pay_time']);
	            $val['add_time_formate'] = RC_Time::local_date('Y-m-d H:i', $val['add_time']);
	        }
	    }
	     
	    return array('item' => $row, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
	
	public function get_bill($bill_id, $store_id) {
	    if (empty($bill_id)) {
	        return false;
	    }
	    $db_store_bill = RC_DB::table('store_bill');
	    if ($store_id) {
	        $db_store_bill->where('store_id', $store_id);
	    }
	    
	    $info = $db_store_bill->where('bill_id', $bill_id)->first();
	    if ($info['pay_time']) {
	        $info['pay_time_formate'] = RC_Time::local_date('Y-m-d H:i:s', $val['pay_time']);
	    }
	    return $info;
	}
}

// end