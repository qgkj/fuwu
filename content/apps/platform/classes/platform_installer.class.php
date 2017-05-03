<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class platform_installer  extends ecjia_installer {

    protected $dependent = array(
        'ecjia.system'    => '1.0',
    );

    public function __construct() {
        $id = 'ecjia.platform';
        parent::__construct($id);
    }
    
    public function install() {
        $table_name = 'platform_account';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(10) unsigned NOT NULL AUTO_INCREMENT",
                "`uuid` varchar(60) NOT NULL COMMENT '唯一标识'",
                "`platform` varchar(30) NOT NULL DEFAULT '' COMMENT '平台'",
                "`type` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '公众号类型'",
                "`shop_id` int(10) NOT NULL DEFAULT '0'",
                "`name` varchar(100) NOT NULL DEFAULT '' COMMENT '公众号名称'",
                "`logo` varchar(100) DEFAULT ''",
                "`token` varchar(100) NOT NULL DEFAULT '' COMMENT 'Token'",
                "`aeskey` varchar(100) NOT NULL DEFAULT ''",
                "`appid` varchar(100) NOT NULL DEFAULT '' COMMENT 'AppID'",
                "`appsecret` varchar(100) NOT NULL DEFAULT '' COMMENT 'AppSecret'",
                "`add_time` int(10) unsigned NOT NULL DEFAULT '0'",
                "`sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序'",
                "`status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态'",
                "PRIMARY KEY (`id`)",
                "UNIQUE KEY `uuid` (`uuid`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'platform_command';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`cmd_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT",
                "`cmd_word` varchar(20) DEFAULT NULL COMMENT '关键字'",
                "`account_id` int(10) NOT NULL",
                "`platform` varchar(30) NOT NULL DEFAULT '' COMMENT '平台'",
                "`ext_code` varchar(30) NOT NULL DEFAULT '' COMMENT '插件标识符'",
                "`sub_code` varchar(30) NOT NULL DEFAULT '' COMMENT '子命令'",
                "PRIMARY KEY (`cmd_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'platform_extend';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
                "`ext_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '扩展id'",
                "`ext_name` varchar(120) NOT NULL DEFAULT '' COMMENT '扩展名称'",
                "`ext_desc` text NOT NULL COMMENT '扩展描述'",
                "`ext_code` varchar(30) NOT NULL DEFAULT '' COMMENT '扩展关键字'",
                "`ext_config` text NOT NULL COMMENT '扩展配置'",
                "`enabled` tinyint(4) UNSIGNED NOT NULL DEFAULT '1' COMMENT '是否安装，1开启，0禁用'",
                "PRIMARY KEY (`ext_id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'platform_config';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`account_id` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0'",
                "`ext_code` VARCHAR(30) NOT NULL DEFAULT '' COMMENT '扩展关键字'",
                "`ext_config` TEXT NOT NULL COMMENT '扩展配置'",
                "PRIMARY KEY (`account_id`, `ext_code`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        return true;
    }
    
    public function uninstall() {
        $table_name = 'platform_account';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'platform_command';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'platform_extend';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'platform_config';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        return true;
    }
}

// end