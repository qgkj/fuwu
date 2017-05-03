<?php
  
/**
 * 余额支付插件
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('payment_abstract', 'payment', false);

class pay_balance extends payment_abstract
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
        $user_id = $_SESSION['user_id'];
        
        /* 获取会员信息*/
        $user_info = RC_Api::api('user', 'user_info', array('user_id' => $user_id));
        
        $result = RC_Api::api('orders', 'user_account_paid', array('user_id' => $user_id, 'order_id' => $this->order_info['order_id']));
        
    	if (is_ecjia_error($result)) {
    		/* 支付失败返回信息*/
    		$error_predata = array(
    				'order_id'      => $this->order_info['order_id'],
    				'order_surplus' => price_format($this->order_info['surplus'], false),
    				'order_amount'  => price_format($this->order_info['order_amount'], false),
    				'pay_code'      => $this->configure['pay_code'],
    				'pay_name'      => $this->configure['pay_name'],
    				'pay_status'    => 'error',
    				'pay_online'    => '',
    		);
    		$error_predata['error_message'] = $result->get_error_message();
			return $error_predata;
			
		} else {
			/* 支付成功返回信息*/
			$predata = array(
	            'order_id'      => $this->order_info['order_id'],
	            'order_surplus' => price_format($this->order_info['order_amount'], false),
	            'order_amount'  => price_format(0, false),
	            'user_money'    => price_format($user_info['user_money'] - $this->order_info['order_amount'], false),
	            'pay_code'      => $this->configure['pay_code'],
	            'pay_name'      => $this->configure['pay_name'],
	            'pay_status'    => 'success',
	            'pay_online'    => '',
	        );
			return $predata;
		}
        
    }
    
    public function notify() { 
    	 return ;
    }
    
    public function response() {	 
    	 return ;
    }
    
}

// end