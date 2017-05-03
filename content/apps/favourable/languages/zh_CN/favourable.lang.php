<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 管理中心优惠活动语言文件
 */
return array(
	/* menu */
	'favourable_list' 			=> '优惠活动列表',
	'add_favourable' 			=> '添加优惠活动',
	'edit_favourable' 			=> '编辑优惠活动',
	'favourable_log' 			=> '优惠活动出价记录',
	'continue_add_favourable' 	=> '继续添加优惠活动',
	'back_favourable_list' 		=> '返回优惠活动列表',
	'add_favourable_ok' 		=> '添加优惠活动成功',
	'edit_favourable_ok' 		=> '编辑优惠活动成功',
		
	/* list */
	'act_is_going' 			=> '仅显示进行中的活动',
	'act_name' 				=> '优惠活动名称',
	'goods_name' 			=> '商品名称',
	'start_time' 			=> '开始时间',
	'end_time' 				=> '结束时间',
	'min_amount' 			=> '金额下限',
	'max_amount' 			=> '金额上限',
	'favourable_not_exist' 	=> '您要操作的优惠活动不存在',
		
	'batch_drop_ok' 		=> '批量删除成功',
	'no_record_selected' 	=> '没有选择记录',
		
	/* info */
	'label_act_name' 		=> '优惠活动名称：',
	'label_start_time' 		=> '优惠开始时间：',
	'label_end_time' 		=> '优惠结束时间：',
	'label_user_rank'		=> '享受优惠的会员等级：',
	'm_label_act_name' 		=> '活动名称：',
	'm_label_start_time' 	=> '开始时间：',
	'm_label_end_time' 		=> '结束时间：',
	'm_label_user_rank'		=> '会员等级：',
	'not_user' 				=> '非会员',
	'label_act_range' 		=> '优惠活动范围：',
	'far_all' 				=> '全部商品',
	'far_category' 			=> '以下分类',
	'far_brand' 			=> '以下品牌',
	'far_goods' 			=> '以下商品',
	'label_search_and_add' 	=> '搜索并加入优惠范围',
		
	'label_min_amount' 		=> '金额下限：',
	'label_max_amount' 		=> '金额上限：',
	'notice_max_amount' 	=> '0表示没有上限',
	'label_act_type' 		=> '优惠方式：',
	'notice_act_type' 		=> '当优惠方式为“享受赠品（特惠品）”时，请输入允许买家选择赠品（特惠品）的最大数量，数量为0表示不限数量；' .
						   		'当优惠方式为“享受现金减免”时，请输入现金减免的金额；' .
			               		'当优惠方式为“享受价格折扣”时，请输入折扣（1－99），如：打9折，就输入90。',
	'fat_goods' 			=> '享受赠品（特惠品）',
	'fat_price' 			=> '享受现金减免',
	'fat_discount' 			=> '享受价格折扣',
		
	'search_result_empty' 		=> '没有找到相应记录，请重新搜索',
	'label_search_and_add_gift' => '搜索并加入赠品（特惠品）',
		
	'js_lang' => array(
		'batch_drop_confirm' 		=> '您确实要删除选中的优惠活动吗？',
		'all_need_not_search' 		=> '优惠范围是全部商品，不需要此操作',
		'range_exists' 				=> '该选项已存在',
		'pls_search' 				=> '请先搜索相应的数据',
		'price_need_not_search' 	=> '优惠方式是享受价格折扣，不需要此操作',
		'gift' 						=> '赠品（特惠品）',
		'price' 					=> '价格',
		'act_name_not_null' 		=> '请输入优惠活动名称',
		'min_amount_not_number' 	=> '金额下限格式不正确（数字）',
		'max_amount_not_number' 	=> '金额上限格式不正确（数字）',
		'act_type_ext_not_number' 	=> '优惠方式后面的值不正确（数字）',
		'amount_invalid' 			=> '金额上限小于金额下限。',
		'start_lt_end' 				=> '优惠开始时间不能大于或等于结束时间',
	),
		
	/* post */
	'pls_set_user_rank' => '请设置享受优惠的会员等级',
	'pls_set_act_range' => '请设置优惠范围',
	'amount_error' 		=> '金额下限不能大于金额上限',
	'act_name_exists' 	=> '该优惠活动名称已存在，请您换一个',
	'nolimit' 			=> '没有限制',	
	
	'favourable_way_is'		=> '优惠活动方式是 ',
	'remove_success'		=> '删除成功',
	'edit_name_success'		=> '更新优惠活动名称成功',
	'pls_enter_name'		=> '请输入优惠活动名称',
	'pls_enter_merchant_name'	=> '请输入商家名称',
	'sort_edit_ok'			=> '排序操作成功',
	'farourable_time'		=> '优惠活动时间：',
	'm_farourable_time'		=> '活动时间：',
	'to'					=> '至',
	'pls_start_time'		=> '请选择活动开始时间',
	'pls_end_time'			=> '请选择活动结束时间',
	'update'				=> '更新',
	'keywords'				=> '输入关键字进行搜索',
	'enter_keywords'		=> '输入特惠品关键字进行搜索',
	'favourable_way'		=> '优惠活动方式',
	'batch_operation'		=> '批量操作',
	'no_favourable_select' 	=> '请先选中要删除的优惠活动！',
	'remove_favourable'		=> '删除优惠活动',
	'search'				=> '搜索',
	'edit_act_name'			=> '编辑优惠活动名称',
	'edit_act_sort'			=> '编辑优惠活动排序',
	'remove_confirm'		=> '您确定要删除该优惠活动吗？',
	'sort'					=> '排序',
	'non_member'			=> '非会员',
	'act_range'				=> '优惠活动范围',
	
	'favourable'			=> '优惠活动',
	'favourable_manage'		=> '优惠活动管理',
	'favourable_add'		=> '添加优惠活动',
	'favourable_update'		=> '编辑优惠活动',
	'favourable_delete'		=> '删除优惠活动',
	
	'start_lt_end' 			=> '优惠开始时间不能大于或等于结束时间',
	'all_need_not_search' 	=> '优惠范围是全部商品，不需要此操作',
	'gift' 					=> '赠品（特惠品）',
	'price' 				=> '价格',
	'batch_drop_confirm' 	=> '您确实要删除选中的优惠活动吗？',
	'all'					=> '全部',
	'on_going'				=> '正在进行中',
	'merchants'				=> '商家',
	'merchant_name'			=> '商家名称',
	'self'					=> '自营',
				
	'overview'				=> '概述',
	'more_info'				=> '更多信息：',
	
	'favourable_list_help'	=> '欢迎访问ECJia智能后台优惠活动列表页面，系统中所有的优惠活动都会显示在此列表中。',
	'about_favourable_list'	=> '关于优惠活动列表帮助文档',
	
	'add_favourable_help'	=> '欢迎访问ECJia智能后台添加优惠活动页面，在此页面可以进行添加优惠活动操作。',
	'about_add_favourable'	=> '关于添加优惠活动帮助文档',
	
	'edit_favourable_help'	=> '欢迎访问ECJia智能后台添加优惠活动页面，在此页面可以进行编辑优惠活动操作。',
	'about_edit_favourable'	=> '关于编辑优惠活动帮助文档',
);

//end