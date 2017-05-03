<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 虚拟卡管理
 */
return array(
	/*------------------------------------------------------ */
	//-- Card information
	/*------------------------------------------------------ */
	'virtual_card_list' => 'Virtual Goods List',
	'return_list'		=> 'Return to virtual goods list',
	'lab_goods_name' 	=> 'Name:',
	'replenish' 		=> 'Replenish',
	'card_sn' 			=> 'No.',
	'card_password' 	=> 'Password',
	'end_date' 			=> 'Deadline',
	'lab_card_id' 		=> 'ID',
	'lab_card_sn' 		=> 'No.:',
	'lab_card_password' => 'Password:',
	'lab_end_date' 		=> 'Deadline:',
	'lab_is_saled' 		=> 'Saled',
	'lab_order_sn' 		=> 'Order No.',
	'action_success' 	=> 'Operation success',
	'action_fail' 		=> 'Operation fail',
	'card' 				=> 'Card list',
	
	'batch_card_add' 	=> 'Batch add products',
	'download_file' 	=> 'Download batch CSV files.',
	'separator' 		=> 'Separating character',
	'uploadfile' 		=> 'Upload file',
	'sql_error' 		=> 'No. %s information was wrong:<br /> ',
	
	/*  Prompting message */
	'replenish_no_goods_id' 		=> 'Lack of product ID parameter, can\'t replenish products',
	'replenish_no_get_goods_name' 	=> 'Product ID parameter was wrong, can\'t get product name',
	
	'drop_card_success' => 'Delete success',
	'batch_drop'		=> 'Batch delete',
	'drop_card_confirm' => 'Are you sure delete the record?',
	'card_sn_exist' 	=> 'Card No. %s already exist,please enter again',
	'go_list' 			=> 'Return',
	'continue_add' 		=> 'Continue to add',
	'uploadfile_fail' 	=> 'Upload file failure',
	'batch_card_add_ok' => 'Already added %s records',
	
	'js_languages' => array(
		'no_card_sn' 			=> 'Card No. or Card Password is blank.',
		'separator_not_null' 	=> 'Separating character can\'t be blank.',
		'uploadfile_not_null' 	=> 'Please select upload file.',
		'updating_info' 		=> '<strong>Updating</strong>(Each 100 records)',
		'updated_info' 			=> '<strong>Updated</strong> <span id=\"updated\">0</span> records.',
	),
	
	'use_help' => 'Help:' .
	        '<ol>' .
	          '<li>Upload file should be CSV file<br />' .
	              'Sequential fill in every row by card ID, password, deadline, these item set off by \',\' or \',\' . But nonsupport \'blank\'<br />'.
	          '<li>Password and deadline can be blank, deadline format should be \'2006-11-6\' or \'2006/11/6\''.
	          '<li>You had better not use chinese in the file to avoid junk.</li>' .
	        '</ol>',

	/*------------------------------------------------------ */
	//-- Change encrypt string
	/*------------------------------------------------------ */
	
	'virtual_card_change' => 'Change Encrypt String',
	'user_guide' => 'Direction:' .
	        '<ol>' .
	          '<li>Encrypt string use for ID and passwrod of encrypt virtual card</li>' .
	          '<li>Encrypt string saved in data/config.php, corresponding constants is AUTH_KEY</li>' .
	          '<li>If you want to change encrypt string, enter old encrypt string and new encrypt string in the textbox, check \'Confirm\' push the button</li>' .
	        '</ol>',
	'label_old_string' => 'Old encrypt string',
	'label_new_string' => 'New encrypt string',
	
	'invalid_old_string' 	=> 'Old encrypt string was wrong',
	'invalid_new_string' 	=> 'New encrypt string was wrong',
	'change_key_ok' 		=> 'Change encrypt string success',
	'same_string' 			=> 'New encrypt string and old encrypt string are the same',
	
	'update_log' 	=> 'Update logs',
	'old_stat' 		=> 'Total %s records. %s records are encrypted by new string, %s records are encrypted by old string(wait for update), %s records are encrypted by unknown string.',
	'new_stat' 		=> '<strong>Update success</strong>, now %s records are encrypted by new string, %s records are encrypted by unknown string.',
	'update_error' 	=> 'Update was wrong: %s',
	
	//追加
	'batch_replenish'			=> 'Batch Replenishment',
	'edit_replenish'			=> 'Edit Replenishment',
	'card_not_empty'			=> 'Card number or card password can not be empty!',
	'card_exists'				=> 'Virtual card %s already exists',
	'insert_records'			=> 'The insert %s record',
	'batch_replenish_success' 	=> 'Batch replenishment success!',
	'card_edit_success'			=> 'Virtual card %s editing success',
	'update_records'			=> 'This update %s records',
	'batch_update_success'		=> 'Batch update success',
	'batch_upload'				=> 'Batch Upload',
	'batch_replenish_confirm'	=> 'Batch replenishment confirmation',
	'pls_upload_file'			=> 'Please choose to upload files',
	'default_auth_key'			=> 'Detected before you could not set the string, the system will initialize the string to 888888, please modify the new encryption string in a timely manner!',
	'update_auth_key'			=> 'Update encryption string ',
	'set_key_success'			=> 'New encryption string set successfully',
	'update_virtual_info'		=> 'At the same time, also updated the %s virtual card information!',
	'stats_edit_success'		=> 'State switch successfully',
	'card_drop_success'			=> 'Virtual card %s deleted successfully',
	'batch_operation'			=> 'Batch Operations',
	'batch_drop_confirm'		=> 'Are you sure you want to bulk delete the selected virtual card?',
	'batch_drop_empty'			=> 'Please select the options you want to operate',
	'batch_edit'				=> 'Batch edit',
	'enter_card_sn'				=> 'Please enter the order number',
	'click_change_stats'		=> 'Click to change status',
	'drop_confirm'				=> 'Are you sure you want to delete the virtual card?',
	'choose_file'				=> 'Select file',
	'modify'					=> 'modify',
	'return_last_page'			=> 'Return to the last page',
	
    'overview'             	=> 'Overview',
    'more_info'            	=> 'More information:',
	
	'vitural_card_help'		=> 'Welcome to ECJia intelligent background module in the change of the encrypted string of pages, through this page can be changed to change the product\'s encryption.',
	'about_vitural_card'	=> 'About change the encryption string help document',
);

// end