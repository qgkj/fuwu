<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 帐号连接抽象类
 * @author royalwang
 */ 
abstract class platform_abstract {
    
    protected $configure = array();
    
    protected $from_username;
    protected $to_username;
    protected $parameter;
    
    public function __construct($configure = array()) {
        if (isset($configure['parameter'])) {
            $this->parameter      = $configure['parameter'];
            $this->from_username  = $configure['parameter']['FromUserName'];
            $this->to_username    = $configure['parameter']['ToUserName'];
        }
        $this->configure      = $configure;
    }

 
    public function set_config(array $config)
    {
        foreach ($config as $key => $value) {
            $this->configure[$key] = $value;
        }
        return $this;
    }
    public function get_config() {
        return $this->configure;
    }
    
    /**
     * 生成插件的配置表单信息
     */
    public function configure_forms($code_list = array(), $format = false)
    {
        $config = $this->local_config();
        $forms = array();
        if ($config['forms']) {
            $forms = $config['forms'];
        }
         
        if ($format) {
            RC_Lang::load_plugin($config['ext_code']);
             
            $ext_config = array();
            /* 循环插件中所有属性 */
            if (!empty($forms)) {
                foreach ($forms as $key => $value) {
                    //todo 语言包升级待确认
                    $ext_config[$key]['desc'] = RC_Lang::lang($value['name'] . '_desc') ? RC_Lang::lang($value['name'] . '_desc') : '';
                    $ext_config[$key]['label'] = RC_Lang::lang($value['name']);
                    $ext_config[$key]['name'] = $value['name'];
                    $ext_config[$key]['type'] = $value['type'];
                     
                    if (!empty($code_list) && isset($code_list[$value['name']])) {
                        $ext_config[$key]['value'] = $code_list[$value['name']];
                    } else {
                        $ext_config[$key]['value'] = $value['value'];
                    }
                     
                    if ($ext_config[$key]['type'] == 'select' ||
                        $ext_config[$key]['type'] == 'radiobox') {
                        //todo 语言包升级待确认
                            $ext_config[$key]['range'] = RC_Lang::lang($ext_config[$key]['name'] . '_range');
                        }
                }
            }
             
            return $ext_config;
        } else {
            return $forms;
        }
    }

    /**
     * 插件返回数据统一接口
     */
    abstract public function event_reply();
    
}

// end