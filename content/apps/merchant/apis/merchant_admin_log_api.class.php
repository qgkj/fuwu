<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商家日志
 * @author 
 */
class merchant_admin_log_api extends Component_Event_Api {
	public function call(&$options) {	

	    $log_info = ecjia_admin_log::instance()->get_message($options['text'], $options['action'], $options['object']);
	    
	    $data = array(
	        'log_time' 		=> RC_Time::gmtime(),
	        'store_id'		=> !empty($_SESSION['store_id']) ? $_SESSION['store_id'] : 0,
	        'user_id' 		=> !empty($_SESSION['staff_id']) ? $_SESSION['staff_id'] : 0,
	        'log_info' 		=> stripslashes($log_info),
	        'ip_address' 	=> RC_Ip::client_ip(),
	    );
	    
	    if (!empty($data['store_id']) && !empty($data['user_id']) && !empty($data['log_info'])) {
	        return RC_DB::table('staff_log')->insertGetId($data);
	    } else {
	        return false;
	    }
	    
	}
	
}

// end