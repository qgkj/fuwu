<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_installer  extends ecjia_installer {

    protected $dependent = array(
        'ecjia.system'    => '1.0',
    );

    public function __construct() {
        $id = 'ecjia.wechat';
        parent::__construct($id);
    }
    
    
    public function install() {
        $table_name = 'wechat_oauth';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`wechat_id` int(10) unsigned NOT NULL DEFAULT '0'",
                "`oauth_redirecturi` varchar(200) NOT NULL DEFAULT ''",
                "`oauth_count` int(8) unsigned NOT NULL DEFAULT '0'",
                "`oauth_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否开启授权'",
                "`last_time` int(10) unsigned NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`wechat_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_menu';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(10) unsigned NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(10) unsigned NOT NULL DEFAULT '0'",
                "`pid` int(3) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID'",
                "`name` varchar(255) NOT NULL COMMENT '菜单标题'",
                "`type` varchar(10) NOT NULL COMMENT '菜单的响应动作类型'",
                "`key` varchar(255) NOT NULL COMMENT '菜单KEY值，click类型必须'",
                "`url` varchar(255) NOT NULL COMMENT '网页链接，view类型必须'",
                "`sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序'",
                "`status` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '状态'",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_reply';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
                "`id` int(10) NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(11) unsigned NOT NULL",
                "`type` varchar(10) NOT NULL COMMENT '自动回复类型'",
                "`content` varchar(255) DEFAULT NULL",
                "`media_id` int(10) DEFAULT NULL",
                "`rule_name` varchar(180) DEFAULT NULL",
                "`add_time` int(11) unsigned NOT NULL DEFAULT '0'",
                "`reply_type` varchar(10) DEFAULT NULL COMMENT '关键词回复内容的类型'",
        	    "PRIMARY KEY (`id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_rule_keywords';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(11) NOT NULL AUTO_INCREMENT",
                "`rid` int(11) NOT NULL COMMENT '规则id'",
                "`rule_keywords` varchar(255) DEFAULT NULL",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_user';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`uid` int(10) unsigned NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(10) unsigned NOT NULL DEFAULT '0'",
                "`subscribe` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户是否订阅该公众号标识'",
                "`openid` varchar(255) NOT NULL COMMENT '用户的标识'",
                "`nickname` varchar(255) NOT NULL COMMENT '用户的昵称'",
                "`sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '用户的性别'",
                "`city` varchar(255) NOT NULL COMMENT '用户所在城市'",
                "`country` varchar(255) NOT NULL COMMENT '用户所在国家'",
                "`province` varchar(255) NOT NULL COMMENT '用户所在省份'",
                "`language` varchar(50) NOT NULL COMMENT '用户的语言'",
                "`headimgurl` varchar(255) NOT NULL COMMENT '用户头像'",
                "`subscribe_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户关注时间'",
                "`remark` varchar(255) DEFAULT NULL",
                "`privilege` varchar(255) DEFAULT NULL",
                "`unionid` varchar(255) NOT NULL",
                "`group_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户组id'",
                "`ect_uid` int(11) unsigned NOT NULL COMMENT 'ecshop会员id'",
                "`bein_kefu` tinyint(1) unsigned NOT NULL COMMENT '是否处在多客服流程'",
                "PRIMARY KEY (`uid`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_user_group';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(10) unsigned NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(10) unsigned NOT NULL DEFAULT '0'",
                "`group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分组id'",
                "`name` varchar(255) NOT NULL COMMENT '分组名字，UTF8编码'",
                "`count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分组内用户数量'",
                "`sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序'",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_qrcode';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(10) NOT NULL AUTO_INCREMENT",
                "`type` int(1) NOT NULL DEFAULT '0' COMMENT '二维码类型，0临时，1永久'",
                "`expire_seconds` int(4) DEFAULT NULL COMMENT '二维码有效时间'",
                "`scene_id` int(10) NOT NULL COMMENT '场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）'",
                "`username` varchar(60) DEFAULT NULL COMMENT '推荐人'",
                "`function` varchar(255) NOT NULL COMMENT '功能'",
                "`ticket` varchar(255) DEFAULT NULL COMMENT '二维码ticket'",
                "`qrcode_url` varchar(255) DEFAULT NULL COMMENT '二维码路径'",
                "`endtime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间'",
                "`scan_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '扫描量'",
                "`wechat_id` int(10) NOT NULL",
                "`status` int(1) NOT NULL DEFAULT '1' COMMENT '状态'",
                "`sort` int(10) NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        
        $table_name = 'wechat_prize';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(11) unsigned NOT NULL",
                "`openid` varchar(100) NOT NULL",
                "`prize_name` varchar(100) NOT NULL",
                "`issue_status` int(2) NOT NULL DEFAULT '0' COMMENT '发放状态，0未发放，1发放'",
                "`winner` varchar(255) DEFAULT NULL",
                "`dateline` int(11) unsigned NOT NULL DEFAULT '0'",
                "`prize_type` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否中奖，0未中奖，1中奖'",
                "`activity_type` varchar(20) NOT NULL COMMENT '活动类型'",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_point';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`log_id` mediumint(8) unsigned NOT NULL COMMENT '积分增加记录id'",
                "`openid` varchar(100) DEFAULT NULL",
                "`keywords` varchar(100) NOT NULL COMMENT '关键词'",
                "`createtime` int(11) unsigned NOT NULL DEFAULT '0'"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_media';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(10) NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(10) NOT NULL",
                "`title` varchar(255) DEFAULT NULL COMMENT '图文消息标题'",
                "`command` varchar(20) NOT NULL COMMENT '关键词'",
                "`author` varchar(20) DEFAULT NULL",
                "`is_show` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示封面，1为显示，0为不显示'",
                "`digest` varchar(255) DEFAULT NULL COMMENT '图文消息的描述'",
                "`content` text NOT NULL COMMENT '图文消息页面的内容，支持HTML标签'",
                "`link` varchar(255) DEFAULT NULL COMMENT '点击图文消息跳转链接'",
                "`file` varchar(255) DEFAULT NULL COMMENT '图片链接'",
                "`size` int(7) DEFAULT NULL COMMENT '媒体文件上传后，获取时的唯一标识'",
                "`file_name` varchar(255) DEFAULT NULL COMMENT '媒体文件上传时间戳'",
                "`thumb` varchar(255) DEFAULT NULL",
                "`add_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间'",
                "`edit_time` int(11) unsigned NOT NULL DEFAULT '0'",
                "`type` varchar(10) DEFAULT NULL",
                "`article_id` varchar(100) DEFAULT NULL",
                "`sort` int(10) unsigned NOT NULL DEFAULT '0'",
            	"`media_id` varchar(255) NOT NULL",
            	"`is_material` varchar(20) NOT NULL",
            	"`media_url` varchar(255) NOT NULL",
            	"`parent_id` int(10) NOT NULL",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_mass_history';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(11) NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(11) unsigned NOT NULL",
                "`media_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '素材id'",
                "`type` varchar(10) DEFAULT NULL COMMENT '发送内容类型'",
                "`status` varchar(20) DEFAULT NULL COMMENT '发送状态，对应微信通通知状态'",
                "`send_time` int(11) unsigned NOT NULL DEFAULT '0'",
                "`msg_id` varchar(20) DEFAULT NULL COMMENT '微信端返回的消息ID'",
                "`totalcount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'group_id下粉丝数；或者openid_list中的粉丝数'",
                "`filtercount` int(10) unsigned NOT NULL DEFAULT '0'",
                "`sentcount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送成功的粉丝数'",
                "`errorcount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送失败的粉丝数'",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_custom_message';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(10) NOT NULL AUTO_INCREMENT",
                "`uid` int(10) unsigned NOT NULL DEFAULT '0'",
                "`msg` varchar(255) DEFAULT NULL COMMENT '信息内容'",
                "`iswechat` smallint(1) unsigned DEFAULT NULL",
                "`send_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发送时间'",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_customer';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        		"`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT",
        		"`wechat_id` int(10) UNSIGNED NOT NULL DEFAULT '0'",
        		"`kf_id` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '客服工号'",
        		"`kf_account` VARCHAR(100) NOT NULL COMMENT '完整客服账号'",
        		"`kf_nick` VARCHAR(100) NOT NULL COMMENT '客服昵称'",
        		"`kf_headimgurl` VARCHAR(255) NOT NULL COMMENT '客服头像'",
        		"`status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '客服状态'",
        		"`online_status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '客服在线状态'",
        		"`accepted_case` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '客服当前正在接待的会话数'",
        		"`kf_wx` VARCHAR(200) NOT NULL",
        		"`invite_wx` VARCHAR(200) NOT NULL",
        		"`invite_expire_time` int(10) NOT NULL DEFAULT '0'",
        		"`invite_status` VARCHAR(100) NOT NULL",
        		"`file_url` VARCHAR(255) NOT NULL",
        		"PRIMARY KEY (`id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_customer_session';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        		"`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT",
        		"`wechat_id` int(10) UNSIGNED NOT NULL DEFAULT '0'",
        		"`kf_account` VARCHAR(255) NOT NULL COMMENT '客服账号'",
        		"`openid` VARCHAR(255) NOT NULL COMMENT '用户openid'",
        		"`opercode` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '会话状态'",
        		"`text` VARCHAR(255) NOT NULL COMMENT '发送内容'",
        		"`time` int(11) UNSIGNED NOT NULL COMMENT '发送时间'",
        		"PRIMARY KEY (`id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_request_times';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(10) unsigned NOT NULL AUTO_INCREMENT",
                "`wechat_id` int(10) unsigned NOT NULL DEFAULT '0'",
                "`day` date NOT NULL COMMENT '日期'",
                "`api_name` varchar(60) NOT NULL COMMENT 'Api名称'",
                "`times` int(10) NOT NULL COMMENT '限制次数'",
                "`last_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后请求时间'",
                "PRIMARY KEY (`id`)",
                "UNIQUE KEY `day` (`day`,`api_name`,`wechat_id`)",
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_tag';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        		"`id` int(10) unsigned NOT NULL AUTO_INCREMENT",
        		"`wechat_id` int(10) unsigned NOT NULL DEFAULT '0'",
        		"`tag_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '标签id'",
        		"`name` varchar(255) NOT NULL COMMENT '标签名字'",
        		"`count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '标签内用户数量'",
        		"`sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序'",
        		"PRIMARY KEY (`id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'wechat_user_tag';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        		"`userid` int(10) unsigned NOT NULL DEFAULT '0'",
        		"`tagid` int(10) unsigned NOT NULL DEFAULT '0'",
        		"INDEX `userid` (`userid`)",
        		"INDEX `tagid` (`tagid`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        return true;
    }
    
    
    public function uninstall() {
        $table_name = 'wechat_oauth';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_menu';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_reply';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_rule_keywords';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_user';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_user_group';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_qrcode';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_prize';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_point';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_media';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_mass_history';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_custom_message';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_customer';
        if (RC_Model::make()->table_exists($table_name)) {
        	RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_customer_session';
        if (RC_Model::make()->table_exists($table_name)) {
        	RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_request_times';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_tag';
        if (RC_Model::make()->table_exists($table_name)) {
        	RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'wechat_user_tag';
        if (RC_Model::make()->table_exists($table_name)) {
        	RC_Model::make()->drop_table($table_name);
        }
        
        return true;
    }
    
}

// end