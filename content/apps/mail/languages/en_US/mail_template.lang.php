<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 管理中心邮件模板管理语言文件
 */
return array(
	'select_template' 	=> 'Please select mail template:',
	'update_success' 	=> 'Saved template content successfully.',
	'update_failed' 	=> 'Saved template content failed.',
	'mail_id' 			=> 'ID',
	'mail_add' 			=> 'Add Mail Template',
	'mail_edit' 		=> 'Edit Mail Template',
	'mail_subject' 		=> 'Mail subject',
	'mail_type' 		=> 'Mail type',
	'mail_plain_text' 	=> 'Plain text mail',
	'mail_html' 		=> 'HTML mail',
	'mail_info' 		=> 'Template content',
		
	/* Template description */
	'order_confirm' 		=> 'Confirm order template',
	'deliver_notice' 		=> 'Shipping notice template',
	'send_password' 		=> 'Send password template',
	'order_cancel' 			=> 'Cancel order template',
	'order_invalid' 		=> 'Fail order template',
	'send_bonus' 			=> 'Send bonus template',
	'group_buy'	 			=> 'Associates template',
	'register_validate' 	=> 'E-mail authentication template',
	'virtual_card' 			=> 'Virtual card templates',
	'remind_of_new_order' 	=> 'Remind of new order template',
	'goods_booking' 		=> 'Reply to goods booking template',
	'user_message' 			=> 'Reply to message template',
	'recomment' 			=> 'Reply to comment template',
	
	'subject_empty' 		=> 'Sorry, mail subject can\'t be blank.',
	'content_empty' 		=> 'Sorry, mail content can\'t be blank.',
	
	'js_lang' => array(
		'save_confirm' 		=> 'You have modified template content, are you sure don\'t save it?',
		'sFirst'			=> 'Home page',
		'sLast' 			=> 'End page',
		'sPrevious'			=> 'Last page',
		'sNext'				=> 'Next page',
		'sInfo'				=> 'A total of _TOTAL_ records section _START_ to section _END_',
		'sZeroRecords' 		=> 'Did not find any record',
		'sEmptyTable' 		=> 'Did not find any record',
		'sInfoEmpty'		=> 'A total of 0 records',
		'sInfoFiltered'		=> '(retrieval from _MAX_ data)',
		'subject_required'	=> 'Mail subject can not be empty!',
		'content_required'	=> 'Template content can not be empty!'
	),
	
	'template_not_exist'	=> 'The mail template does not exist, please visit the correct mail template!',
	'update'				=> 'Update',
	'mail_template'			=> 'Mail Template',
	'template_name'			=> 'Mail template',
	'label_template_name'	=> 'Mail template:',
	'label_mail_subject'	=> 'Mail subject:',
	'label_mail_type'		=> 'Mail type:',
	'label_mail_info'		=> 'Template content:',
	
	'overview'				=> 'Overview',
	'more_info'				=> 'More information:',
	'template_list_help'	=> 'Welcome to ECJia intelligent background mail template list page, the system will display all the mail template in this list.',
	'about_template_list'	=> 'About mail template list help document',
	
	'edit_template_help'	=> 'Welcome to ECJia intelligent background editing mail template page, you can edit the corresponding message template information.',
	'about_edit_template'	=> 'About edit mail template list help document',
);

//end