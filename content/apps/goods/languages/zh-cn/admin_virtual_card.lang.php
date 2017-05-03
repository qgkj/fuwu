<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 虚拟卡管理
 */
/*------------------------------------------------------ */
//-- 卡片信息
/*------------------------------------------------------ */
$LANG['virtual_card_list'] = '虚拟商品列表';
$LANG['lab_goods_name'] = '商品名称 ：';
$LANG['replenish'] = '补货';
$LANG['lab_card_id'] = '编号';
$LANG['lab_card_sn'] = '卡片序号';
$LANG['lab_card_password'] = '卡片密码';
$LANG['lab_end_date'] = '截至使用日期';
$LANG['lab_is_saled'] = '是否已出售';
$LANG['lab_order_sn'] = '订单号';
$LANG['action_success'] = '操作成功';
$LANG['action_fail'] = '操作失败';
$LANG['card'] = '卡片列表';

$LANG['batch_card_add'] = '批量添加补货';
$LANG['download_file'] = '下载批量CSV文件';
$LANG['separator'] = '分隔符：';
$LANG['uploadfile'] = '上传文件：';
$LANG['sql_error'] = '第 %s 条信息出错：<br /> ';

/* 提示信息 */
$LANG['replenish_no_goods_id'] = '缺少商品ID参数，无法进行补货操作';
$LANG['replenish_no_get_goods_name'] = '商品ID参数有误，无法获取商品名';
$LANG['drop_card_success'] = '该记录已成功删除';
$LANG['batch_drop'] = '批量删除';
$LANG['drop_card_confirm'] = '你确定要删除该记录吗？';
$LANG['card_sn_exist'] = '卡片序号 %s 已经存在，请重新输入';
$LANG['go_list'] = '返回补货列表';
$LANG['continue_add'] = '继续补货';
$LANG['uploadfile_fail'] = '文件上传失败';
$LANG['batch_card_add_ok'] = '已成功添加了 %s 条补货信息';

$LANG['js_languages']['no_card_sn'] = '卡片序号和卡片密码不能都为空。';
$LANG['js_languages']['separator_not_null'] = '分隔符号不能为空。';
$LANG['js_languages']['uploadfile_not_null'] = '请选择要上传的文件。';

$LANG['use_help'] = '使用说明：' .
        '<ol>' .
          '<li>上传文件应为CSV文件<br />' .
              'CSV文件第一列为卡片序号；第二列为卡片密码；第三列为使用截至日期。<br />'.
              '(用EXCEL创建csv文件方法：在EXCEL中按卡号、卡片密码、截至日期的顺序填写数据，完成后直接保存为csv文件即可)'.
          '<li>密码，和截至日期可以为空，截至日期格式为2006-11-6或2006/11/6'.
          '<li>卡号、卡片密码、截至日期中不要使用中文</li>' .
        '</ol>';

/*------------------------------------------------------ */
//-- 改变加密串
/*------------------------------------------------------ */

$LANG['virtual_card_change'] = '更改加密串';
$LANG['user_guide'] = '使用说明：' .
        '<ol>' .
          '<li>加密串是在加密虚拟卡类商品的卡号和密码时使用的</li>' .
          '<li>加密串保存 shop_config中，对应的code是 auth_key</li>' .
          '<li>如果要更改加密串在下面的文本框中输入原加密串和新加密串，点\'确定\'按钮后即可</li>' .
        '</ol>';
$LANG['label_old_string'] = '原加密串：';
$LANG['label_new_string'] = '新加密串：';

$LANG['invalid_old_string'] = '原加密串不正确';
$LANG['invalid_new_string'] = '新加密串不正确';
$LANG['change_key_ok'] = '更改加密串成功';
$LANG['same_string'] = '新加密串跟原加密串相同';

$LANG['update_log'] = '更新记录';
$LANG['old_stat'] = '总共有记录 %s 条。已使用新串加密的记录有 %s 条，使用原串加密（待更新）的记录有 %s 条，使用未知串加密的记录有 %s 条。';
$LANG['new_stat'] = '<strong>更新完毕</strong>，现在使用新串加密的记录有 %s 条，使用未知串加密的记录有 %s 条。';
$LANG['update_error'] = '更新过程中出错：%s';
$LANG['js_languages']['updating_info'] = '<strong>正在更新</strong>（每次 100 条记录）';
$LANG['js_languages']['updated_info'] = '<strong>已更新</strong> <span id=\"updated\">0</span> 条记录。';

// end