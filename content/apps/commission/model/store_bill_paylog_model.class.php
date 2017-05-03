<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 账单
 */
class store_bill_paylog_model extends Component_Model_Model {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'store_bill_paylog';
		parent::__construct();
	}
	
	/**
	 * 获取打款列表
	 * @param integer $store_id
	 * @param array $filter
	 */
	public function get_bill_paylog_list ($bill_id, $page = 1, $page_size = 15, $filter = array()) {
	    $db_store_bill_paylog = RC_DB::table('store_bill_paylog as b');
	    
	    if ($bill_id) {
	        $db_store_bill_paylog->whereRaw('b.bill_id=' . $bill_id);
	    } else {
	        return false;
	    }
	    
	    if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
	        $db_store_bill_paylog->whereBetween('add_time', array($filter['start_date'], $filter['end_date']));
	    } else {
	        if (!empty($filter['start_date']) && empty($filter['end_date'])) {
	            $db_store_bill_paylog->where('add_time', '>=', $filter['start_date']);
	        }
	        if (empty($filter['start_date']) && !empty($filter['end_date'])) {
	            $db_store_bill_paylog->where('add_time', '<=', $filter['end_date']);
	        }
	    }
	    
	    $filter_count = $db_store_bill_paylog
	 		->select(RC_DB::raw('count(*) as count_all'), RC_DB::raw('SUM(bill_amount) as count_bill_amount'))
	        ->first();
	    $filter['count_all'] 			= $filter_count['count_all'] > 0 			? $filter_count['count_all'] 			: 0;
	    $filter['count_bill_amount'] 	= $filter_count['count_bill_amount'] > 0 	? $filter_count['count_bill_amount'] 	: 0;
	    
	    $page = new ecjia_page($filter_count['count_all'], $page_size, 6);
	    
	    $row = $db_store_bill_paylog
		    ->leftJoin('admin_user as au', RC_DB::raw('b.admin_id'), '=', RC_DB::raw('au.user_id'))
		    ->select(RC_DB::raw('b.*, au.user_name '))
		    ->take($page_size)
		    ->orderBy('add_time', 'desc')
		    ->skip($page->start_id-1)
		    ->get();
	    
	    if ($row) {
	        foreach ($row as $key => &$val) {
	            $val['add_time_formate'] = RC_Time::local_date('Y-m-d H:i:s', $val['add_time']);
	        }
	    }
	    return array('item' => $row, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
	
    public function get_paylog_count($bill_id) {
	    return RC_DB::table('store_bill_paylog')->where('bill_id', $bill_id)->count();
	}
}

// end