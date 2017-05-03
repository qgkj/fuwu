<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 消息中心
 * @author will.chen
 */
class notification_module extends api_admin implements api_interface {
	
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        
    	$size = $this->requestData('pagination.count', 15);
    	$page = $this->requestData('pagination.page', 2);
    	
    	$type          = array('Ecjia\System\Notifications\ExpressAssign', 'Ecjia\System\Notifications\ExpressGrab', 'Ecjia\System\Notifications\ExpressPickup', 'Ecjia\System\Notifications\ExpressFinished');
    	$type_label    = array('Ecjia\System\Notifications\ExpressAssign' => 'express_assign', 'Ecjia\System\Notifications\ExpressGrab' => 'express_grab', 'Ecjia\System\Notifications\ExpressPickup' => 'express_pickup', 'Ecjia\System\Notifications\ExpressFinished' => 'express_finished');
    	$record_count  = RC_DB::table('notifications')
                    	->whereIn('type', $type)
                    	->where('notifiable_type', 'orm_staff_user_model')
                    	->where('notifiable_id', $_SESSION['staff_id'])
                    	->count();
    	
    	//实例化分页
    	$page_row              = new ecjia_page($record_count, $size, 6, '', $page);
    	$skip                  = $page_row->start_id-1;
        $notifications_result  = RC_DB::table('notifications')
                                ->whereIn('type', $type)
                                ->where('notifiable_type', 'orm_staff_user_model')
                                ->where('notifiable_id', $_SESSION['staff_id'])
                                ->skip($skip)
                                ->take($size)
                                ->orderBy('created_at', 'dsec')
                                ->get();
        
        $notifications_list = array();
        
        if (!empty($notifications_result)) {
        	$express_order_db = RC_Model::model('express/express_order_viewmodel');
        	foreach ($notifications_result as $val) {
        		$data = json_decode($val['data'], true);
        		
        		$notifications_list[] = array(
        						'id'	        => $val['id'],
        						'type'	        => $type_label[$val['type']],
        						'time'	        => $val['created_at'],
        						'title'	        => $data['title'],
        						'description'	=> $data['body'],
        						'read_status'	=> empty($val['read_at']) ? 'unread' : 'read',
        						'data'	        => $data['data'],
        		);
        	}
        }
        
		$pager = array(
				'total' => $page_row->total_records,
				'count' => $page_row->total_records,
				'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		return array('data' => $notifications_list, 'pager' => $pager);
	 }	
}

// end