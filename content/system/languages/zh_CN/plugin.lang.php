<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 插件管理语言文件
 */

return array(
	'addon_manage'	=> '插件管理',
	'plugin_name'	=> '名称',
	'plugin_desc'	=> '描述',
	'plugin_version'=> '版本',
	'plugin_author'	=> '作者',
	
	'upgrade'			=> '升级',
	'upgrade_success'	=> '升级成功',
	
	'uninstall_confirm'		=> '卸载插件将删除该插件的所有数据。\n您确定要卸载这个插件吗？',
	'create_table_failed'	=> '创建插件的数据表失败，该插件可能是一个无效的插件。<br />错误信息：<br />%s',
	'dir_readonly'			=> '%s 目录不可写，请检查您的服务器设置。',
	'file_readonly'			=> '%s 文件不可写，请检查您的服务器设置。',
	'uninstall_success'		=> '指定的插件已经卸载成功。',
	'install_success'		=> '指定的插件已经安装成功。',
	'upgrade_success'		=> '指定的插件已经升级成功。',
	'plugin_not_exists'		=> '没有找到指定的插件文件，请确认该插件是否确实存在。',
	'class_not_exists'		=> '没有找到指定的插件类，该插件可能已经被损坏。',
	
	'js_languages' => array(
		'lang_removeconfirm'=> '您确定要卸载该插件吗？',
	)
);

// end