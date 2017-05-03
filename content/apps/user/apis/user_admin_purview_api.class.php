<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class user_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
			array('action_name' => RC_Lang::get('user::users.user_account_manage'), 'action_code' => 'account_manage', 	'relevance' => ''),
			array('action_name' => RC_Lang::get('user::users.surplus_manage'), 		'action_code' => 'surplus_manage', 	'relevance' => 'account_manage'),
        		
			array('action_name' => RC_Lang::get('user::users.user_manage'), 		'action_code' => 'user_manage', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('user::users.user_update'), 		'action_code' => 'user_update', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('user::users.user_delete'), 		'action_code' => 'user_delete', 	'relevance' => ''),
        		
			array('action_name' => RC_Lang::get('user::users.button_remove'), 		'action_code' => 'users_drop', 		'relevance' => 'user_manage'),
			array('action_name' => RC_Lang::get('user::users.user_rank_manage'), 	'action_code' => 'user_rank', 		'relevance' => ''),
			array('action_name' => RC_Lang::get('user::users.sync_users'), 			'action_code' => 'sync_users', 		'relevance' => ''),
			array('action_name' => RC_Lang::get('user::users.integrate_users'), 	'action_code' => 'integrate_users', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('user::users.reg_fields'), 			'action_code' => 'reg_fields', 		'relevance'   => ''),
        );
        return $purviews;
    }
}

// end
