<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 应用语言包
 */
return array(
	'order_id' 				=> '订单号',
	'affiliate_separate' 	=> '分成',
	'affiliate_cancel' 		=> '取消',
	'affiliate_rollback' 	=> '撤销',
	'log_info' 				=> '操作信息',
	'edit_ok' 				=> '操作成功',
	'edit_fail' 			=> '操作失败',
	'separate_info' 		=> '订单号 %s, 分成:金钱 %s 积分 %s',
	'separate_info2' 		=> '用户ID %s ( %s ), 分成:金钱 %s 积分 %s',
	'sch_order' 			=> '搜索订单号',
		
	'sch_stats' => array(
		'name' 	=> '操作状态',
		'info' 	=> '按操作状态查找:',
		'all' 	=> '全部',
		0 		=> '等待处理',
		1 		=> '已分成',
		2 		=> '取消分成',
		3 		=> '已撤销',
	),
				
	'order_stats' => array(
		'name' 	=> '订单状态',
		0 		=> '未确认',
		1 		=> '已确认',
		2 		=> '已取消',
		3 		=> '无效',
		4 		=> '退货',
	),
		
	'js_languages' => array(
		'cancel_confirm' 	=> '您确定要取消分成吗？此操作不能撤销。',
		'rollback_confirm' 	=> '您确定要撤销此次分成吗？',
		'separate_confirm' 	=> '您确定要分成吗？',
	),
				
	'loginfo' => array(
		'cancel' 	=> '分成被管理员取消！',
		0 			=> '用户id:',
		1 			=> '现金:',
		2 			=> '积分:',
		
	),
		
	'separate_type' => '分成类型',
	
	'separate_by' => array(
		0 	=> '推荐注册分成',
		1 	=> '推荐订单分成',
		-1 	=> '推荐注册分成',
		-2 	=> '推荐订单分成',
	),
		
	'show_affiliate_orders' => '此列表显示此用户推荐的订单信息。',
	'back_note' 			=> '返回会员编辑页面',
	
	//追加
	'gbs' => array(
		GBS_PRE_START 	=> '未开始',
		GBS_UNDER_WAY 	=> '进行中',
		GBS_FINISHED 	=> '结束未处理',
		GBS_SUCCEED 	=> '成功结束',
		GBS_FAIL 		=> '失败结束',
	),

	'cancel_success' 	=> '取消成功',
	'rollback_success' 	=> '撤销成功',
	'order_sn_is'		=> '订单号为 ',
	'filter'			=> '筛选',
	'search'			=> '搜索',
	'order_sn_empty'	=> '请输入订单号'
);

//end