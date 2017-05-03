<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 应用管理语言文件
 */
return array(
	'addon_manage'	=> 'Application Management',
		
	'addon_application'		=> 'Application',
	
	'application_name'		=>'Name',
	'application_dir'		=> 'Directory',
	'application_desc'		=> 'Description',
	'application_version'	=> 'Version',
	'application_author'	=> 'Author',
	'application_copyright_info'=> 'Copyright Information',
	
	'install'	=> 'Install',
	'uninstall'	=> 'Uninstall',
	'upgrade'	=> 'Upgrade',
	'upgrade_success'=> 'Upgrade seccessfully!',
	
	'uninstall_confirm'		=> 'Uninstall application will delete all data of the plug-in. \nAre you sure uninstall this application?',
	'create_table_failed'	=> 'Create datasheet of application failed, the plug-in may be invalid. <br/> Wrong message:<br />%s.',
	'dir_readonly'		 	=> '%s directory can\'t be wrote, please check your server config.',
	'file_readonly'			=> '%s file can\'t be wrote, please check your server config.',
	'uninstall_success'		=>'The appointed application has uninstalled successfully.',
	'install_success'		=>'The appointed application has installed successfully.',
	'upgrade_success'		=>'The appointed application has upgraded successfully.',
	'plugin_not_exists'		=>'We havn\'t got the appoint application file, please confirm the plug-in whether has existed.',
	'class_not_exists'		=>'We havn\'t got the appoint application class, the plug-in may be damaged.',
	
	'js_languages'  => array(
		'lang_removeconfirm' => 'Are you sure you want to delete this application it?',
	),
		
);

// end