<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 公众号调用接口每日限制
 */
return array(
	/*获取接口调用凭据*/
	'token' => array(
		'title' => RC_Lang::get('wechat::wechat.get_access_token'),
	    'times' => '2000',
	    'api'   => 'https://api.weixin.qq.com/cgi-bin/token'
	),
	'getcallbackip' => array(
		'title' => RC_Lang::get('wechat::wechat.get_server_ip'),
		'times' => null,
		'api'   => 'https://api.weixin.qq.com/cgi-bin/getcallbackip'
	),
		
	/*自定义菜单*/
    'menu/create' => array(
    	'title' => RC_Lang::get('wechat::wechat.custom_menu_create'),
        'times' => '1000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/create'
    ),
    'menu/get' => array(
    	'title' => RC_Lang::get('wechat::wechat.custom_menu_demadn'),
        'times' => '10000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/get'
    ),
    'menu/delete' => array(
    	'title' => RC_Lang::get('wechat::wechat.custom_menu_del'),
        'times' => '1000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/delete'
    ),
	'menu/addconditional' => array(
		'title' => RC_Lang::get('wechat::wechat.custom_menu_add'),
		'times' => '2000',
		'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/addconditional'
	),
	'menu/delconditional' => array(
		'title' => RC_Lang::get('wechat::wechat.del_individuation_menu'),
		'times' => '2000',
		'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/delconditional'
	),
	'menu/trymatch' => array(
		'title' => RC_Lang::get('wechat::wechat.test_individuation_menu'),
		'times' => '20000',
		'api'   => 'https://api.weixin.qq.com/cgi-bin/menu/trymatch'
	),
	'get_current_selfmenu_info' => array(
		'title' => RC_Lang::get('wechat::wechat.get_individuation_menu'),
		'times' => null,
		'api'   => 'https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info'
	),
		
	/*用户管理*/
    'groups/create' => array(
    	'title' => RC_Lang::get('wechat::wechat.add_user_group'),
        'times' => '1000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/create'
    ),
    'groups/get' => array(
        'title' => RC_Lang::get('wechat::wechat.get_user_group'),
        'times' => '1000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/get'
    ),
	'groups/getid' => array(
		'title' => RC_Lang::get('wechat::wechat.demand_user_group'),
		'times' => null,
		'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/getid'
	),
    'groups/update' => array(
        'title' => RC_Lang::get('wechat::wechat.edit_user_group'),
        'times' => '1000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/update'
    ),
    'groups/members/update' => array(
        'title' => RC_Lang::get('wechat::wechat.move_user_group'),
        'times' => '100000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/members/update'
    ),
    'groups/members/batchupdate' => array(
    	'title' => RC_Lang::get('wechat::wechat.batch_move_user_group'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/members/batchupdate'
    ),
    'groups/delete' => array(
    	'title' => RC_Lang::get('wechat::wechat.del_user_group'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/groups/delete'
    ),
    'user/info/updateremark' => array(
    	'title' => RC_Lang::get('wechat::wechat.set_user_comment'),
    	'times' => '10000',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark'
    ),
    'user/info' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_user_info'),
    	'times' => '5000000',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/user/info'
    ),
    'user/info/batchget' => array(
    	'title' => RC_Lang::get('wechat::wechat.batch_get_user_info'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/user/info/batchget'
    ),
    'user/get' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_attention_list'),
    	'times' => '500',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/user/get'
    ),
    'tags/create' => array(
    	'title' => RC_Lang::get('wechat::wechat.add_label'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/create'
    ),
    'tags/get' => array(
	    'title' => RC_Lang::get('wechat::wechat.get_num_lable'),
	    'times' => null,
	    'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/get'
    ),
    'tags/update' => array(
    	'title' => RC_Lang::get('wechat::wechat.edit_lable'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/update'
    ),
    'tags/delete' => array(
    	'title' => RC_Lang::get('wechat::wechat.del_lable'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/delete'
    ),
    'tags/getidlist' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_user_lable_list'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/getidlist'
    ),
    'tags/members/batchtagging' => array(
    	'title' => RC_Lang::get('wechat::wechat.batch_user_lable'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging'
    ),
    'tags/members/batchuntagging' => array(
    	'title' => RC_Lang::get('wechat::wechat.batch_user_close_lable'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/tags/members/batchuntagging'
    ),
    
    /*发送消息*/
    'customservice/kfaccount/add' => array(
    	'title' => RC_Lang::get('wechat::wechat.add_server_account'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/customservice/kfaccount/add'
    ),
    'customservice/kfaccount/update' => array(
    	'title' => RC_Lang::get('wechat::wechat.edit_server_account'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/customservice/kfaccount/update'
    ),
    'customservice/kfaccount/del' => array(
    	'title' => RC_Lang::get('wechat::wechat.del_server_account'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/customservice/kfaccount/del'
    ),
    'customservice/kfaccount/uploadheadimg' => array(
    	'title' => RC_Lang::get('wechat::wechat.set_server_head'),
    	'times' => null,
    	'api'   => 'http://api.weixin.qq.com/customservice/kfaccount/uploadheadimg'
    ),
    'customservice/getkflist' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_all_server_account'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist'
    ),
    'customservice/getonlinekflist' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_server_online_message'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist'
    ),
    'customservice/kfaccount/inviteworker' => array(
    	'title' => RC_Lang::get('wechat::wechat.invite_bind_server_account'),
    	'times' => null,
    	'api' 	=> 'https://api.weixin.qq.com/cgi-bin/customservice/kfaccount/inviteworker'
    ),
    'message/custom/send' => array(
        'title' => RC_Lang::get('wechat::wechat.send_server_message'),
        'times' => '500000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/message/custom/send'
    ),
    'message/mass/sendall' => array(
    	'title' => RC_Lang::get('wechat::wechat.group_mass_texting'),
    	'times' => '100',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall'
    ),
    'message/mass/send' => array(
    	'title' => RC_Lang::get('wechat::wechat.openid_list_mass_texting'),
    	'times' => '100',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/send'
    ),
    'message/mass/delete' => array(
    	'title' => RC_Lang::get('wechat::wechat.del_mass_texting'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/delete'
    ),
    'message/mass/preview' => array(
    	'title' => RC_Lang::get('wechat::wechat.browse_mes_type'),
    	'times' => '100',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/preview'
    ),
    'message/mass/get' => array(
    	'title' => RC_Lang::get('wechat::wechat.demand_mass_mes_status'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/mass/get'
    ),
    'template/api_set_industry' => array(
    	'title' => RC_Lang::get('wechat::wechat.set_industry'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/template/api_set_industry'
    ),
    'template/api_add_template' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_template_id'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/template/api_add_template'
    ),
    'message/template/send' => array(
    	'title' => RC_Lang::get('wechat::wechat.send_template_message'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/message/template/send'
    ),
    'get_current_autoreply_info' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_auto_rule'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/get_current_autoreply_info'
    ),
    
    /*素材管理*/
    'material/add_news' => array(
    	'title' => RC_Lang::get('wechat::wechat.new_graphic_material'),
    	'times' => '5000',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/add_news'
    ),
    'material/add_material' => array(
    	'title' => RC_Lang::get('wechat::wechat.new_graphic_material'),
    	'times' => '1000',
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/add_material'
    ),
    'material/get_material' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_permanent_material'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/get_material'
    ),
    'material/del_material' => array(
    	'title' => RC_Lang::get('wechat::wechat.del_permanent_material'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/del_material'
    ),
    'material/update_news' => array(
    	'title' => RC_Lang::get('wechat::wechat.edit_permanent_material'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/update_news'
    ),
    'material/get_materialcount' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_material_sum'),
    	'times' => null, //图片和图文消息素材（包括单图文和多图文）的总数上限为5000，其他素材的总数上限为1000
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount'
    ),
    'material/batchget_material' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_material_list'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/material/batchget_material'
    ),
    
    /*账号管理*/
    'qrcode/create' => array(
        'title' => RC_Lang::get('wechat::wechat.add_code_ticket'),
        'times' => '100000',
        'api'   => 'https://api.weixin.qq.com/cgi-bin/qrcode/create'
    ),
    'showqrcode' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_code_ticket'),
    	'times' => null,
    	'api'   => 'https://mp.weixin.qq.com/cgi-bin/showqrcode'
    ),
    'shorturl' => array(
    	'title' => RC_Lang::get('wechat::wechat.long_turn_short'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/shorturl'
    ),
    
    /*数据统计*/
    'datacube/getusersummary' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_add_user_data'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getusersummary'
    ),
    'datacube/getusercumulate' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_accumulative_user_data'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getusercumulate'
    ),
    'datacube/getarticlesummary' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_image_mass_data'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getarticlesummary'
    ),
    'datacube/getarticletotal' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_image_mass_all_data'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getarticletotal'
    ),
    'datacube/getuserread' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_image_statistics_data'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getuserread'
    ),
    'datacube/getuserreadhour' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_image_statistics_time'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getuserreadhour'
    ),
    'datacube/getusershare' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_image_statistics_share'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getusershare'
    ),
    'datacube/getusersharehour' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_image_statistics_share_time'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/datacube/getusersharehour'
    ),
    
    /*微信JS-SDK*/
    'ticket/getticket' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_api_ticket'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/ticket/getticket'
    ),
    
    /*微信门店*/
    'media/uploadimg' => array(
    	'title' => RC_Lang::get('wechat::wechat.put_store_image'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/media/uploadimg'
    ),
    'poi/addpoi' => array(
    	'title' => RC_Lang::get('wechat::wechat.found_store'),
    	'times' => null,
    	'api'   => 'http://api.weixin.qq.com/cgi-bin/poi/addpoi'
    ),
    'poi/getpoi' => array(
    	'title' => RC_Lang::get('wechat::wechat.demand_store_info'),
    	'times' => null,
    	'api'   => 'http://api.weixin.qq.com/cgi-bin/poi/getpoi'
    ),
    'poi/getpoilist' => array(
   		'title' => RC_Lang::get('wechat::wechat.demand_store_list'),
   		'times' => null,
   		'api'   => 'https://api.weixin.qq.com/cgi-bin/poi/getpoilist'
    ),
    'poi/updatepoi' => array(
   		'title' => RC_Lang::get('wechat::wechat.edit_store_service_info'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/poi/updatepoi'
    ),
    'poi/delpoi' => array(
   		'title' => RC_Lang::get('wechat::wechat.del_store'),
   		'times' => null,
    	'api'   => 'https://api.weixin.qq.com/cgi-bin/poi/delpoi'
    ),
    'poi/getwxcategory' => array(
    	'title' => RC_Lang::get('wechat::wechat.store_class_list'),
    	'times' => null,
    	'api'   => 'http://api.weixin.qq.com/cgi-bin/poi/getwxcategory'
    ),
    
    /*微信智能接口*/
    'semantic/semproxy/search' => array(
    	'title' => RC_Lang::get('wechat::wechat.send_semantic_request'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/semantic/semproxy/search'
    ),
    
  	/*微信摇一摇周边*/
    'account/register' => array(
    	'title' => RC_Lang::get('wechat::wechat.apply_yiy_rim'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/account/register'
    ),
    'device/applyid' => array(
    	'title' => RC_Lang::get('wechat::wechat.apply_facility_id'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/applyid'
    ),
    'device/applystatus' => array(
    	'title' => RC_Lang::get('wechat::wechat.demand_facility_status'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/applystatus'
    ),
    'device/update' => array(
    	'title' => RC_Lang::get('wechat::wechat.edit_facility_info'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/update'
    ),
    'device/bindlocation' => array(
    	'title' => RC_Lang::get('wechat::wechat.facility_sotre_user'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/bindlocation'
    ),
    'device/search' => array(
    	'title' => RC_Lang::get('wechat::wechat.deman_facility_list'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/search'
    ),
    'page/add' => array(
    	'title' => RC_Lang::get('wechat::wechat.add_page'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/page/add'
    ),
    'page/update' => array(
    	'title' => RC_Lang::get('wechat::wechat.edit_page_message'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/page/update'
    ),
    'page/search' => array(
    	'title' => RC_Lang::get('wechat::wechat.demand_page_list'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/page/search'
    ),
    'page/delete' => array(
    	'title' => RC_Lang::get('wechat::wechat.del_page'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/page/delete'
    ),
    'material/add' => array(
    	'title' => RC_Lang::get('wechat::wechat.upload_image_material'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/material/add'
    ),
    'device/bindpage' => array(
    	'title' => RC_Lang::get('wechat::wechat.facility_store_relation'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/bindpage'
    ),
    'relation/search' => array(
    	'title' => RC_Lang::get('wechat::wechat.demand_facility_store_relation'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/relation/search'
    ),
    'user/getshakeinfo' => array(
    	'title' => RC_Lang::get('wechat::wechat.demand_yiy_facility_user_info'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/user/getshakeinfo'
    ),
    'statistics/device' => array(
    	'title' => RC_Lang::get('wechat::wechat.facility_user_data_statistics'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/statistics/device'
    ),
    'statistics/devicelist' => array(
    	'title' => RC_Lang::get('wechat::wechat.batch_demand_fac_mes'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/statistics/devicelist'
    ),
    'statistics/page' => array(
    	'title' => RC_Lang::get('wechat::wechat.page_data_statistics'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/statistics/page'
    ),
    'statistics/pagelist' => array(
    	'title' => RC_Lang::get('wechat::wechat.batch_demand_page_data'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/statistics/pagelist'
    ),
    'lottery/addlotteryinfo' => array(
    	'title' => RC_Lang::get('wechat::wechat.add_packet_activity'),
    	'times' => null,
    	'api'   => ' https://api.weixin.qq.com/shakearound/lottery/addlotteryinfo'
    ),
    'lottery/setprizebucket' => array(
    	'title' => RC_Lang::get('wechat::wechat.record_packet_info'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/lottery/setprizebucket'
    ),
    'lottery/setlotteryswitch' => array(
    	'title' => RC_Lang::get('wechat::wechat.set_packet_open_close'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/lottery/setlotteryswitch'
    ),
    'lottery/querylottery' => array(
    	'title' => RC_Lang::get('wechat::wechat.demand_packet'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/lottery/querylottery'
    ),
    'device/group/add' => array(
    	'title' => RC_Lang::get('wechat::wechat.add_facility_group'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/add'
    ),
    'device/group/update' => array(
    	'title' => RC_Lang::get('wechat::wechat.edit_facility_group'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/update'
    ),
    'device/group/delete' => array(
    	'title' => RC_Lang::get('wechat::wechat.del_facility_group'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/delete'
    ),
    'device/group/getlist' => array(
    	'title' => RC_Lang::get('wechat::wechat.demand_facility_group_list'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/getlist'
    ),
    'device/group/getdetail' => array(
    	'title' => RC_Lang::get('wechat::wechat.demand_facility_info'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/getdetail'
    ),
    'device/group/adddevice' => array(
    	'title' => RC_Lang::get('wechat::wechat.add_facility_fgroup'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/adddevice'
    ),
    'device/group/deletedevice' => array(
    	'title' => RC_Lang::get('wechat::wechat.del_facility_fgroup'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/shakearound/device/group/deletedevice'
    ),
    'openplugin/token' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_wifi_token'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/openplugin/token'
    ),
    
    /*微信连Wi-Fi*/
    'shop/list' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_wifi_store_list'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/shop/list'
    ),
    'shop/get' => array(
    	'title' => RC_Lang::get('wechat::wechat.demand_wifi_info'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/shop/get'
    ),
    'shop/update' => array(
    	'title' => RC_Lang::get('wechat::wechat.edit_store_int_info'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/shop/update'
    ),
    'shop/clean' => array(
    	'title' => RC_Lang::get('wechat::wechat.empty_store_int_facility'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/shop/clean'
    ),
    'device/add' => array(
    	'title' => RC_Lang::get('wechat::wechat.add_pass_wifi'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/device/add'
    ),
    'device/list' => array(
    	'title' => RC_Lang::get('wechat::wechat.demand_wifi_fac'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/device/list'
    ),
    'device/delete' => array(
    	'title' => RC_Lang::get('wechat::wechat.del_wifi_fac'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/device/delete'
    ),
    'qrcode/get' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_material_code'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/qrcode/get'
    ),
    'account/get_connecturl' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_num_int_url'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/account/get_connecturl'
    ),
    'homepage/set' => array(
    	'title' => RC_Lang::get('wechat::wechat.set_store_page'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/homepage/set'
    ),
    'homepage/get' => array(
    	'title' => RC_Lang::get('wechat::wechat.demand_store_page'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/homepage/get'
    ),
    'bar/set' => array(
    	'title' => RC_Lang::get('wechat::wechat.set_top_entrance'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/bar/set'
    ),
    'statistics/list' => array(
    	'title' => RC_Lang::get('wechat::wechat.wifi_data'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/bizwifi/statistics/list'
    ),
    
    /*微信扫一扫*/
    'merchantinfo/get' => array(
    	'title' => RC_Lang::get('wechat::wechat.get_sotre_infom'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/merchantinfo/get'
    ),
    'product/create' => array(
    	'title' => RC_Lang::get('wechat::wechat.create_goods'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/create'
    ),
    'product/modstatus' => array(
    	'title' => RC_Lang::get('wechat::wechat.check_close_goods'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/modstatus'
    ),
    'testwhitelist/set' => array(
    	'title' => RC_Lang::get('wechat::wechat.test_write_list'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/testwhitelist/set'
    ),
    'product/getqrcode' => array(
    	'title' => RC_Lang::get('wechat::wechat.demand_goods_code'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/getqrcode'
    ),
    'product/get' => array(
    	'title' => RC_Lang::get('wechat::wechat.demand_goods_info'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/get'
    ),
    'product/getlist' => array(
    	'title' => RC_Lang::get('wechat::wechat.batch_demand_goods_info'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/getlist'
    ),
    'product/update' => array(
    	'title' => RC_Lang::get('wechat::wechat.updata_goods_info'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/update'
    ),
    'product/clear' => array(
    	'title' => RC_Lang::get('wechat::wechat.clean_goods_info'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/product/clear'
    ),
    'scanticket/check' => array(
    	'title' => RC_Lang::get('wechat::wechat.wxticket_parameter'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/scan/scanticket/check'
    ),
    'sns/oauth2/access_token' => array(
        'title' => RC_Lang::get('wechat::wechat.get_page_access_token'),
        'times' => null,
        'api'   => 'https://api.weixin.qq.com/sns/oauth2/access_token'
    ),
    'sns/oauth2/refresh_token' => array(
        'title' => RC_Lang::get('wechat::wechat.refresh_page_access_token'),
        'times' => null,
        'api'   => 'https://api.weixin.qq.com/sns/oauth2/refresh_token'
    ),
    'sns/userinfo' => array(
        'title' => RC_Lang::get('wechat::wechat.page_access_user_info'),
        'times' => null,
        'api'   => 'https://api.weixin.qq.com/sns/userinfo'
    ),
    'sns/auth' => array(
    	'title' => RC_Lang::get('wechat::wechat.check_access_token'),
    	'times' => null,
    	'api'   => 'https://api.weixin.qq.com/sns/auth'
    ),
);

//end