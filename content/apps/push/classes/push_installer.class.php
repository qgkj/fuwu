<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class push_installer extends ecjia_installer {
    
    protected $dependent = array(
    	'ecjia.system' => '1.0',
    );
    
    public function __construct() {
        $id = 'ecjia.push';
        parent::__construct($id);
    }
    
    
    public function install() {
        $table_name = 'push_message';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
            	"`message_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT",
            	"`app_id` int(10) unsigned NOT NULL",
                "`device_token` CHAR(64) NOT NULL",
                "`device_client` CHAR(10) NOT NULL",
                "`title` VARCHAR(150) NOT NULL",
                "`content` VARCHAR(255) NOT NULL",
                "`add_time` INT(10) NOT NULL",
                "`push_time` INT(10) NOT NULL",
                "`push_count` TINYINT(1) NOT NULL",
                "`template_id` MEDIUMINT(8) NOT NULL",
                "`in_status` TINYINT(1) NOT NULL DEFAULT '0'",
                "`extradata` TEXT NOT NULL",
                "PRIMARY KEY (`message_id`)"
            );
            
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'push_event';
        if (!RC_Model::make()->table_exists($table_name)) {
        	$schemes = array(
        			"`event_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '消息事件id'",
        			"`event_code` varchar(60) NOT NULL COMMENT '消息事件code'",
        			"`event_name` varchar(60) NOT NULL COMMENT '消息事件名称'",
        			"`app_id` int(10) unsigned NOT NULL COMMENT '客户端设备id'",
        			"`template_id` int(10) unsigned NOT NULL COMMENT '模板id'",
        			"`is_open` tinyint(3) NOT NULL COMMENT '是否启用'",
        			"`create_time` int(100) unsigned NOT NULL",
        			"PRIMARY KEY (`event_id`)"
        	);
        	RC_Model::make()->create_table($table_name, $schemes);
        }
        
        if (!ecjia::config('app_name', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_name', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('app_push_development', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_push_development', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('app_key_android', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_key_android', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('app_secret_android', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_secret_android', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('app_key_iphone', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_key_iphone', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('app_secret_iphone', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_secret_iphone', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('app_key_ipad', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_key_ipad', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('app_secret_ipad', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'app_secret_ipad', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('push_user_signin', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'push_user_signin', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('push_order_shipped', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'push_order_shipped', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('push_order_payed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'push_order_payed', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('push_order_placed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'push_order_placed', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        
        return true;
    }
    
    
    public function uninstall() {
        $table_name = 'push_message';
        if (RC_Model::make()->table_exists($table_name)) {
           RC_Model::make()->drop_table($table_name);
        }
        
        if (ecjia::config('app_name', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_name');
        }
        if (ecjia::config('app_push_development', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_push_development');
        }
        if (ecjia::config('app_key_android', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_key_android');
        }
        if (ecjia::config('app_secret_android', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_secret_android');
        }
        if (ecjia::config('app_key_iphone', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_key_iphone');
        }
        if (ecjia::config('app_secret_iphone', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_secret_iphone');
        }
        if (ecjia::config('app_key_ipad', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_key_ipad');
        }
        if (ecjia::config('app_secret_ipad', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('app_secret_ipad');
        }
        
        if (ecjia::config('push_user_signin', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('push_user_signin');
        }
        if (ecjia::config('push_order_shipped', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('push_order_shipped');
        }
        if (ecjia::config('push_order_payed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('push_order_payed');
        }
        if (ecjia::config('push_order_placed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('push_order_placed');
        }
        
        return true;
    }
}

// end