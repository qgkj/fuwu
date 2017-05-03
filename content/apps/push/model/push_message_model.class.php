<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class push_message_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'push_message';
		parent::__construct();
	}
	
	/**
	 * 消息记录
	 */
	public function get_pushlist() {
	    $filter['keywords']	= empty($_GET['keywords']) 	? '' 	: trim($_GET['keywords']);
	    $filter['pushval']	= empty($_GET['pushval']) 	? 0 	: intval($_GET['pushval']);
	    $status 			= empty($_GET['status'])	? 0  	: $_GET['status'];
	    $filter['in_status']='';
	
	    $db_push_message = RC_DB::table('push_message');
	    
	    if (!empty($status) || (isset($_GET['status']) && intval($_GET['status']) === 0 )) {
	        $filter['in_status']  =  $status;
	        $db_push_message->where('in_status', $status);
	    }
	
	    if ($filter['keywords']) {
	        $db_push_message->where('title', 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
	    }
	    
	    $msg_count = $db_push_message->select(RC_DB::raw('count(*) AS count, SUM(IF(device_client="android", 1, 0)) AS android, SUM(IF(device_client="iphone", 1, 0)) AS iphone, SUM(IF(device_client="ipad", 1, 0)) AS ipad'))
	    	->first();
	    
	    $msg_count = array(
    		'count'		=> empty($msg_count['count'])   ? 0 : $msg_count['count'],
    		'android'	=> empty($msg_count['android']) ? 0 : $msg_count['android'],
    		'iphone'	=> empty($msg_count['iphone']) 	? 0 : $msg_count['iphone'],
    		'ipad'	    => empty($msg_count['ipad']) 	? 0 : $msg_count['ipad'],
	    );
	
	    //安卓
	    if ($filter['pushval'] == 1) {
	        $db_push_message->where('device_client', 'android');
	    }
	    //iphone
	    if ($filter['pushval'] == 2) {
	        $db_push_message->where('device_client', 'iphone');
	    }
	
	    //ipad
	    if ($filter['pushval'] == 3) {
	        $db_push_message->where('device_client', 'ipad');
	    }
	
	    $count = $db_push_message->count();
	    $page = new ecjia_page($count, 15, 6);
	    
	    $row = $db_push_message->select('*')->orderby('add_time', 'desc')->take(15)->skip($page->start_id-1)->get();

	    if (!empty($row)) {
	        foreach ($row AS $key => $val) {
	            $row[$key]['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['add_time']);
	            $row[$key]['push_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['push_time']);
	            if ($row[$key]['device_client'] == 'android') {
	                $row[$key]['device_client'] = 'Android';
	            } elseif ($row[$key]['device_client'] == 'iphone') {
	                $row[$key]['device_client'] = 'iPhone';
	            } elseif ($row[$key]['device_client'] == 'ipad'){
	                $row[$key]['device_client'] = 'iPad';
	            }
	        }
	    }
	    return array('item' => $row, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'msg_count' => $msg_count);
	}
	
	public function push_message_find($id, $field) {
        if (!empty($field)) {
            return RC_DB::table('push_message')->where('message_id', $id)->select($field)->first();
        } else {
            return RC_DB::table('push_message')->where('message_id', $id)->first();
        }
	}
	
	public function push_message_remove($id, $in = false) {
		$db_push_message = RC_DB::table('push_message');
		if ($in) {
			return $db_push_message->whereIn('message_id', $id)->delete();
		} else {
			return $db_push_message->where('message_id', $id)->delete();
		}
	}
}

// end