<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 管理中心优惠活动语言文件
 */
return array(
	/* menu */
	'favourable_list' 			=> 'Favourable List',
	'add_favourable' 			=> 'Add Favourable Activity',
	'edit_favourable' 			=> 'Edit Favourable Activity',
	'favourable_log' 			=> 'Offer bid record',
	'continue_add_favourable' 	=> 'Continue to add favourable activity',
	'back_favourable_list' 		=> 'Return to favourable list',
	'add_favourable_ok' 		=> 'Add favourable activity success',
	'edit_favourable_ok' 		=> 'Edit favourable activity success',
	
	/* list */
	'act_is_going' 			=> 'Show only the ongoing activities',
	'act_name' 				=> 'Name',
	'goods_name' 			=> 'Trade names',
	'start_time' 			=> 'Start time',
	'end_time' 				=> 'End time',
	'min_amount' 			=> 'The amount of the minimum',
	'max_amount' 			=> 'The upper limit',
	'favourable_not_exist' 	=> 'You want to operate the concession does not exist Events',
	
	'batch_drop_ok' 		=> 'Bulk delete successful',
	'no_record_selected' 	=> 'Record no choice',
	
	/* info */
	'label_act_name' 		=> 'Events offers name:',
	'label_start_time' 		=> 'Offer Start Time:',
	'label_end_time' 		=> 'Offers End time:',
	'label_user_rank' 		=> 'To enjoy the favourable treatment of members rating:',
	'not_user'	 			=> 'Non-Member',
	'label_act_range' 		=> 'Offer range:',
	'far_all' 				=> 'All goods',
	'far_category' 			=> 'The following classification',
	'far_brand' 			=> 'The following brands',
	'far_goods' 			=> 'The following merchandise',
	'label_search_and_add' 	=> 'Search and add the scope of concessions',
	
	'label_min_amount' 		=> 'The amount of the minimum:',
	'label_max_amount' 		=> 'The upper limit:',
	'notice_max_amount' 	=> '0 that there is no upper limit',
	'label_act_type' 		=> 'Discount method:',
	'notice_act_type' 		=> 'When the concession for the "enjoyment of gifts (for ex-gratia goods)", please enter the permit buyers to choose gift (ex-gratia goods) the maximum quantity, quantity to 0 express an unlimited number,' .
	        					'When the concession for the "enjoyment of cash for relief", enter the amount of cash relief,' .
	        					'When the concession for the "enjoyment of price discounts", please enter the discount (1-99), such as: playing 9 packs, on the input 90.',
	'fat_goods' 			=> 'Enjoy the gift (for ex-gratia goods)',
	'fat_price'	 			=> 'Enjoy cash relief',
	'fat_discount' 			=> 'Enjoy the price discounts',
	
	'search_result_empty' 		=> 'Record not found a corresponding, re-search',
	'label_search_and_add_gift' => 'Search and add gifts (goods ex-gratia)',
	
	'js_lang' => array(
		'batch_drop_confirm' 		=> 'Are you sure you want to delete the selected concession activities?',
		'all_need_not_search' 		=> 'Offers range of merchandise are all, do not need this operation',
		'range_exists' 				=> 'This option has been in existence for',
		'pls_search' 				=> 'Please search for corresponding data',
		'price_need_not_search' 	=> 'Concessions is to enjoy price discounts do not need this operation',
		'gift' 						=> 'Gifts (goods ex-gratia)',
		'price' 					=> 'Price',
		'act_name_not_null' 		=> 'Please enter the name of concessions Events',
		'min_amount_not_number' 	=> 'The minimum amount is not formatted correctly (figure)',
		'max_amount_not_number' 	=> 'Limit on the amount of incorrect format (digital)',
		'act_type_ext_not_number' 	=> 'Favourable way behind the incorrect value (figure)',
		'amount_invalid' 			=> 'The upper limit is less than the minimum amount.',
		'start_lt_end' 				=> 'Offers start time should not exceed the end of time',
	),
	
	/* post */
	'pls_set_user_rank' => 'Please set to enjoy the favourable treatment of members of hierarchical',
	'pls_set_act_range' => 'Please set up the scope of concessions',
	'amount_error' 		=> 'The amount of the minimum amount should not exceed the upper limit',
	'act_name_exists' 	=> 'Activity name of the discount already exists, please change one',
	'nolimit' 			=> 'There is no limit',

	'favourable_way_is'		=> 'Favourable way is ',
	'remove_success'		=> 'Delete success',
	'edit_name_success'		=> 'Update favourable activity name success',
	'pls_enter_name'		=> 'Please enter activity keywords',
	'pls_enter_merchant_name'	=> 'Please enter merchant name',
	'sort_edit_ok'			=> 'Sort operation success',
	'farourable_time'		=> 'Favourable activity time:',
	'to'					=> 'to',
	'pls_start_time'		=> 'Please choose the event start time',
	'pls_end_time'			=> 'Please choose the event end time',
	'update'				=> 'Update',
	'keywords'				=> 'Enter keywords for search',
	'enter_keywords'		=> 'Enter special items to search for',
	'favourable_way'		=> 'Favourable activity mode',
	'batch_operation'		=> 'Batch Operations',
	'no_favourable_select' 	=> 'Please select the favourable activity to delete!',
	'remove_favourable'		=> 'Delete favourable activity',
	'search'				=> 'Search',
	'edit_act_name'			=> 'Edit Name',
	'edit_act_sort'			=> 'Edit Sort',
	'remove_confirm'		=> 'Are you sure you want to delete the favourable activity?',
	'sort'					=> 'Sort',
	'non_member'			=> 'Non-members',
	'act_range'				=> 'Offer range',
	
	'favourable'			=> 'Favourable Activity',
	'favourable_manage'		=> 'Favourable Activity Management',
	'favourable_add'		=> 'Add Favourable Activity',
	'favourable_update'		=> 'Edit Favourable Activity',
	'favourable_delete'		=> 'Remove Favourable Activity',
	
	'start_lt_end' 			=> 'Offers start time should not exceed the end of time',
	'all_need_not_search' 	=> 'Offers range of merchandise are all, do not need this operation',
	'gift' 					=> 'Gifts (goods ex-gratia)',
	'price' 				=> 'Price',
	'batch_drop_confirm' 	=> 'Are you sure you want to delete the selected concession activities?',
	'all'					=> 'All',
	'on_going'				=> 'On going',
	'merchants'				=> 'Merchants',
	'merchant_name'			=> 'Merchant name',
	
	'overview'         		=> 'Overview',
	'more_info'        		=> 'More information:',
	
	'favourable_list_help'	=> 'Welcome to ECJia intelligent background to the list page of favourable activities, the system will display all the favourable activities in this list.',
	'about_favourable_list'	=> 'About favourable activities list to help document',
	
	'add_favourable_help'	=> 'Welcome to ECJia intelligent background to add favourable activities page, this page can be added to the operation of favourable activities.',
	'about_add_favourable'	=> 'About add favourable activities to help document',
	
	'edit_favourable_help'	=> 'Welcome to ECJia intelligent background to add favourable activities page, the page can be edited for the operation of favourable activities.',
	'about_edit_favourable'	=> 'About edit favourable activities to help document',
);

//end