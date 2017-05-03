<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 管理中心配送方式管理语言文件
 */
$LANG['shipping_area_name']      = '配送区域名称';
$LANG['shipping_area_districts'] = '地区列表';
$LANG['shipping_area_regions']   = '所辖地区';
$LANG['shipping_area_assign']    = '配送方式';
$LANG['area_region']             = '地区';
$LANG['removed_region']          = '该区域已被移除';
$LANG['area_shipping']           = '配送方式';
$LANG['fee_compute_mode']        = '费用计算方式';
$LANG['fee_by_weight']           = '按重量计算';
$LANG['fee_by_number']           = '按商品件数计算';
$LANG['new_area']                = '新建配送区域';
$LANG['label_country']           = '国家：';
$LANG['label_province']          = '省份：';
$LANG['label_city']              = '城市：';
$LANG['label_district']          = '区/县：';

$LANG['batch']                  = '批量操作';
$LANG['batch_delete']           = '批量删除操作';
$LANG['batch_no_select_falid']  = '未选中元素，批量删除操作失败';
$LANG['delete_selected']        = '移除选定的配送区域';
$LANG['btn_add_region']         = '添加选定地区';
$LANG['free_money']             = '免费额度：';
$LANG['pay_fee']                = '货到付款支付费用：';
$LANG['edit_area']              = '编辑配送区域';

$LANG['add_continue']           = '继续添加配送区域';
$LANG['back_list']              = '返回列表页';
$LANG['empty_regions']          = '当前区域下没有任何关联地区';

/* 提示信息 */
$LANG['repeat_area_name']       = '已经存在一个同名的配送区域。';
$LANG['not_find_plugin']        = '没有找到指定的配送方式的插件。';
$LANG['remove_confirm']         = '您确定要删除选定的配送区域吗？';
$LANG['remove_success']         = '指定的配送区域已经删除成功！';
$LANG['no_shippings']           = '没有找到任何可用的配送方式。';
$LANG['add_area_success']       = '添加配送区域成功。';
$LANG['edit_area_success']      = '编辑配送区域成功。';
$LANG['disable_shipping_success'] = '指定的配送方式已经从该配送区域中移除。';

/* 需要用到的JS语言项 */
$LANG['js_languages']['no_area_name']        = '配送区域名称不能为空。';
$LANG['js_languages']['del_shipping_area']   = '请先删除该配送区域，然后重新添加。';
$LANG['js_languages']['invalid_free_mondy']  = '免费额度不能为空且必须是一个整数。';
$LANG['js_languages']['blank_shipping_area'] = '配送区域的所辖区域不能为空。';
$LANG['js_languages']['lang_remove']         = '移除';
$LANG['js_languages']['lang_remove_confirm'] = '您确定要移除该地区吗？';
$LANG['js_languages']['lang_disabled']       = '禁用';
$LANG['js_languages']['lang_enabled']        = '启用';
$LANG['js_languages']['lang_setup']          = '设置';
$LANG['js_languages']['lang_region']         = '地区';
$LANG['js_languages']['lang_shipping']       = '配送方式';
$LANG['js_languages']['region_exists']       = '选定的地区已经存在。';

// end