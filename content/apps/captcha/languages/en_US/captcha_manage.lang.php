<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 验证码管理界面语言包
 */

return array(
	'captcha_manage' 		=> 'Verification Code Set',
	'captcha_note' 			=> 'Open Verification Code required GD library server support, and your server does not install the GD library.',
	'captcha_setting' 		=> 'Verification Code Set',
	'captcha_turn_on' 		=> 'Enable Verification Code',
	'turn_on_note' 			=> 'Image Verification Code to avoid malicious bulk submit comments or information, recommend Open Verification Code function. Note: The Verification Code will make the opening part of the operation becomes complicated, it is recommended only when necessary to open.',
	'captcha_register' 		=> 'New User Registration',
	'captcha_login' 		=> 'User Login',
	'captcha_comment' 		=> 'Comment',
	'captcha_admin' 		=> 'Backgrounds Administrator Login',
	'captcha_login_fail' 	=> 'Login Failed Display Verification Code',
	'login_fail_note' 		=> 'Select /"Yes/" in the User Login failed 3 times before show Verification Code, select /"No/" will always be displayed when logging in Verification Code. Note: Only in the opening of the user login when the Verification Code set to be valid.',
	'captcha_width' 		=> 'Verification Code Picture Width',
	'width_note' 			=> 'Verification code picture width, range between 40 ~ 145.',
	'captcha_height' 		=> 'Verification Code Picture Height',
	'height_note' 			=> 'Verification code picture height, range between 15 ~ 50.',
	
	/* JS 语言项 */
	'js_languages' => array(
		'setupConfirm' 	=> 'Enabling new verification code styles will override the original style.<br />Are you sure you want to enable the selected style?', //追加
	 	'width_number' 	=> 'Please enter the picture width number!',
		'proper_width' 	=> 'The width of the picture must between 40 to 145!',
		'height_number' => 'Please enter the picture height number!',
		'proper_height' => 'The height of the picture must between 40 to 145!',
	),
	
	'current_theme' 	=> 'Current style',								//追加
	'install_success' 	=> 'Enable verification code style success.',	//追加
	'save_ok' 			=> 'Settings saved successfully',
	'save_setting' 		=> 'Save settings',								//追加
	'captcha_message' 	=> 'Message Board Guest Book',
	
	//追加
	'click_for_another'	=> 'Cannot see clearly? Click to change another verification code.',
	'label_captcha'		=> 'Captcha：',
	'label_merchant_captcha'		=> 'Captcha',
	'captcha_error'		=> 'The verification code you entered is incorrect.',
	'captcha_wrong'		=> 'Verification code error!',
	'captcha_right'		=> 'Verify code correct!',
	
	'admin_captcha_lang' => array(
		'captcha_width_required'	=> 'Please enter the verification code image width!',
		'captcha_width_min'			=> 'Verification code image width can not be less than 40!',
		'captcha_width_max'			=> 'Verification code picture width can not be greater than 145!',
		'captcha_height_required'	=> 'Please enter the verification code image height!',
		'captcha_height_min'		=> 'Verification code height can not be less than 15!',
		'captcha_height_max'		=> 'Verification code picture height can not be greater than 50!',
		'setupConfirm'				=> 'Are you sure you want to change the verification code style?',
		'is_checked'				=> 'You have selected this code style!',
		'ok'						=> 'OK',
		'cancel'					=> 'Cancel',
	),
	'captcha' 				=> 'Verification code',
	'modify_code_parameter'	=> 'Modify verification code parameters',
	'install_failed'		=> 'Enable verification code style failed.',
	'code_style'			=> 'Available Verification Code Style',
	'enable_code'			=> 'Enable this verification code',
	'add_code'				=> 'Add verification code',
);

// end