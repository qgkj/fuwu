<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 管理中心优惠活动语言文件
 */
/* menu */
$LANG['favourable_list']            = '优惠活动列表';
$LANG['add_favourable']             = '添加优惠活动';
$LANG['edit_favourable']            = '编辑优惠活动';
$LANG['favourable_log']             = '优惠活动出价记录';
$LANG['continue_add_favourable']    = '继续添加优惠活动';
$LANG['back_favourable_list']       = '返回优惠活动列表';
$LANG['add_favourable_ok']          = '添加优惠活动成功';
$LANG['edit_favourable_ok']         = '编辑优惠活动成功';

/* list */
$LANG['act_is_going']               = '仅显示进行中的活动';
$LANG['act_name']                   = '优惠活动名称';
$LANG['goods_name']                 = '商品名称';
$LANG['start_time']                 = '开始时间';
$LANG['end_time']                   = '结束时间';
$LANG['min_amount']                 = '金额下限';
$LANG['max_amount']                 = '金额上限';
$LANG['favourable_not_exist']       = '您要操作的优惠活动不存在';
$LANG['js_languages']['batch_drop_confirm'] = '您确实要删除选中的优惠活动吗？';
$LANG['batch_drop_ok']              = '批量删除成功';
$LANG['no_record_selected']         = '没有选择记录';

/* info */
$LANG['label_act_name']             = '优惠活动名称：';
$LANG['label_start_time']           = '优惠开始时间：';
$LANG['label_end_time']             = '优惠结束时间：';
$LANG['label_user_rank']            = '享受优惠的会员等级：';
$LANG['not_user']                   = '非会员';
$LANG['label_act_range']            = '优惠范围：';
$LANG['far_all']                    = '全部商品';
$LANG['far_category']               = '以下分类';
$LANG['far_brand']                  = '以下品牌';
$LANG['far_goods']                  = '以下商品';
$LANG['label_search_and_add']       = '搜索并加入优惠范围';
$LANG['js_languages']['all_need_not_search'] = '优惠范围是全部商品，不需要此操作';
$LANG['js_languages']['range_exists']        = '该选项已存在';
$LANG['label_min_amount']       = '金额下限：';
$LANG['label_max_amount']       = '金额上限：';
$LANG['notice_max_amount']      = '0表示没有上限';
$LANG['label_act_type']         = '优惠方式：';
$LANG['notice_act_type']        = '当优惠方式为“享受赠品（特惠品）”时，请输入允许买家选择赠品（特惠品）的最大数量，数量为0表示不限数量；' .
                                  '当优惠方式为“享受现金减免”时，请输入现金减免的金额；' .
                                  '当优惠方式为“享受价格折扣”时，请输入折扣（1－99），如：打9折，就输入90。';
$LANG['fat_goods']              = '享受赠品（特惠品）';
$LANG['fat_price']              = '享受现金减免';
$LANG['fat_discount']           = '享受价格折扣';
$LANG['js_languages']['pls_search'] = '请先搜索';
$LANG['search_result_empty']        = '没有找到相应记录，请重新搜索';
$LANG['label_search_and_add_gift']  = '搜索并加入赠品（特惠品）';
$LANG['js_languages']['price_need_not_search'] = '优惠方式是享受价格折扣，不需要此操作';
$LANG['js_languages']['gift']       = '赠品（特惠品）';
$LANG['js_languages']['price']      = '价格';

$LANG['js_languages']['act_name_not_null']       = '请输入优惠活动名称';
$LANG['js_languages']['min_amount_not_number']   = '金额下限格式不正确（数字）';
$LANG['js_languages']['max_amount_not_number']   = '金额上限格式不正确（数字）';
$LANG['js_languages']['act_type_ext_not_number'] = '优惠方式后面的值不正确（数字）';
$LANG['js_languages']['amount_invalid']          = '金额上限小于金额下限。';
$LANG['js_languages']['start_lt_end']            = '优惠开始时间不能大于结束时间';

/* post */
$LANG['pls_set_user_rank'] = '请设置享受优惠的会员等级';
$LANG['pls_set_act_range'] = '请设置优惠范围';
$LANG['amount_error']      = '金额下限不能大于金额上限';
$LANG['act_name_exists']   = '该优惠活动名称已存在，请您换一个';

$LANG['nolimit']           = '没有限制';

//end