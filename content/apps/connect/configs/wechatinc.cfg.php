<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 微信登录配置文件
 */
return array(
	'appid'     	=> 'wx77fdf7be38dd7c5f',
	'appsecret' 	=> '3b22791b1e06584415a16fabaaf44716',
	'redirect_uri'  => RC_Config::system('CUSTOM_WEB_SITE_URL').'/callback_wechat.php', //回调URL
	'last_url'  	=> RC_Config::system('CUSTOM_WEB_SITE_URL'), 						//最终跳转URL
);

// end