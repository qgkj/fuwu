<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

return array(
	/* Field information */
	'user_id'		=> 'ID',
	'user_name'		=> 'Rolename',
	'email'			=> 'Email',
	'password'		=> 'Password',
	'join_time'		=> 'Join time',
	'last_time'		=> 'The latest login time',
	'last_ip'		=> 'The latest visitor\'s IP',
	'action_list'	=> 'Operater authorization',
	'nav_list'		=> 'Navigation',
	'language'		=> 'language',
	
	'allot_priv'	=> 'Assign authorization',
	'allot_list'	=> 'Authorization list',
	'go_allot_priv'	=> 'Administrator authorization config',
	
	'view_log'		=> 'View logs',
	
	'back_home'		=> 'Return to HOME',
	'forget_pwd'	=> 'Do you forget password?',
	'get_new_pwd'	=> 'Get back administrator password',
	'pwd_confirm'	=> 'Re-enter',
	'new_password'	=> 'New password',
	'old_password'	=> 'Primary password',
	'agency'		=> 'Agency the user be in charge of',
	'self_nav'		=> 'Individual navigation',
	'all_menus'		=> 'All menus',
	'add_nav'		=> 'Add',
	'remove_nav'	=> 'Remove',
	'move_up'		=> 'Move up',
	'move_down'		=> 'Move down',
	'continue_add'	=> 'Continue add administrator.',
	'back_list'		=> 'Return to administrator list.',
	
	'admin_edit'	=> 'Edit administrator',
	'edit_pwd'		=> 'Edit password',
	
	'back_admin_list'	=> 'Return to role list.',
	
	/* Prompting message */
	'js_languages' => array(
		'user_name_empty'=> 'Please enter username!',
		'password_invaild'=> 'Password must contain both letters and numbers and the length should not be smaller than in 6!',
		'email_empty'=> 'Email address can\'t be blank!',
		'email_error'=> 'Email address format is invalid!',
		'password_error'=> 'The two passwords you entered did not match. Please type it again!',
		'captcha_empty'=> 'Please enter verification code!',
	),
	'action_succeed'		=> 'Successfully!',
	'edit_profile_succeed'	=> 'You edit account information successfully!',
	'edit_password_succeed'	=> 'You edit password successfully, please re-login!',
	'user_name_exist'		=> 'The administrator already exists.',
	'email_exist'			=> 'Email address already exists.',
	'captcha_error'			=> 'Your verification code is invalid.',
	'login_faild'			=> 'Your accounts information is invalid.',
	'user_name_drop'		=> 'Delete successfully!',
	'pwd_error'				=> 'Primary password is invalid.',
	'old_password_empty'	=> 'If you want edit password, you must enter the primary password!',
	'edit_admininfo_error'	=> 'You can only edit yourself profile!',
	'edit_admininfo_cannot'	=> 'You can\'t operate for the administrator authorization!',
	'edit_remove_cannot'	=> 'You can not delete the administrator demo!',
	'remove_self_cannot'	=> 'Administrator demo can\'t be deleted!',
	'remove_cannot'			=> 'You have no authorization to delete!',
	'remove_cannot_user'	=> 'This role is in use, not administrator!',
	
	'modif_info'	=> 'Edit Profile',
	'edit_navi'		=> 'Config individual navigation',
	
	/* Help */
	'password_notic'	=> 'If you want to edit the password, please enter primary password, if leave a blank, password isn\'t changed.',
	'email_notic'		=> 'Enter administrator\'s Email address, the format must be valid.',
	'confirm_notic'		=> 'Re-enter administrator\'s password, your password entries must match.',
	
	/* Login memu */
	'label_username'	=> 'Username:',
	'label_password'	=> 'Password:',
	'label_captcha'		=> 'Verification Code:',
	'click_for_another'	=> 'Invisibility? Replace an image.',
	'signin_now'		=> 'Enter',
	'remember'			=> 'Remember my login information.',
);

//end
