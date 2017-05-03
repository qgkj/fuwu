<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 管理员留言语言文件
 */

return array(
	'sender_id'		=> '留言者',
	'receiver_id'	=> '接收者',
	'send_date'		=> '发送日期',
	'read_date'		=> '阅读日期',
	'readed'		=> '是否已读',
	'deleted'		=> '是否删除',
	'title'			=> '留言主题',
	'message'		=> '留言内容',
	
	'view_msg'		=> '查看留言',
	'reply_msg'		=> '回复留言',
	'send_msg'		=> '发送留言',
	'edit_msg'		=> '编辑留言',
	'drop_msg'		=> '删除留言',
	'all_amdin'		=> '所有管理员',
	'msg_list'		=> '留言列表',
	'no_read'		=> '未阅读',
	'next_list'		=> '下一条',
	'action_succeed'=> '操作成功!',
	
	'back_list'			=> '返回留言列表',
	'continue_send_msg'	=> '继续发送留言',
	
	/* 提示信息 */
	'js_languages'  => array(
		'title_empty'	=> '请填写留言主题!',
		'message_empty'	=> '请填写留言内容!',
	),

	'select_msg_type'=> '选择查看类型',
	
	'message_type'  => array(
		0 => '所有留言',
		1 => '所有收到的留言',
		2 => '所有发送的留言',
		3 => '未阅读的留言',
		4 => '已阅读的留言',
	),

	'drop_msg'	=> '删除选中',
	
	'batch_drop_success'=> '成功删除了 %d 个留言记录',
	'no_select_msg'		=> '您现在没有任何留言记录',
);

// end