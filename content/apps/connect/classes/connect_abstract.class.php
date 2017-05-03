<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 帐号连接抽象类
 * @author royalwang
 */ 
abstract class connect_abstract {
    
    protected $client_id;
    protected $client_secret;
    protected $open_id;
    protected $access_token;
    protected $configure = array();
    
    
    public function __construct($client_id, $client_secret, $configure = array()) {
        $this->client_id     = $client_id;
        $this->client_secret = $client_secret;
        $this->configure     = $configure;
    }
    
    public function set_config(array $config) {
        foreach ($config as $key => $value) {
            $this->configure[$key] = $value;
        }
        return $this;
    }
    
    public function get_config() {
        return $this->configure;
    }
    
    /**
     * 获取插件配置信息
     */
    abstract public function configure_config();
    /**
     * 配置表单信息
     */
    
    public function configure_forms($code_list = array(), $format = false) {
        $config = $this->configure_config();
        $forms  = array();
        if ($config['forms']) {
            $forms = $config['forms'];
        }
         
        if ($format) {
            RC_Lang::load_plugin($config['connect_code']);
             
            $connect_config = array();
            /* 循环插件中所有属性 */
            if (!empty($forms)) {
                foreach ($forms as $key => $value) {
                	//@todo 语言包升级待确认
                    $connect_config[$key]['desc']  = RC_Lang::lang($value['name'] . '_desc') ? RC_Lang::lang($value['name'] . '_desc') : '';
                    $connect_config[$key]['label'] = RC_Lang::lang($value['name']);
                    $connect_config[$key]['name']  = $value['name'];
                    $connect_config[$key]['type']  = $value['type'];
                     
                    if (!empty($code_list) && isset($code_list[$value['name']])) {
                        $connect_config[$key]['value'] = $code_list[$value['name']];
                    } else {
                        $connect_config[$key]['value'] = $value['value'];
                    }
                     
                    if ($connect_config[$key]['type'] == 'select' ||
                        $connect_config[$key]['type'] == 'radiobox') {
                            $connect_config[$key]['range'] = RC_Lang::lang($connect_config[$key]['name'] . '_range');
                        }
                }
            }
             
            return $connect_config;
        } else {
            return $forms;
        }
    }

    /**
     * 生成授权网址
     */
    abstract function authorize_url();
    
    /**
     * 登录成功后回调处理
     **/
    abstract public function callback();
    
    
    /**
     * 获取access token
     */
    public function access_token($callback_url, $code) {
        
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
        
    }
    
    /**
     * 调用接口
     * 示例：获取登录用户信息
     * $result = $obj->api('users/me', array(), 'GET');
     */
    public function api($url, $params = array(), $method = 'GET') {
        
    }
    
    /**
     * 生成用户名
     * @return string
     */
    public function generate_username() {
        /* 不是用户注册，则创建随机用户名*/
        return 'a' . rc_random(10, 'abcdefghijklmnopqrstuvwxyz0123456789');;
    }
    
    /**
     * 生成邮箱
     * @return string
     */
    public function generate_email() {
        /* 不是用户注册，则创建随机用户名*/
        $string = 'a' . rc_random(10, 'abcdefghijklmnopqrstuvwxyz0123456789');
        $email = $string.'@163.com';
        return $email;
    }
    
    abstract public function get_username(array $profile);
    abstract public function get_email(array $profile); 
}

// end