<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取移动设置device info
 * @author royalwang
 */
class mobile_device_info_api extends Component_Event_Api {
	
    /**
     * @param $options[array] 
     *          $options['user_id'] 用户ID
     *          $options['admin_id'] 管理员ID
     *
     * @return array
     */
	public function call(&$options) {	
	    $user_id   = isset($options['user_id'])   ? $options['user_id']         : 0;
	    $user_type = isset($options['user_type']) ? trim($options['user_type']) : 'user';
	    
	    if (!empty($user_id)) {
	    	$db = RC_DB::table('mobile_device');
	        $db->where('user_id', $user_id)->where('user_type', $user_type);
	        if (isset($options['device_code']) && !empty($options['device_code'])) {
	        	$db->where('device_code', $options['device_code']);
	        }
	        $db->where('user_type', $user_type);
	        $db->whereNotNull('device_token');
	        
	        $db->orderBy('update_time', 'desc')->orderBy('id', 'desc');
	        return $db->first();
	    }
        
	    return false;
	}
}

// end