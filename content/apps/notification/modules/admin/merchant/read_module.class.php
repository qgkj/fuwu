<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 消息中心标记为已读
 * @author will.chen
 */
class read_module extends api_admin implements api_interface {
	
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	
    	if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		
    	$message_id = $this->requestData('id');
    	if (empty($message_id)) {
    		return new ecjia_error('invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
    	}
    	
    	$db = RC_DB::table('notifications');
    	if ($_SESSION['staff_id']) {
    		$db->where('notifiable_type', 'orm_staff_user_model')->where('notifiable_id', $_SESSION['staff_id']);
    	} elseif ($_SESSION['admin_id']) {
    	    
    	}
    	$notification_info = $db->where('id', $message_id)->first();
    	if (empty($notification_info)) {
    		return new ecjia_error('notification_not_exists', '该消息不存在！');
    	}
    	if (!empty($notification_info['read_at'])) {
    		return new ecjia_error('notification_already_read', '该消息已读！');
    	} 
    	
    	RC_DB::table('notifications')->where('id', $message_id)->update(array('read_at' => RC_Time::local_date('Y-m-d H:i:s', RC_Time::gmtime())));
    	
		return array();
	 }	
}

// end