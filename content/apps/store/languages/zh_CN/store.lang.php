<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA应用语言包
 * @author songqian
 */
return array(

	//主菜单
	'store_manage'	=> '入驻商管理',

	//子菜单
	'store_affiliate'=> '入驻商家',
	'preaudit' 		=> '待审核商家',
	'category' 		=> '店铺分类',
	'commission' 	=> '佣金结算',
	'percent' 		=> '佣金比例',
	'config' 		=> '后台设置',
	'mobileconfig' 	=> '移动应用设置',

	//商家入驻列列表
	'store'			=>	'入驻商',
	'store_list'	=>	'入驻商列表',
	'id'			=>	'编号',
	'store_update'	=>	'编辑入驻商',
	'store_title'	=>	'店铺名称',
	'store_cat'		=>	'店铺分类',
	'sort_order'	=>	'排序',
	'view'			=>	'查看详情',
	'lock'			=>	'锁定',
	'unlock'		=> '解锁',
	'pls_name'		=>	'请输入店铺名称',
	'serach'		=>	'搜索',


	//待审核商家入驻列表
	'store_preaudit'		=>	'待审核入驻商',
	'store_preaudit_list'	=>	'待审核入驻商列表',
	'check'					=>	'审核',
	'check_view'		    =>	'审核商家',

	//通用
	'sub_update' =>'更新',
	'sub_check'	 =>'处理',
	'store_title_lable' 	=>	'店铺名称：',
	'store_cat_lable' 		=>	'店铺分类：',
	'store_keywords_lable' 	=>	'店铺关键词：',
	'lock_lable' 			=>	'是否锁定店铺：',
	'check_lable' 			=>	'审核：',
	'check_no' 				=>	'未通过',
	'check_yes' 			=>	'通过',
	'select_plz'			=>	'请选择……',
	'companyname_lable'		=>	'公司名称：',
	'person_lable'			=>	'法定代表人：',
	'email_lable'			=>	'电子邮箱：',
	'contact_lable'			=>	'联系方式：',
	'lable_contact_lable'	=>	'联系方式',
	'label_province'		=>	'所在省份： ',
	'label_city'			=>	'所在城市： ',
	'label_district'		=>	'所在市区： ',

	'address_lable'			        =>	'通讯地址：',
	'identity_type_lable'			=>	'证件类型：',
	'identity_number_lable'			=>	'证件号码：',
	'identity_pic_front_lable'		=>	'证件正面：',
	'identity_pic_back_lable'		=>	'证件反面：',
	'personhand_identity_pic_lable'	=>	'手持证件：',
	'business_licence_lable'		=>	'营业执照注册号：',
	'business_licence_pic_lable'	=>	'营业执照电子版：',
	'bank_branch_name_lable'		=>	'开户银行支行名称：',
	'bank_name_lable'				=>	'收款银行：',
	'bank_account_number_lable'		=>	'银行账号：',
	'bank_account_name_label'		=>	'账户名称： ',
	'bank_address_lable'			=>	'开户银行支行地址：',
	'remark_lable'		=>	'备注信息：',
	'longitude_lable'	=>	'经度：',
	'latitude_lable'	=>	'纬度：',
	'sort_order_lable'	=>	'排序：',
	'apply_time_lable'	=>	'申请时间：',
	'browse'			=> '浏览',
	'modify'			=> '修改',
	'change_image'		=> '更换图片',
	'file_address'		=> '文件地址：',
	'edit_success' 		=> 	'编辑成功',
	'deal_success'	 	=>	'处理成功',
	'check_success'	 	=>	'审核成功',
	'open'	 	        =>	'开启',
	'close'	 	        =>	'关闭',
	'personal'	        =>	'个人',
	'personal_name'	    =>	'个人名称：',
	'company'	        =>	'企业',
	'no_upload'         =>  '还未上传',
	'apply_time'        =>	'申请时间',
	'person'            =>	'法定代表人',
	'companyname'	    =>	'公司名称',
	'confirm_time'      =>'审核通过时间',
	'del_store_cat_img_ok' =>'删除店铺分类图片成功！',
	'anonymous'	        => '匿名用户',
	'set_commission' 	=> '设置佣金',

    'preaudit_list'     => '全部',
	'validate_type'		=>	'入驻类型：',

	'view_staff'		=>	'查看员工',
	'user_ident'		=>	'编号：',
	'employee_number'	=>	'员工编号',
	'main_name'			=>	'名称：',
	'employee_name'		=>	'员工姓名',
	'nick_name'			=>	'昵称',
	'main_email'		=>	'邮箱：',
	'email'				=>	'邮箱',
	'main_add_time'		=>	'加入时间：',
	'add_time'			=>	'加入时间',
	'main_introduction'	=>	'介绍：',
	'introduction'		=>	'描述',
	'shopowner'			=>	'店长：',
	'mobile'			=>	'联系方式：',

	'people_id'			=>	'身份证',
	'passport'			=>	'护照',
	'hong_kong_and_macao_pass'			=>	'港澳身份证',

    'edit_store'		=>	'编辑商家信息',
	'order_refund' 		=> '订单退款：%s',
    'shipping_not_need' =>	'无需使用配送方式',
    'shipping_time' 	=> '发货时间：',
    'pay_time' 	        => '付款时间：',
    // 日志
    'log_list'	=>'员工日志记录',
	'log_id'	=>'编号',
	'log_name'	=>'操作者',
	'log_time'	=>'操作日期',
    'log_ip'	=>'IP地址',
	'log_info'	=>'操作记录',
    'js_lang'   => array(
			'choose_delet_time' => '请先选择删除日志的时间！',
			'delet_ok_1' 		=> '确定删除',
			'delet_ok_2' 		=> '的日志吗？',
			'ok' 				=> '确定',
			'cancel' 			=> '取消',
	),
	
	'store_lock'   =>'锁定商家',
	'store_check'  =>'审核入驻商'
);

//end
