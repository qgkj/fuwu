<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 会员等级语言包
 */
$LANG['rank_name'] 				= '会员等级名称';
$LANG['integral_min'] 			= '积分下限';
$LANG['integral_max'] 			= '积分上限';
$LANG['discount'] 				= '初始折扣率';
$LANG['add_user_rank'] 			= '添加会员等级';
$LANG['edit_user_rank'] 		= '编辑会员等级';
$LANG['special_rank'] 			= '特殊会员组';
$LANG['show_price'] 			= '在商品详情页显示该会员等级的商品价格';
$LANG['notice_special'] 		= '特殊会员组的会员不会随着积分的变化而变化。';
$LANG['add_continue'] 			= '继续添加会员等级';
$LANG['back_list'] 				= '返回会员等级列表';
$LANG['show_price_short'] 		= '显示价格';
$LANG['notice_discount'] 		= '请填写为0-100的整数,如填入80，表示初始折扣率为8折';

/* 提示信息  */
$LANG['delete_success'] 		= '删除成功！';
$LANG['edit_success']  			= '编辑成功！';
$LANG['add_success']  			= '添加成功！';

$LANG['rank_name_exists'] 		= '会员等级名 %s 已经存在。';
$LANG['add_rank_success'] 		= '会员等级已经添加成功。';
$LANG['edit_rank_success'] 		= '会员等级已经编辑成功。';
$LANG['integral_min_exists'] 	= '已经存在一个等级积分下限为 %d 的会员等级';
$LANG['integral_max_exists'] 	= '已经存在一个等级积分上限为 %d 的会员等级';

/* JS 语言 */
$LANG['js_languages']['remove_confirm'] 		= '您确定要删除选定的会员等级吗？';
$LANG['js_languages']['rank_name_empty'] 		= '您没有输入会员等级名称。';
$LANG['js_languages']['integral_min_invalid'] 	= '您没有输入积分下限或者积分下限不是一个正整数。';
$LANG['js_languages']['integral_max_invalid'] 	= '您没有输入积分上限或者积分上限不是一个正整数。';
$LANG['js_languages']['discount_invalid'] 		= '您没有输入折扣率或者折扣率不是一个正整数。';
$LANG['js_languages']['integral_max_small'] 	= '积分上限必须大于积分下限。';
$LANG['js_languages']['lang_remove'] 			= '移除';

// end