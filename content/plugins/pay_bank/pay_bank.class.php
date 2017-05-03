<?php
  
/**
 * 银行汇款（转帐）插件
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('payment_abstract', 'payment', false);

class pay_bank extends payment_abstract
{
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
    
    public function get_prepare_data() {
        $predata = array(
            'pay_code'     => $this->configure['pay_code'],
            'pay_name'     => $this->configure['pay_name'],
        	'pay_online'   => $this->configure['bank_account_info'],
        );
        
        return $predata;
    }
    
    public function notify() {
    	 
        return;
    }
    
    public function response() {
    	 
        return;
    }

}

// end