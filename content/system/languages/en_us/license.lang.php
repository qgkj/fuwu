<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

return array(
	/* 菜单 */
	'upload_license'	=> 'upload license',
	'download_license'	=> 'download license',
	'back'				=> 'back',
	
	/* 列表页 */
	'license_here'	=> 'license certificate',
	
	/* 标签 */
	'label_certificate_download'	=> 'Backup of ECshop certificate downloaded',
	'label_license_key'				=> 'Authorization codes：',
	'label_certificate_reset'		=> 'ECshop certificate recovery by upload',
	'label_delete_license'			=> 'Delete wrong license',
	'label_select_license'			=> 'Select a license to upload：',
	
	/* 系统提示 */
	'delete_license_notice'	=> 'When you uploads a wrong ECShop certificate making the failure of the certificate functionality, please empty wrong certificate here, then use the certificate upload recovery feature to recover the correct certificate.',
	'license_notice'		=> 'ECShop certificate is the only mark to enjoy the ECShop service, it records important information such as information about your business、record of buying service、the prepaid account amounts. You need to use the function of "certificate download and backup" to backup the certificate, and keep safely. When your shop system needs to reinstall, you can use the function of "certificate download and backup" to recover the certificate backuped before in the new installed system, this new system can continue to use the important informations in the certificate.',
	'delete_license'		=> "The wrong certificate has been deleted.",
	'fail_license'			=> "Content of certificate is not complete. Please make sure the certificate are correct, then upload again！",
	'recover_license'		=> "Certificate recover successful.",
	'no_license_down'		=> "Failure。No certificate can be downloaded temporarily！",
	'fail_license_login'	=> "Certificate of registry failure. From the certificate is not correct!",
	
	/* JS提示 */
	'js_languages' => array(
		'del_confirm'=> 'Confirm the deletion of wrong certificates？',
	),
);

//end