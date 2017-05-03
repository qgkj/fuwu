<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 计划任务程序语言包
 */
return array(
	'cron' 				=> '计划任务',
	'cron_name' 		=> '计划任务名称',
	'cron_code' 		=> '此计划任务',
	'if_open' 			=> '开启',
	'version' 			=> '版本',
	'cron_desc' 		=> '计划任务描述',
	'cron_author' 		=> '插件作者',
	'cron_time' 		=> '计划任务执行时间',
	'cron_next' 		=> '下次执行时间',
	'cron_this' 		=> '上次执行时间',
	'cron_allow_ip' 	=> '允许执行的服务器IP',
	'cron_run_once' 	=> '执行后关闭',
		
	'cron_alow_files' 	=> '允许执行页面',
	'notice_alow_files' => '前台后台触发计划运行的应用，留空即表示在所有应用均触发',
	'notice_alow_ip' 	=> '允许运行计划任务服务器的IP，请用半角逗号分隔多个IP，留空即表示所执行的服务器IP不受限制',
	'notice_minute' 	=> '请用半角逗号分隔多个分钟',
	'cron_do' 			=> '执行',
	'do_ok' 			=> '执行成功',
	'cron_month' 		=> '每月',
	'cron_day' 			=> '日',
	'cron_week' 		=> '每周',
	'cron_thatday' 		=> '当天',
	'cron_hour' 		=> '时',
	'cron_minute'	 	=> '分钟',
	'cron_unlimit' 		=> '每日',
	'cron_advance' 		=> '高级选项',
	'cron_show_advance' => '显示高级选项',
	'install_ok' 		=> '安装成功',
	'edit_ok' 			=> '编辑成功',
		
	'week' => array(
		1 => '星期一',
		2 => '星期二',
		3 => '星期三',
		4 => '星期四',
		5 => '星期五',
		6 => '星期六',
		7 => '星期日',
	),

	'minute' => array(
		'custom'  => '自定义',
		'five'    => '每5分钟',
		'ten' 	  => '每10分钟',
		'fifteen' => '每15分钟',
		'twenty'  => '每20分钟',
		'thirty'  => '每30分钟',
	),
		
	'uninstall_ok' 			=> '卸载成功',
	'cron_not_available' 	=> '该计划任务不存在或尚未安装',
	'back_list' 			=> '返回计划任务列表',
	'name_is_null' 			=> '您没有输入计划任务名称！',
	
	'js_languages' => array(
		'lang_removeconfirm' => '您确定要卸载此计划任务吗？'
	),
		
	'enable' 	=> '启用',
	'disable' 	=> '禁用',
	
	'cron_disabled'		=> '计划任务已禁用',
	'cron_enable'		=> '计划任务已启用',
	'edit_cron'			=> '编辑计划任务',
	'edit_fail'			=> '编辑失败',
	'do_fail'			=> '执行失败',
	'no_page_allowed'	=> '没有找到允许执行的页面',
	'disabled_confirm'	=> '您确定要禁用该计划任务吗？',
	'enable_confirm'	=> '您确定要启用该计划任务吗？',
	'do_confirm'		=> '您确定要执行该计划任务吗？',
	
	'label_cron_name'		=> '计划任务名称：',
	'label_cron_desc'		=> '计划任务描述：',
	'label_cron_time'		=> '计划任务执行时间：',
	'label_cron_minute'		=> '分钟：',
	'label_cron_run_once'	=> '执行后关闭：',
	'label_cron_advance'	=> '高级选项：',
	'label_cron_allow_ip'	=> '允许执行的服务器IP：',
	'label_cron_advance'	=> '高级选项：',
	
	'cron_manage'		=> '计划任务管理',
	'cron_update'		=> '计划任务更新',
	'plugin_name_empty'	=> '计划任务插件名称不能为空',
	'plugin_exist'		=> '安装的插件已存在',

	'js_lang' => array(
		'ok'		=> '确定',
		'cancel'	=> '取消',
	)
);

// end