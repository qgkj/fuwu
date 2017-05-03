<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 程序说明
 */
return array(
	'stat' => array(
		'name' 	=> 'State',
		 0 		=> 'unconfirmed',
		 1 		=> 'Confirmed',
		 2 		=> 'Unsubscribed',
	),
		
	'email_val' 		=> 'E-mail address',
	'export' 			=> 'Export List',
	'id' 				=> 'ID',
	'button_remove' 	=> 'Remove',
	'button_unremove' 	=> 'Confirmed',
	'button_exit' 		=> 'Unsubscribe',
	'no_select_email' 	=> 'Email not selected',
	
	'batch_remove_succeed' 		=> 'Batch delete success',
	'batch_unremove_succeed' 	=> 'Batch confirm success',
	'batch_exit_succeed' 		=> 'Batch cancel success',
	'back_list' 				=> 'Return to mail list',
	'button_selected' 			=> 'Batch operation',
		
	//追加
	'email_list'			=> 'Mail Subscription Management',
	'email_address'			=> 'Email address is %s',
	'email_id'				=> 'Mail number is%s',
	'select_operate'		=> 'Please select the operation to be performed.',
	'batch'					=> 'Batch Operations',
	
	'select_remove_email'	=> 'Please check to delete the mail subscription!',
	'select_ok_email'		=> 'Please check to confirm the email subscription!',
	'select_exit_email'		=> 'Please select the mail subscription to unsubscribe!',
	'batch_remove_confirm'	=> 'Are you sure you want to delete the selected message subscription?',
	'batch_ok_confirm'		=> 'Are you sure you want to confirm the selected mail subscription?',
	'batch_exit_confirm'	=> 'Are you sure you want to unsubscribe from the selected email subscription?',
	'remove_email'			=> 'Delete subscription mail',
	'ok_email'				=> 'Confirm subscription mail',
	'exit_email'			=> 'Mail subscribe unsubscribe',
	
	'email_manage'			=> 'Mail Management',
	'email_send_list'		=> 'Mail Queue Management',
	'mail_template'			=> 'Mail Template',
	'mail_template_settings'=> 'Mail server settings',
	'email_list_update'		=> 'Mail Subscription Update',
	'email_list_delete'		=> 'Delete Mail Subscription',
	'email_sendlist_manage'	=> 'Mail Queue Management',
	'email_sendlist_send'	=> 'Send Mail Queue',
	'email_sendlist_delete'	=> 'Remove Message Queue',
	'mail_template_manage'	=> 'Mail Template Management',
	'mail_template_update'	=> 'Mail Template Update',
	
	'email'					=> 'mail',
	'subscription_email'	=> 'Subscription mail',
	'batch_send'			=> 'Batch send ',
	'all_send'				=> 'Send all ',
	'batch_exit'			=> 'Batch unsubscribe ',
	'batch_ok'				=> 'Batch determination ',
	'batch_setup'			=> 'Batch settings ',
	
	'overview'				=> 'Overview',
	'more_info'				=> 'More information:',
	'email_list_help'		=> 'Welcome to ECJia intelligent background mail subscription management page, the system will send all the messages in this queue will be displayed in the.',
	'about_email_list'		=> 'About mail subscription management help document',
);

//end