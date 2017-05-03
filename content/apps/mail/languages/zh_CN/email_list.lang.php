<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 程序说明
 */
return array(
	'stat' => array(
		'name' 	=> '状态',
		  0		=> '未确认',
		  1 	=> '已确认',
		  2 	=> '已退订',
	),
		
	'email_val' 		=> '邮件地址',
	'export' 			=> '导出列表',
	'id' 				=> '编号',
	'button_remove' 	=> '删除',
	'button_unremove' 	=> '确认',
	'button_exit' 		=> '退订',
	'no_select_email' 	=> '没有选定的Email',
		
	'batch_remove_succeed' 	=> '批量删除成功',
	'batch_unremove_succeed'=> '批量确认成功',
	'batch_exit_succeed' 	=> '批量退订成功',
	'back_list' 			=> '返回邮件列表',
	'button_selected' 		=> '批量操作',
		
	//追加
	'email_list'			=> '邮件订阅管理',
	'email_address'			=> '邮件地址是 %s',
	'email_id'				=> '邮件编号是 %s',
	'select_operate'		=> '请选择要进行的操作',
	'batch'					=> '批量操作',
		
	'select_remove_email'	=> '请先选中要删除的邮件订阅！',
	'select_ok_email'		=> '请先选中要确认的邮件订阅！',
	'select_exit_email'		=> '请先选中要退订的邮件订阅！',
	'batch_remove_confirm'	=> '您确定要删除选中的邮件订阅吗？',
	'batch_ok_confirm'		=> '您确定要确认选中的邮件订阅吗？',
	'batch_exit_confirm'	=> '您确定要退订选中的邮件订阅吗？',
	'remove_email'			=> '删除订阅邮件',
	'ok_email'				=> '确认订阅邮件',
	'exit_email'			=> '退订订阅邮件',
	
	'email_manage'			=> '邮件管理',
	'email_send_list'		=> '邮件队列管理',
	'mail_template'			=> '邮件模板',
	'mail_template_settings'=> '邮件服务器设置',
	'email_list_update'		=> '邮件订阅更新',
	'email_list_delete'		=> '邮件订阅删除',
	'email_sendlist_manage'	=> '邮件队列管理',
	'email_sendlist_send'	=> '邮件队列发送',
	'email_sendlist_delete'	=> '邮件队列删除',
	'mail_template_manage'	=> '邮件模板管理',
	'mail_template_update'	=> '邮件模板更新',
	
	'email'					=> '邮件',
	'subscription_email'	=> '订阅邮件',
	'batch_send'			=> '批量发送',
	'all_send'				=> '全部发送',
	'batch_exit'			=> '批量退订',
	'batch_ok'				=> '批量确定',
	'batch_setup'			=> '批量设置',
	
	'overview'				=> '概述',
	'more_info'				=> '更多信息：',
	'email_list_help'		=> '欢迎访问ECJia智能后台邮件订阅管理页面，系统中所有准备发送的邮件都会显示在此队列中。',
	'about_email_list'		=> '关于邮件订阅管理帮助文档',
);

//end