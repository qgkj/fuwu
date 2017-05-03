<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 验证码管理界面语言包
 */

$LANG['captcha_manage']     = '验证码设置';
$LANG['captcha_note']       = '开启验证码需要服务GD库支持，而您的服务器不支持GD。';

$LANG['captcha_setting']    = '验证码设置';
$LANG['captcha_turn_on']    = '启用验证码';
$LANG['turn_on_note']       = '图片验证码可以避免恶意批量评论或提交信息，推荐打开验证码功能。注意: 启用验证码会使得部分操作变得繁琐，建议仅在必需时打开';
$LANG['captcha_register']   = '新用户注册';
$LANG['captcha_login']      = '用户登录';
$LANG['captcha_comment']    = '发表评论';
$LANG['captcha_admin']      = '后台管理员登录';
$LANG['captcha_login_fail'] = '登录失败时显示验证码';
$LANG['login_fail_note']    = '选择“是”将在用户登录失败 3 次后才显示验证码，选择“否”将始终在登录时显示验证码。注意: 只有在启用了用户登录验证码时本设置才有效';
$LANG['captcha_width']      = '验证码图片宽度';
$LANG['width_note']         = '验证码图片的宽度，范围在 40～145 之间';
$LANG['captcha_height']     = '验证码图片高度';
$LANG['height_note']        = '验证码图片的高度，范围在 15～50 之间';

/* JS 语言项 */
$LANG['js_languages']['setupConfirm']  = '启用新的验证码样式将覆盖原来的样式。<br />您确定要启用选定的样式吗？';
$LANG['js_languages']['width_number']  = '图片宽度请输入数字!';
$LANG['js_languages']['proper_width']  = '图片宽度要在40到145之间!';
$LANG['js_languages']['height_number'] = '图片高度请输入数字!';
$LANG['js_languages']['proper_height'] = '图片高度要在15到50之间!';

$LANG['current_theme']   = '当前样式';
$LANG['install_success'] = '启用验证码样式成功。';

$LANG['save_ok']         = '设置保存成功';
$LANG['save_setting']    = '保存设置';
$LANG['captcha_message'] = '留言板留言';

// end