<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author songqian
 */
class mail_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            array('action_name' => RC_Lang::get('mail::email_list.email_list'), 		'action_code' => 'email_list_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('mail::email_list.email_list_update'), 	'action_code' => 'email_list_update', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('mail::email_list.email_list_delete'),	'action_code' => 'email_list_delete', 'relevance' => ''),
        		
            array('action_name' => RC_Lang::get('mail::email_list.email_sendlist_manage'), 	'action_code' => 'email_sendlist_manage',	'relevance' => ''),
        	array('action_name' => RC_Lang::get('mail::email_list.email_sendlist_send'), 	'action_code' => 'email_sendlist_send', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('mail::email_list.email_sendlist_delete'), 	'action_code' => 'email_sendlist_delete',	'relevance' => ''),
        		
            array('action_name' => RC_Lang::get('mail::email_list.mail_template_manage'), 'action_code' => 'mail_template_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('mail::email_list.mail_template_update'), 'action_code' => 'mail_template_update', 'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('mail::email_list.mail_template_settings'), 'action_code' => 'mail_settings_manage', 'relevance' => ''),
        );
        
        return $purviews;
    }
}

// end