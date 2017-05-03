<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 会员管理语言文件
 */
return array(
	/* 列表页面 */
	'label_user_name' 		=> '名称',
	'label_pay_points_gt' 	=> '会员积分大于',
	'label_pay_points_lt' 	=> '会员积分小于',
	'label_rank_name' 		=> '会员等级',
	'all_option' 			=> '所有等级',
	
	'view_order' 	=> '查看订单',
	'view_deposit' 	=> '查看账目明细',
	'username' 		=> '会员名称',
	'email' 		=> '邮件地址',
	'is_validated' 	=> '已验证',
	'not_validated'	=> '未验证',
	'reg_date' 		=> '注册日期',
	'button_remove' => '删除会员',
	'users_edit' 	=> '编辑会员账号',
	'goto_list' 	=> '返回会员账号列表',
	'username_empty'=> '会员名称不能为空！',
	'validated'		=> '（已验证）',
	
	/* 表单相关语言项 */
	'password' 			=> '登录密码',
	'confirm_password'  => '确认密码',
	'newpass'	=> '新密码',
	'question'	=> '密码提示问题',
	'answer' 	=> '密码提示问题答案',
	'gender' 	=> '性别',
	'birthday' 	=> '出生日期',
		
	'sex' => array(
		0 => '保密',
		1 => '男',
		2 => '女',
	),
		
	'pay_points' 			=> '消费积分',
	'rank_points' 			=> '等级积分',
	'user_money' 			=> '可用资金',
	'frozen_money' 			=> '冻结资金',
	'pay_points_lable' 		=> '消费积分：',
	'rank_points_lable' 	=> '等级积分：',
	'user_money_lable' 		=> '可用资金：',
	'frozen_money_lable' 	=> '冻结资金：',
		
	'credit_line' 			=> '信用额度',
	'user_rank' 			=> '会员等级',
	'not_special_rank' 		=> '非特殊等级',
	'view_detail_account' 	=> '查看明细',
	'parent_user' 			=> '推荐人',
	'parent_user_lable' 	=> '推荐人：',
	'parent_remove' 		=> '脱离推荐关系',
	'affiliate_user' 		=> '推荐会员',
	'show_affiliate_users' 	=> '查看推荐详细名单',
	'show_affiliate_orders' => '查看推荐订单详情',
	'affiliate_lever' 		=> '等级',
	'affiliate_num' 		=> '人数',
	'page_note' 			=> '此列表显示用户推荐的全部会员信息，',
	'how_many_user' 		=> '个会员。',
	'back_note' 			=> '返回会员编辑页面',
	'affiliate_level' 		=> '推荐等级',
	
	'msn' 					=> 'MSN',
	'qq'  					=> 'QQ',
	'home_phone'    		=> '家庭电话',
	'office_phone' 		 	=> '办公电话',
	'mobile_phone'  		=> '手机号',
	'msn_lable' 			=> 'MSN：',
	'qq_lable'  			=> 'QQ：',
	'home_phone_lable' 		=> '家庭电话：',
	'office_phone_lable' 	=> '办公电话：',
	'mobile_phone_lable' 	=> '手机：',
	
	'notice_pay_points'		=> '消费积分是一种站内货币，允许用户在购物时支付一定比例的积分。',
	'notice_rank_points'	=> '等级积分是一种累计的积分，系统根据该积分来判定用户的会员等级。',
	'notice_user_money'		=> '用户在站内预留下的金额',
	
	/* 提示信息 */
	'keep_add' 			=> '继续添加会员',
	'edit_success' 		=> '编辑成功！',
	'not_empty' 		=> '会员名不为空！',
	
	'username_exists' 	=> '已经存在一个相同的用户名。',
	'email_exists' 		=> '该邮件地址已经存在。',
	'edit_user_failed' 	=> '修改会员资料失败。',
	'invalid_email' 	=> '输入了非法的邮件地址。',
	'update_success' 	=> '编辑用户信息已经成功。',
	'still_accounts' 	=> '该会员有余额或欠款\n',
	'remove_confirm' 	=> '您确定要删除该会员账号吗？',
	
	'list_still_accounts' 	=> '选中的会员账户中仍有余额或欠款\n',
	'list_remove_confirm' 	=> '您确定要删除所有选中的会员账号吗？',
	'remove_order_confirm' 	=> '该会员账号已经有订单存在，删除该会员账号的同时将清除订单数据。<br />您确定要删除吗？',
	'remove_order' 			=> '是，我确定要删除会员账号及其订单数据',
	
	'remove_cancel' 	=> '不，我不想删除该会员账号了。',
	'remove_success' 	=> '会员账号 %s 已经删除成功。',
	'add_success' 		=> '会员账号 %s 已经添加成功。',
	
	'batch_remove_success' 	=> '已经成功删除了 %d 个会员账号。',
	'no_select_user' 		=> '您现在没有需要删除的会员！',
	'register_points' 		=> '注册送积分',
	'username_not_allow' 	=> '用户名不允许注册',
	'username_invalid' 		=> '无效的用户名',
	'email_invalid' 		=> '无效的email地址',
	'email_not_allow' 		=> '邮件不允许',
	
	/* 地址列表 */
	'address_list'	=> '收货地址',
	'consignee' 	=> '收货人',
	'address' 		=> '详细地址',
	'link' 			=> '联系方式',
	'other' 		=> '其他',
	'tel' 			=> '电话',
	'mobile' 		=> '手机',
	'best_time' 	=> '最佳送货时间',
	'sign_building' => '标志建筑',
	
	/* JS 语言项 */
	'js_languages' => array(
		'no_username' 			=> '没有输入用户名。',
		'invalid_email' 		=> '没有输入邮件地址或者输入了一个无效的邮件地址。',
		'chinese_password' 		=> '密码不能有中文或非法字符。',
		'no_password' 			=> '没有输入密码。',
		'less_password' 		=> '输入的密码不能少于六位。',
		'passwd_balnk' 			=> '密码中不能包含空格 。',
		'no_confirm_password' 	=> '没有输入确认密码。',
		'password_not_same' 	=> '确认密码和输入的密码不一致。',
		'invalid_pay_points' 	=> '消费积分数不是一个整数。',
		'invalid_rank_points' 	=> '等级积分数不是一个整数。',
		'password_len_err' 		=> '密码和确认密码的长度不能小于6 。',
		'credit_line' 			=> '信用额度不为空且为数值类型 。',
	),
	
	//追加
	'user_list'			=>	'会员列表',
	'user_add' 			=>  '添加会员',
	'back_user_list' 	=>  '返回会员列表',
	'add_user_success' 	=> 	'会员账号添加成功。',
	'delete_user_success' 	=> 	'会员账号删除成功。',
	'user_info'				=>	'会员详情',
	'user_info_confirm'		=>	'没有查询到该会员的信息',
	'mailbox_information'	=>	'邮箱信息',
	
	'bulk_operations'	=>	'批量操作',
	'filter'			=>	'筛选',
	'serach'			=>	'搜索',
	'serach_condition'	=>	'请输入会员名称/邮箱',
	'select_user'		=> 	'请先选中要删除的用户',
	'delete_confirm'	=>	'删除会员将清除该会员的所有信息，您确定要这么做吗？',
	'details'			=>	'详细信息',
	'delete'			=>	'删除',
	'edit_email_address'=>	'编辑邮箱地址',
	
	'id_confirm'				=>	'请输入ID或会员名称或邮箱',
	'view'						=>	'查看',
	'member_information'		=>	'会员信息',
	'edit'						=>	'编辑',
	'email'						=>	'会员邮箱',
	'registration_time'		 	=>	'注册时间',
	'lable_registration_time'	=>	'注册时间：',
	'email_verification'		=>	'邮箱验证',
	'email_verification_lable'	=>	'邮箱验证：',
	'last_login_time'			=>	'最后登录时间',
	'last_login_time_lable'		=>	'最后登录时间：',
	'last_login_ip'				=>	'最后登录IP',
	'last_login_ip_lable'		=>	'最后登录IP：',
	'users_money'				=>	'用户资金',
	'more'						=>	'更多',
	'default_address'			=>	'(默认地址)',
	'zip_code'					=>	'邮编',
	'no_address'  				=>  '该用户暂无收货地址',
	
	'member_order'	=>	'会员订单',
	'order_number'	=>	'订单号',
	'order_time'	=>	'下单时间',
	'receiver_name'	=>	'收货人',
	'total_amount'	=>	'总金额',
	'order_status'	=>	'订单状态',
	'no_order_information'	=>	'该会员暂无订单信息',
	
	'region'					=> '所在地区',
	'telephone_phone'			=> '电话/手机',
	
	'current_members'			=>	'当前会员：',
	'default_address_two'		=>	'默认地址',
	'full_address'				=>	'全部地址',
	'member_basic_information'	=>	'会员基础信息',
	'user_names' 				=>	'会员名称：',
	'membership_details' 		=>	'会员详细信息',
	'select_date'				=>	'选择日期',
	
	'label_email'				=> '邮件地址：',
	'label_password'			=> '登录密码：',
	'label_newpass'				=> '新密码：',
	'label_confirm_password'	=> '确认密码：',
	'label_user_rank'			=> '会员等级：',
	'label_gender'				=> '性别：',
	'label_birthday'			=> '出生日期：',
	'label_credit_line'			=> '信用额度：',
	
	'invalid_parameter'		=> '参数无效',
	'create_user_failed'	=> '创建参数失败',
	'invalid_email'			=> 'email地址格式错误',
	'not_exists_info'		=> '不存在的信息',
	
	/*menu*/
	'user_manage'			=> '会员管理',
	'user_update'			=> '更新会员',
	'user_delete'			=> '删除会员',
	'surplus_reply'			=> '充值和提现申请',
	'account_manage'		=> '资金管理',
	'reg_fields'			=> '会员注册项设置',
	'integrate_users'		=> '会员整合',
	
	/*权限*/
	'user_account_manage'	=> '会员账户管理',
	'surplus_manage'		=> '会员余额管理',
	'user_rank_manage'		=> '会员等级管理',
	'sync_users'			=> '同步会员数据',
	
	'edit_user_failed'		=> '设置密码失败',
	'edit_password_failure'	=> '您输入的原密码不正确！',
	
	'usermoney'		=> '会员账户',
	'user_account'	=> '充值提现',
	'check'			=> '到款审核',
	'free'			=> '免费',
	'no_name'		=> '匿名购买',
			
    //js
	'keywords_required'	=>	'请先输入关键字',
	'username_required'	=>	'请输入会员名称！',
	'email_required'	=>	'请输入邮箱地址！',
	'email_check'		=>	'请输入正确的邮箱地址格式！',
	'password_required'	=>	'请输入密码！',
	'password_length'	=>	'密码长度不能小于6！',
	'password_check'	=>	'两次密码不一致！',
	
	//help
	'overview'				=> '概述',
	'more_info'				=> '更多信息：',
	
	//会员
	'user_list_help'		=> '欢迎访问ECJia智能后台会员列表页面，系统中所有的会员都会显示在此列表中。',
	'about_user_list'		=> '关于会员列表帮助文档',
	'user_add_help'			=> '欢迎访问ECJia智能后台添加会员页面，在此页面可以进行添加会员操作。',
	'about_add_user'		=> '关于添加会员帮助文档',
	'user_edit_help'		=> '欢迎访问ECJia智能后台编辑会员页面，在此页面可以进行编辑会员操作。',
	'about_edit_user'		=> '关于编辑会员帮助文档',
	'user_view_help'		=> '欢迎访问ECJia智能后台会员详情页面，在此页面可以进行对会员的详细信息查看。',
	'about_view_user'		=> '关于查看会员帮助文档',
	'user_address_help'		=> '欢迎访问ECJia智能后台会员收获地址列表页面，系统中所有的会员收获地址都会显示在此列表中。',
	'about_address_user'	=> '关于会员收获地址列表帮助文档',
	
	//会员注册
	'user_register_help'	=> '欢迎访问ECJia智能后台会员注册项列表页面，系统中所有的会员注册项都会显示在此列表中。',
	'about_user_register'	=> '关于会员注册项帮助文档',
	'add_register_help'		=> '欢迎访问ECJia智能后台添加会员注册项页面，在此页面可以进行添加会员注册项操作。',
	'about_add_register'	=> '关于添加会员注册项帮助文档',
	'edit_register_help'	=> '欢迎访问ECJia智能后台编辑会员注册项页面，在此页面可以进行编辑会员注册项操作。',
	'about_edit_register'	=> '关于编辑会员注册项帮助文档',
	
	//会员等级
	'user_rank_help'		=> '欢迎访问ECJia智能后台会员等级列表页面，系统中所有的会员等级都会显示在此列表中。',
	'about_user_rank'		=> '关于会员等级列表帮助文档',
	'add_rank_help'			=> '欢迎访问ECJia智能后台添加会员等级页面，在此页面可以进行添加会员等级操作。',
	'about_add_rank'		=> '关于添加会员等级帮助文档',
	'edit_rank_help'		=> '欢迎访问ECJia智能后台编辑会员等级页面，在此页面可以进行编辑会员等级操作。',
	'about_edit_rank'		=> '关于编辑会员等级帮助文档',
	
	//会员整合
	'user_integrate_help'	=> '欢迎访问ECJia智能后台会员整合页面，用户可通过蓝色背景提示信息对会员进行相应的整合操作。',
	'about_user_integrate'	=> '关于会员整合帮助文档',
	
	//充值和体现申请
	'user_account_help'		=> '欢迎访问ECJia智能后台充值和提现申请列表页面，系统中所有的充值和提现申请都会显示在此列表中。',
	'about_user_account'	=> '关于充值和提现申请帮助文档',
	'add_account_help'		=> '欢迎访问ECJia智能后台添加充值和提现申请页面，在此页面可以进行添加充值和提现申请操作。',
	'about_add_account'		=> '关于添加充值和提现申请帮助文档',
	'edit_account_help'		=> '欢迎访问ECJia智能后台编辑充值和提现申请页面，在此页面可以进行编辑充值和提现申请操作。',
	'about_edit_account'	=> '关于编辑充值和提现申请帮助文档',

	//资金管理
	'user_account_manage_help'	=> '欢迎访问ECJia智能后台资金管理页面，在此页面进行日期筛选，可以查看某个时间段的有关会员账户信息。',
	'about_user_account_manage'	=> '关于资金管理帮助文档',
	
	//账目明细
	'user_account_log_help'		=> '欢迎访问ECJia智能后台会员账户信息页面，在此页面可以查看有关会员的所有账户信息。',
	'about_user_account_log'	=> '关于会员账户信息帮助文档',
	'add_account_log_help'		=> '欢迎访问ECJia智能后台调节会员账户页面，在此页面可以对会员的账户进行调节操作。',
	'about_add_account_log'		=> '关于调节会员账户帮助文档',
);

// end