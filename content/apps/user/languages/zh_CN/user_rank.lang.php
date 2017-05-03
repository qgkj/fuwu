<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 会员等级语言包
 */
return array(
	'rank_name' 		=> '会员等级名称',
	'integral_min' 		=> '积分下限',
	'integral_max' 		=> '积分上限',
	'discount' 			=> '初始折扣率',
	'add_user_rank' 	=> '添加会员等级',
	'edit_user_rank'	=> '编辑会员等级',
	'special_rank' 		=> '特殊会员组',
	'show_price' 		=> '在商品详情页显示该会员等级的商品价格',
	'notice_special'	=> '特殊会员组的会员不会随着积分的变化而变化。',
	'add_continue'  	=> '继续添加会员等级',
	'back_list' 		=> '返回会员等级列表',
	'show_price_short' 	=> '显示价格',
	'notice_discount' 	=> '请填写为0-100的整数,如填入80，表示初始折扣率为8折',
	
	/* 提示信息  */
	'delete_success'	=> '删除成功',
	'edit_success'  	=> '编辑成功',
	'add_success'  		=> '添加成功',
	'edit_fail'			=> '编辑失败',
	
	'rank_name_exists' 		=> '会员等级名 %s 已经存在。',
	'add_rank_success' 		=> '会员等级已经添加成功。',
	'edit_rank_success' 	=> '会员等级已经编辑成功。',
	'integral_min_exists' 	=> '已经存在一个等级积分下限为 %d 的会员等级',
	'integral_max_exists' 	=> '已经存在一个等级积分上限为 %d 的会员等级',
	
	/* JS 语言 */
	'js_languages' => array(
		'remove_confirm' 	   	=> '您确定要删除选定的会员等级吗？',
		'rank_name_empty' 	   	=> '您没有输入会员等级名称。',
		'integral_min_invalid' 	=> '您没有输入积分下限或者积分下限不是一个正整数。',
		'integral_max_invalid' 	=> '您没有输入积分上限或者积分上限不是一个正整数。',
		'discount_invalid' 	   	=> '您没有输入折扣率或者折扣率不是一个正整数。',
		'integral_max_small'   	=> '积分上限必须大于积分下限。',
		'lang_remove' 		  	=> '移除',
	),
	
	'rank' 						=>	'会员等级',
	'hide_price_short' 			=>	'隐藏价格',
	'change_success' 			=>	'切换成功',
	'join_group' 				=>	'加入特殊会员组',
	'remove_group'				=>	'移出特殊会员组',
	'edit_user_name'			=>	'编辑会员名称',
	'edit_integral_min' 		=>	'积分下限',
	'edit_integral_max' 		=>	'积分上限',
	'edit_discount' 			=>	'编辑初始折扣率',
	'click_switch_status'		=>	'点击切换状态',
	'delete_rank_confirm'		=>	'您确定要删除会员等级吗?',
	
	'label_rank_name'			=> '会员等级名称：',
	'label_integral_min'		=> '积分下限：',
	'label_integral_max'		=> '积分上限：',
	'label_discount'			=> '初始折扣率：',
	'submit_update'				=> '更新',
	
	'rank_name_confirm' 		=>	'请输入会员等级名称',
	'min_points_confirm' 		=>	'请输入积分下限',
	'max_points_confirm' 		=>	'请输入积分上限',
	'discount_required_confirm' =>	'请输入折扣率',
);

// end