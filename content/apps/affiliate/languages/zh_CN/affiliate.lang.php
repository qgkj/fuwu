<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 应用语言包
 */
return array(
	'on' 	=> '开启',
	'off' 	=> '关闭',
	
	'separate_by' => array(
		0	=> '推荐注册分成',
		1 	=> '推荐订单分成',
	),
	
	'expire' 				=> '推荐时效：',
	'level_point_all' 		=> '积分分成总额百分比：',
	'level_money_all' 		=> '现金分成总额百分比：',
	'level_register_all' 	=> '注册积分分成数：',
	'level_register_up' 	=> '等级积分分成上限：',
	'level_point' 			=> '积分分成百分比',
	'level_money' 			=> '现金分成百分比',
		

	'label_level_point'		=> '积分分成百分比：',
	'label_level_money' 	=> '现金分成百分比：',
		
	'edit_ok' 				=> '操作成功',
	'level_error'		 	=> '最多可以设5个级别！',
	'levels' 				=> '推荐人级别',
	'label_levels'			=> '推荐人级别：',
		
	'js_languages' => array(
		'lang_removeconfirm' 	=> '您确定要删除这个等级么？',
		'save' 					=> '保存',
		'cancel' 				=> '取消',
	),
	
	'unit' => array(
		'hour' 	=> '小时',
		'day' 	=> '天',
		'week' 	=> '周',
	),
	
	'addrow' 	=> '增加',
	'all_null' 	=> '不能全为空',
	
	'help_expire' 	=> '访问者点击某推荐人的网址后，在此时间段内注册、下单，均认为是该推荐人的所介绍的。',
	'help_lpa' 		=> '订单积分的此百分比部分作为分成用积分。',
	'help_lma' 		=> '订单金额的此百分比部分作为分成用金额。',
	'help_lra' 		=> '介绍会员注册，介绍人所能获得的等级积分。',
	'help_lru' 		=> '等级积分到此上限则不再奖励介绍注册积分。',
		
	//追加
	'is_on'				=> '是否开启',
	'label_is_on'		=> '是否开启：',
	'add_affiliate'		=> '添加分成',
	'affiliate_percent'	=> '分成比例',
	'add_affiliate_percent'	=> '添加分成比例',
	'update_affiliate_percent' => '编辑分成比例',
	'affiliate_percent_list' => '分成比例列表',
	'level_point_empty'	=> '请输入积分分成百分比',
	'level_point_wrong'	=> '积分分成百分比格式不正确，应为数字类型',
	'level_money_empty'	=> '请输入现金分成百分比',
	'level_money_wrong'	=> '现金分成百分比格式不正确，应为数字类型',
	'add_success'		=> '添加成功',
	'level_point_is'	=> '积分百分比为 ',
	'level_money_is'	=> '现金百分比为 ',
	'edit_success'		=> '编辑成功',
	'edit_fail'			=> '编辑失败',
	'remove_success'	=> '删除成功',
	'remove_fail'		=> '删除失败',
	'affiliate_type'	=> '推荐分成类型：',
	'edit_level_point'	=> '编辑积分分成百分比',
	'edit_level_money'	=> '编辑现金分成百分比',
	
	'affiliate_config'		=> '推荐邀请设置',
	'affiliate_manage'		=> '推荐管理',
	'affiliate_set'			=> '推荐设置',
	'sharing_management'	=> '分成管理',
	'affiliate_set_manage'	=> '推荐设置管理',
	'affiliate_set_update'	=> '推荐设置更新',
	'affiliate_set_drop'	=> '推荐设置删除',
	'affiliate_percent_manage'	=> '分成比例管理',
	'affiliate_percent_update'	=> '分成比例更新',
	'affiliate_percent_drop'	=> '分成比例删除',
	'recommend_management'	=> '推荐分成管理',
	'recommend_update'		=> '推荐分成更新',
	'affiliate'				=> '推荐分成',
	'config'				=> '配置',
	'do'					=> '执行',
	'cancel'				=> '取消',
	'rollback'				=> '撤销',
	'ok'					=> '确定',
	'notice'				=> '推荐设置已关闭',
	
	'label_level_register_integral_all'	=> '消费积分分成数：',
	'label_level_register_integral_up'	=> '消费积分分成上限人数：',
	'label_level_register_account_all'	=> '余额分成数：',
	'label_level_register_account_up'	=> '余额分成上限人数：',
	
	'level_register_integral_all_help'	=> '介绍会员注册或下单时，介绍人所能获得消费积分奖励。',
	'level_register_integral_up_help'	=> '推荐人数到此上限则不再消费积分。（0为不限制人数）',
	'level_register_account_all_help'	=> '介绍会员注册或下单时，介绍人所能获得余额奖励。',
	'level_register_account_up_help'	=> '推荐人数到此上限则不再奖励余额。（0为不限制人数）',
);

//end