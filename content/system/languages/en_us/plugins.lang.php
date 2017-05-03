<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

return array(
	'plugin_name'	=> 'Name',
	'plugin_desc'	=> 'Description',
	'plugin_version'	=> 'Version',
	'plugin_author'		=> 'Author',
	
	'upgrade'			=> 'Upgrade',
	'upgrade_success'	=> 'Upgrade seccessfully!',
	
	'uninstall_confirm'		=> "Uninstall plug-in will delete all data of the plug-in. \nAre you sure uninstall this plug-in?",
	'create_table_failed'	=> 'Create datasheet of plug-in failed, the plug-in may be invalid. <br/> Wrong message:<br />%s.',
	'dir_readonly'		=> '%s directory can\'t be wrote, please check your server config.',
	'file_readonly'		=> '%s file can\'t be wrote, please check your server config.',
	'uninstall_success'	=> 'The appointed plug-in has uninstalled successfully.',
	'install_success'	=> 'The appointed plug-in has installed successfully.',
	'upgrade_success'	=> 'The appointed plug-in has upgraded successfully.',
	'plugin_not_exists'	=> 'We havn\'t got the appoint plug-in file, please confirm the plug-in whether has existed.',
	'class_not_exists'	=> 'We havn\'t got the appoint plug-in class, the plug-in may be damaged.',
		
	//追加
	'js_languages' => array(
		'lang_removeconfirm'=> 'Are you sure you want to delete this grade it?',
	)
);

//end