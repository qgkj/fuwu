<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA Member level language pack
 */
return array(
	'rank_name'			=> 'Rank name',
	'integral_min'		=> 'Min points',
	'integral_max'		=> 'Max points',
	'discount'			=> 'Discount',
	'add_user_rank'		=> 'Add User Rank',
	'edit_user_rank'	=> 'Edit User Rank',
	'special_rank'		=> 'Special rank',
	'show_price'		=> 'Display the price for user rank in the details page.',
	'notice_special'	=> 'Special member can\'t be changed as points changed.',
	'add_continue'		=> 'Continue to add user rank',
	'back_list'			=> 'Return to user rank list',
	'show_price_short'	=> 'Display the price',
	'notice_discount'	=> 'Please fill in for the 0-100 integer, such as fill in 80, said the initial discount rate of 8 packs',
		
	/* 提示信息  */
	'delete_success'	=> 'Delete success',
	'edit_success'  	=> 'Edit success',
	'add_success'  		=> 'Add success',
	'edit_fail'			=> 'Edit failed',
		
	'rank_name_exists'	=> 'The user rank name %s already exists.',
	'add_rank_success'	=> 'The user rank has added successfully.',
	'edit_rank_success' => 'The user rank has compiled successfully',//追加
	'integral_min_exists'	=> 'The user rank has existed, and min limit of points is %d.',
	'integral_max_exists'	=> 'The user rank has existed, and max limit of points is %d.',
	
	/* JS language */
	'js_languages' =>array(
		'remove_confirm'		=> 'Are you sure delete the selected user rank?',
		'rank_name_empty'		=> 'Please enter user rank name.',
		'integral_min_invalid'	=> 'Please enter a min limit of points, and the number must be an integer.',
		'integral_max_invalid'	=> 'Please enter a max limit of points, and the number must be an integer.',
		'discount_invalid'		=> 'Please enter a discount rate, and the number must be more than 100.',
		'integral_max_small'	=> 'The max limit points must be more than min limit.',
		'lang_remove'			=> 'Remove',
	),
		
	'rank' 						=>	'User Rank',
	'hide_price_short' 			=>	'Hide price',
	'change_success' 			=>	'Handover success',
	'join_group' 				=>	'Special Members Join Group',
	'remove_group'				=>	'Remove special group members',
	'edit_user_name'			=>	'Edit member name',
	'edit_integral_min' 		=>	'Edit integral min',
	'edit_integral_max' 		=>	'Edit integral max',
	'edit_discount' 			=>	'Edit the initial discount rate',
	'click_switch_status'		=>	'Click Switch Status',
	'delete_rank_confirm'		=>	'Are you sure you want to delete the member rank?',
		
	'label_rank_name'			=> 	'Rank name:',
	'label_integral_min'		=> 	'Min points:',
	'label_integral_max'		=> 	'Max points:',
	'label_discount'			=> 	'Discount:',
	'submit_update'				=>	'Update',
	
	'rank_name_confirm' 		=>	'Please enter the name of Member Ratings!',
	'min_points_confirm' 		=>	'Please enter the integral lower limit!',
	'max_points_confirm' 		=>	'Please enter the integral upper limit!',
	'discount_required_confirm' =>	'Please enter a discount rate!',
);

//end