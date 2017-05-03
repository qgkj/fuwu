<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 程序说明
 */
$LANG['on'] = '开启';
$LANG['off'] = '关闭';

$LANG['separate_by'][0] = '推荐注册分成';
$LANG['separate_by'][1] = '推荐订单分成';

$LANG['expire'] = '推荐时效：';
$LANG['level_point_all'] = '积分分成总额百分比：';
$LANG['level_money_all'] = '现金分成总额百分比：';
$LANG['level_register_all'] = '注册积分分成数：';
$LANG['level_register_up'] = '等级积分分成上限：';
$LANG['level_point'] = '积分分成百分比';
$LANG['level_money'] = '现金分成百分比';
$LANG['edit_ok'] = '操作成功';
$LANG['level_error'] = '最多可以设5个级别！';
$LANG['levels'] = '推荐人级别';
$LANG['js_languages']['lang_removeconfirm'] = '您确定要删除这个等级么？';
$LANG['js_languages']['save'] = '保存';
$LANG['js_languages']['cancel'] = '取消';

$LANG['unit']['hour'] = '小时';
$LANG['unit']['day'] = '天';
$LANG['unit']['week'] = '周';

$LANG['addrow'] = '增加';

$LANG['all_null'] = '不能全为空';

$LANG['help_expire'] = '访问者点击某推荐人的网址后，在此时间段内注册、下单，均认为是该推荐人的所介绍的。';
$LANG['help_lpa'] = '订单积分的此百分比部分作为分成用积分。';
$LANG['help_lma'] = '订单金额的此百分比部分作为分成用金额。';
$LANG['help_lra'] = '介绍会员注册，介绍人所能获得的等级积分。';
$LANG['help_lru'] = '等级积分到此上限则不再奖励介绍注册积分。';
?>