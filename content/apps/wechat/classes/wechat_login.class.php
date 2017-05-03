<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 微信公众平台登录
 */
class wechat_login
{
    protected $oauth;
    protected $access_token;
    
    protected $client_id;
    protected $client_secret;
    
    protected $openid;
    protected $unionid;
    
    protected $wechat_id;
    
    public function __construct($uuid, $openid) {
        RC_Loader::load_app_class('platform_account', 'platform', false);
        
        
        $account             = platform_account::make($uuid);
        $wechat_config       = $account->getAccount();
        
        $this->wechat_id     = $account->getAccountID();
        $this->openid        = $openid;
        $this->client_id     = $wechat_config['appid'];
        $this->client_secret = $wechat_config['appsecret'];
        $config = array(
            'appid'     => $this->client_id,
            'appsecret' => $this->client_secret,
        );
        $this->oauth = new Component_WeChat_WeChat($config); 
    }
    
    public function callback() {
        $state = $_SESSION['wechat_login_state'];
        $callback_url = $this->configure['sns_wechat_callback'];
        
        //--------验证state防止CSRF攻击
        if($_GET['state'] != $state){
            return new ecjia_error('wechat_state_not_match', 'The state does not match. You may be a victim of CSRF.');
        }
        
        $token = $this->access_token($this->configure['sns_wechat_callback'], $_GET['code']);
        
        if (!is_ecjia_error($token)) {
            $userinfo = $this->me();
            
            $connect_user = new connect_user($this->configure['connect_code'], $this->open_id);
            $connect_user->save_openid($this->access_token, serialize($userinfo), $token['expires_in']);
            
            $rname = $userinfo['nickname'];
            return array('connect_code' => $this->configure['connect_code'], 'open_id' => $this->open_id, 'username' => $rname);
        } else {
            return new ecjia_error('sns_wechat_authorize_failure', RC_Lang::get('wechat::wechat.authorize_failure'));
        }
    }
    
    public function get_username() {
        return $this->generate_username();
    }
    
    public function get_email() {
        return $this->generate_email();
    }
    
}

// end