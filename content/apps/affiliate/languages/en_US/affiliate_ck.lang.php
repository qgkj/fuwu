<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA Application language pack
 */
return array(
	'order_id' 				=> 'Order No.',
	'affiliate_separate' 	=> 'Divided into',
	'affiliate_cancel' 		=> 'Cancel',
	'affiliate_rollback' 	=> 'Revoke',
	'log_info' 				=> 'Operation information',
	'edit_ok' 				=> 'Operate success',
	'edit_fail' 			=> 'Operate failed',
	'separate_info' 		=> 'Order No. %s, divided into: money %s points %s',
	'separate_info2' 		=> 'User ID %s (%s), divided into: money %s points %s',
	'sch_order' 			=> 'Search Order No.',
	
	'sch_stats' => array(
		'name' 	=> 'Operate status',
		'info' 	=> 'According to operational status search:',
		'all' 	=> 'All',
		0 		=> 'Wait for treatment',
		1 		=> 'Divided',
		2 		=> 'Cancel divided',
		3 		=> 'Revoked',
	),
		
	'order_stats' => array(
		'name' 	=> 'Order status',
		0 		=> 'Not confirmed',
		1 		=> 'Confirmed',
		2 		=> 'Canceled',
		3 		=> 'Invalid',
		4 		=> 'Return goods',
	),	
		
	'js_languages' => array(
		'cancel_confirm' 	=> 'Are you sure you want to cancel into it? This action can not be revoked.',
		'rollback_confirm' 	=> 'You sure you want to revoke this into it?',
		'separate_confirm' 	=> 'Are you sure you want into it?',
	),
	
	'loginfo' => array(
		'cancel' 	=> 'Divided by the administrator canceled!',
		0 			=> 'User id:',
		1 			=> 'Cash:',
		2 			=> 'Points:',
		
	),
	
	'separate_type' => 'Divided types',
	
	'separate_by' => array(
		0 	=> 'Recommend register is divided into',
		1 	=> 'Recommend orders into',
		-1 	=> 'Recommend register is divided into',
		-2 	=> 'Recommend orders into',
	),
	
	'show_affiliate_orders' => 'This list shows the recommended order information for this user.',
	'back_note' 			=> 'Return to the user-edited page',
	
	//追加
	'gbs' => array(
		GBS_PRE_START 	=> 'Preparing',
		GBS_UNDER_WAY 	=> 'In progress',
		GBS_FINISHED 	=> 'Finished but undisposed',
		GBS_SUCCEED 	=> 'Succeed',
		GBS_FAIL 		=> 'Fail',
	),
	
	'cancel_success' 	=> 'Cancel success',
	'rollback_success'	=> 'Revoke success',
	'order_sn_is'		=> 'The order sn is ',
	'filter'			=> 'Filter',
	'search'			=> 'Search',
	'order_sn_empty'	=> 'Please enter an order number'
);

//end