<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class wechat_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(        		
        	array('action_name' => RC_Lang::get('wechat::wechat.accredit_login'), 'action_code' => 'wechat_oauth_manage', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.edit_accredit_login'), 'action_code' => 'wechat_oauth_update', 'relevance'   => ''),
        		
        	array('action_name' => RC_Lang::get('wechat::wechat.auto_reply_manage'), 'action_code' => 'wechat_response_manage', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.auto_reply_add'), 'action_code' => 'wechat_response_add', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.auto_reply_edit'), 'action_code' => 'wechat_response_update', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.auto_reply_del'), 'action_code' => 'wechat_response_delete', 'relevance'   => ''),
        		
        	array('action_name' => RC_Lang::get('wechat::wechat.custom_menu'), 'action_code' => 'wechat_menus_manage', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.add_menu'), 'action_code' => 'wechat_menus_add', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.edit_menu'), 'action_code' => 'wechat_menus_update', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.del_menu'), 'action_code' => 'wechat_menus_delete', 'relevance'   => ''),
        		
        	array('action_name' => RC_Lang::get('wechat::wechat.message_template'), 'action_code' => 'message_template_manage', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.add_message_template'), 'action_code' => 'message_template_add', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.edit_message_template'), 'action_code' => 'message_template_update', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.del_message_template'), 'action_code' => 'message_template_delete', 'relevance'   => ''),
        		
        	array('action_name' => RC_Lang::get('wechat::wechat.channel_code'), 'action_code' => 'wechat_qrcode_manage', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.add_channel_code'), 'action_code' => 'wechat_qrcode_add', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.edit_channel_code'), 'action_code' => 'wechat_qrcode_update', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.del_channel_code'), 'action_code' => 'wechat_qrcode_delete', 'relevance'   => ''),
        		
        	array('action_name' => RC_Lang::get('wechat::wechat.sweep_recommend'),   'action_code' => 'wechat_share_manage', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.add_code'), 'action_code' => 'wechat_share_add', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.edit_code'), 'action_code' => 'wechat_share_update', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.del_code'), 'action_code' => 'wechat_share_delete', 'relevance'   => ''),
        		
        	array('action_name' => RC_Lang::get('wechat::wechat.material_manage'), 'action_code' => 'wechat_material_manage', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.material_add'), 'action_code' => 'wechat_material_add', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.material_edit'), 'action_code' => 'wechat_material_update', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.material_del'), 'action_code' => 'wechat_material_delete', 'relevance'   => ''),
        	
        	array('action_name' => RC_Lang::get('wechat::wechat.mass_message'), 'action_code' => 'wechat_message_manage', 'relevance'   => ''),
        		
        	array('action_name' => RC_Lang::get('wechat::wechat.user_manage'), 'action_code' => 'wechat_subscribe_manage', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.user_add'), 'action_code' => 'wechat_subscribe_add', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.user_edit'), 'action_code' => 'wechat_subscribe_update', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.user_del'), 'action_code' => 'wechat_subscribe_delete', 'relevance'   => ''),
        		
        	array('action_name' => RC_Lang::get('wechat::wechat.user_message_manage'), 'action_code' => 'wechat_subscribe_message_manage', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.user_message_send'), 'action_code' => 'wechat_subscribe_message_add', 'relevance'   => ''),
        		
        	array('action_name' => RC_Lang::get('wechat::wechat.service_manage'), 'action_code' => 'wechat_customer_manage', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.service_add'), 'action_code' => 'wechat_customer_add', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.service_edit'), 'action_code' => 'wechat_customer_update', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.service_del'), 'action_code' => 'wechat_customer_delete', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.service_record_manage'), 'action_code' => 'wechat_record_manage', 'relevance'   => ''),
        		
        	array('action_name' => RC_Lang::get('wechat::wechat.draw_record'), 'action_code' => 'wechat_prize_manage', 'relevance'   => ''),
        	array('action_name' => RC_Lang::get('wechat::wechat.api_request_manage'), 'action_code' => 'wechat_request_manage', 'relevance'   => ''),
        );
        return $purviews;
    }
}

// end