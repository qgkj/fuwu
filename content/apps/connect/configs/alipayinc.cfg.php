<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 支付宝登录配置文件
 */
return array(
	"partner"		=> "2088011125312949",
// 	"key"			=> "m2rgo80qokhtn14vjp2b9zjjbjfqiyce",
	"key"			=> "t81jxyepjml863mgbywpwob3sne9xg8m",
	"callback"		=> RC_Config::system('CUSTOM_WEB_SITE_URL')."/callback_alipay.php",
	"sign_type"		=> strtoupper('MD5'),
	"input_charset"	=> strtolower('utf-8'),
	"transport"		=> "http",
);

//end