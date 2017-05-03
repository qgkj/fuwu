<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

$LANG['num_order']      = '编号';
$LANG['wechat']         = '公众平台';
$LANG['wechat_number']  = '微信号';
$LANG['errcode']        = '错误代码：';
$LANG['errmsg']         = '错误信息：';

//公众平台
$LANG['wechat_num']         = '公众平台帐号';
$LANG['wechat_name']        = '公众号名称';
$LANG['wechat_type']        = '公众号类型';
$LANG['wechat_add_time']    = '添加时间';
$LANG['wechat_status']      = '状态';
$LANG['wechat_manage']      = '功能管理';
$LANG['wechat_type0']       = '未认证的公众号';
$LANG['wechat_type1']       = '订阅号';
$LANG['wechat_type2']       = '服务号';
// $LANG['wechat_type3'] = '认证服务号';
// $LANG['wechat_type4'] = '企业号';
$LANG['wechat_type3']       = '测试帐号';
$LANG['wechat_open']        = '开启';
$LANG['wechat_close']       = '关闭';
$LANG['wechat_register']    = '暂时还没有公众号，模板堂邀您尝试%s添加一个公众号</a>。';
$LANG['wechat_id']          = '公众号原始id';
$LANG['token']              = 'Token';
$LANG['appid']              = 'AppID';
$LANG['appsecret']          = 'AppSecret';
$LANG['wechat_add']         = '新增';
$LANG['wechat_help1']       = '如：ecmoban';
$LANG['wechat_help2']       = '请认真填写，如：gh_845581623321';
$LANG['wechat_help3']       = '自定义的Token值';
$LANG['wechat_help4']       = '用于自定义菜单等高级功能（订阅号不需要填写）';
$LANG['wechat_help5']       = '认证服务号是指向微信官方交过300元认证费的服务号';
$LANG['must_name']          = '请填写公众号名称';
$LANG['must_id']            = '请填写公众号原始ID';
$LANG['must_token']         = '请填写公众号Token';
$LANG['wechat_empty']       = '公众号不存在';
$LANG['open_wechat']        = '请开启公众号';

//关注用户
$LANG['sub_title']          = '关注用户列表';
$LANG['sub_search']         = '请输入昵称、省、市搜索';
$LANG['sub_headimg']        = '头像';
$LANG['sub_openid']         = '微信用户唯一标识(openid)';
$LANG['sub_nickname']       = '昵称';
$LANG['sub_sex']            = '性别';
$LANG['sub_province']       = '省(直辖市)';
$LANG['sub_city']           = '城市';
$LANG['sub_time']           = '关注时间';
$LANG['sub_move']           = '转移';
$LANG['sub_move_sucess']    = '转移成功';
$LANG['sub_group']          = '所在分组';
$LANG['sub_update_user']    = '更新用户信息';
$LANG['send_custom_message'] = '发送客服消息';
$LANG['custom_message_list'] = '客服消息列表';
$LANG['message_content']    = '消息内容';
$LANG['message_time']       = '发送时间';
$LANG['button_send']        = '发送';
$LANG['select_openid']      = '请选择微信用户';
$LANG['sub_help1']          = '只有48小时内给公众号发送过信息的粉丝才能接收到信息';
$LANG['sub_binduser']       = '绑定用户';

//分组
$LANG['group_sys']          = '同步分组信息';
$LANG['group_title']        = '分组管理';
$LANG['group_num']          = '公众平台中的编号';
$LANG['group_name']         = '分组名称';
$LANG['group_fans']         = '粉丝量';
$LANG['group_add']          = '添加分组';
$LANG['group_edit']         = '编辑分组';
$LANG['group_update']       = '更新';
$LANG['group_move']         = '将选中粉丝转移到分组中';

//菜单
$LANG['menu']               = '微信菜单';
$LANG['menu_add']           = '菜单添加';
$LANG['menu_edit']          = '菜单编辑';
$LANG['menu_name']          = '菜单名称';
$LANG['menu_type']          = '菜单类型';
$LANG['menu_parent']        = '父级菜单';
$LANG['menu_select']        = '请选择菜单';
$LANG['menu_click']         = 'click';
$LANG['menu_view']          = 'view';
$LANG['menu_keyword']       = '菜单关键词';
$LANG['menu_url']           = '外链URL';
$LANG['menu_create']        = '生成自定义菜单';
$LANG['menu_show']          = '显示';
$LANG['menu_select_del']    = '请选择需要删除的菜单';
$LANG['menu_help1']         = '如无特殊需要，这里请不要填写 (如果要实现一键拨号，请填写"tel:您的电话号码")';

//二维码
$LANG['qrcode']             = '二维码';
$LANG['qrcode_scene']       = '应用场景';
$LANG['qrcode_scene_value'] = '应用场景值';
$LANG['qrcode_scene_limit'] = '场景值已存在，请重新填写';
$LANG['qrcode_type']        = '二维码类型';
$LANG['qrcode_function']    = '功能';
$LANG['qrcode_short']       = '临时二维码';
$LANG['qrcode_forever']     = '永久二维码';
$LANG['qrcode_get']         = '获取二维码';
$LANG['qrcode_valid_time']  = '有效时间';
$LANG['qrcode_help1']       = '以秒为单位，最大不超过1800，默认1800（永久二维码无效）';
$LANG['qrcode_help2']       = '临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）';

//图文回复
$LANG['article']            = '图文回复';
$LANG['title']              = '标题';
$LANG['please_upload']      = '请上传图片';
$LANG['content']            = '正文';
$LANG['link_err']           = '链接格式不正确';

//扫码引荐
$LANG['share']              = '扫码引荐';
$LANG['share_name']         = '推荐人';
$LANG['share_userid']       = '推荐人ID';
$LANG['share_account']      = '现金分成';
$LANG['scan_num']           = '扫描量';
$LANG['expire_seconds']     = '有效时间';
$LANG['share_help']         = '不填则为无限制';
$LANG['no_limit']           = '无限制';

//end