<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台connect模块权限 
 * @author royalwang
 */
class connect_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            array('action_name' => RC_Lang::get('connect::connect.connect'), 'action_code' => 'connect_users_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('connect::connect.edit'), 	 'action_code' => 'connect_users_update', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('connect::connect.enable'),  'action_code' => 'connect_users_enable', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('connect::connect.disable'), 'action_code' => 'connect_users_disable', 'relevance' => ''),
        );
        
        return $purviews;
    }
}

// end