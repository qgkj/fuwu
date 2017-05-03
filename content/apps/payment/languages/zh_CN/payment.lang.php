<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 管理中心支付方式管理语言文件
 */
return array(
	'02_payment_list' 	=> '支付方式',
	'payment' 			=> '支付方式',
	'payment_name' 		=> '名称',
	'version' 			=> '版本',
	'payment_desc' 		=> '描述',
	'short_pay_fee' 	=> '费用',
	'payment_author' 	=> '插件作者',
	'payment_is_cod' 	=> '货到付款：',
	'payment_is_online' => '在线支付：',
	
	'enable' 		=> '启用',
	'disable' 		=> '禁用',
	'name_edit' 	=> '支付方式名称',
	'payfee_edit' 	=> '支付方式费用',
	'payorder_edit' => '支付方式排序',
	'name_is_null' 	=> '您没有输入支付方式名称！',
	'name_exists' 	=> '该支付方式名称已存在！',
	'pay_fee' 		=> '支付手续费',
	'back_list' 	=> '返回支付方式列表',
	'install_ok' 	=> '安装成功',
	'edit_ok' 		=> '编辑成功',
	'edit_falid' 	=> '编辑失败',
	'uninstall_ok' 	=> '卸载成功',

	'find_order_sn' =>	'请输入商城订单编号',
	'find_trade_no' =>	'请输入流水号',

	'invalid_pay_fee' 		=> '支付费用不是一个合法的价格',
	'decide_by_ship' 		=> '配送决定',
	'edit_after_install' 	=> '该支付方式尚未安装，请你安装后再编辑',
	'payment_not_available' => '该支付插件不存在或尚未安装',
	
	'js_lang' => array(
		'lang_removeconfirm' 	=> '您确定要卸载该支付方式吗？',
		'pay_name_required'		=> '请输入支付名称',
		'pay_name_minlength'	=> '支付名称长度不能小于3',
		'pay_desc_required'		=> '请输入支付描述',
		'pay_desc_minlength'	=> '支付描述长度不能小于6',
	),

	'wait_for_payment'		=>	'等待付款',
	'payment_success'		=>	'付款成功',
	'heading_order_info' 	=> '订单信息',
	'fund_flow_record' 	=> '资金流水记录',
	'transaction_flow_record'	=> '交易流水记录',
	'view_flow_record'	=> '查看交易流水记录',
	'order_id' 		=> '编号',
	'order_sn' 		=> '商城订单编号',
	'trade_type' 	=> '交易类型',
	'trade_no' 		=> '流水号',
	'pay_code' 		=> '支付方式',
	'pay_name' 		=> ' 支付名称',
	'total_fee' 	=> '支付金额',
	'create_time' 	=> '创建时间',
	'update_time' 	=> '修改更新时间',
	'pay_time' 	=> '支付成功时间',
	'pay_status' 	=> '交易状态',
	'pay_not_exist' => '此支付方式不存在或者参数错误！',
	'pay_disabled' 	=> '此支付方式还没有被启用！',
	'pay_success' 	=> '您此次的支付操作已成功！',
	'pay_fail' 		=> '支付操作失败，请返回重试！',
	'buy'			=>	'消费',
	'refund'		=>	'退款',
	'deposit'		=>	'充值',
	'withdraw'		=>	'提现',

	'ctenpay' 		=> '立即注册财付通商户号',
	'ctenpay_url' 	=> 'http://union.tenpay.com/mch/mch_register_b2c.shtml?sp_suggestuser=542554970',
	'ctenpayc2c_url'=> 'https://www.tenpay.com/mchhelper/mch_register_c2c.shtml?sp_suggestuser=542554970',
	'tenpay'  		=> '即时到账',
	'tenpayc2c'		=> '中介担保',
			
	'dualpay'			=> '标准双接口',
	'escrow'			=> '担保交易接口',
	'fastpay'			=> '即时到帐交易接口',
	'alipay_pay_method'	=> '选择接口类型：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
	'getPid'			=> '获取Pid、Key',
	
	//追加
	'repeat'					=> '已存在',
	'buyer'						=> '买家',
	'surplus_type_0'			=> '充值',
	'order_gift_integral'		=> '订单 %s 赠送的积分',
	'please_view_order_detail' 	=> '商品已发货，详情请到用户中心订单详情查看',
	'plugin'					=> '插件',
	'disabled'					=> '已停用',
	'enabled'					=> '已启用',
	'edit_payment'				=> '编辑支付方式',
	'payment_list'				=> '支付方式列表',
	'number_valid'				=> '请输入合法数字',
	'enter_valid_number'		=> '请输入合法数字或百分比%',
	'edit_free_as'				=> '修改费用为  %s',
	'edit_payment_name'			=> '编辑支付方式名称',
	'edit_payment_order'		=> '编辑支付方式排序',
	'label_payment_name'		=> '名称：',
	'label_payment_desc'		=> '描述：',
	'label_pay_fee'				=> '支付手续费：',
	
	'payment_manage'		=> '支付方式管理',
	'payment_update'		=> '支付方式更新',
	'plugin_install_error'	=> '支付方式名称或pay_code不能为空',
	'plugin_uninstall_error'=> '支付方式名称不能为空',
	
	'overview'             	=> '概述',
	'more_info'             => '更多信息：',
	
	'payment_list_help'		=> '欢迎访问ECJia智能后台支付方式页面，系统中所有的支付方式都会显示在此列表中。',
	'about_payment_list'	=> '关于支付方式帮助文档',

);

// end