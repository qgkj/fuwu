<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class affiliate_installer extends ecjia_installer {
    
    protected $dependent = array(
    	'ecjia.system' => '1.0',
    );
    
    public function __construct() {
        $id = 'ecjia.affiliate';
        parent::__construct($id);
    }
    
    public function install() {
    	
    	/* 推荐模板*/
    	if (!ecjia::config('invite_template', ecjia::CONFIG_CHECK)) {
    		ecjia_config::instance()->insert_config('hidden', 'invite_template', '', array('type' => 'hidden'));
    		ecjia_config::instance()->write_config('invite_template', '您的好友{$user_name}，正在为您推荐！');
    	}
    	
    	/* 推荐说明*/
    	if (!ecjia::config('invite_explain', ecjia::CONFIG_CHECK)) {
    		ecjia_config::instance()->insert_config('hidden', 'invite_explain', '', array('type' => 'hidden'));
    	}
    	
    	/* 推荐奖励记录表*/
    	$invite_reward_table = 'invite_reward';
    	if (!RC_Model::make()->table_exists($invite_reward_table)) {
    		$schemes = array(
    				"`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
    				"`invite_id` int(11) unsigned NOT NULL",
    				"`invitee_id` int(10) unsigned NOT NULL COMMENT '被邀请人id'",
    				"`invitee_name` varchar(60) NOT NULL COMMENT '被邀请人名称'",
    				"`reward_type` varchar(10) NOT NULL COMMENT '奖励类型（红包：bouns，积分：integral，余额：balance）'",
    				"`reward_value` varchar(100) NOT NULL COMMENT '获得的奖励'",
    				"`reward_desc` varchar(100) NOT NULL COMMENT '奖励补充描述说明'",
    				"`add_time` int(10) unsigned NOT NULL",
    				"PRIMARY KEY (`id`)",
    				"KEY `invite_id` (`invite_id`)"
    		);
    		RC_Model::make()->create_table($invite_reward_table, $schemes);
    	}
    	
    	
    	/* 受邀记录表*/
    	$invitee_record_table = 'invitee_record';
    	if (!RC_Model::make()->table_exists($invitee_record_table)) {
    		$schemes = array(
    			"`id` int(11) unsigned NOT NULL AUTO_INCREMENT",
    			"`invite_id` int(11) unsigned NOT NULL",
    			"`invitee_phone` char(11) NOT NULL COMMENT '受邀者手机号'",
    			"`invite_type` varchar(10) NOT NULL",
    			"`is_registered` int(1) unsigned NOT NULL COMMENT '是否已注册'",
    			"`expire_time` int(10) unsigned NOT NULL COMMENT '有效期'",
    			"`add_time` int(10) unsigned NOT NULL",
    			"PRIMARY KEY (`id`)",
    			"KEY `invite_id` (`invite_id`)",
    			"KEY `invite_type` (`invite_type`)"
    		);
    		RC_Model::make()->create_table($invitee_record_table, $schemes);
    	}
    }
    
    public function uninstall() {
    	
    	/* 推荐模板*/
    	if (ecjia::config('invite_template', ecjia::CONFIG_CHECK)) {
    		ecjia_config::instance()->delete_config('invite_template');
    	}
    	
    	if (ecjia::config('invite_explain', ecjia::CONFIG_CHECK)) {
    		ecjia_config::instance()->delete_config('invite_explain');
    	}
    	
    	
    	$invite_reward_table = 'invite_reward';
    	if (RC_Model::make()->table_exists($invite_reward_table)) {
    		RC_Model::make()->drop_table($invite_reward_table);
    	}
    	
    	$invitee_record_table = 'invitee_record';
    	if (RC_Model::make()->table_exists($invitee_record_table)) {
    		RC_Model::make()->drop_table($invitee_record_table);
    	}
    }
}

// end