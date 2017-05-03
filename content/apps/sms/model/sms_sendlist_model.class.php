<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class sms_sendlist_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'sms_sendlist';
		parent::__construct();
	}
	
	/**
	 * 获取短信发送记录列表
	 */
	public function get_sendlist() {
	    $start_date	= empty($_GET['start_date'])	? '' : RC_Time::local_strtotime($_GET['start_date']);
	    $end_date	= empty($_GET['end_date']) 		? '' : RC_Time::local_strtotime($_GET['end_date']);
	    $keywords	= empty($_GET['keywords']) 		? '' : trim($_GET['keywords']);
	    
	    $where = array();
	    $filter['keywords']   = $keywords;
	    $filter['start_date'] = $start_date;
	    $filter['end_date']   = $end_date;
	    $filter['errorval']   = empty($_GET['errorval']) ? 0 : intval($_GET['errorval']);
	    
	    $db_sms_sendlist = RC_DB::table('sms_sendlist');
	    
	    if ($filter['keywords']) {
	    	$db_sms_sendlist->where(function($query) use ($keywords) {
	    		$query->where('mobile', 'like', '%'.mysql_like_quote($keywords).'%')->orWhere('sms_content', 'like', '%'.mysql_like_quote($keywords).'%');
	    	});
	    }
	
	    if ($filter['start_date'] ) {
	        $db_sms_sendlist->where('last_send', '>=', $start_date);
	    }
	
	    if ($filter['end_date']) {
	        $db_sms_sendlist->where('last_send', '<=', $end_date);
	    }
	    
	    $msg_count = $db_sms_sendlist->select(RC_DB::raw('count(*) AS count, SUM(IF(error > 0, 1, 0)) AS faild, SUM(IF(error = 0, 1, 0)) AS success, SUM(IF(error < 0, 1, 0)) AS wait'))
	    	->first();

	    $msg_count = array(
    		'count'		=> empty($msg_count['count']) 	? 0 : $msg_count['count'],
    		'faild'	    => empty($msg_count['faild']) 	? 0 : $msg_count['faild'],
    		'success'	=> empty($msg_count['success']) ? 0 : $msg_count['success'],
    		'wait'	    => empty($msg_count['wait']) 	? 0 : $msg_count['wait']
	    );
	    
	    //待发送
	    if ($filter['errorval'] == 1) {
	        $where['error'] = -1;
	        
	        $db_sms_sendlist->where('error', '=', -1);
	    }
	
	    //发送成功
	    if ($filter['errorval'] == 2) {
	        $where['error'] = 0;
	        
	        $db_sms_sendlist->where('error', '=', 0);
	    }
	
	    //发送失败
	    if ($filter['errorval'] == 3) {
	        $where['error'] = array('gt' => 0);
	        
	        $db_sms_sendlist->where('error', '>', 0);
	    }
	
	    $count = $db_sms_sendlist->count();
	    $page = new ecjia_page($count, 15, 6);
	    
	    $row = $db_sms_sendlist->select('*')->orderby('last_send', 'desc')->take(15)->skip($page->start_id-1)->get();
		
	    if (!empty($row)) {
	        foreach ($row AS $key => $val) {
	            $row[$key]['last_send'] = RC_Time::local_date(ecjia::config('time_format'), $val['last_send']);
	        }
	    }

	    $filter['start_date'] = RC_Time::local_date(ecjia::config('date_format'), $filter['start_date']);
	    $filter['end_date']   = RC_Time::local_date(ecjia::config('date_format'), $filter['end_date']);
	    
	   	return array('item' => $row, 'filter' => $filter, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'msg_count' => $msg_count);
	}
	
	public function sms_sendlist_find($where) {
		return RC_DB::table('sms_sendlist')->where('id', $where)->first();
	}
	
	public function sms_sendlist_select($where, $in=false) {
		$db_sms_sendlist = RC_DB::table('sms_sendlist');
		if ($in){
			foreach($where as $key => $val){
				$db_sms_sendlist->whereIn($key, $val);
			}
		} else {
			foreach($where as $key => $val){
				$db_sms_sendlist->where($key, $val);
			}
		}
		return $db_sms_sendlist->get();
	}
}

// end