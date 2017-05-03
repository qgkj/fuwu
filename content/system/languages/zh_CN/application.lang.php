<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 应用管理语言文件
 */
return array(
	'addon_manage'	=> '应用管理',
		
	'addon_application'		=> '应用',
	
	'application_name'		=>'名称',
	'application_dir'		=> '目录',
	'application_desc'		=> '描述',
	'application_version'	=> '版本',
	'application_author'	=> '作者',
	'application_copyright_info'=> '版权信息',
	
	'install'	=> '安装',
	'uninstall'	=> '卸载',
	'upgrade'	=> '升级',
	'upgrade_success'=> '升级成功',
	
	'uninstall_confirm'		=> '卸载应用将删除该应用的所有数据。\n您确定要卸载这个应用吗？',
	'create_table_failed'	=> '创建应用的数据表失败，该应用可能是一个无效的应用。<br />错误信息：<br />%s',
	'dir_readonly'		 	=> '%s 目录不可写，请检查您的服务器设置。',
	'file_readonly'			=> '%s 文件不可写，请检查您的服务器设置。',
	'uninstall_success'		=>'指定的应用已经卸载成功。',
	'install_success'		=>'指定的应用已经安装成功。',
	'upgrade_success'		=>'指定的应用已经升级成功。',
	'plugin_not_exists'		=>'没有找到指定的应用文件，请确认该应用是否确实存在。',
	'class_not_exists'		=>'没有找到指定的应用类，该应用可能已经被损坏。',
	
	'js_languages'  => array(
		'lang_removeconfirm' => '您确定要卸载该应用吗？',
	),
);

// end