<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 插件使用方法
 * @author royalwang
 */
class connect_method {

    /**
     * 获取所有可用的帐号连接插件列表
     */
    public function connect_list() {
        $plugins         = RC_Plugin::get_plugins();
        $captcha_plugins = ecjia_config::instance()->get_addon_config('connect_plugins', true);
    
        $list = array();
        foreach ($captcha_plugins as $code => $plugin) {
            if (isset($plugins[$plugin])) {
                $list[$code] = $plugins[$plugin];
    
                $list[$code]['code']                = $code;
                $list[$code]['format_name']         = $list[$code]['Name'];
                $list[$code]['format_description']  = $list[$code]['Description'];
            }
        }
    
        return $list;
    }
    
    /**
     * 获取指定连接方式的实例
     * @param string $code
     * @param array $config
     * @return connect_factory
     */
    public function get_connect_instance($connect_code, $config = array()) {
        $connect_info = $this->connect_info_by_code($connect_code);
        if (empty($config)) {
            $config = $this->unserialize_config($connect_info['connect_config']);
        }
        $config['connect_code'] = $connect_code;
        $config['connect_name'] = $connect_info['connect_name'];
        RC_loader::load_app_class('connect_factory', 'connect',false);
        $handler = new connect_factory($connect_code, $config);
        return $handler;
    }
    
    /**
     * 取得支付方式信息
     * @param   int|string     $connect_id/$connect_code     连接方式id 或 连接方式code
     * @return  array   支付方式信息
     */
    public function connect_info_by_code($connect_code) {
        $db = RC_loader::load_app_model('connect_model', 'connect');
        return $db->find(array('connect_code' => $connect_code , 'enabled' => 1));
    }
    public function connect_info_by_id($connect_id) {
        $db = RC_loader::load_app_model('connect_model', 'connect');
        return $db->find(array('connect_id' => $connect_id , 'enabled' => 1));
    }

    public function create_username($openid, $connect_code) {
        $connect_instance = $this->get_connect_instance($connect_code);
        $username         = $connect_instance->generate_username();
        $email            = $connect_instance->generate_email();
        return array($username, $email);
    }
    
    /**
     * 处理序列化的配置参数
     * 返回一个以name为索引的数组
     *
     * @access  public
     * @param   string       $cfg
     * @return  void
     */
    public function unserialize_config($cfg) {
        if (is_string($cfg) && ($arr = unserialize($cfg)) !== false) {
            $config = array();
            foreach ($arr AS $key => $val) {
                $config[$val['name']] = $val['value'];
            }
            return $config;
        } else {
            return false;
        }
    }

}

// end