<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 管理中心配送方式管理语言文件
 */
return array(
	'shipping_area_name'		=> 'Shipping area name',
	'shipping_area_districts'	=> 'Area list',
	'shipping_area_regions'		=> 'Region',
	'shipping_area_assign'		=> 'Shipping method',
		
	'area_region'		=> 'Region',
	'removed_region' 	=> 'The region has been removed',//追加
	'area_shipping'		=> 'Shipping method',
	'fee_compute_mode'	=> 'Cost calculation',
	'fee_by_weight'		=> 'By weight',
	'fee_by_number'		=> 'By number',
	'new_area'			=> 'Creat Shipping Area',
	'label_country'		=> 'Country:',
	'label_province'	=> 'Province:',
	'label_city'		=> 'City:',
	'label_district'	=> 'District:',
	'batch' 			=> 'Batch Operations',//追加
	'batch_delete' 		=> 'Batch delete operation',//追加
	
	'batch_no_select_falid' => 'Unchecked element, the mass delete operation failed',//追加
	'delete_selected'		=> 'Delete the selected shipping region.',
		
	'btn_add_region'	=> 'Add the selected region',
	'free_money'		=> 'Free allowance',
	'pay_fee'			=> 'Cash on shipping payment',
	'edit_area'			=> 'Edit Area',
	'add_continue'		=> 'Continue to add shipping region',
	'back_list'			=> 'Return to list page',
	'empty_regions'		=> 'Current region has no related regions.',
	
	/* Prompting message */
	'repeat_area_name'	=> 'The shipping region already exists.',
	'not_find_plugin'	=> 'No shipping plug-in.',
	'remove_confirm'	=> 'Are you sure delete the shipping region?',
	'remove_success'	=> 'Appointed shipping region has be deleted successfully!',
	'remove_fail'		=> 'Remove failed',
	'no_shippings'		=> 'No shipping.',
	'add_area_success'	=> 'Add shipping region successfully.',
	'edit_area_success'	=> 'Edit shipping region successfully.',
	'disable_shipping_success'	=> 'Appointed shipping region has be removed.',
	
	/* JS language item */
	'js_languages' => array(
		'no_area_name'		=> 'Please enter name of shipping region.',
		'del_shipping_area'	=> 'Please delete the regional distribution, and then re-add.',
		'invalid_free_mondy'=> 'Please enter a free allowance and it must be an integer.',
		'blank_shipping_area'	=> 'The regional distribution can`t is blank.',
		'lang_remove'			=> 'Remove',
		'lang_remove_confirm'	=> 'Are you sure remove the region?',
			
		'lang_disabled'			=> 'Disabled',
		'lang_enabled'			=> 'Enabled',
		'lang_setup'			=> 'Setup',
		'lang_region'			=> 'Region',
		'lang_shipping'			=> 'Shipping method',
		'region_exists'			=> 'The region already exists.',
	),
	
	//追加
	'item_fee' 			=> 'Single commodity costs',
	'shipping_area'		=> 'Distribution area',
	'list'				=> 'List',
	'shipping_way'		=> 'The mode of distribution is ',
	'add_area_success'	=> 'Add distribution area success',
	'add'				=> 'Add',
	
	'select_shipping_area'	=> 'Select delivery area:',
	'search_country_name'	=> 'Search country name',
	'no_country_choose'		=> 'No country area available...',
	'search_province_name'	=> 'Search province name',
	'choose_province_first'	=> 'Please select the name of the province...',
	'search_city_name'		=> 'Search city / region name',
	'choose_city_first'		=> 'Please select the city / district name...',
	'search_districe_name'	=> 'Search county / Township name',
	'choose_districe_first'	=> 'Please select the county / Township name...',
	'shipping_method'		=> 'Shipping Method',
	
	'batch_drop_confirm'	=> 'Are you sure you want to delete the selected distribution area?',
	'select_drop_area'		=> 'Please select the area you want to remove distribution!',
	'area_name_keywords'	=> 'Please enter area name keywords',
	'drop_area_confirm'		=> 'Are you sure you want to delete the distribution area?',
	
	'search'	=> 'Search',
	'yes'		=> 'Yes',
	'no'		=> 'No',
	
	'label_shipping_area_name' 	=> 'Shipping area name:',
	'label_fee_compute_mode'	=> 'Cost calculation:',
	'shiparea_manage'			=> 'Delivery Area Management',
	'shiparea_delete'			=> 'Delete Delivery Area',
				
	'overview'				=> 'Overview',
	'more_info'         	=> 'More information:',
	
	'shipping_area_help' 	=> 'Welcome to ECJia intelligent background distribution area page, you can view the corresponding distribution list in this page.',
	'about_shipping_area'	=> 'About the distribution area to help document',
	
	'add_area_help'			=> 'Welcome to the new distribution area of ECJia intelligent background page, you can create new distribution area information on this page.',
	'about_add_area'		=> 'About the new distribution area to help document',
	
	'edit_area_help'		=> 'Welcome to ECJia intelligent background editing and distribution area page, you can edit the corresponding distribution of regional information in this page.',
	'about_edit_area'		=> 'About edit the distribution area to help document ',
);

//end