<?php
  
/**
 * 微信登录
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('platform_abstract', 'platform', false);
class mp_checkin extends platform_abstract
{    

	/**
	 * 获取插件配置信息
	 */
	public function local_config() {
		$config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
		if (is_array($config)) {
			return $config;
		}
		return array();
	}
	
    public function event_reply() {
    	
    	$wechat_point_db = RC_Loader::load_app_model('wechat_point_model','wechat');
    	$wechatuser_db = RC_Loader::load_app_model('wechat_user_model', 'wechat');
    	$platform_config = RC_Loader::load_app_model('platform_config_model','platform');
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	$users_db 			= RC_Loader::load_app_model('users_model','user');
    	
    	$uuid = trim($_GET['uuid']);
    	$account = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    
    	$info = $platform_config->find(array('account_id' => $wechat_id,'ext_code'=>'mp_checkin'));
    	$openid = $this->from_username;
    	$ect_uid = $wechatuser_db->where(array('openid'=>$openid))->get_field('ect_uid');
    	$nobd = "还未绑定，需<a href = '".RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_init', 'openid' => $openid, 'uuid' => $_GET['uuid']))."'>点击此处</a>进行绑定";
    	
		if (empty($ect_uid)) {
			$content = array(
				'ToUserName' => $this->from_username,
				'FromUserName' => $this->to_username,
				'CreateTime' => SYS_TIME,
				'MsgType' => 'text',
				'Content' => $nobd
			);
		} else {
			$ext_config  = $platform_config->where(array('account_id' => $wechat_id,'ext_code'=>$info['ext_code']))->get_field('ext_config');
		
	    	$config = array();
	    	$config = unserialize($ext_config);
	    	foreach ($config as $k => $v) {
				if ($v['name'] == 'point_status') {
					$point_status = $v['value'];
				}
				if ($v['name'] == 'point_interval') {
					$point_interval = $v['value'];
				}
				if ($v['name'] == 'point_num') {
					$point_num = $v['value'];
				}
				if ($v['name'] == 'point_value') {
					$point_value = $v['value'];
				}
			}
			
			if (isset($point_status) && $point_status == 1) {	
				$oldpoints = $users_db->where(array('user_id' => $ect_uid))->get_field('rank_points');
				$rank_points = intval($oldpoints) + intval($point_value);
								
				$where = 'openid = "' . $openid . '" and createtime > (UNIX_TIMESTAMP(NOW())- ' .$point_interval . ') and keywords = "'.$info['ext_code'].'"';
	            $num = $wechat_point_db->where($where)->count('*');
	            
	            if ($num < $point_num) {
	            	// 积分赠送
	            	$this->give_point($openid, $info);
	            	$content = array(
						'ToUserName' => $this->from_username,
						'FromUserName' => $this->to_username,
						'CreateTime' => SYS_TIME,
						'MsgType' => 'text',
						'Content' => '签到成功，您已获得'.$point_value.'积分，当前总积分为'.$rank_points.'分。'
					);
	            } else {
	            	$content = array(
						'ToUserName' => $this->from_username,
						'FromUserName' => $this->to_username,
						'CreateTime' => SYS_TIME,
						'MsgType' => 'text',
						'Content' => '签到次数已用完'
					);
	            }
			} else {
				$content = array(
					'ToUserName' => $this->from_username,
					'FromUserName' => $this->to_username,
					'CreateTime' => SYS_TIME,
					'MsgType' => 'text',
					'Content' => '未启用签到送积分'
				);
			}
			
		}
		return $content;
    }
    
    /**
     * 积分赠送
     */
    public function give_point($openid, $info) {
    	$wechat_point_db = RC_Loader::load_app_model('wechat_point_model','wechat');
    	if (!empty($info)) {
    		// 配置信息
    		$config = array();
    		$config = unserialize($info['ext_config']);
    		
    		foreach ($config as $k => $v) {
    			if ($v['name'] == 'point_status') {
    				$point_status = $v['value'];
    			}
    			if ($v['name'] == 'point_interval') {
    				$point_interval = $v['value'];
    			}
    			if ($v['name'] == 'point_num') {
    				$point_num = $v['value'];
    			}
    			if ($v['name'] == 'point_value') {
    				$point_value = $v['value'];
    			}
    		}
    		// 开启积分赠送
    		if (isset($point_status) && $point_status == 1) {
    			$where = 'openid = "' . $openid . '" and createtime > (UNIX_TIMESTAMP(NOW())- ' .$point_interval . ') and keywords = "'.$info['ext_code'].'"';
	            $num = $wechat_point_db->where($where)->count('*');
    			if ($num < $point_num) {
    				$this->do_point($openid, $info, $point_value);
    			}
    		}
    	}
    }
    
    /**
     * 执行赠送积分
     */
    public function do_point($openid, $info, $point_value) {
    	$wechatuser_db		= RC_Loader::load_app_model('wechat_user_model','wechat');
    	$users_db 			= RC_Loader::load_app_model('users_model','user');
    	$account_log_db 	= RC_Loader::load_app_model('account_log_model','user');
    	$wechat_point_db	= RC_Loader::load_app_model('wechat_point_model','wechat');
    	
    	$time = RC_Time::gmtime();
    	$ect_uid = $wechatuser_db->where(array('openid'=>$openid))->get_field('ect_uid');
    	$rank_points = $users_db->where(array('user_id' => $ect_uid))->get_field('rank_points');
    	
    	$point = array(
    		'rank_points' => intval($rank_points) + intval($point_value)
    	);
    	
    	$users_db->where(array('user_id' => $ect_uid))->update($point);
        	
    	// 积分记录
    	$data['user_id'] = $ect_uid;
    	$data['user_money'] = 0;
    	$data['frozen_money'] = 0;
    	$data['rank_points'] = $point_value;
    	$data['pay_points'] = 0;
    	$data['change_time'] = $time;
    	$data['change_desc'] = '积分赠送';
    	$data['change_type'] = ACT_OTHER;
    	
    	$log_id = $account_log_db->insert($data);
    	
    	// 从表记录
    	$data1['log_id'] = $log_id;
    	$data1['openid'] = $openid;
    	$data1['keywords'] = $info['ext_code'];
    	$data1['createtime'] = $time;
    	
    	$log_id = $wechat_point_db->insert($data1);
    }
}

// end