<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

return array(
	/* Field information */
	'user_name'	=> 'Administrator username',
	'email'		=> 'Email',
	'enter_admin_pwd'	=> 'Administrator new password',
	'confirm_admin_pwd'	=> 'Administrator verify password',
	'get_newpassword'	=> 'Administrator password repossess',
	'click_button'		=> 'OK',
	'reset_button'		=> 'Reset',
	'admin_login'		=> 'Login',
	'login_now'	=> 'Login now',
	
	/* Prompting message */
	'js_languages' => array(
		'user_name_empty'	=> 'Please enter username!',
		'email_empty'		=> 'Email address can\'t be blank!',
		'email_error'		=> 'Email address format is invalid!',
		'admin_pwd_empty'	=> 'Please enter administrator new password!',
		'confirm_pwd_empty'	=> 'Please re-enter administrator password!',
		'both_pwd_error'	=> 'The two passwords you entered did not match. Please type it again!',
	),
		
	'email_username_error'	=> 'Username and Email address must match, please return!',
	'send_mail_error'		=> 'Error send email, please check your mail server config!',
	'code_param_error'		=> 'Your request is invalid, please return!',
	'send_success'			=> 'Reset password mail has sent your mailbox:',
	'update_pwd_success'	=> 'Your new password has edited successfully!',
	'update_pwd_failed'		=> 'Edit new password failure!',
);

//end