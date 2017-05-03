<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 程序说明
 */
return array(
	'email_val' 	=> '邮件地址',
	'email_error' 	=> '错误次数',
	'email_subject' => '邮件标题',
	'delete' 		=> '删除',
	'ckdelete' 		=> '确定删除?',
	'del_ok' 		=> '共删除 %d 条记录，删除成功！',
	'no_select' 	=> '未选择对象！',
	'last_send' 	=> '上次发送于',
	
	'pri' => array(
		'name' 	=> '优先级',
	       0	=> '普通',
	       1 	=> '高',
	),
	
	'type' => array(
		'name' 		=> '邮件类型',
		'magazine' 	=> '杂志订阅',
		'template' 	=> '关注订阅',
	),
	
	'button_remove' 	=> '删除',
	'batch_send' 		=> '选择发送',
	'all_send' 			=> '全部发送',
	'mailsend_null' 	=> '邮件发送列表空！',
	'mailsend_finished' => '共 %d 条邮件发送完成！',
	'send_end' 			=> '共发送 %d 条记录，选择邮件发送完成！',
		
	'no_use' 			=> '未使用',
	'email_send_list'	=> '邮件队列管理',
	'email_title'		=> '邮件标题是 %s',
	'email_address'		=> '邮件地址是 %s',
	'select_operate'	=> '请选择要进行的操作',
	'batch'				=> '批量操作',
		
	'remove_mail_send'		=> '删除邮件发送',
	'select_mail_send'		=> '选择邮件发送',
	'batch_remove_confirm'	=> '您确定要删除选中的邮件吗？',
	'batch_send_confirm'	=> '您确定要发送选中的邮件吗？',
	'select_remove_email'	=> '请先选中要删除的邮件！',
	'select_send_email'		=> '请先选中要发送的邮件！',
	'all_typemail'			=> '所有邮件类型',
	'all_levels'			=> '所有级别',
	'filter'				=> '筛选',
	'send_errors'			=> '次发送错误',
	'drop_mail_confirm'		=> '您确定要删除该邮件信息吗？',
	
	'overview'				=> '概述',
	'more_info'				=> '更多信息：',
	'send_list_help'		=> '欢迎访问ECJia智能后台邮件队列管理页面，系统中所有准备发送的邮件都会显示在此队列中。',
	'about_send_list'		=> '关于邮件队列管理帮助文档',
	
	'js_lang' => array(
		'data_loading'		=> '数据加载中, 请稍等...',
		'sending_email'		=> '正在发送邮件, 请稍等...',
		'no_match_records'	=> '没有找到匹配的记录！',
		'send_confirm'		=> '您确定要这么做吗？',
		'ok'				=> '确定',
		'cancel'			=> '取消',
		'select_send_email'	=> '请先选中要发送的邮件！',
		'batch_send_confirm'=> '您确定要发送选中的邮件吗？',
	)
);

//end