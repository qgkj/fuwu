<?php
  
/**
 * 微信登录
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('platform_abstract', 'platform', false);
class mp_userbind extends platform_abstract
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
    	$wechatuser_db = RC_Loader::load_app_model('wechat_user_model', 'wechat');
    	$user_db = RC_Loader::load_app_model('users_model', 'user');
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	RC_Loader::load_app_class('wechat_user', 'wechat', false);
    	
    	$openid = $this->from_username;
    	$uuid = trim($_GET['uuid']);
    	$account = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	$wechat_user = new wechat_user($wechat_id, $openid);
    	$ect_uid = $wechat_user->getUserId();
    	
    	$username = $user_db->where(array('user_id' => $ect_uid))->get_field('user_name');
    	$hasbd = "您已拥有帐号，用户名为【".$username."】，<a href = '".RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_init', 'openid' => $openid, 'uuid' => $_GET['uuid']))."'>点击此处</a>可以设置密码";
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
    		$content = array(
    			'ToUserName' => $this->from_username,
    			'FromUserName' => $this->to_username,
    			'CreateTime' => SYS_TIME,
    			'MsgType' => 'text',
    			'Content' => $hasbd
    		);
    	}
    	return $content;
    }
    
    
    /**
     * 生成授权网址
     */
    public function authorize_url() {
        $callback_url = '';
        $state = md5(uniqid(rand(), TRUE));
        $params = array(
            'redirect_uri'  => $callback_url,
            'scope'         => 'snsapi_userinfo',
            'state'         => $state,
        );
        $_SESSION['wechat_login_state'] = $state;
        $code_url = $this->oauth->getQRConnectCodeUrl($params);
    
        return $code_url;
    }
    
}

// end