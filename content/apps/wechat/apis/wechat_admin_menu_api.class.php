<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台微信公众平台
 * @author royalwang
 */
class wechat_admin_menu_api extends Component_Event_Api
{

    public function call(&$options)
    {
        $menus = ecjia_admin::make_admin_menu('15_content', RC_Lang::get('wechat::wechat.weixin_notice'), '', 18);
        
        $submenus = array(
        	ecjia_admin::make_admin_menu('01_wechat', RC_Lang::get('wechat::wechat.user_manage'), RC_Uri::url('wechat/admin_subscribe/init'), 1)->add_purview('wechat_subscribe_manage'),
        	ecjia_admin::make_admin_menu('02_wechat', RC_Lang::get('wechat::wechat.message_manage'), RC_Uri::url('wechat/admin_message/init'), 2)->add_purview('wechat_subscribe_message_manage'),
        	ecjia_admin::make_admin_menu('03_wechat', RC_Lang::get('wechat::wechat.mass_message'), RC_Uri::url('wechat/admin_mass_message/init'), 3)->add_purview('wechat_message_manage'),
        		
        	ecjia_admin::make_admin_menu('divider', '', '', 5)->add_purview(array('wechat_menus_manage', 'wechat_material_manage', 'wechat_response_manage')),
        	ecjia_admin::make_admin_menu('06_wechat', RC_Lang::get('wechat::wechat.custom_menu'), RC_Uri::url('wechat/admin_menus/init'), 6)->add_purview('wechat_menus_manage'),
        	ecjia_admin::make_admin_menu('07_wechat', RC_Lang::get('wechat::wechat.material_manage'), RC_Uri::url('wechat/admin_material/init', array('type'=>'news', 'material' => 1)), 7)->add_purview('wechat_material_manage'),
        	ecjia_admin::make_admin_menu('08_wechat', RC_Lang::get('wechat::wechat.auto_reply'), RC_Uri::url('wechat/admin_response/reply_subscribe'), 8)->add_purview('wechat_response_manage'),
        	ecjia_admin::make_admin_menu('09_wechat', RC_Lang::get('wechat::wechat.reply_keyword'), RC_Uri::url('wechat/admin_response/reply_keywords'), 9)->add_purview('wechat_response_manage'),
        		
        	ecjia_admin::make_admin_menu('divider', '', '', 10)->add_purview(array('wechat_customer_manage', 'wechat_record_manage')),
        	ecjia_admin::make_admin_menu('11_wechat', RC_Lang::get('wechat::wechat.customer'), RC_Uri::url('wechat/admin_customer/init'), 11)->add_purview('wechat_customer_manage'),
        	ecjia_admin::make_admin_menu('12_wechat', RC_Lang::get('wechat::wechat.service_record'), RC_Uri::url('wechat/admin_record/init'), 12)->add_purview('wechat_record_manage'),
        		
        	ecjia_admin::make_admin_menu('divider', '', '', 13)->add_purview(array('wechat_qrcode_manage', 'wechat_share_manage', 'wechat_oauth_manage', 'wechat_prize_manage', 'wechat_request_manage')),
        	ecjia_admin::make_admin_menu('14_wechat', RC_Lang::get('wechat::wechat.channel_code'), RC_Uri::url('wechat/admin_qrcode/init'), 14)->add_purview('wechat_qrcode_manage'),
        	ecjia_admin::make_admin_menu('15_wechat', RC_Lang::get('wechat::wechat.sweep_recommend'), RC_Uri::url('wechat/admin_share/init'), 15)->add_purview('wechat_share_manage'),
        	ecjia_admin::make_admin_menu('16_wechat', RC_Lang::get('wechat::wechat.accredit_login'), RC_Uri::url('wechat/admin_oauth/info'), 16)->add_purview('wechat_oauth_manage'),
        	ecjia_admin::make_admin_menu('17_wechat', RC_Lang::get('wechat::wechat.draw_record'), RC_Uri::url('wechat/admin_prize/init'), 17)->add_purview('wechat_prize_manage'),
        	ecjia_admin::make_admin_menu('18_wechat', RC_Lang::get('wechat::wechat.api_request'), RC_Uri::url('wechat/admin_request/init'), 18)->add_purview('wechat_request_manage'),
        );
        
        $menus->add_submenu($submenus);
        
        return $menus;
    }
}

// end