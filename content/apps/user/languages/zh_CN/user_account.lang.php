<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 会员充值提现管理语言项
 */
return array(
	'edit' 			=> '编辑',
	'user_surplus' 	=> '预付款',
	'surplus_id' 	=> '编号',
	'user_id' 		=> '会员名称',
	'surplus_amount'=> '金额',
	'add_date' 		=> '操作日期',
	'pay_mothed' 	=> '支付方式',
	'process_type' 	=> '类型',
	'confirm_date' 	=> '到款日期',
	'surplus_notic' => '管理员备注',
	'surplus_desc' 	=> '会员描述',
	'surplus_type' 	=> '操作类型',
	'no_user' 		=> '匿名购买',
		
	'surplus_type' => array(
		0 => '充值',
		1 => '提现',
	),
		
	'admin_user'	=> '操作员',
	'status' 		=> '到款状态',
	'confirm' 		=> '已完成',
	'unconfirm' 	=> '未确认',
	'cancel' 		=> '取消',
	'please_select' => '请选择...',
	'surplus_info' 	=> '会员金额信息',
	'check' 		=> '到款审核',
	
	'money_type' 		  	=> '币种',
	'surplus_add' 			=> '添加申请',
	'surplus_edit' 			=> '编辑申请',
	'attradd_succed' 		=> '您此次操作已成功！',
	'username_not_exist' 	=> '您输入的会员名称不存在！',
	'cancel_surplus' 		=> '您确定要取消这条记录吗?',
	'surplus_amount_error' 	=> '要提现的金额超过了此会员的帐户余额，此操作将不可进行！',
	'edit_surplus_notic' 	=> '现在的状态已经是 已完成，如果您要修改，请先将之设置为 未确认',
	'back_list' 			=> '返回充值和提现申请',
	'continue_add' 			=> '继续添加申请',
	'user_name_keyword' 	=> '请输入会员名称关键字',
	
	/* 提示信息  */
	'drop_success'			=> '删除成功！',
	'add_success' 			=> '添加成功！',
	'edit_success' 			=> '编辑成功！',
	
	/* JS语言项 */
	'js_languages' => array(
		'user_id_empty' 		=> '会员名称不能为空！',
		'deposit_amount_empty' 	=> '请输入充值的金额！',
		'pay_code_empty' 		=> '请选择支付方式',
		'deposit_amount_error'	=> '请按正确的格式输入充值的金额！',
		'deposit_type_empty' 	=> '请填写类型！',
		'deposit_notic_empty' 	=> '请填写管理员备注！',
		'deposit_desc_empty' 	=> '请填写会员描述！',
	),
	
	'recharge_withdrawal_apply' 		=> '充值提现申请',
	'log_username' 						=> '会员名称是',
	'batch_deletes_ok' 					=> '批量删除成功',
	'update_recharge_withdrawal_apply' 	=> '更新充值提现申请',
	'bulk_operations'					=> '批量操作',
	'application_confirm'				=> '已完成的申请无法被删除，你确定要删除选中的列表吗？',
	'select_operated_confirm'			=> '请选中要操作的项',
	'batch_deletes' 					=> '批量删除',
	'to' 								=> '至',
	'filter'							=> '筛选',
	'start_date' 						=> '开始日期',
	'end_date' 							=> '结束日期',
	'delete'							=> '删除',
	'delete_surplus_confirm'			=> '您确定要删除充值提现记录吗？',
	'user_information'					=> '会员信息',
	'anonymous_member' 					=> '匿名会员',
	'yuan'								=> '元',
	'deposit'							=> '充值',
	'withdraw'							=> '提现',
	'edit_remark'						=> '编辑备注',
	
	'label_user_id' 			=> '会员名称：',
	'label_surplus_amount'		=> '金额：',
	'label_pay_mothed' 			=> '支付方式：',
	'label_process_type' 		=> '类型：',
	'label_surplus_notic' 		=> '管理员备注：',
	'label_surplus_desc' 		=> '会员描述：',
	'label_status' 				=> '到款状态：',
	'submit_update'				=> '更新',
	
	'keywords_required'			=> '请输入关键字',
	'username_required'			=> '请输入会员名称',
	'amount_required'			=> '请输入金额',
	'check_time'				=> '开始时间不得大于结束时间！',
	
	'user_name_is'				=> '会员名称是%s，',
	'money_is'					=> '金额是%s',
	'delete_record_count'		=> '本次删除了 %s 条记录',
	'select_operate_item'		=> '请先选择需要操作的项',
	'withdraw_apply'			=> '提现申请',
	'pay_apply'					=> '充值申请',
	
);

// end