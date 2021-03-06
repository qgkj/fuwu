<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 红包类型/红包管理语言包
 */
return array(
	/* Bonus type feild information */
	'bonus_manage' 				=> 'Bonus Manage',
    'bonus_type' 	            => 'Bonus Type',
	'bonus_list' 				=> 'Bonus List',
	'type_name' 				=> 'Name',
	'merchants_name'			=> 'Merchant name',
	'type_money' 				=> 'Bonus money',
	'min_goods_amount' 			=> 'Minimum orders amount',
	'notice_min_goods_amount' 	=> 'Only the total amount of merchandise to achieve this the number of orders to use such red packets.',
	'min_amount' 				=> 'Min limit',
    'min_amount_lable' 			=> 'Min limit:',
	'max_amount' 				=> 'Max limit',
	'send_startdate' 			=> 'Start time',
	'send_enddate' 				=> 'Deadline',
	
	'use_startdate' 	=> 'Start time',
	'use_enddate' 		=> 'Deadline',
	'send_count'	 	=> 'Provide quantity',
	'use_count' 		=> 'Use quantity',
	'send_method' 		=> 'Provide method',
	'send_type' 		=> 'Type',
	'param' 			=> 'Parameter',
	'no_use' 			=> 'No used',
	'yuan' 				=> 'yuan',
	'user_list' 		=> 'Member list',
	'type_name_empty' 	=> 'Bonus type name can\'t be blank!',
	'type_money_empty' 	=> 'Bonus money can\'t be blank!',
	'min_amount_empty' 	=> 'Min limit of order of bonus type can\'t be blank!',
	'max_amount_empty' 	=> 'Max limit of order of bonus type can\'t be blank!',
	'send_count_empty' 	=> 'Quantity of bonus type can\'t be blank!',
	
	'send_by' => array(
		SEND_BY_USER 		=> 'By user',
		SEND_BY_GOODS 		=> 'By product',
		SEND_BY_ORDER 		=> 'By order money',
		SEND_BY_PRINT 		=> 'Offline',
		SEND_BY_REGISTER 	=> 'Register send bonus',
		SEND_COUPON			=> 'Coupon'
	),
	
	'report_form' 		=> 'Report',
	'send' 				=> 'Send',
	'bonus_excel_file' 	=> 'Offline bonus information list ',
	
	'goods_cat' 		=> 'Category',
	'goods_brand' 		=> 'Brand',
	'goods_key' 		=> 'Keywords',
	'all_goods' 		=> 'Optional product',
	'send_bouns_goods' 	=> 'Provide the type bonus product',
	'remove_bouns' 		=> 'Remove bonus',
	'all_remove_bouns' 	=> 'All remove',
	'goods_already_bouns' 	=> 'The product has provided for other type bonus!',
	'send_user_empty' 		=> 'You have no select member whom needs to issue bonus, please return!',
	'batch_drop_success' 	=> ' %d bonuses has be deleted.',
	'sendbonus_count' 	=> 'Total provide %d bonuses.',
	'send_bouns_error' 	=> 'Send out member bonus inaccurate, please try it again!',
	'no_select_bonus' 	=> 'You have no choice need to remove users bonus.',
	'bonustype_edit' 	=> 'Edit Bonus Type',
	'bonustype_view' 	=> 'View details',
	'drop_bonus' 		=> 'Delete',
	'send_bonus' 		=> 'Provide',
	'continus_add' 		=> 'Continue add bonus type',
	'back_list' 		=> 'Return to bonus type list',
	'bonustype_list' 	=> 'Bonus Type List',
	'continue_add' 		=> 'Continue to add bonus.',
	'back_bonus_list' 	=> 'Return to bonus list',
	'validated_email' 	=> 'Only to authenticated users through the mail issuance of red packets.',
	
	/* Prompting message */
	'add_success'			=> 'Add success',
	'edit_success'			=> 'Edit success',
	'attradd_succed' 		=> 'Operation successfully!',
	'del_bonustype_succed' 	=> 'Delete bonus type success',
	
	'js_languages' => array(
		'type_name_empty' 		=> 'Please enter bonus type name!',
		'type_money_empty' 		=> 'Please enter bonus type price!',
		'order_money_empty' 	=> 'Please enter order money!',
		'type_money_isnumber' 	=> 'Type money must be number format!',
		'order_money_isnumber' 	=> 'Order money must be number format!',
		'bonus_sn_empty' 		=> 'Please enter bonus NO.!',
		'bonus_sn_number' 		=> 'Bonus\'s NO. must be a figure!',
		'bonus_sum_empty' 		=> 'Please enter bonus quantity you want to provide!',
		'bonus_sum_number' 		=> 'Provide bonus quantity must be an integer!',
		'bonus_type_empty'	 	=> 'Please select bonus type money!',
		'user_rank_empty' 		=> 'Please appoint member rank!',
		'user_name_empty' 		=> 'Please select a member at least!',
		'invalid_min_amount' 	=> 'Please enter a minimum level of orders (the figure is greater than 0)',
		'send_start_lt_end' 	=> 'bonus release date can not be greater than the beginning date of the end',
		'use_start_lt_end'	 	=> 'bonus use date can not be greater than the beginning date of the end',
	),
	
	'send_count_error' 		=> 'The provide bonus quantiyt must be an integer!',
	'order_money_notic' 	=> 'As long as the amount of the value of orders will be issued red packets to the user',
	'type_money_notic' 		=> 'The type bonus can offset money',
	'send_startdate_notic' 	=> 'The type bonus can be provided only current time between start time and deadline.',
	'use_startdate_notic' 	=> 'Only the current time between the start date and the time between the closing date, this type of red packets can only be used.',
	'type_name_exist' 		=> 'The type name already exists.',
	'type_money_error' 		=> 'The money must be a figure and can\'t less than 0!',
	'bonus_sn_notic' 		=> 'TIP: Bonus NO. is composed of 6 bits serial number seed and 4 bits stochastic numbers.',
	'creat_bonus' 			=> 'Created',
	'creat_bonus_num' 		=> 'Bonus NO.',
	'bonus_sn_error' 		=> 'Bonus NO. must be a figure!',
	'send_user_notice' 		=> 'Please enter username when you provide bonus for user , many usres were divided by (,) <br /> such as:liry, wjz, zwj',
	
	/* Bonus information field */
	'bonus_id' 			=> 'ID',
	'bonus_type_id' 	=> 'Type money:',
	'send_bonus_count' 	=> 'Bonus quantity:',
	'start_bonus_sn' 	=> 'Start NO.',
	'bonus_sn' 			=> 'Bonus NO.',
	'user_id' 			=> 'User',
	'used_time' 		=> 'Time',
	'order_id' 			=> 'Order NO.',
	'send_mail' 		=> 'Send mail',
	'emailed' 			=> 'Email notice',
	
	'mail_status' => array(
		BONUS_NOT_MAIL 					=> 'Not send',
		BONUS_INSERT_MAILLIST_FAIL 		=> 'Insert maillist has failed.',		//追加
		BONUS_INSERT_MAILLIST_SUCCEED 	=> 'Insert maillist has successfully.',	//追加
		BONUS_MAIL_FAIL 				=> 'Send mail has failed.',
		BONUS_MAIL_SUCCEED 				=> 'Send mail has successfully.',
	),
	
	'sendtouser' 			=> 'Provide bonus for appointed user',
	'senduserrank' 			=> 'Provide bonus by user rank ',
	'userrank' 				=> 'User rank',
	'select_rank' 			=> 'All users...',
	'keywords'				=> 'Keywords: ',
	'userlist' 				=> 'User list: ',
	'send_to_user' 			=> 'Disseminate the red envelope to the following users',		
	'search_users' 			=> 'Search user',
	'confirm_send_bonus' 	=> 'Submit',
	'bonus_not_exist' 		=> 'The bonus is nonexistent.',
	'success_send_mail' 	=> 'Send %d mails successfully.',
	'send_continue' 		=> 'Continue to send bonus.',
	
	//追加
	'send_startdate_lable' 	=> 'Payment start date:',
	'send_enddate_lable' 	=> 'Payment end date:',
	'use_startdate_lable' 	=> 'Use start date:',
	'use_enddate_lable' 	=> 'Use end date:',
	'min_amount_lable' 		=> 'Min limit:',
	'send_method_lable' 	=> 'Provide method:',
	'min_goods_amount_lable'=> 'Minimum orders amount:',
	'usage_type_label'		=> 'Usee type:',
	'type_money_lable' 		=> 'Bonus money:',
	'type_name_lable' 		=> 'Name:',
	'add_bonus_type'		=> 'Add Bonus type',
	'send_type_is'			=> 'Send Type is ',
	'bonustype_name_is'		=> 'Bonus type name is ',
	'send_rank_is'			=> 'Send rank is ',
	'send_target_is'		=> 'Send target is ',
	'batch_operation'		=> 'Batch Operations',
	'remove_confirm'		=> 'Are you sure you want to do this?',
	'pls_choose_remove'		=> 'Please select the bonus to delete',
	'pls_choose_send'		=> 'Please select the bonus to insert the message',
	'insert_maillist'		=> 'Insert message to send queue',
	'remove_bonus_confirm'	=> 'Are you sure you want to delete the bonus?',
	'search_goods_help'		=> 'To search for issuing this type of product display in red area on the left, click on the left side of the list option, you can enter the right side of the product distributed red zone. You can also issued a red envelope of merchandise in the right edit.',
	'filter_goods_info'		=> 'Filter to product information',
	'no_content'			=> 'No content yet',
	'user_rank'				=> 'User rank:',
	'enter_user_keywords'	=> 'Please enter a user name',
	'search_user_help'		=> 'Search to distribute this type of bonus to show the user in the left area, click the left list of options, the user can enter the right side of the issue of red envelopes. You can also edit the user on the right side of the editor.',
	'no_info'				=> 'No information.',
	'filter_user_info'		=> 'Screen search user information',
	'update'				=> 'Update',
	'all_send_type'			=> 'All types of send',
	'filter'				=> 'Filter',
	'edit_bonus_type_name'	=> 'Edit bonus Type Name',
	'view_bonus'			=> 'View bonus',
	'general_audience'		=> 'General audience',
	'remove_bonustype_confirm'	=> 'Are you sure you want to remove the bonus type?',
	'gen_excel'					=> 'Export report',
	'edit_bonus_money'			=> 'Edit bonus amount',
	'edit_order_limit'			=> 'Edit order amount limit',
	
	'bonus_type_manage'		=> 'Bonus Type Manage',
	'bonus_type_add'		=> 'Add Bonus Type',
	'bonus_type_update'		=> 'Edit Bonus Type',
	'bonus_type_delete'		=> 'Delete Bonus Type',
	'invalid_parameter'		=> 'Invalid parameter',
	'send_coupon_repeat'	=> 'You have already received the coupon!',
	'list_bonus_type'		=> 'Bonus type',
	
	'bonus_type_help'		=> 'Welcome to ECJia intelligent background bonus type list page, the system will display all of the bonus type in this list.',
	'about_bonus_type'		=> 'About bonus type list help document',
	'add_bonus_help'		=> 'Welcome to ECJia intelligent background add bonus type page, on this page you can add a bonus type of operation.',
	'about_add_bonus'		=> 'About add bonus type of help document',
	'edit_bonus_help'		=> 'Welcome to ECJia intelligent background edit bonus type page, this page can be edited bonus type of operation.',
	'about_edit_bonus'		=> 'About edit bonus type of help document',
	
	'send_by_user_help'		=> 'Welcome to ECJia intelligent background send bonus by user page, on this page the user can operate send bonus.',
	'about_send_by_user'	=> 'About send bonus by user help document',
	
	'send_by_goods_help'	=> 'Welcome to ECJia intelligent background send bonus by goods page, on this page the user can operate send bonus.',
	'about_send_by_goods'	=> 'About send bonus by goods help document',
	
	'send_by_print_help'	=> 'Welcome to ECJia intelligent background send bonus by print page, on this page the user can operate send bonus.',
	'about_send_by_print'	=> 'About send bonus by print help document',
	
	'send_coupon_help'		=> 'Welcome to ECJia intelligent background send coupon by goods page, on this page the user can operate send coupon.',
	'about_send_coupon'		=> 'About send coupon by goods help document',
	
	'bonus_list_help'		=> 'Welcome to ECJia intelligent background bonus list page, the system will display all of the red in this list.',
	'about_bonus_list'		=> 'About bonus list help document',
	
	'overview'				=> 'Overview',
	'more_info'				=> 'More information:',
	
	'type_name_required'		=> 'Please enter bonus type name',
	'type_name_minlength'		=> 'Bonus type name can not be less than 1',
	'type_money_required'		=> 'Please enter the amount of bonus',
	'min_goods_amount_required'	=> 'Please enter a minimum amount order',
	
	'bonus_sum_required'		=> 'Please enter the number of bonus!',
	'bonus_number_required'		=> 'Please enter the number!',
	'select_goods_empty'		=> 'Not search for goods information',
	'select_user_empty'			=> 'Not search for user information',
	
	'send_startdate_required'	=> 'Please enter send start date!',
	'send_enddate_required'		=> 'Please enter send end date!',
	'use_startdate_required'	=> 'Please enter use start date!',
	'use_enddate_required'		=> 'Please enter end start date!',
	
	'send_start_lt_end' 		=> 'bonus release date can not be greater than the beginning date of the end',
	'use_start_lt_end'	 		=> 'bonus use date can not be greater than the beginning date of the end',
	'merchant_notice'			=> 'Settled businesses do not have the right to operate, please visit the business background operation!'
);

//end