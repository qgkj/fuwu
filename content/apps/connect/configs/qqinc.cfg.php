<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * QQ登录配置文件
 */
return array(
	"appid" 		=> "101036658",
	"appkey"		=> "bd0015ffb2a10cb6f14de85124a8a73f",
	"callback"		=> RC_Config::system('CUSTOM_WEB_SITE_URL')."/callback_qq.php",
	"scope"			=> "get_user_info",
	"errorReport"	=> true,
	"storageType"	=> "file",
);

//end