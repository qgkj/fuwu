<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 虚拟卡管理
 */
return array(
	/*------------------------------------------------------ */
	//-- 卡片信息
	/*------------------------------------------------------ */
	'virtual_card_list' => '虚拟商品列表',
	'return_list'		=> '返回虚拟商品列表',
	'lab_goods_name' 	=> '商品名称 ：',
	'replenish' 		=> '补货',
	'card_sn' 			=> '卡片序号',
	'card_password' 	=> '卡片密码',
	'end_date' 			=> '截至日期',
	'lab_card_id' 		=> '编号',
	'lab_card_sn' 		=> '卡片序号：',
	'lab_card_password' => '卡片密码：',
	'lab_end_date' 		=> '截至日期：',
	'lab_is_saled' 		=> '是否已出售',
	'lab_order_sn' 		=> '订单号',
	'action_success' 	=> '操作成功',
	'action_fail' 		=> '操作失败',
	'card' 				=> '卡片列表',
	
	'batch_card_add' 	=> '批量添加补货',
	'download_file' 	=> '下载批量CSV文件',
	'separator' 		=> '分隔符：',
	'uploadfile' 		=> '上传文件：',
	'sql_error' 		=> '第 %s 条信息出错：<br /> ',
		
	/* 提示信息 */
	'replenish_no_goods_id' 		=> '缺少商品ID参数，无法进行补货操作',
	'replenish_no_get_goods_name' 	=> '商品ID参数有误，无法获取商品名',
		
	'drop_card_success' => '该记录已成功删除',
	'batch_drop' 		=> '批量删除',
	'drop_card_confirm' => '你确定要删除该记录吗？',
	'card_sn_exist' 	=> '卡片序号 %s 已经存在，请重新输入',
	'go_list' 			=> '返回补货列表',
	'continue_add' 		=> '继续补货',
	'uploadfile_fail' 	=> '文件上传失败',
	'batch_card_add_ok' => '已成功添加了 %s 条补货信息',
		
	'js_languages' => array(
		'no_card_sn' 			=> '卡片序号和卡片密码不能都为空。',
		'separator_not_null' 	=> '分隔符号不能为空。',
		'uploadfile_not_null' 	=> '请选择要上传的文件。',
		'updating_info' 		=> '<strong>正在更新</strong>（每次 100 条记录）',
		'updated_info' 			=> '<strong>已更新</strong> <span id=\"updated\">0</span> 条记录。',
	),
		
	'use_help' => '使用说明：' .
			'<ol>' .
			'<li>上传文件应为CSV文件<br />' .
			'CSV文件第一列为卡片序号；第二列为卡片密码；第三列为使用截至日期。<br />'.
			'(用EXCEL创建csv文件方法：在EXCEL中按卡号、卡片密码、截至日期的顺序填写数据，完成后直接保存为csv文件即可)'.
			'<li>密码，和截至日期可以为空，截至日期格式为2006-11-6或2006/11/6'.
			'<li>卡号、卡片密码、截至日期中不要使用中文</li>' .
			'</ol>',
	/*------------------------------------------------------ */
	//-- 改变加密串
	/*------------------------------------------------------ */
	'virtual_card_change' => '更改加密串',
	'user_guide' => '使用说明：' .
			'<ol>' .
			'<li>加密串是在加密虚拟卡类商品的卡号和密码时使用的</li>' .
			'<li>加密串保存 shop_config中，对应的code是 auth_key</li>' .
			'<li>如果要更改加密串在下面的文本框中输入原加密串和新加密串，点\'确定\'按钮后即可</li>' .
			'</ol>',
	'label_old_string' 	=> '原加密串：',
	'label_new_string' 	=> '新加密串：',
	
	'invalid_old_string'=> '原加密串不正确',
	'invalid_new_string'=> '新加密串不正确',
	'change_key_ok' 	=> '更改加密串成功',
	'same_string' 		=> '新加密串跟原加密串相同',
		
	'update_log' 	=> '更新记录',
	'old_stat' 		=> '总共有记录 %s 条。已使用新串加密的记录有 %s 条，使用原串加密（待更新）的记录有 %s 条，使用未知串加密的记录有 %s 条。',
	'new_stat' 		=> '<strong>更新完毕</strong>，现在使用新串加密的记录有 %s 条，使用未知串加密的记录有 %s 条。',
	'update_error' 	=> '更新过程中出错：%s',
	
	//追加
	'batch_replenish'			=> '批量补货',
	'edit_replenish'			=> '编辑补货',
	'card_not_empty'			=> '卡片序号或者卡片密码不能为空！',
	'card_exists'				=> '虚拟卡 %s 已经存在',
	'insert_records'			=> '本次插入 %s 条记录',
	'batch_replenish_success' 	=> '批量补货成功！',
	'card_edit_success'			=> '虚拟卡 %s 编辑成功',
	'update_records'			=> '本次更新 %s 条记录',
	'batch_update_success'		=> '批量更新成功',
	'batch_upload'				=> '批量上传',
	'batch_replenish_confirm'	=> '批量补货确认',
	'pls_upload_file'			=> '请选择上传文件',
	'default_auth_key'			=> '检测到您之前可能未设置加密串，系统将初始化加密串为 888888,请及时修改新的加密串！',
	'update_auth_key'			=> '更新加密串为 ',
	'set_key_success'			=> '新加密串设置成功',
	'update_virtual_info'		=> '同时本次还更新了 %s 条虚拟卡信息！',
	'stats_edit_success'		=> '状态切换成功',
	'card_drop_success'			=> '虚拟卡 %s 删除成功',
	'batch_operation'			=> '批量操作',
	'batch_drop_confirm'		=> '您确定要批量删除选中的虚拟卡吗？',
	'batch_drop_empty'			=> '请先选中要操作的信息',
	'batch_edit'				=> '批量编辑',
	'enter_card_sn'				=> '请输入订单号',
	'click_change_stats'		=> '点击改变状态',
	'drop_confirm'				=> '您确定要删除该虚拟卡吗？',
	'choose_file'				=> '选择文件',
	'modify'					=> '修改',
	'return_last_page'			=> '返回上一页',
	
	'overview'				=> '概述',
	'more_info'				=> '更多信息：',
	
	'vitural_card_help'		=> '欢迎访问ECJia智能后台商品模块中的更改加密串页面，通过此页面可以对商品的加密串进行更改。',
	'about_vitural_card'	=> '关于更改加密串帮助文档',
);

// end