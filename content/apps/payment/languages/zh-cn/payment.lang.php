<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 管理中心支付方式管理语言文件
 */
$LANG['02_payment_list'] = '支付方式';


$LANG['payment']            = '支付方式';
$LANG['payment_name']       = '名称';
$LANG['version']            = '版本';
$LANG['payment_desc']       = '描述';
$LANG['short_pay_fee']      = '费用';
$LANG['payment_author']     = '插件作者';
$LANG['payment_is_cod']     = '货到付款？';
$LANG['payment_is_online']  = '在线支付？';

$LANG['enable']  = '启用';
$LANG['disable'] = '关闭';

$LANG['name_edit']     = '支付方式名称';
$LANG['payfee_edit']   = '支付方式费用';
$LANG['payorder_edit'] = '支付方式排序';

$LANG['name_is_null'] = '您没有输入支付方式名称！';
$LANG['name_exists']  = '该支付方式名称已存在！';

$LANG['pay_fee']        = '支付手续费';
$LANG['back_list']      = '返回支付方式列表';
$LANG['install_ok']     = '安装成功';
$LANG['edit_ok']        = '编辑成功';
$LANG['edit_falid']     = '编辑失败';
$LANG['uninstall_ok']   = '卸载成功';

$LANG['invalid_pay_fee'] = '支付费用不是一个合法的价格';
$LANG['decide_by_ship']  = '配送决定';

$LANG['edit_after_install']     = '该支付方式尚未安装，请你安装后再编辑';
$LANG['payment_not_available']  = '该支付插件不存在或尚未安装';

$LANG['js_languages']['lang_removeconfirm'] = '您确定要卸载该支付方式吗？';

// $LANG['ctenpay']           = '立即注册财付通商户号';
// $LANG['ctenpay_url']       = 'http://union.tenpay.com/mch/mch_register_b2c.shtml?sp_suggestuser=542554970';
// $LANG['ctenpayc2c_url']    = 'https://www.tenpay.com/mchhelper/mch_register_c2c.shtml?sp_suggestuser=542554970';
// $LANG['tenpay']  = '即时到账';
// $LANG['tenpayc2c'] = '中介担保';


/* 支付确认部分 */
$LANG['pay_status']     = '支付状态';
$LANG['pay_not_exist']  = '此支付方式不存在或者参数错误！';
$LANG['pay_disabled']   = '此支付方式还没有被启用！';
$LANG['pay_success']    = '您此次的支付操作已成功！';
$LANG['pay_fail']       = '支付操作失败，请返回重试！';

// end