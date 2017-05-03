<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 管理中心会员数据整合插件管理程序语言文件
 */
return array(
	'integrate_name' 	=> '名称',
	'integrate_version' => '版本',
	'integrate_author' 	=> '作者',
	
	/* 插件列表 */
	'update_success' 	=> '设置会员数据整合插件已经成功。',
	'install_confirm' 	=> '您确定要安装该会员数据整合插件吗？',
	'need_not_setup' 	=> '当您采用ECJia会员系统时，无须进行设置。',
	'different_domain' 	=> '您设置的整合对象和 ECJia 不在同一域下。<br />您将只能共享该系统的会员数据，但无法实现同时登录。',
	'points_set' 		=> '积分兑换设置',
	'view_user_list' 	=> '查看论坛用户',
	'view_install_log' 	=> '查看安装日志',
	
	'integrate_setup' 	=> '设置会员数据整合插件',
	'continue_sync' 	=> '继续同步会员数据',
	'go_userslist' 		=> '返回会员帐号列表',
		
	'user_help' => '使用方法：<br/>
         1:如果需要整合其他的用户系统，请到 插件中心 安装相应插件进行整合。<br/>
         2:如果需要更换整合的用户系统，直接启用目标插件即可完成整合，同时将自动停用其他整合插件。<br/>
         3:如果不需要整合任何用户系统，请选择启用 ECJia 插件，即可停用所有的整合插件。',
		
	/* 查看安装日志 */
	'lost_install_log' 	=> '未找到安装日志',
	'empty_install_log' => '安装日志为空',
		
	/* 表单相关语言项 */
	'db_notice' 		=> '点击“<font color="#000000">下一步</font>”将引导你到将商城用户数据同步到整合论坛。如果不需同步数据请点击“<font color="#000000">直接保存配置信息</font>”',
	'lable_db_host' 	=> '数据库服务器主机名：',
	'lable_db_name' 	=> '数据库名：',
	'lable_db_chartset' => '数据库字符集：',
	'lable_is_latin1' 	=> '是否为latin1编码',
	
	'lable_db_user' => '数据库帐号：',
	'lable_db_pass' => '数据库密码：',
	'lable_prefix' 	=> '数据表前缀：',
	'lable_url' 	=> '被整合系统的完整 URL：',
	
	/* 表单相关语言项(discus5x) */
	'cookie_prefix' => 'COOKIE前缀：',
	'cookie_salt' 	=> 'COOKIE加密串：',
	'button_next' 	=> '下一步',
	
	'button_force_save_config' 	=> '直接保存配置信息',
	'save_confirm' 				=> '您确定要直接保存配置信息吗？',
	'button_save_config' 		=> '保存配置信息',
	
	'error_db_msg' 		=> '数据库地址、用户或密码不正确',
	'error_db_exist' 	=> '数据库不存在',
	'error_table_exist' => '整合论坛关键数据表不存在，你填写的信息有误',
	
	'notice_latin1' 	 => '该选项填写错误时将可能到导致中文用户名无法使用',
	'error_not_latin1' 	 => '整合数据库检测到不是latin1编码！请重新选择',
	'error_is_latin1' 	 => '整合数据库检测到是lantin1编码！请重新选择',
	'invalid_db_charset' => '整合数据库检测到是%s 字符集，而非%s 字符集',
	'error_latin1' 		 => '你填写的整合信息会导致严重错误，无法完成整合',
	
	/* 检查同名用户 */
	'conflict_username_check' => '检查商城用户是否和整合论坛用户有重名',
	'check_notice' 	  	=> '本页将检测商城已有用户和论坛用户是否有重名，点击“开始检查前”，请为商城重名用户选择一个默认处理方法',
	'default_method'  	=> '如果检测出商城有重名用户，请为这些用户选择一个默认处理方法',
	'shop_user_total' 	=> '商城共有 %s 个用户待检查',
	'lable_size' 	 	=> '每次检查用户个数',
	'start_check' 		=> '开始检查',
	'next' 			 	=> '下一步',
	'checking' 		 	=> '正在检查...(请不要关闭浏览器)',
	'notice' 		 	=> '已经检查 %s / %s ',
	'check_complete' 	=> '检查完成',
		
	/* 同名用户处理 */
	'conflict_username_modify' => '商城重名用户列表',
	'modify_notice' 		   => '以下列出了所有商城与论坛的重名用户及处理方法。如果您已确认所有操作，请点击“开始整合”；您对重名用户的操作的更改需要点击按钮“保存本页更改”才能生效。',
	'page_default_method' 	   => '本页面中重名用户默认处理方法',
	
	'lable_rename' 	=> '商城重名用户加后缀',
	'lable_delete' 	=> '删除商城的重名用户及相关数据',
	'lable_ignore' 	=> '保留商城重名用户，论坛同名用户视为同一用户',
	'short_rename' 	=> '商城用户改名为',
	'short_delete' 	=> '删除商城用户',
	'short_ignore' 	=> '保留商城用户',
	'user_name' 	=> '商城用户名',
	'email' 		=> 'email',
	'reg_date' 		=> '注册日期',
	'all_user' 		=> '所有商城重名用户',
	'error_user' 	=> '需要重新选择操作的商城用户',
	'rename_user' 	=> '需要改名的商城用户',
	'delete_user' 	=> '需要删除的商城用户',
	'ignore_user' 	=> '需要保留的商城用户',
	'submit_modify' => '保存本页变更',
	'button_confirm_next' => '开始整合',
		
	/* 用户同步 */
	'user_sync'	 	=> '同步商城数据到论坛，并完成整合',
	'button_pre' 	=> '上一步',
	'task_name' 	=> '任务名',
	'task_status' 	=> '任务状态',
	'task_del' 		=> '%s 个商城用户数待删除',
	'task_rename' 	=> '%s 个商城用户需要改名',
	'task_sync' 	=> '%s 个商城用户需要同步到论坛',
	'task_save' 	=> '保存配置信息，并完成整合',
	'task_uncomplete' => '未完成',
	'task_run' 		=> '执行中 (%s / %s)',
	'task_complete' => '已完成',
	'start_task' 	=> '开始任务',
	'sync_status' 	=> '已经同步 %s / %s',
	'sync_size' 	=> '每次处理用户数量',
	'sync_ok' 		=> '恭喜您。整合成功',
	'save_ok' 		=> '保存成功',
		
	/* 积分设置 */
	'no_points' 		=> '没有检测到论坛有可以兑换的积分',
	'bbs' 				=> '论坛',
	'shop_pay_points' 	=> '商城消费积分',
	'shop_rank_points' 	=> '商城等级积分',
	'add_rule' 			=> '新增规则',
	'modify' 			=> '修改',
	'rule_name' 		=> '兑换规则',
	'rule_rate' 		=> '兑换比例',
		
	/* JS语言项 */
	'js_languages' => array(
		'no_host' 	=> '数据库服务器主机名不能为空。',
		'no_user' 	=> '数据库帐号不能为空。',
		'no_name' 	=> '数据库名不能为空。',
		'no_integrate_url' 	=> '请输入整合对象的完整 URL',
		'install_confirm'	=> '请不要在系统运行中随意的更换整合对象。\r\n您确定要安装该会员数据整合插件吗？',
		'num_invalid' 	 	=> '同步数据的记录数不是一个整数',
		'start_invalid'  	=> '同步数据的起始位置不是一个整数',
		'sync_confirm' 	 	=> '同步会员数据会将目标数据表重建。请在执行同步之前备份好您的数据。\r\n您确定要开始同步会员数据吗？',
		'no_method' 	 	=> '请选择一种默认处理方法',
		'rate_not_null'  	=> '比例不能为空',
		'rate_not_int' 	 	=> '比例只能填整数',
		'rate_invailed'  	=> '你填写了一个无效的比例',
		'user_importing' 	=> '正在导入用户到UCenter中...',
	),
		
	'cookie_prefix_notice' => 'UTF8版本的cookie前缀默认为xnW_，GB2312/GBK版本的cookie前缀默认为KD9_。',
		
	/* UCenter设置语言项 */
	'ucenter_tab_base' 	=> '基本设置',
	'ucenter_tab_show' 	=> '显示设置',
	'ucenter_lab_id' 	=> 'UCenter 应用 ID:',
	'ucenter_lab_key' 	=> 'UCenter 通信密钥:',
	'ucenter_lab_url' 	=> 'UCenter 访问地址:',
	'ucenter_lab_ip' 	=> 'UCenter IP 地址:',
	
	'ucenter_lab_connect' => 'UCenter 连接方式:',
	'ucenter_lab_db_host' => 'UCenter 数据库服务器:',
	'ucenter_lab_db_user' => 'UCenter 数据库用户名:',
	'ucenter_lab_db_pass' => 'UCenter 数据库密码:',
	'ucenter_lab_db_name' => 'UCenter 数据库名:',
	'ucenter_lab_db_pre'  => 'UCenter 表前缀:',
	
	'ucenter_lab_tag_number' => 'TAG 标签显示数量:',
	'ucenter_lab_credit_0' 	 => '等级积分名称:',
	'ucenter_lab_credit_1'   => '消费积分名称:',
	'ucenter_opt_database'   => '数据库方式',
	'ucenter_opt_interface'  => '接口方式',
		
	'ucenter_notice_id' 	 => '该值为当前商店在 UCenter 的应用 ID，一般情况请不要改动',
	'ucenter_notice_key' 	 => '通信密钥用于在 UCenter 和 ECJia 之间传输信息的加密，可包含任何字母及数字，请设置完全相同的通讯密钥，确保两套系统能够正常通信',
	'ucenter_notice_url' 	 => '该值在您安装完 UCenter 后会被初始化，在您 UCenter 地址或者目录改变的情况下，修改此项，一般情况请不要改动 例如: http://www.sitename.com/uc_server (最后不要加"/")',
	'ucenter_notice_ip' 	 => '如果您的服务器无法通过域名访问 UCenter，可以输入 UCenter 服务器的 IP 地址',
	'ucenter_notice_connect' => '请根据您的服务器网络环境选择适当的连接方式',
	'ucenter_notice_db_host' => '可以是本地也可以是远程数据库服务器，如果 MySQL 端口不是默认的 3306，请填写如下形式：127.0.0.1:6033',
	'uc_notice_ip' 			 => '连接的过程中出了点问题，请您填写服务器 IP 地址，如果您的 UC 与 ECJia 装在同一服务器上，我们建议您尝试填写 127.0.0.1',
		
	'uc_lab_url' 	=> 'UCenter 的 URL:',
	'uc_lab_pass' 	=> 'UCenter 创始人密码:',
	'uc_lab_ip' 	=> 'UCenter 的 IP:',
	
	'uc_msg_verify_failur' 	  => '验证失败',
	'uc_msg_password_wrong'   => '创始人密码错误',
	'uc_msg_data_error' 	  => '安装数据错误',
	'ucenter_import_username' => '会员数据导入到 UCenter',
	
	'uc_import_notice' 		=> '提醒：导入会员数据前请暂停各个应用(如Discuz!, SupeSite等)',
	'uc_members_merge' 		=> '会员合并方式',
	'user_startid_intro' 	=> '<p>此起始会员ID为%s。如原 ID 为 888 的会员将变为 %s+888 的值。</p>',
	'uc_members_merge_way1' => '将与UC用户名和密码相同的用户强制为同一用户',
	'uc_members_merge_way2' => '将与UC用户名和密码相同的用户不导入UC用户',
	'start_import' 			=> '开始导入',
	'import_user_success' 	=> '成功将会员数据导入到 UCenter',
	'uc_points' 			=> 'UCenter的积分兑换设置需要在UCenter管理后台进行',
	'uc_set_credits' 		=> '设置积分兑换方案',
	'uc_client_not_exists' 	=> 'uc_client目录不存在，请先把uc_client目录上传到商城根目录下再进行整合',
	'uc_client_not_write' 	=> 'uc_client/data目录不可写，请先把uc_client/data目录权限设置为777',
	
	'uc_lang' => array(
		'credits' => array(
			'0' => array(
				'0' => '等级积分',
				'1' => ''
			),
			'1' => array(
				'0' => '消费积分',
				'1' => ''
			)
		),
		'exchange' => 'UCenter积分兑换'
	),

	'save_error' 			=> '保存失败',
	'member_integration'	=>	'会员整合',
	'back_integration'		=>	'返回会员整合',
	'integration_ok'		=>	'成功启用会员整合插件',
	'support_UCenter'		=>	'目前仅支持UCenter方式的会员整合。',
	'integrate_desc' 		=> 	'描述',
	'set_up' 				=> 	'设置',
	'enable' 				=> 	'启用',
	'UCenter_api'			=>	'UCenter仅限使用接口连接方式。',
	'UCenter_integration'	=>	'目前仅支持UCenter会员整合',
	'yes'					=>	'是',
	'no'					=>	'否',
	'save' 					=> '保存',
	
	'js_lang' => array(
		'sFirst'		=> '首页',
		'sLast' 		=> '尾页',
		'sPrevious'		=> '上一页',
		'sNext'			=> '下一页',
		'sInfo'			=> '共_TOTAL_条记录 第_START_条到第_END_条',
		'sZeroRecords' 	=> '没有找到任何记录',
		'sEmptyTable' 	=> '没有找到任何记录',
		'sInfoEmpty'	=> '共0条记录',
		'sInfoFiltered'	=> '（从_MAX_条数据中检索）',

		'server_name'	=> '请输入服务器主机名！',
		'data_name'		=> '请输入数据库帐号！',
		'data_password'	=> '请输入数据库密码！',
		'check_url'		=> '请输入完整URL！',
		'check_cookie'	=> '请输入COOKIE前缀！',
	)
);

// end