<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 发送短信的接口
 * @author royalwang
 */
class push_push_send_api extends Component_Event_Api {
	
    /**
     * @param $options array
     *          $options['user_id'] 用户ID
     *          $options['admin_id'] 管理员ID
     *          $options['device_token'] 设备token
     *          $options['device_client'] 设备类型
     *          $options['custom_fields'] 自定义字段
     *          $options['description'] 推送消息描述
     * @return array
     */
	public function call(&$options) {	    
	    // $user_id, $admin_id, $device_token, $device_client, $priority
	    if (!is_array($options)) {
	        return new ecjia_error('invalid_argument', __('无效参数'));
	    }
	    
	    if (empty($options['user_id']) && empty($options['admin_id']) && empty($options['device_token']) && empty($options['device_client'])) {
	        return new ecjia_error('invalid_argument', __('无效参数'));
	    }
	    
	    if (!isset($options['description']) && !isset($options['msg']) && !isset($options['template_id'])) {
	        return new ecjia_error('invalid_argument', __('无效参数'));
	    }
	    
	    if (isset($options['priority'])) {
	        $priority = $options['priority'];
	    } else {
	        $priority = 1;
	    }

	    RC_Loader::load_app_class('push_send', 'push', false);
	    
	    if (ecjia::config('push_order_placed_apps', ecjia::CONFIG_EXISTS)) {
	        $push_order_placed_apps = ecjia::config('push_order_placed_apps');
	        $apps = explode(',', $push_order_placed_apps);
	        foreach ($apps as $appid) {
				$db_mobile_manage = RC_Model::model('mobile/mobile_manage_model');
				$device_code = $db_mobile_manage->where(array('app_id' => $appid))->get_field('device_code');
	        	if (!empty($options['admin_id'])) {
	        		$device_info = RC_Api::api('mobile', 'device_info', array('admin_id' => $options['admin_id'], 'device_code' => $device_code));
	        	} elseif (!empty($options['user_id'])) {
	        		$device_info = RC_Api::api('mobile', 'device_info', array('user_id' => $options['user_id'], 'device_code' => $device_code));
	        	}
	        	
	        	if (empty($device_info['device_client']) || empty($device_info['device_token'])) {
	        		return new ecjia_error('device_token_not_found' ,__('未找到该用户的Device Token！'));
	        	}
	        	
	            push_send::make($appid)->set_client($device_info['device_client'])->set_field($options['custom_fields'])->send($device_info['device_token'], $options['msg'], $options['msg'], $options['template_id'], $priority);
	        }
	        return true;
	    } else {
	        return false;
	    }
	}
}

// end