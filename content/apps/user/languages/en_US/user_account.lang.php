<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA Member prepaid cash management language items
 */
return array(
	'edit' 			=> 'edit',//追加
	'user_surplus'	=> 'Advanced payment',
	'surplus_id'	=> 'ID',
	'user_id'		=> 'Username',
	'surplus_amount'=> 'Amount',
	'add_date'		=> 'Time',
	'pay_mothed'	=> 'Payment method',
	'process_type'	=> 'Type',
	'confirm_date'	=> 'Confirm date',
	'surplus_notic'	=> 'Remarks',
	'surplus_desc'	=> 'Description',
	'surplus_type'	=> 'Operation type',
	'no_user'		=> 'Anonymous buying',
		
	'surplus_type' => array(
		0 => 'Saving',
		1 => 'Drawing',
	),
		
	'admin_user' 	=> 'Administrator',
	'status'	 	=> 'Status',
	'confirm'		=> 'Confirmed',
	'unconfirm'		=> 'Unconfirmed',
	'cancel'		=> 'Cancel',
	'please_select'	=> 'Please select...',
	'surplus_info'	=> 'Balance information',
	'check'			=> 'Check',
	
	'money_type'			=> 'Payment mothod',
	'surplus_add'			=> 'Add Apply',
	'surplus_edit'			=> 'Edit Apply',
	'attradd_succed'		=> 'Successfully!',
	'username_not_exist'	=> 'The username is invalid!',
	'cancel_surplus'		=> 'Are you sure cancel this record?',
	'surplus_amount_error'	=> 'Wrong, the drawing money is more than your balance!',
	'edit_surplus_notic'	=> 'The status is already complete now, if you want to modify, please config it as confirm.',
	'back_list'				=> 'Return to saving and drawing',
	'continue_add'			=> 'Continue to add application',
	'user_name_keyword' 	=> 'Please enter user name keyword',
		
	/* 提示信息  */
	'delete_success'		=> 'Delete success',
	'edit_success'  		=> 'Edit success',
	'add_success'  			=> 'Add success',
	
	/* JS language item */
	'js_languages' => array(
		'user_id_empty'			=> 'Please enter a username',
		'deposit_amount_empty'	=> 'Please enter saving amount!',
		'pay_code_empty'		=> 'Please select a payment mothod!',
		'deposit_amount_error'	=> 'Please enter a valid format of amount!',
		'deposit_type_empty'	=> 'Please select a type!',
		'deposit_notic_empty'	=> 'Please enter remarks!',
		'deposit_desc_empty'	=> 'Please enter description of users!',
	),
		
	'recharge_withdrawal_apply' 		=> 'Recharge And Withdrawals Apply',
	'log_username' 						=> 'Member name',
	'batch_deletes_ok' 					=> 'Batch deleted successfully',
	'update_recharge_withdrawal_apply' 	=> 'Updated recharge withdrawal application',
	'bulk_operations'					=> 'Batch Operations',
	'application_confirm'				=> 'Completed applications can not be deleted, you sure you want to delete the selected list it?',
	'select_operated_confirm'			=> 'Please select the item to be operated.',
	'batch_deletes' 					=> 'Delete',
	'to' 								=> 'To',
	'filter'							=> 'Filter',
	'start_date' 						=> 'start date',
	'end_date' 							=> 'end date',
	'delete'							=> 'delete',
	'delete_surplus_confirm'			=> 'Are you sure you want to delete recharge withdrawal records?',
	'user_information'					=> 'member information',
	'anonymous_member' 					=> 'Anonymous Member',
	'yuan'								=> 'yuan',
	'deposit'							=> 'deposit',
	'withdraw'							=> 'withdraw',
	'edit_remark'						=> 'Notes to editor',
	
	'label_user_id'				=> 'Username:',
	'label_surplus_amount'		=> 'Amount:',
	'label_pay_mothed'			=> 'Payment method:',
	'label_process_type'		=> 'Type:',
	'label_surplus_notic'		=> 'Remarks:',
	'label_surplus_desc'		=> 'Description:',
	'label_status'	 			=> 'Status:',
	'submit_update'				=> 'Update',
	
	'keywords_required'			=> 'Please enter key words!',
	'username_required'			=> 'Please enter a member name!',
	'amount_required'			=> 'Please enter amount!',
	'check_time'				=> 'Start time can not be greater than the end time!',
	
	'merchants_notice'			=> 'Settled businesses do not have the right to operate, please visit the business background operation!',
	'user_name_is'				=> 'Member name is %s,',
	'money_is'					=> 'Amount is %s',
	'delete_record_count'		=> 'The deletion of the %s records',
	'select_operate_item'		=> 'The deletion of the %s records',
	'withdraw_apply'			=> 'Withdraw apply',
	'pay_apply'					=> 'Pay apply',
);

//end