<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 管理中心权限管理模块语言文件
 */

return array(
	'user_id'		=> '编号',
	'role_name'		=> '角色名',
	'email'			=> 'Email地址',
	'password'		=> '密  码',
	'join_time'		=> '加入时间',
	'last_time'		=> '最后登录时间',
	'last_ip'		=> '最后访问的IP',
	'action_list'	=> '操作权限',
	'nav_list'		=> '导航条',
	'language'		=> '使用的语言',
	
	'allot_priv'	=> '分派权限',
	'allot_list'	=> '权限列表',
	'go_allot_priv'	=> '设置管理员权限',
	
	'view_log'		=> '查看日志',
	
	'back_home'		=> '返回首页',
	'forget_pwd'	=> '您忘记了密码吗?',
	'get_new_pwd'	=> '找回管理员密码',
	'pwd_confirm'	=> '确认密码',
	'new_password'	=> '新密码',
	'old_password'	=> '旧密码',
	'agency'		=> '负责的办事处',
	'self_nav'		=> '个人导航',
	'all_menus'		=> '所有菜单',
	'add_nav'		=> '增加',
	'remove_nav'	=> '移除',
	'move_up'		=> '上移',
	'move_down'		=> '下移',
	'continue_add'	=> '继续添加管理员',
	'back_list'		=> '返回管理员列表',
	
	'admin_edit'	=> '编辑管理员',
	'edit_pwd'		=> '修改密码',
	
	'back_admin_list'	=> '返回角色列表',
	
	/* 提示信息 */
	'js_languages' => array(
		'user_name_empty'	=> '管理员用户名不能为空!',
		'password_invaild'	=> '密码必须同时包含字母及数字且长度不能小于6!',
		'email_empty'		=> 'Email地址不能为空!',
		'email_error'		=> 'Email地址格式不正确!',
		'password_error'	=> '两次输入的密码不一致!',
		'captcha_empty'		=> '您没有输入验证码!',
	),
	'action_succeed'		=> '操作成功!',
	'edit_profile_succeed'	=> '您已经成功的修改了个人帐号信息!',
	'edit_password_succeed'	=> '您已经成功的修改了密码，因此您必须重新登录!',
	'user_name_exist'		=> '该管理员已经存在!',
	'email_exist'			=> 'Email地址已经存在!',
	'captcha_error'			=> '您输入的验证码不正确。',
	'login_faild'			=> '您输入的帐号信息不正确。',
	'user_name_drop'		=> '已被成功删除!',
	'pwd_error'				=> '输入的旧密码错误!',
	'old_password_empty'	=> '如果要修改密码,必须先输入你的旧密码!',
	'edit_admininfo_error'	=> '只能编辑自己的个人资料!',
	'edit_admininfo_cannot'	=> '您不能对此管理员的权限进行任何操作!',
	'edit_remove_cannot'	=> '您不能删除demo这个管理员!',
	'remove_self_cannot'	=> '您不能删除自己!',
	'remove_cannot'			=> '此管理员您不能进行删除操作!',
	'remove_cannot_user'	=> '此角色有管理员在使用，暂时不能删除!',
	
	'modif_info'	=> '编辑个人资料',
	'edit_navi'		=> '设置个人导航',
	
	/* 帮助信息 */
	'password_notic'	=> '如果要修改密码,请先填写旧密码,如留空,密码保持不变',
	'email_notic'		=> '输入管理员的Email邮箱,必须为Email格式',
	'confirm_notic'		=> '输入管理员的确认密码,两次输入必须一致',
	
	/* 登录表单 */
	'label_username'	=> '管理员姓名：',
	'label_password'	=> '管理员密码：',
	'label_captcha'		=> '验证码：',
	'click_for_another'	=> '看不清？点击更换另一个验证码。',
	'signin_now'		=> '进入管理中心',
	'remember'			=> '请保存我这次的登录信息。',
);

// end