<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
return array(
    'pay_code'      => 'pay_alipay',
    'is_cod' 		=> '0',							/* 是否支持货到付款 */
    'is_online' 	=> '1',							/* 是否支持在线支付 */
    
    'forms' => array(
        array('name' => 'alipay_account',           'type' => 'text',       'value' => ''),
        array('name' => 'alipay_key',               'type' => 'text',       'value' => ''),
        array('name' => 'alipay_partner',           'type' => 'text',       'value' => ''),
        array('name' => 'alipay_pay_method',        'type' => 'select',     'value' => ''),
        array('name' => 'private_key',		        	'type' => 'textarea',   'value' => ''),
        array('name' => 'private_key_pkcs8',		    'type' => 'textarea',   'value' => ''),
    ),
);

// end