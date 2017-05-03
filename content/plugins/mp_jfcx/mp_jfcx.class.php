<?php
  
/**
 * 积分查询
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('platform_abstract', 'platform', false);
class mp_jfcx extends platform_abstract
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
    	$user_db = RC_Loader::load_app_model('users_model', 'user');
    	$db_user_rank = RC_Loader::load_app_model('user_rank_model','user');
    	
    	$openid = $this->from_username;
    	$uid  = $wechatuser_db->where(array('openid' => $openid))->get_field('ect_uid');//获取绑定用户会员id
    	$nobd = "还未绑定，需<a href = '".RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_init', 'openid' => $openid, 'uuid' => $_GET['uuid']))."'>点击此处</a>进行绑定";
    	if(empty($uid)) {
    		$content = array(
				'ToUserName' => $this->from_username,
				'FromUserName' => $this->to_username,
				'CreateTime' => SYS_TIME,
				'MsgType' => 'text',
				'Content' => $nobd
			);
    	} else {
    		$field = 'rank_points, pay_points, user_money, user_rank';
    		$data = $user_db->field($field)->find(array('user_id' => $uid));
    		if (!empty($data)) {
    			$msg = "您的余额：".price_format($data['user_money'], false). "\n".
    					"等级积分：".$data['rank_points']."\n".
    					"消费积分：".$data['pay_points'];
    			$content = array(
    				'ToUserName'    => $this->from_username,
    				'FromUserName'  => $this->to_username,
    				'CreateTime'    => SYS_TIME,
    				'MsgType'       => 'text',
    				'Content'		=> $msg
    			);
    		}
    	}
        return $content;
    }
    
}

// end