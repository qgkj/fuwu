<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 缺货登记语言包
*/
return array(
	'init'			=> '全部缺货登记信息',
	'booking' 		=> '订购信息',
	'id' 			=> '序号',
	'goods_name' 	=> '缺货商品名',
	'user_name' 	=> '登记用户',
	'number' 		=> '数量',
	'booking_time' 	=> '登记时间',
	'dispose_user' 	=> '处理用户',
	'dispose_time' 	=> '处理时间',
	'desc' 			=> '详细描述',
	'is_dispose' 	=> '是否已处理',
	'disposed' 		=> '已处理',
	'undisposed' 	=> '未处理',
	'dispose_info' 	=> '处理信息',
	
	'email' 	=> '邮件通知',
	'tel' 		=> '电话通知',
	'both' 		=> '电话和email同时通知',
	'link_info' => '用联系方式',
	'link_man' 	=> '联系人',
	'note' 		=> '处理备注',
	'guest_user'=> '未注册用户',
	'i_dispose' => '我来处理',
	
	'detail' 		 	=> '查看详情',
	'back_list_all'  	=> '返回缺货登记列表',
	'dispose_succeed'  	=> '处理成功',
	'mail_send_fail'  	=> '邮件发送失败，请检查邮件服务器设置后重新发送邮件。',
	'mail_send_success' => '邮件发送成功，请到邮箱查看。',
	'remail' 		 	=> '重发邮件',
	
	/* 提示信息  */
	'js_languages' => array(
		'no_note' 		=> '请输入备注信息',
		'drop_success' 	=> '删除成功！',
	),
		
	//追加
	'booking_list'		=> '缺货登记列表',
	'book_goods_name'	=> '请输入商品名称关键字',
	'drop_confirm'		=> '您确定要删除该商品的缺货登记信息吗？',
	
	'label_user_name' 	=> '登记用户：',
	'label_booking_time'=> '登记时间：',
	'label_goods_name' 	=> '缺货商品名：',
	'label_number' 		=> '数量：',
	'label_desc' 		=> '详细描述：',
	'label_link_man' 	=> '联系人：',
	'label_tel' 		=> '电话通知：',
	'label_dispose_user'=> '处理用户：',
	'label_dispose_time'=> '处理时间：',
	'label_note' 		=> '处理备注：',
	
	'overview'			=> '概述',
	'more_info'			=> '更多信息：',
	
	'goods_booking_help'	=> '欢迎访问ECJia智能后台缺货登记列表页面，系统中有关缺货信息都在此列表中显示。',
	'about_goods_booking'	=> '关于缺货登记列表帮助文档',
	
	'booking_detail_help'	=> '欢迎访问ECJia智能后台缺货登记详情页面，系统中有关缺货的详情信息显示在此页面。',
	'about_booking_detail'	=> '关于缺货登记详情帮助文档'
);

// end 