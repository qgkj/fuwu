<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 管理中心邮件模板管理语言文件
 */
return array(
	'select_template' 	=> '邮件模版',
	'update_success' 	=> '保存模板内容成功。',
	'update_failed' 	=> '保存模板内容失败。',
	'mail_id' 			=> '编号',
	'mail_add' 			=> '添加邮件模板',
	'mail_edit' 		=> '编辑邮件模板',
	'mail_subject' 		=> '邮件主题',
	'mail_type'		 	=> '邮件类型',
	'mail_plain_text' 	=> '纯文本邮件',
	'mail_html' 		=> 'HTML 邮件',
	'mail_info' 		=> '模板内容',
	
	/* 模板描述 */
	'order_confirm' 		=> '订单确认模板',
	'deliver_notice' 		=> '发货通知模板',
	'send_password' 		=> '发送密码模板',
	'order_cancel' 			=> '订单取消模板',
	'order_invalid' 		=> '订单无效模板',
	'send_bonus' 			=> '发送红包模板',
	'group_buy' 			=> '团购商品模板',
	'register_validate' 	=> '邮件验证模板',
	'virtual_card' 			=> '虚拟卡片模板',
	'remind_of_new_order' 	=> '新订单提醒模板',
	'goods_booking' 		=> '缺货回复模板',
	'user_message' 			=> '留言回复模板',
	'recomment' 			=> '用户评论回复模板',
		
	'subject_empty' 		=> '对不起，邮件的主题不能为空。',
	'content_empty' 		=> '对不起，邮件的内容不能为空。',
		
	'js_lang' => array(
		'save_confirm' 		=> '您已经修改了模板内容，您确定不保存么？',
		'sFirst'			=> '首页',
		'sLast' 			=> '尾页',
		'sPrevious'			=> '上一页',
		'sNext'				=> '下一页',
		'sInfo'				=> '共_TOTAL_条记录 第_START_条到第_END_条',
		'sZeroRecords' 		=> '没有找到任何记录',
		'sEmptyTable' 		=> '没有找到任何记录',
		'sInfoEmpty'		=> '共0条记录',
		'sInfoFiltered'		=> '（从_MAX_条数据中检索）',
		'subject_required'	=> '邮件主题不能为空！',
		'content_required'	=> '模板内容不能为空！',
	),
	
	'template_not_exist'	=> '邮件模板不存在，请访问正确的邮件模板！',
	'update'				=> '更新',
	'mail_template'			=> '邮件模板',
	'template_name'			=> '邮件模板',
	'label_template_name'	=> '邮件模板：',
	'label_mail_subject'	=> '邮件主题：',
	'label_mail_type'		=> '邮件类型：',
	'label_mail_info'		=> '模板内容：',
	
	'overview'				=> '概述',
	'more_info'				=> '更多信息：',
	'template_list_help'	=> '欢迎访问ECJia智能后台邮件模板列表页面，系统中所有的邮件模板都会显示在此列表中。',
	'about_template_list'	=> '关于邮件模板列表帮助文档',
	
	'edit_template_help'	=> '欢迎访问ECJia智能后台编辑邮件模板页面，可以在此编辑相应的邮件模板信息。',
	'about_edit_template'	=> '关于编辑邮件模板帮助文档',
);

//end