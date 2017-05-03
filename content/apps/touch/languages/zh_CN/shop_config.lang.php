<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 管理中心商店设置语言文件
 */
return array(
	'cfg_name' => array(
		'wap'                 		=> '微商城设置',
		'wap_config'          		=> '是否使用微商城功能',
		'wap_logo'            		=> '微商城 LOGO',
		'wap_index_logo'      		=> '微商城首页LOGO',
		'wap_hot_search'      		=> '微商城热门搜索',
		'shop_pc_url'            	=> 'PC商城地址',
		'shop_touch_url'         	=> '微商城地址',
		'shop_iphone_download'   	=> 'iPhone下载地址',
		'shop_android_download'  	=> 'android下载地址',
		'shop_ipad_download'     	=> 'iPad下载地址',
		'shop_app_icon'          	=> 'APP图标',
		'shop_app_description'   	=> 'APP简介',
		'touch_bottom_banner'       => '首页底部广告图片',
		'touch_bottom_banner_url'   => '首页底部广告链接',
		'wap_copyright' 			=> '版权信息',
	),
	
	'cfg_desc' => array(
		'wap_logo'            		=> '为了更好地兼容各种手机类型，LOGO 最好为png图片',
		'wap_hot_search'      		=> '每个热门搜索词组请使用“,”隔开，注意“,”必须是英文逗号',
		'touch_bottom_banner_url'	=> '注意：只有设置了广告跳转地址，底部广告才会显示。否则不会显示',
		'wap_copyright' 			=> '请填写您商城的版权信息。若留空，则不显示版权信息',
	),
	
	'cfg_range' => array(
		'wap_config' => array(
			'0'	=> '关闭',
			'1' => '开启'
		)
	),
);

// end