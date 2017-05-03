<?php
  
/**
 * 客服
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('platform_abstract', 'platform', false);
class mp_kefu extends platform_abstract
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
    	$wechatuser_db = RC_Loader::load_app_model('wechat_user_model','wechat');
    	$wechat_custom_message_db = RC_Loader::load_app_model('wechat_custom_message_model', 'wechat');
    	$platform_config_db = RC_Loader::load_app_model('platform_config_model','platform');
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	RC_Loader::load_app_class('wechat_method', 'wechat', false);
    	 
//     	$openid = $this->from_username;
    	$uuid = trim($_GET['uuid']);
    	$account = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	//是否超时
//     	$timeout = false;

//     	$uid  = $wechatuser_db->where(array('openid' => $openid))->get_field('ect_uid');//获取绑定用户会员id
    	$ext_config  = $platform_config_db->where(array('account_id' => $wechat_id,'ext_code'=>'mp_kefu'))->get_field('ext_config');
    	$config = array();
    	$config = unserialize($ext_config);
    	
    	foreach ($config as $k => $v) {
    		if ($v['name'] == 'kefu_status') {
    			$kefu_status = $v['value'];
    		}
    		if ($v['name'] == 'kefu_value') {
    			$kefu_value = $v['value'];
    		}
    	}
    	
//     	$nobd = "还未绑定，需<a href = '".RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_init', 'openid' => $openid, 'uuid' => $_GET['uuid']))."'>点击此处</a>进行绑定";
//     	if(empty($uid)) {
//     		$content = array(
// 				'ToUserName' => $this->from_username,
// 				'FromUserName' => $this->to_username,
// 				'CreateTime' => SYS_TIME,
// 				'MsgType' => 'text',
// 				'Content' => $nobd
// 			);
//     	} else {
//     		$time_list = $wechat_custom_message_db->field('send_time')->where(array('uid'=>$uid))->order('send_time desc')->limit(2)->select();
//     		if($time_list[0]['send_time'] - $time_list[1]['send_time'] > 3600 * 2){
//     			$timeout = true;
//     		}
    		$wechat = wechat_method::wechat_instance($uuid);
    		$msg = array(
    			'touser' => $this->from_username,
    			'msgtype' => 'text',
    			'text' => array(
    				'content' => '欢迎进入客服系统'
    			)
    		);
    		$wechat->sendCustomMessage($msg);
			if($kefu_status == 1) {
				if (empty($kefu_value)) {
					$content = array(
						'ToUserName'  => $this->from_username,
						'FromUserName'=> $this->to_username,
						'CreateTime'  => SYS_TIME,
						'MsgType'     => 'transfer_customer_service',
					);
				} else {
					$content = array(
						'ToUserName'  => $this->from_username,
						'FromUserName'=> $this->to_username,
						'CreateTime'  => SYS_TIME,
						'MsgType'     => 'transfer_customer_service',
						'TransInfo'   => array(
							'KfAccount'=>$kefu_value
						)
					);
				}
			} else {
				$content = array(
					'ToUserName' => $this->from_username,
					'FromUserName' => $this->to_username,
					'CreateTime' => SYS_TIME,
					'MsgType' => 'text',
					'Content' => '抱歉还未开启多客服转接'
				);
			}
//     	}
        return $content;
    }
}

// end