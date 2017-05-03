<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA Member management language file
 */
return array(
	/* List page */
	'label_user_name'		=> 'Username',
	'label_pay_points_gt'	=> 'Points more than:',
	'label_pay_points_lt'	=> 'Less than:',
	'label_rank_name'		=> 'Rank',
	'all_option'			=> 'All...',
	
	'view_order'		=> 'View the order',
	'view_deposit'		=> 'View account details',
	'username'			=> 'Username',
	'email'				=> 'Email',
	'is_validated'		=> 'Verified',
	'not_validated'		=> 'Not verified',
	'reg_date'			=> 'Register date',
	'button_remove'		=> 'Delete Member',
	'users_edit'		=> 'Edit User',
	'goto_list'			=> 'Return to list',
	'username_empty'	=> 'Please enter a username!',
	'validated'			=> '(Verified)',
	
	/* List relative language item */
	'password'			=> 'Password',
	'confirm_password'	=> 'Confirm password',
	'newpass'			=> 'Password',
	'question'			=> 'Secret question',
	'answer'			=> 'Secret answer',
	'gender'			=> 'Sex',
	'birthday'			=> 'Birthday',
		
	'sex' => array(
		0 => 'Secrecy',
		1 => 'Male',
		2 => 'Female',
	),
		
	'pay_points'			=> 'Payment points',
	'pay_points_lable'		=> 'Payment points:',
	'rank_points'			=> 'Rank points',
	'rank_points_lable'		=> 'Rank points:',
	'user_money'			=> 'Available money',
	'user_money_lable'		=> 'Available money:',
	'frozen_money'			=> 'Frozen money',
	'frozen_money_lable'	=> 'Frozen money:',
		
	'credit_line'			=> 'Credit line',
	'user_rank'				=> 'Rank',
	'not_special_rank'		=> 'Nonspecial rank',
	'view_detail_account'	=> 'View details.',
	'parent_user'			=> 'Recommend people',
	'parent_user_lable'		=> 'Recommend people:',
	'parent_remove'			=> 'From relations recommend',
	'affiliate_user'		=> 'Recommended Member',
	'show_affiliate_users'	=> 'See a detailed list of recommended',
	'show_affiliate_orders'	=> 'See Recommended Order Details',
	'affiliate_lever'		=> 'Level',
	'affiliate_num'			=> 'Number of user',
	'page_note'				=> 'This list shows the user all the recommended membership information,',
	'how_many_user'			=> 'users.',
	'back_note'				=> 'Return to the user-edited page',
	'affiliate_level'		=> 'Recommended Level',
	
	'msn'					=> 'MSN',
	'qq'					=> 'QQ',
	'home_phone'			=> 'Home phone',
	'office_phone'			=> 'Office Phone',
	'mobile_phone'			=> 'Mobile',
	'qq_lable'				=> 'QQ:',
	'msn_lable'				=> 'MSN:',
	'office_phone_lable'	=> 'Office phone:',
	'home_phone_lable'		=> 'Home phone:',
	'mobile_phone_lable'	=> 'Mobile:',
	
	'notice_pay_points'		=> 'Payment points is a sort of monetary in the shop, to allow user use to a scale points for shopping.',
	'notice_rank_points'	=> 'Rank points is a sort of aggregate points, the system according to points to estimate user\'s rank.',
	'notice_user_money'		=> 'User obligate money in the shop.',
	
	/* Notice */
	'keep_add' 			=> 'Continue to add member',
	'edit_success' 		=> 'Edit success',
	'not_empty' 		=> 'Username is not empty',
		
	'username_exists'	=> 'The username has existed.',
	'email_exists'		=> 'The email address has existed.',
	'edit_user_failed'	=> 'Edit user data failed.',
	'invalid_email'		=> 'The email address is invalid.',
	'update_success'	=> 'Edit user data successfully.',
	'still_accounts'	=> 'This member have balance or arrears\n',
	'remove_confirm'	=> 'Are you sure delete the user\\\'s account?',
		
	'list_still_accounts'	=> 'Some user selected still have balance or arrears\n',
	'list_remove_confirm'	=> 'Are you sure delete all user\\\'s account selected?',
	'remove_order_confirm'	=> 'The user\'s account already exists, if you delete the user account, then the order data will be deleted. <br />Are you sure delete it?',
	'remove_order'			=> 'Yes, I will delete the user account and orders.',
		
	'remove_cancel'			=> 'No, I won\'t delete the user account.',
	'remove_success'		=> 'User account %s has deleted successfully.',
	'add_success'			=> 'User account %s has added successfully.',
		
	'batch_remove_success'	=> 'You has deleted %d user accounts.',
	'no_select_user'		=> 'You do not need to delete a member!',
	'register_points'		=> 'Register Tanjie',
	'username_not_allow'	=> 'User not allowed to register',
	'username_invalid'		=> 'Invalid user name',
	'email_invalid'			=> 'Invalid email address',
	'email_not_allow'		=> 'E-mail does not allow',
	
	/* 地址列表 */
	'address_list'	=> 'Receiving address',
	'consignee'		=> 'Consignee',
	'address'		=> 'Address',
	'link'			=> 'Contact',
	'other'			=> 'Other',
	'tel'			=> 'Phone',
	'mobile'		=> 'Mobile',
	'best_time'		=> 'The best delivery time',
	'sign_building'	=> 'Building signs',
	
	/* JS language item */
	'js_languages' => array(
		'no_username'			=> 'Please enter a username.',
		'invalid_email'			=> 'Please enter a valid eamil address.',
		'chinese_password' 		=> 'The password can not have Chinese characters or illegal.',//追加
		'no_password'			=> 'Please enter your password.',
		'less_password'			=> 'The password entered can`t less than six.',
		'passwd_balnk'			=> 'The password entered can`t have blank',
		'no_confirm_password'	=> 'Please enter your confirm password.',
		'password_not_same'		=> 'the password and the confirm password is not same.',
		'invalid_pay_points'	=> 'The points of payment must be an integer.',
		'invalid_rank_points'	=> 'The points of rank must be an integer.',
		'password_len_err'		=> 'New Password and Confirm Password should not less than the length of 6',
		'credit_line' 			=> 'Credit line is not empty and numeric types.',//追加
	),
		
	//追加
	'user_list'				=> 'Member List',
	'user_add' 				=>  'Add Member',
	'back_user_list' 		=>  'Return to member list',
	'add_user_success' 		=> 	'Add success',
	'delete_user_success' 	=> 	'Delete success',
	'user_info'				=> 'Membership Details',
	'user_info_confirm'		=> 'You can not find any information about this member',
	'mailbox_information'	=> 'Mailbox Information',
		
	'bulk_operations'	=> 'Batch Operations',
	'filter'			=> 'Filter',
	'serach'			=> 'Search',
	'serach_condition'	=> 'Please Enter username or email or phone number',
	'select_user'		=> 	'Please select the user to delete',
	'delete_confirm'	=> 'Delete member will clear all information about this member. <br/> Are you sure you want to do this?',
	'details'			=> 'Details',
	'delete'			=> 'Delete',
	'edit_email_address'=> 'Edit Email Address',
		
	'id_confirm'				=> 'Please enter ID or name or email',
	'view'						=> 'View',
	'member_information'		=> 'Member information',
	'edit'						=> 'Edit',
	'email'						=> 'Members mailbox',
	'registration_time'			=> 'Registration time',
	'lable_registration_time'	=> 'Registration time:',
	'email_verification'		=> 'E-mail verification',
	'email_verification_lable'	=> 'E-mail verification:',
	'last_login_time'			=> 'Last login time',
	'last_login_time_lable'		=> 'Last login time:',
	'last_login_ip'				=> 'Last Login IP',
	'last_login_ip_lable'		=> 'Last login ip:',
	'users_money'				=> 'Users of funds',
	'more'						=> 'More',
	'default_address'			=> '(Default Address)',
	'zip_code'					=> 'Zip code',
	'no_address'  				=>  'The user no delivery address',
		
	'member_order'			=> 'Member order',
	'order_number'			=> 'Order number',
	'order_time'			=> 'Order time',
	'receiver_name'			=> 'Receiver',
	'total_amount'			=> 'Total amount',
	'order_status'			=> 'Order status',
	'no_order_information'	=> 'No member of the order information',
		
	'region'					=> 'Region',
	'telephone_phone'			=> 'Telephone / Cell phone',
		
	'current_members'			=> 'Current Members:',
	'default_address_two'		=> 'Default Address',
	'full_address'				=> 'Full address',
	'member_basic_information'	=> 'Member basic information',
	'user_names' 				=> 'Name:',
	'membership_details' 		=> 'Membership details',
	'select_date'				=> 'Select Date',
	
	'label_email'				=> 'Email:',
	'label_password'			=> 'Password:',
	'label_newpass'				=> 'Password:',
	'label_confirm_password'	=> 'Confirm password:',
	'label_user_rank'			=> 'Rank:',
	'label_gender'				=> 'Sex:',
	'label_birthday'			=> 'Birthday:',
	'label_credit_line'			=> 'Credit line:',
	
	'invalid_parameter'		=> 'Invalid parameter',
	'create_user_failed'	=> 'Failed to create parameters',
	'invalid_email'			=> 'Email address format error',
	'not_exists_info'		=> 'Information that does not exist',
	
	/*menu*/
	'user_manage'			=> 'Member',
	'user_update'			=> 'Update member',
	'user_delete'			=> 'Delete member',
	'surplus_reply'			=> 'Recharge And Withdrawals Apply',
	'account_manage'		=> 'Funds Management',
	'reg_fields'			=> 'Register Options Settings',
	'integrate_users'		=> 'Member Integration',
	
	/*权限*/
	'user_account_manage'	=> 'Member Account Management',
	'surplus_manage'		=> 'Member Balance Management',
	'user_rank_manage'		=> 'Member Level Management',
	'sync_users'			=> 'Member Data Synchronization',
	
	'edit_user_failed'		=> 'Set Password Failed',
	'edit_password_failure'	=> 'The original password you entered is incorrect!',
	
	'usermoney'		=> 'Member account',
	'user_account'	=> 'Recharge cash',
	'check'			=> 'Audit to paragraph',
	'free'			=> 'Free',
	'no_name'		=> 'Anonymous purchase',
	
	//js
	'keywords_required'		=> 'Please Enter keywords!',
	'username_required'		=> 'Please enter a member name!',
	'email_required'		=> 'Please enter the e-mail address!',
	'password_required'		=> 'Please enter your password!',
	'email_check'			=> 'Please enter a valid email format!',
	'password_length'		=> 'Password length can not be less than 6!',
	'password_check'		=> 'The two passwords do not match!',
	
	//help
	'overview'				=> 'Overview',
	'more_info'				=> 'More information:',
	
	//会员
	'user_list_help'		=> 'Welcome to ECJia intelligent background members list page, the system will display all the members in this list.',
	'about_user_list'		=> 'About members list help document',
	'user_add_help'			=> 'Welcome to ECJia intelligent background add member page, on this page you can operate to add members',
	'about_add_user'		=> 'About add members help document',
	'user_edit_help'		=> 'Welcome to ECJia intelligent background edit member page, this page can be edited Member operation.',
	'about_edit_user'		=> 'About edit member help document',
	'user_view_help'		=> 'Welcome to ECJia intelligent background member details page, on this page you can view the details of the members.',
	'about_view_user'		=> 'About view member help document',
	'user_address_help'		=> 'Welcome to ECJia intelligent background members of the delivery address list page, the system addresses all of the members of the harvest will be displayed in this list.',
	'about_address_user'	=> 'About members harvested address list help document',
	
	//会员注册
	'user_register_help'	=> 'Welcome to ECJia intelligent background member registration page list of items, all of the members of the system registry entries will be displayed in this list.',
	'about_user_register'	=> 'About member registration item help document',
	'add_register_help'		=> 'Welcome to ECJia background add intelligent members of registry entries page, on this page you can add entries registered members operate.',
	'about_add_register'	=> 'About add members registered entries help document',
	'edit_register_help'	=> 'Welcome to ECJia intelligent background editing member registrations page, this page can be edited member registration entry operation.',
	'about_edit_register'	=> 'About edit member registrations help document',
	
	//会员等级
	'user_rank_help'		=> 'Welcome to ECJia intelligent background members rating list page, the system will display all members rating in this list.',
	'about_user_rank'		=> 'About member level list help document',
	'add_rank_help'			=> 'Welcome to ECJia intelligent background add membership level page, this page can add membership levels to operate.',
	'about_add_rank'		=> 'About add membership level help document',
	'edit_rank_help'		=> 'Welcome to ECJia intelligent background editing membership level page, this page can be edited Member level operations.',
	'about_edit_rank'		=> 'About edit membership level help document',
	
	//会员整合
	'user_integrate_help'	=> 'Welcome to ECJia intelligent background integration of members page, the user can make the appropriate information to members through the integration of operations prompted a blue background.',
	'about_user_integrate'	=> 'About members integration help document',
	
	//充值和体现申请
	'user_account_help'		=> 'Welcome to ECJia intelligent background recharging and withdrawals application list page, the system recharge and withdrawals all applications will appear in this list.',
	'about_user_account'	=> 'Recharge and withdrawals on the application help document',
	'add_account_help'		=> 'Welcome to ECJia intelligent background add recharge and withdrawals application page, this page can be added to recharge and withdrawal application operation.',
	'about_add_account'		=> 'About add recharge and withdrawals application help document',
	'edit_account_help'		=> 'Welcome to ECJia intelligent background recharging and withdrawals editing application page, this page can be edited and recharge requesting a withdrawal.',
	'about_edit_account'	=> 'About edit recharge and withdrawals application help document',
	
	//资金管理
	'user_account_manage_help'	=> 'Welcome to ECJia intelligent background money management page, on this page the date filter, you can view information about the member account for a period of time.',
	'about_user_account_manage'	=> 'About financial management help document',
	
	//账目明细
	'user_account_log_help'		=> 'Welcome to ECJia intelligent background member account information page, on this page you can view all information about the accounts of members.',
	'about_user_account_log'	=> 'About member account information help document',
	'add_account_log_help'		=> 'Welcome to ECJia intelligent background adjustment member account page, this page can be adjusted to the Member account operations.',
	'about_add_account_log'		=> 'About regulating the member account help document ',
);

//end