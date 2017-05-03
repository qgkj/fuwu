<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class push_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            array('action_name' => RC_Lang::get('push::push.push_msg'), 	'action_code' => 'push_message',	'relevance' => ''),
        	array('action_name' => RC_Lang::get('push::push.remove_msg'), 	'action_code' => 'push_delete', 	'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('push::push.push_event_manage'), 	'action_code' => 'push_event_manage', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('push::push.push_event_update'), 	'action_code' => 'push_event_update', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('push::push.push_event_delete'), 	'action_code' => 'push_event_delete', 	'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('push::push.push_history_manage'), 	'action_code' => 'push_history_manage', 	'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('push::push.push_template_manage'), 'action_code' => 'push_template_manage', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('push::push.push_template_update'), 'action_code' => 'push_template_update', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('push::push.push_template_delete'), 'action_code' => 'push_template_delete', 	'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('push::push.push_config_manage'), 	'action_code' => 'push_config_manage', 		'relevance' => '')
        );
        return $purviews;
    }
}

// end