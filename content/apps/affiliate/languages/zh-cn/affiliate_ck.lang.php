<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 程序说明
 */
$LANG['order_id'] = '订单号';
$LANG['affiliate_separate'] = '分成';
$LANG['affiliate_cancel'] = '取消';
$LANG['affiliate_rollback'] = '撤销';
$LANG['log_info'] = '操作信息';
$LANG['edit_ok'] = '操作成功';
$LANG['edit_fail'] = '操作失败';
$LANG['separate_info'] = '订单号 %s, 分成:金钱 %s 积分 %s';
$LANG['separate_info2'] = '用户ID %s ( %s ), 分成:金钱 %s 积分 %s';
$LANG['sch_order'] = '搜索订单号';

$LANG['sch_stats']['name'] = '操作状态';
$LANG['sch_stats']['info'] = '按操作状态查找:';
$LANG['sch_stats']['all'] = '全部';
$LANG['sch_stats'][0] = '等待处理';
$LANG['sch_stats'][1] = '已分成';
$LANG['sch_stats'][2] = '取消分成';
$LANG['sch_stats'][3] = '已撤销';
$LANG['order_stats']['name'] = '订单状态';
$LANG['order_stats'][0] = '未确认';
$LANG['order_stats'][1] = '已确认';
$LANG['order_stats'][2] = '已取消';
$LANG['order_stats'][3] = '无效';
$LANG['order_stats'][4] = '退货';
$LANG['js_languages']['cancel_confirm'] = '您确定要取消分成吗？此操作不能撤销。';
$LANG['js_languages']['rollback_confirm'] = '您确定要撤销此次分成吗？';
$LANG['js_languages']['separate_confirm'] = '您确定要分成吗？';
$LANG['loginfo'][0] = '用户id:';
$LANG['loginfo'][1] = '现金:';
$LANG['loginfo'][2] = '积分:';
$LANG['loginfo']['cancel'] = '分成被管理员取消！';

$LANG['separate_type'] = '分成类型';
$LANG['separate_by'][0] = '推荐注册分成';
$LANG['separate_by'][1] = '推荐订单分成';
$LANG['separate_by'][-1] = '推荐注册分成';
$LANG['separate_by'][-2] = '推荐订单分成';

$LANG['show_affiliate_orders'] = '此列表显示此用户推荐的订单信息。';
$LANG['back_note'] = '返回会员编辑页面';
?>