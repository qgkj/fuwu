<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 发送短信的接口
 * @author royalwang
 */
class sms_sms_send_api extends Component_Event_Api {
	
    /**
     * @param $options[array] 
     *          $options['tpl_name'] 模板代码
     *
     * @return array
     */
	public function call(&$options) {	
	    
	    // $mobile, $msg, $template, $priority
		
	    if (!is_array($options)) {
	        return new ecjia_error('invalid_argument', __('无效参数'));
	    }
	    
	    if (!isset($options['mobile']) && !isset($options['msg']) && !isset($options['template_id'])) {
	        return new ecjia_error('invalid_argument', __('无效参数'));
	    }
	    
	    if (isset($options['priority'])) {
	        $priority = $options['priority'];
	    } else {
	        $priority = 1;
	    }

	    RC_Loader::load_app_class('sms_send', 'sms');
	    return sms_send::make()->send($options['mobile'], $options['msg'], $options['template_id'], $priority);
	}
}

// end