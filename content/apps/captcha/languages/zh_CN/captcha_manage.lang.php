<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 验证码管理界面语言包
 */

return array(
	'captcha_manage' 		=> '验证码设置',
	'captcha_note' 			=> '开启验证码需要服务GD库支持，而您的服务器不支持GD。',
	'captcha_setting' 		=> '验证码设置',
	'captcha_turn_on' 		=> '启用验证码',
	'turn_on_note' 			=> '图片验证码可以避免恶意批量评论或提交信息，推荐打开验证码功能。注意: 启用验证码会使得部分操作变得繁琐，建议仅在必需时打开',
	'captcha_register' 		=> '新用户注册',
	'captcha_login' 		=> '用户登录',
	'captcha_comment' 		=> '发表评论',
	'captcha_admin' 		=> '后台管理员登录',
	'captcha_login_fail' 	=> '登录失败时显示验证码',
	'login_fail_note' 		=> '选择“是”将在用户登录失败 3 次后才显示验证码，选择“否”将始终在登录时显示验证码。注意: 只有在启用了用户登录验证码时本设置才有效',
	'captcha_width' 		=> '验证码图片宽度',
	'width_note' 			=> '验证码图片的宽度，范围在 40～145 之间',
	'captcha_height' 		=> '验证码图片高度',
	'height_note' 			=> '验证码图片的高度，范围在 15～50 之间',
		
	/* JS 语言项 */
	'js_languages' => array(
		'setupConfirm' 	=> '启用新的验证码样式将覆盖原来的样式。<br />您确定要启用选定的样式吗？',
		'width_number' 	=> '图片宽度请输入数字!',
		'proper_width' 	=> '图片宽度要在40到145之间!',
		'height_number' => '图片高度请输入数字!',
		'proper_height' => '图片高度要在15到50之间!',
	),
		
	'current_theme' 	=> '当前样式',
	'install_success' 	=> '启用验证码样式成功。',
	'save_ok' 			=> '设置保存成功',
	'save_setting' 		=> '保存设置',
	'captcha_message' 	=> '留言板留言',
	
	//追加
	'click_for_another'	=> '看不清？点击更换另一个验证码。',
	'label_captcha'		=> '验证码：',
	'label_merchant_captcha' => '验证码',
	'captcha_error'		=> '您输入的验证码不正确。',
	'captcha_wrong'		=> '验证码错误！',
	'captcha_right'		=> '验证码正确！',
	
	'admin_captcha_lang' => array(
		'captcha_width_required'	=> '请输入验证码图片宽度！',
		'captcha_width_min'			=> '验证码图片宽度不能小于40！',
		'captcha_width_max'			=> '验证码图片宽度不能大于145！',
		'captcha_height_required'	=> '请输入验证码图片高度！',
		'captcha_height_min'		=> '验证码图片高度不能小于15！',
		'captcha_height_max'		=> '验证码图片高度不能大于50！',
		'setupConfirm'				=> '您确定要更换验证码样式吗？',
		'is_checked'				=> '您已选中此验证码样式！',
		'ok'						=> '确定',
		'cancel'					=> '取消',
	),
	'captcha' 				=> '验证码',
	'modify_code_parameter'	=> '修改验证码参数',
	'install_failed'		=> '启用验证码样式失败。',
	'code_style'			=> '可用验证码样式',
	'enable_code'			=> '启用此验证码',
	'add_code'				=> '添加验证码',
);

// end