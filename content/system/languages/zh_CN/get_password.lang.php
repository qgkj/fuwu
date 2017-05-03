<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 管理中心管理员密码取回文件
 */

return array(
	'user_name'			=> '管理员用户名',
	'email'				=> 'Email地址',
	'enter_admin_pwd'	=> '管理员新密码',
	'confirm_admin_pwd'	=> '管理员确认密码',
	'get_newpassword'	=> '管理员密码找回',
	'click_button'		=> '确定',
	'reset_button'		=> '重置',
	'admin_login'		=> '登录首页',
	'login_now'			=> '立即登录',
	
	/* 提示信息 */
	'js_languages'  => array(
		'user_name_empty'	=> '管理员用户名不能为空!',
		'email_empty'		=> 'Email地址不能为空!',
		'email_error'		=> 'Email地址格式不正确!',
		'admin_pwd_empty'	=> '请输入管理员新密码!',
		'confirm_pwd_empty'	=> '请输入管理员确认密码!',
		'both_pwd_error'	=> '您两次输入的密码不一致!',
	),
	
	'email_username_error'	=> '用户名与Email地址不匹配,请返回!',
	'send_mail_error'		=> '邮件发送错误, 请检查您的邮件服务器设置!',
	'code_param_error'		=> '您执行了一个不合法的请求，请返回！',
	'send_success'			=> '重置密码的邮件已经发到您的邮箱：',
	'update_pwd_success'	=> '您的新密码已修改成功！',
	'update_pwd_failed'		=> '修改新密码失败！',
);

// end