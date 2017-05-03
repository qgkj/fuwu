<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_installer extends ecjia_installer {

    protected $dependent = array(
        'ecjia.system' => '1.0',
    );

    public function __construct() {
        $id = 'ecjia.mobile';
        parent::__construct($id);
    }
    
    public function install() {
    	/* 设备信息*/
        $table_name = 'mobile_device';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
                "`device_udid` char(40) NOT NULL DEFAULT ''",
                "`device_client` char(10) NOT NULL DEFAULT ''",
                "`device_code` char(4) NOT NULL DEFAULT ''",
                "`device_name` varchar(30) DEFAULT NULL",
                "`device_alias` varchar(30) DEFAULT NULL",
                "`device_token` char(64) DEFAULT NULL",
                "`device_os` varchar(30) DEFAULT NULL",
            	"`device_type` varchar(30) DEFAULT NULL",
                "`user_id` int(9) NOT NULL DEFAULT '0'",
                "`is_admin` tinyint(1) NOT NULL DEFAULT '0'",
                "`location_province` varchar(20) DEFAULT NULL",
                "`location_city` varchar(20) DEFAULT NULL",
            	"`visit_times` int(10) NOT NULL",
                "`in_status` tinyint(1) NOT NULL",
                "`add_time` int(10) NOT NULL",
            	"`update_time` int(10) NOT NULL",
                "PRIMARY KEY (`id`)",
                "UNIQUE KEY `device_udid` (`device_udid`,`device_client`,`device_code`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        /* 今日热点*/
        $table_name = 'mobile_news';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			"`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
        			"`group_id` int(11) NOT NULL",
        			"`title` varchar(100) DEFAULT NULL",
        			"`description` varchar(255) DEFAULT NULL",
        			"`image` varchar(100) DEFAULT NULL",
        			"`content_url` varchar(100) DEFAULT NULL",
        			"`type` char(10) NOT NULL DEFAULT ''",
        			"`status` tinyint(3) NOT NULL DEFAULT '0'",
        			"`create_time` int(10) NOT NULL",
        			"PRIMARY KEY (`id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        
        $table_name = 'mobile_message';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			"`message_id` int(11) unsigned NOT NULL AUTO_INCREMENT",
        			"`sender_id` int(11) NOT NULL DEFAULT '0'",
        			"`sender_admin` tinyint(1) NOT NULL",
        			"`receiver_id` int(11) NOT NULL DEFAULT '0'",
        			"`receiver_admin` tinyint(1) NOT NULL",
        			"`send_time` int(11) unsigned NOT NULL DEFAULT '0'",
        			"`read_time` int(11) unsigned NOT NULL DEFAULT '0'",
        			"`readed` tinyint(1) unsigned NOT NULL DEFAULT '0'",
        			"`deleted` tinyint(1) unsigned NOT NULL DEFAULT '0'",
        			"`title` varchar(150) NOT NULL DEFAULT ''",
        			"`message` text NOT NULL",
        			"`message_type` varchar(25) NOT NULL",
        			"PRIMARY KEY (`message_id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
		
        /* 客户端管理*/
        $table_name = 'mobile_manage';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`app_id` int(10) unsigned NOT NULL AUTO_INCREMENT",
                "`app_name` varchar(100) NOT NULL DEFAULT '' COMMENT '应用名称'",
                "`bundle_id` varchar(100) NOT NULL DEFAULT '' COMMENT 'app包名'",
                "`app_key` varchar(100) NOT NULL DEFAULT '' COMMENT 'appkey'",
                "`app_secret` varchar(100) NOT NULL DEFAULT '' COMMENT 'AppSecret'",
                "`device_code` char(4) NOT NULL",
                "`device_client` char(10) NOT NULL DEFAULT ''",
                "`platform` varchar(50) NOT NULL DEFAULT '' COMMENT '服务平台名称'",
                "`add_time` int(10) unsigned NOT NULL DEFAULT '0'",
                "`status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态'",
                "`sort` smallint(4) unsigned NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`app_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /* 今日头条*/
        $table_name = 'mobile_toutiao';
    	if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
                "`title` varchar(100) DEFAULT NULL",
                "`tag` varchar(20) DEFAULT NULL",
                "`description` varchar(255) DEFAULT NULL",
                "`image` varchar(100) DEFAULT NULL",
                "`content_url` varchar(100) DEFAULT NULL",
                "`sort_order` smallint(4) unsigned NOT NULL DEFAULT '100'",
                "`status` tinyint(1) unsigned NOT NULL DEFAULT '1'",
                "`create_time` int(10) unsigned NOT NULL DEFAULT '0'",
                "`update_time` int(10) unsigned NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /* 扫码登录*/
        $table_name = 'qrcode_validate';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			"`user_id` int(40) NOT NULL COMMENT 'user_id'",
        			"`is_admin` bit(1) NOT NULL COMMENT '是否是管理员'",
        			"`uuid` varchar(20) NOT NULL COMMENT 'code'",
        			"`status` tinyint(4) NOT NULL COMMENT '状态'",
        			"`expires_in` int(11) NOT NULL COMMENT '有效期'",
        			"`device_udid` char(40) DEFAULT NULL",
        			"`device_client` char(10) DEFAULT NULL",
        			"`device_code` char(4) DEFAULT NULL",
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /* 签到*/
        $table_name = 'mobile_checkin';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			 "`id` int(10) unsigned NOT NULL AUTO_INCREMENT",
					 "`user_id` int(10) unsigned DEFAULT NULL COMMENT '用户id'",
					 "`checkin_time` int(10) unsigned DEFAULT NULL COMMENT '签到时间'",
					 "`integral` int(10) unsigned DEFAULT NULL COMMENT '签到获取积分'",
					 "`source` varchar(20) DEFAULT NULL COMMENT '签到来源'",
					 "PRIMARY KEY (`id`)",
					 "KEY `user_id` (`user_id`)",
					 "KEY `checkin_time` (`checkin_time`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /* 催单提醒*/
        $table_name = 'order_reminder';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			 "`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
					 "`order_id` int(11) NOT NULL",
					 "`message` varchar(255) DEFAULT NULL",
					 "`status` varchar(100) DEFAULT NULL",
					 "`create_time` int(10) NOT NULL",
					 "`confirm_time` int(10) NOT NULL",
					 "PRIMARY KEY (`id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /*摇一摇活动表*/
        $table_name = 'mobile_activity';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			"`activity_id` int(10)  NOT NULL AUTO_INCREMENT",
        			"`activity_name` varchar(20) NOT NULL DEFAULT '' COMMENT '活动名称'",
        			"`activity_group` tinyint(4) NOT NULL DEFAULT '0' COMMENT '活动组（1、摇一摇）'",
        			"`activity_desc` text NOT NULL COMMENT '活动规则描述'",
        			"`activity_object` int(10) unsigned NOT NULL COMMENT '活动对象（app，pc，touch等）'",
        			"`limit_num` tinyint(4) NOT NULL DEFAULT '0' COMMENT '活动限制次数（0为不限制）'",
        			"`limit_time` int(10) NOT NULL DEFAULT '0' COMMENT '多少时间内活动限制（0为在活动时间内，否则多少时间内限制，单位：分钟）'",
        			"`start_time` int(10) unsigned DEFAULT NULL COMMENT '活动开始时间'",
        			"`end_time` int(10) unsigned DEFAULT NULL COMMENT '活动结束时间'",
        			"`add_time` int(10) unsigned DEFAULT NULL COMMENT '创建时间'",
        			"`enabled` tinyint(4) DEFAULT NULL COMMENT '是否使用，1开启，0禁用'",
        			"PRIMARY KEY (`activity_id`)",
        			"KEY `activity_group` (`activity_group`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /*活动日志表*/
        $table_name = 'mobile_activity_log';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        		  "`id` int(10) unsigned NOT NULL AUTO_INCREMENT",
				  "`activity_id` int(10) unsigned NOT NULL COMMENT '活动id'",
				  "`user_id` int(10) unsigned NOT NULL COMMENT '会员id'",
				  "`username` varchar(25) NOT NULL COMMENT '会员名称'",
				  "`prize_id` int(10) unsigned NOT NULL COMMENT '奖品池id'",
				  "`prize_name` varchar(30) NOT NULL COMMENT '奖品名称'",
				  "`issue_status` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '发放状态，0未发放，1发放'",
				  "`issue_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '（奖品）发放时间'",
				  "`issue_extend` text COMMENT '需线下延期发放的扩展信息（序列化）'",
				  "`add_time` int(10) unsigned DEFAULT NULL COMMENT '抽奖时间'",
				  "`source` varchar(20) DEFAULT NULL COMMENT '来源（app，touch，pc等）'",
				  "PRIMARY KEY (`id`)",
				  "KEY `activity_id` (`activity_id`)",
				  "KEY `prize_id` (`prize_id`)",
				  "KEY `user_id` (`user_id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        /*活动奖品表*/
        $table_name = 'mobile_activity_prize';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        		  "`prize_id` int(10) unsigned NOT NULL AUTO_INCREMENT",
				  "`activity_id` int(10) unsigned NOT NULL COMMENT '活动id'",
				  "`prize_level` tinyint(4) unsigned DEFAULT '0' COMMENT '奖项等级（从0开始，0为大奖，依此类推）'",
				  "`prize_name` varchar(30) NOT NULL DEFAULT '' COMMENT '奖品名称'",
				  "`prize_type` int(10) unsigned NOT NULL COMMENT '奖品类型'",
				  "`prize_value` varchar(30) NOT NULL DEFAULT '' COMMENT '对应奖品信息（id或数量）'",
				  "`prize_number` int(10) NOT NULL DEFAULT '0' COMMENT '奖品数量（goods与nothing设置无效）'",
				  "`prize_prob` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '奖品数量（概率，总共100%）'",
				  "PRIMARY KEY (`prize_id`)",
				  "KEY `activity_id` (`activity_id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        RC_Loader::load_app_class('mobile_method', 'mobile');
        if (!ecjia_config::instance()->check_group('mobile')) {
            ecjia_config::instance()->add_group('mobile', 10);
        }
        
        if (!ecjia::config(mobile_method::STORAGEKEY_discover_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('mobile', mobile_method::STORAGEKEY_discover_data, serialize(array()), array('type' => 'hidden'));
        }
        if (!ecjia::config(mobile_method::STORAGEKEY_shortcut_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('mobile', mobile_method::STORAGEKEY_shortcut_data, serialize(array()), array('type' => 'hidden'));
        }
        if (!ecjia::config(mobile_method::STORAGEKEY_cycleimage_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('mobile', mobile_method::STORAGEKEY_cycleimage_data, serialize(array()), array('type' => 'hidden'));
        }
        if (!ecjia::config(mobile_method::STORAGEKEY_cycleimage_phone_data, ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', mobile_method::STORAGEKEY_cycleimage_phone_data, serialize(array()), array('type' => 'hidden'));
        }
        //应用二维码图片
        if (!ecjia::config('mobile_iphone_qrcode', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_iphone_qrcode', '', array('type' => 'file', 'store_dir' => 'data/assets/'));
        }
        if (!ecjia::config('mobile_ipad_qrcode', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_ipad_qrcode', '', array('type' => 'file', 'store_dir' => 'data/assets/'));
        }
        if (!ecjia::config('mobile_android_qrcode', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_android_qrcode', '', array('type' => 'file', 'store_dir' => 'data/assets/'));
        }
        
        if (!ecjia::config('mobile_launch_adsense', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('mobile', 'mobile_launch_adsense', '', array('type' => 'manual'));
        }
        if (!ecjia::config('mobile_tv_adsense_group', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('mobile', 'mobile_tv_adsense_group', '', array('type' => 'manual'));
        }
        if (!ecjia::config('mobile_home_adsense_group', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_home_adsense_group', '', array('type' => 'manual'));
        }
        if (!ecjia::config('mobile_recommend_city', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_recommend_city', '', array('type' => 'manual'));
        }
        /* pad 登录页颜色设置*/
        if (!ecjia::config('mobile_pad_login_fgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_pad_login_fgcolor', '', array('type' => 'color'));
        }
        if (!ecjia::config('mobile_pad_login_bgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_pad_login_bgcolor', '', array('type' => 'color'));
        }
        if (!ecjia::config('mobile_pad_login_bgimage', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_pad_login_bgimage', '', array('type' => 'file', 'store_dir' => 'data/assets/'));
        }
        /* 手机  登录页颜色设置*/
        if (!ecjia::config('mobile_phone_login_fgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_phone_login_fgcolor', '', array('type' => 'color'));
        }
        if (!ecjia::config('mobile_phone_login_bgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_phone_login_bgcolor', '', array('type' => 'color'));
        }
        if (!ecjia::config('mobile_phone_login_bgimage', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_phone_login_bgimage', '', array('type' => 'file', 'store_dir' => 'data/assets/'));
        }
        
        if (!ecjia::config('bonus_readme_url', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'bonus_readme_url', '', array('type' => 'text'));
        }
        if (!ecjia::config('mobile_feedback_autoreply', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_feedback_autoreply', '', array('type' => 'textarea'));
        }
        if (!ecjia::config('mobile_topic_adsense', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_topic_adsense', '', array('type' => 'manual'));
        }
        if (!ecjia::config('mobile_app_icon', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_app_icon', '', array('type' => 'file', 'store_dir' => 'data/assets/'));
        }
        
        if (!ecjia::config('checkin_award_open', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'checkin_award_open', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('checkin_award_type', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'checkin_award_type', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('checkin_award', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'checkin_award', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('checkin_extra_day', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'checkin_extra_day', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('checkin_extra_award', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'checkin_extra_award', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('comment_award_open', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'comment_award_open', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('comment_award', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'comment_award', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('comment_award_rules', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'comment_award_rules', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('order_reminder_type', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'order_reminder_type', 0, array('type' => 'select'));
        }
        
        if (!ecjia::config('order_reminder_value', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'order_reminder_value', '', array('type' => 'hidden'));
        }
        
		/*分享链接*/   
    	if (!ecjia::config('mobile_share_link', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('mobile', 'mobile_share_link', '', array('type' => 'text'));
        }
        
        return true;
    }
    
    
    public function uninstall() {
        $table_name = 'mobile_device';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'mobile_news';
        if (RC_Model::make()->table_exists($table_name)) {
        	RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'mobile_message';
        if (RC_Model::make()->table_exists($table_name)) {
        	RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'mobile_manage';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
    	$table_name = 'mobile_toutiao';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        RC_Loader::load_app_class('mobile_method', 'mobile');
        if (ecjia_config::instance()->check_group('mobile')) {
            ecjia_config::instance()->delete_group('mobile');
        }
        
        if (ecjia::config(mobile_method::STORAGEKEY_discover_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config(mobile_method::STORAGEKEY_discover_data);
        }
        if (ecjia::config(mobile_method::STORAGEKEY_shortcut_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config(mobile_method::STORAGEKEY_shortcut_data);
        }
        if (ecjia::config(mobile_method::STORAGEKEY_cycleimage_data, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config(mobile_method::STORAGEKEY_cycleimage_data);
        }
        
        if (ecjia::config('mobile_iphone_qrcode', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_iphone_qr_code');
        }
        if (ecjia::config('mobile_ipad_qrcode', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_ipad_qr_code');
        }
        if (ecjia::config('mobile_android_qrcode', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_android_qr_code');
        }
        if (ecjia::config('mobile_launch_adsense', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('mobile_launch_adsense');
        }
        if (ecjia::config('mobile_tv_adsense_group', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('mobile_tv_adsense_group');
        }
        
        if (ecjia::config('mobile_home_adsense_group', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_home_adsense_group');
        }
        if (ecjia::config('mobile_recommend_city', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_recommend_city');
        }
        /* 删除pad 登录页颜色设置*/
        if (ecjia::config('mobile_pad_login_fgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_pad_login_fgcolor');
        }
        if (ecjia::config('mobile_pad_login_bgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_pad_login_bgcolor');
        }
        if (ecjia::config('mobile_pad_login_bgimage', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_pad_login_bgimage');
        }
        /* 删除手机  登录页颜色设置*/
        if (ecjia::config('mobile_phone_login_fgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_phone_login_fgcolor');
        }
        if (ecjia::config('mobile_phone_login_bgcolor', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_phone_login_bgcolor');
        }
        if (ecjia::config('mobile_phone_login_bgimage', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_phone_login_bgimage');
        }
        
        if (ecjia::config('bonus_readme_url', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('bonus_readme_url');
        }
        if (ecjia::config('mobile_feedback_autoreply', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_feedback_autoreply');
        }
        if (ecjia::config('mobile_topic_adsense', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_topic_adsense');
        }
        if (ecjia::config('mobile_app_icon', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_app_icon');
        }
        /*分享链接*/
        if (ecjia::config('mobile_share_link', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('mobile_share_link');
        }
        return true;
    }
    
}

// end