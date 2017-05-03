<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

return array(
    /*
     ******************************** 基本配置 ********************************
     */
    //网站时区，Etc/GMT-8 实际表示的是 GMT+8 timezone
    'timezone' 						=> env('TIMEZONE', 'Etc/GMT-8'), 		
    //网站语言包
    'locale' 						=> 'zh_CN',	
    //是否Gzip压缩后输出
    'gzip' 							=> 0, 					
    //密钥
    'auth_key' 						=> 'UbGuq4G8uqk9yRKHhiRn', 

    //调试显示
    'debug_display'                 => false, 

	'admin_entrance'				=> 'admincp',
	
	'admin_enable'					=> true,

    /*
     ********************************URL路由*******************************
     */
    //URL重写模式
    'url_rewrite'					=> false,		
    //URL模式（normal：普通模式 pathinfo：PATHINFO模式 cli：命令行模式）
    'url_mode'						=> 'normal',			
		
	
    /*
     ******************************** 模板参数 *******************************
     */   
    //风格
    'tpl_style'                     => 'default',  
    // 信息提示模板
    'tpl_message'                   => 'showmessage.dwt.php',
    
	'tpl_usedfront'					=> false,

);

// end