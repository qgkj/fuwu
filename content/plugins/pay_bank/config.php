<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
return array(
    'pay_code'      => 'pay_bank',
	'is_cod' 		=> '0',		/* 是否支持货到付款 */
	'is_online' 	=> '0', 	/* 是否支持在线支付 */
		
	'forms' => array(
	    array('name' => 'bank_account_info', 'type' => 'textarea', 'value' => ''),
	),
);

// end