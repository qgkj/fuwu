<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class platform_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
        	array('action_name' => RC_Lang::get('platform::platform.platform_list'), 'action_code' => 'platform_config_manage', 	'relevance'   => ''),
        	array('action_name' => RC_Lang::get('platform::platform.platform_add'), 'action_code' => 'platform_config_add', 		'relevance'   => ''),
        	array('action_name' => RC_Lang::get('platform::platform.platform_edit'), 'action_code' => 'platform_config_update', 	'relevance'   => ''),
        	array('action_name' => RC_Lang::get('platform::platform.platform_del'), 'action_code' => 'platform_config_delete', 	'relevance'   => ''),
        		
        	array('action_name' => RC_Lang::get('platform::platform.platform_extend_manage'), 'action_code' => 'platform_extend_manage', 	'relevance'   => ''),
        	array('action_name' => RC_Lang::get('platform::platform.platform_extend_add'), 'action_code' => 'platform_extend_add', 		'relevance'   => ''),
        	array('action_name' => RC_Lang::get('platform::platform.platform_extend_edit'), 'action_code' => 'platform_extend_update', 	'relevance'   => ''),
        	array('action_name' => RC_Lang::get('platform::platform.platform_extend_del'), 'action_code' => 'platform_extend_delete', 	'relevance'   => ''),
        		
        	array('action_name' => RC_Lang::get('platform::platform.function_extension'), 		'action_code' 	=> 'extend_manage', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('platform::platform.function_extension_edit'), 	'action_code' 	=> 'extend_update', 'relevance'   => ''),
        		
        	array('action_name' => RC_Lang::get('platform::platform.command_manage'), 'action_code' => 'platform_command_manage', 	'relevance'   => ''),
        	array('action_name' => RC_Lang::get('platform::platform.command_add'), 'action_code' => 'platform_command_add', 		'relevance'   => ''),
        	array('action_name' => RC_Lang::get('platform::platform.command_edit'), 'action_code' => 'platform_command_update', 	'relevance'   => ''),
        	array('action_name' => RC_Lang::get('platform::platform.command_del'), 'action_code' => 'platform_command_delete', 	'relevance'   => '')
        );
        return $purviews;
    }
}

// end