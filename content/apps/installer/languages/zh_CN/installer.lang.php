<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

return array(
	'connect_failed'		=> '连接数据库失败，请检查您输入的数据库帐号是否正确。',
	'cannt_create_database'	=> '无法创建数据库',
	'username_error'		=> '管理员名称不能为空',
	'password_empty_error'	=> '密码不能为空',
	'admin_user' =>array(
		0 => '商品列表|index.php?m=goods&c=admin&a=init',
		1 => '订单列表|index.php?m=orders&c=admin&a=init',
		2 => '会员列表|index.php?m=user&c=admin&a=init',
		3 => '入驻商家|index.php?m=store&c=admin&a=init',
		4 => '广告列表|index.php?m=adsense&c=admin&a=init',
	),
	'password_invaild'			=> '密码必须同时包含字母及数字',
	'password_short'			=> '密码长度不能小于8',
	'password_not_eq'			=> '密码不相同',
	'create_passport_failed'	=> '创建管理员帐号失败',
	'write_config_file_failed'	=> '写入配置文件出错',
	'finish_success'			=> '恭喜您，安装成功!',
	'has_locked_installer_title'=> '安装程序已经被锁定。',
	'locked_message'			=> '如果您确定要重新安装ECJIA到家，请删除content/storages/data目录下的install.lock。',
	'path_error'				=> '抱歉，当前程序运行在 %s 目录下，ECJia到家程序必须运行在网站根目录下/，请您更换目录后再重新运行安装程序。',
	'innodb_not_support'		=> '当前MySQL数据库不支持InnoDB引擎，请检查后再进行安装。',
	'mysql_version_error'		=> 'MySQL数据库版本过低，请使用5.5以上版本。',
	'js_languages' => array(
		'password_invaild'	=> '密码必须同时包含字母及数字',
	),
);

//end