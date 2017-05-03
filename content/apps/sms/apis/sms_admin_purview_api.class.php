<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author songqian
 */
class sms_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            array('action_name' => RC_Lang::get('sms::sms.sms_send_manage'), 	'action_code' => 'sms_send_manage', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('sms::sms.sms_history_manage'), 'action_code' => 'sms_history_manage', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('sms::sms.sms_template_manage'),'action_code' => 'sms_template_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('sms::sms.sms_template_update'),'action_code' => 'sms_template_update', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('sms::sms.sms_template_delete'),'action_code' => 'sms_template_delete', 'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('sms::sms.sms_config_manage'), 	'action_code' => 'sms_config_manage', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('sms::sms.sms_config_update'), 	'action_code' => 'sms_config_update', 	'relevance' => '')
        );
        return $purviews;
    }
}

// end