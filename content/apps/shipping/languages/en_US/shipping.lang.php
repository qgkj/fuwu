<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 管理中心配送方式管理语言文件
 */
return array(
	'03_shipping_list' 	=> 'Shipping',	//追加
	'shipping_name'		=> 'Name',
	'shipping_version'	=> 'Version',
	'shipping_desc'		=> 'Description',
	'shipping_author'	=> 'Author',
	'insure'			=> 'Insurance',
	'support_cod'		=> 'COD',
	'shipping_area'		=> 'Config area',
	'shipping_print_edit'		=> 'Edit print template',
	'shipping_print_template'	=> 'Express a single template',
	'shipping_template_info'	=> 'Order template variable description:<br/>{$shop_name}Shop name express<br/>{$province}Shop express their respective provinces<br/>{$city}Shop express-owned urban<br/>{$shop_address}Express Shop Address<br/>{$service_phone}Express Shop top<br/>{$order.order_amount}Express orders<br/>{$order.region}Express the recipient area<br/>{$order.tel}That the recipient phone<br/>{$order.mobile}Express the recipient mobile phone<br/>{$order.zipcode}Recipient express Zip<br/>{$order.address}Express the full address of the recipient<br/>{$order.consignee}Express the recipient name<br/>{$order.order_sn}Express order number',
	'shipping_template_info_t'  => 'Order Template Variable Description',
	'shipping_template_info_l' 	=> '{$shop_name}It represents the name of the shop<br/>{$province}Representation shop owned provinces<br/>{$city}Shop represent their respective cities<br/>{$shop_address}Expressed Shop Address<br/>{$service_phone}Tel showing Shop<br/>',//追加
	'shipping_template_info_c' 	=> '{$order.order_amount}It represents the amount of orders<br/>{$order.region}It indicates the recipient area<br/>{$order.tel}It indicates the recipient/s phone<br/>{$order.mobile}It indicates the recipient phone<br/>',//追加
	'shipping_template_info_r' 	=> '{$order.zipcode}Zip code represents recipient<br/>{$order.address}It indicates the recipient address details<br/>{$order.consignee}It represents the name of the recipient<br/>{$order.order_sn}That the order number',//追加
	
	'enable' 	=> 'Enabled',		//追加
	'disable' 	=> 'Disabled',		//追加

	/* Memu */
	'shipping_install'		=> 'Install shipping method',
	'install_succeess'		=> 'Shipping method %s install successfully!',
	'del_lable'				=> 'Delete Label',
	'upload_shipping_bg'	=> 'Upload express waybill image',
	'del_shipping_bg'		=> 'Remove Express Waybill Picture',
	'save_setting'			=> 'Save Settings',
	'recovery_default'		=> 'Restore Default',
	'attradd_succed' 		=> 'Successful operation',//追加
	'attradd_faild'   		=>'operation failed',//追加
	
	/* Express single-part */
	'lable_select_notice'	=> '--Select Insert Tab--',
	'lable_box' => array(
		'shop_country'	=> 'Shop - National',
		'shop_province'	=> 'Shop - Provinces',
		'shop_city'		=> 'Shop - City',
		'shop_name'		=> 'Shop - Name',
		'shop_district'	=> 'Shop - District / County',
		'shop_tel'		=> 'Shop - Telephone',
		'shop_address'	=> 'Shop - Address',
			
		'customer_country'	=> 'Recipient - National',
		'customer_province'	=> 'Recipient - Provinces',
		'customer_city'		=> 'Recipient - City',
		'customer_district'	=> 'recipient - District / County',
		'customer_tel'		=> 'Recipient - Telephone',
		'customer_mobel'	=> 'Recipient - Mobile',
		'customer_post'		=> 'Recipient - Zip Code',
		'customer_address'	=> 'Recipient - full address',
		'customer_name'		=> 'Recipient - Name',
			
		'year'				=> 'Years - Date of the day',
		'months'			=> 'Month - Day of the date',
		'day'				=> 'Day - Date of the day',
		'order_no'			=> 'Order number - Order',
		
		'order_postscript'	=> 'Remarks - Order',
		'order_best_time'	=> 'Delivery time - Orders',
		'pigeon'			=> '√-Pigeon',
	),
		
	/* Prompting message */
	'no_shipping_name'	=> 'Shipping method name can\'t be empty.',
	'no_shipping_desc'	=> 'Shipping method description can\'t be empty.',
	'change_shipping_desc_faild' => 'Delivery description modification fails.',//追加
	'repeat_shipping_name'	=> 'The shipping method already exists.',
	'uninstall_success'		=> 'Shipping method %s has uninstall successfully.',
	'add_shipping_area'		=> 'Creat new shipping area for shipping method',
	'no_shipping_insure'	=> 'Insurance money can\'t be empty, if you don\'t use it please config as 0.',
	'not_support_insure'	=> 'The shipping method isn\t support insure, config insure cost has failed.',
	'invalid_insure'		=> 'Shipping insurance money is invalid.',
	'no_shipping_install'	=> 'Distribution means that you have not installed temporarily can not edit template',
	'edit_template_success'	=> 'Express has been successfully edit the template.',
	
	/* JS language item */
	'js_languages' => array(
		'lang_removeconfirm'	=> 'Are you sure uninstall the shipping method?',
		'shipping_area'			=> 'Config area',
		'upload_falid'			=> 'Error: file type is not correct. Please upload %s type of file!',
		'upload_del_falid'		=> 'Error: Delete failed!',
		'upload_del_confirm'	=> "Tip: Do you confirm the deletion to print a single image?",
		'no_select_upload'		=> "Error: You do not choose to print a single image. Please use the 'Browse ...' button to select!",
		'no_select_lable'		=> "Operation terminated! You did not choose any label.",
		'no_add_repeat_lable'	=> "Operation failed! Not allowed to add a duplicate label.",
		'no_select_lable_del'	=> "Delete Failed! You do not select any label.",
		'recovery_default_suer'	=> "To restore the default do you confirm? Restore Default will display the contents of the installation.",
	),
		
	//追加
	'select_image'			=> 'Select',
	'file_empty'			=> 'File is not selected',
	'upload'				=> 'Upload',
	'edit_shipping_name'	=> 'Edit delivery name',
	'set_shipping'			=> 'Set delivery area',
	'edit_shipping_order' 	=> 'Edit delivery sort',
	'not_support'			=> 'Not support',
	
	'select_template_mode'	=> 'Please select a template pattern:',
	'code_mode'				=> 'Code patterns',
	'income_model'			=> 'WYSIWYG mode',
	'mode_notice'			=> 'Select code mode can switch to the previous version. It is recommended that you use the "WYSIWYG mode". All the mode selection, the same effect on the print template.',
	
	'shipping'	 		=> 'Shipping Method',
	'plugin'			=> 'Plugin',
	'disabled'			=> 'Disabled',
	'enabled'			=> 'Enabled',
	'format_error'		=> 'Incorrect input format',
	'remove_success'	=> 'Delete success',
	'use_again_notice'	=> 'To remove the picture is the default image, the recovery template can be used again',
	'remove_success'	=> 'Delete failed',
	'express_template'	=> 'Express template',
	'edit_template'		=> 'Edit Express Template',
	'shipping_list'		=> 'Delivery List',
	'enter_valid_number'=> 'Please enter a valid number or percentage%',
	
	'edit_shipping'			=> 'Edit Shipping',
	'insure_lable' 			=> 'Insurance：',
	'shipping_name_lable'	=> 'Name:',
	'shipping_desc_lable' 	=> 'Description:',
	'support_cod_label'		=> 'COD:',
	'shipping_not_available'=> 'The distribution plugin does not exist or has not been installed',
	'repeat'				=> 'Repeat',
	'install_ok' 			=> 'Successful installation',
	'edit_ok'				=> 'Edited successfully',
	
	'shipping_manage'		=> 'Delivery Management',
	
	'js_lang' => array(
		'shipping_area_name_required'	=> 'Delivery area name can not be empty',
		'not_empty_message'				=> 'can not be null and must be an integer.',
		'shipping_area_region_required' => 'Delivery area can not be empty.',
		'no_select_region'				=> 'No alternative area',
		'add'							=> 'Add',
		'region_selected'				=> 'The area has been selected!',
		'shipping_name_required'		=> 'Please enter the name of Delivery',
		'shipping_name_minlength'		=> 'Delivery nominal length is not less than 3',
		'shipping_desc_required'		=> 'Please enter a description of the distribution',
		'shipping_desc_minlength'		=> 'Distribution mode description length can not be less than 6',
	),
	
	'overview'				=> 'Overview',
	'more_info'         	=> 'More information:',
	
	'shipping_list_help'	=> 'Welcome to ECJia intelligent background distribution mode page, the system will display all the way in this list.',
	'about_shipping_list'	=> 'About delivery mode help document ',
	
	'edit_template_help'	=> 'Welcome to ECJia intelligent background Express template edit page, you can edit the corresponding Express template information.',
	'about_edit_template'	=> 'About edit Express template help document',
);

//end