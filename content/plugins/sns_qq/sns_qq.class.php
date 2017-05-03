<?php
  
/**
 * QQ登录
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('connect_abstract', 'connect', false);
RC_Loader::load_app_class('connect_user', 'connect', false);
class sns_qq extends connect_abstract
{
    protected $oauth;
    
    const GET_AUTH_CODE_URL = "https://graph.qq.com/oauth2.0/authorize";
    const GET_ACCESS_TOKEN_URL = "https://graph.qq.com/oauth2.0/token";
    const GET_OPENID_URL = "https://graph.qq.com/oauth2.0/me";
    
    protected $recorder;
    public $urlUtils;
    protected $error;
    
    public function __construct($client_id, $client_secret, $configure = array()) {
        parent::__construct($client_id, $client_secret, $configure);
        
        $inc = array(
        	'appid' => $this->configure['sns_qq_appid'],
            'appkey' => $this->configure['sns_qq_appkey'],
            'callback' => $this->configure['sns_qq_callback'],
            'scope' => 'get_user_info',
            'errorReport' => true
        );
        $this->recorder = new Recorder($inc);
        $this->urlUtils = new UrlUtils($inc);
        $this->error = new ErrorCase($inc);
    }
    
    /**
     * 获取插件配置信息
     */
    public function configure_config() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        if (is_array($config)) {
            return $config;
        }
        return array();
    }
    
    /**
     * 生成授权网址
     */
    public function authorize_url() {
        $appid = $this->recorder->readInc("appid");
        $callback = $this->recorder->readInc("callback");
        $scope = $this->recorder->readInc("scope");
        
        //-------生成唯一随机串防CSRF攻击
        $state = md5(uniqid(rand(), TRUE));
        $this->recorder->write('state', $state);
        
        //-------构造请求参数列表
        $keysArr = array(
            "response_type"     => "code",
            "client_id"         => $appid,
            "redirect_uri"      => $callback,
            "state"             => $state,
            "scope"             => $scope
        );
        
        $login_url = $this->urlUtils->combineURL(self::GET_AUTH_CODE_URL, $keysArr);
        
        return $login_url;
    }
    
    public function callback() {
        $state = $this->recorder->read("state");
        $callback = $this->recorder->readInc("callback");
        
        //--------验证state防止CSRF攻击
        if($_GET['state'] != $state){
            $this->error->showError("30001");
        }

        $token = $this->access_token($callback, $_GET['code']);
       
        $userinfo = $this->me();
        
        $connect_user = new connect_user($this->configure['connect_code'], $this->open_id);
        $connect_user->save_openid($this->access_token, serialize($userinfo), $token['expires_in']);
        
        if ($userinfo['ret'] == 0) {
            return array('connect_code' => $this->configure['connect_code'], 'open_id' => $this->open_id, 'username' => $userinfo['nickname']);
        } else {
            return new ecjia_error('sns_qq_authorize_failure', '登录授权失败，请换其他方式登录');
        }        
    }
    
    /**
     * 获取access token
     */
    public function access_token($callback_url, $code) {
        //-------请求参数列表
        $keysArr = array(
            "grant_type"    => "authorization_code",
            "client_id"     => $this->recorder->readInc("appid"),
            "redirect_uri"  => urlencode($this->recorder->readInc("callback")),
            "client_secret" => $this->recorder->readInc("appkey"),
            "code"          => $_GET['code']
        );
        //------构造请求access_token的url
        $token_url = $this->urlUtils->combineURL(self::GET_ACCESS_TOKEN_URL, $keysArr);
        $response = $this->urlUtils->get_contents($token_url);
        
        if (strpos($response, "callback") !== false) {
            $lpos       = strpos($response, "(");
            $rpos       = strrpos($response, ")");
            $response   = substr($response, $lpos + 1, $rpos - $lpos -1);
            $msg        = json_decode($response);
        
            if (isset($msg->error)) {
                $this->error->showError($msg->error, $msg->error_description);
            }
        }
        
        $params = array();
        parse_str($response, $params);
        
        $this->recorder->write("access_token", $params["access_token"]);
        
        $this->access_token = $params["access_token"];

        return $params;
    }
    
    public function get_openid() {
        //-------请求参数列表
        $keysArr = array(
            "access_token" => $this->recorder->read("access_token")
        );
    
        $graph_url = $this->urlUtils->combineURL(self::GET_OPENID_URL, $keysArr);
        $response = $this->urlUtils->get_contents($graph_url);
    
        //--------检测错误是否发生
        if (strpos($response, "callback") !== false) {
            $lpos       = strpos($response, "(");
            $rpos       = strrpos($response, ")");
            $response   = substr($response, $lpos + 1, $rpos - $lpos -1);
        }
    
        $user = json_decode($response);
        if (isset($user->error)) {
            $this->error->showError($user->error, $user->error_description);
        }
    
        //------记录openid
        $this->recorder->write("openid", $user->openid);
        $this->open_id = $user->openid;
        
        return $user->openid;
    }
    
    /**
     * 使用refresh token 获取新的access token
     * @param unknown $refresh_token
     */
    public function access_token_refresh($refresh_token) {
        
    }
    
    /**
     * 获取登录用户信息
     */
    public function me() {
        $open_id =  $this->get_openid();
        $this->oauth = new QQConnect($this->recorder, $this->urlUtils, $this->error, $this->access_token, $open_id);
        $userinfo = $this->oauth->get_user_info();
        return $userinfo;
    }
    
    public function get_username(array $profile) {
        return $profile['nickname'];
    }
    
    public function get_email(array $profile) {
        return $this->generate_email();
    }
    
}

// end