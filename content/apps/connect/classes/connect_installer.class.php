<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class connect_installer extends ecjia_installer {
    
    protected $dependent = array(
    	'ecjia.system'	=> '1.0',
        'ecjia.user'	=> '1.0',
    );
    
    public function __construct() {
        $id = 'ecjia.connect';
        parent::__construct($id);
    }
    
    
    public function install() {
        $table_name = 'connect';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`connect_id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT",
                "`connect_code` varchar(20) NOT NULL DEFAULT ''",
                "`connect_name` varchar(120) NOT NULL DEFAULT ''",
                "`connect_desc` text NOT NULL",
                "`connect_order` tinyint(3) unsigned NOT NULL DEFAULT '0'",
                "`connect_config` text NOT NULL",
                "`enabled` tinyint(1) unsigned NOT NULL DEFAULT '0'",
                "`support_type` mediumint(6) unsigned NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`connect_id`)",
                "KEY `connect_code` (`connect_code`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        $table_name = 'connect_user';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
                "`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
                "`connect_code` char(30) NOT NULL",
                "`user_id` int(11) unsigned NOT NULL DEFAULT '0'",
                "`is_admin` tinyint(1) NOT NULL DEFAULT '0'",
                "`open_id` char(64) NOT NULL DEFAULT ''",
                "`refresh_token` char(64) DEFAULT ''",
                "`access_token` char(64) NOT NULL DEFAULT ''",
                "`profile` text",
                "`create_at` int(10) unsigned NOT NULL DEFAULT '0'",
                "`expires_in` int(10) unsigned NOT NULL DEFAULT '0'",
                "`expires_at` int(10) unsigned NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)",
                "KEY `open_id` (`connect_code`,`open_id`)"
            );
            RC_Model::make()->create_table($table_name, $schemes);
        }
    }
    
    
    public function uninstall() {
        $table_name = 'connect';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
        
        $table_name = 'connect_user';
        if (RC_Model::make()->table_exists($table_name)) {
            RC_Model::make()->drop_table($table_name);
        }
    }
}

// end