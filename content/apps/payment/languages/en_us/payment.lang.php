<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 管理中心支付方式管理语言文件
 */
return array(
	'02_payment_list' 	=> 'Payment',
	'payment'			=> 'Payment Mothod',
	'payment_name'		=> 'Name',
	'version'			=> 'Version',
	'payment_desc'		=> 'Description',
	'short_pay_fee'		=> 'Money',
	'payment_author'	=> 'Author',
	'payment_is_cod'	=> 'Pay after received?',
	'payment_is_online'	=> 'Online payment?',
		
	'enable' 		=> 'Enable',
	'disable' 		=> 'Disable',
	'name_edit' 	=> 'Name of payment method',
	'payfee_edit' 	=> 'Payment method cost',
	'payorder_edit' => 'Order of payment',
	'name_is_null'	=> 'Please enter payment method name!',
	'name_exists'	=> 'The payment method has existed!',
	'pay_fee'		=> 'Poundage',
	'back_list'		=> 'Return to payment mothod list.',
	'install_ok'	=> 'Install success',
	'edit_ok'		=> 'Edit success',
	'edit_falid' 	=> 'Edit failed',
	'uninstall_ok'	=> 'Uninstall success',
	
	'invalid_pay_fee'		=> 'Please enter a valid number of payment.',
	'decide_by_ship'		=> 'Shipping decision',
	'edit_after_install'	=> 'You can\'t use the payment mothod until it is installed.',
	'payment_not_available'	=> 'The payment plug-in don\'t exist or have not been installed yet.',
	
	'js_lang' => array(
		'lang_removeconfirm'	=> 'Are you sure remove the payment method?',
		'pay_name_required'		=> 'Please enter a payment name',
		'pay_name_minlength'	=> 'Payment name length should not be less than 3',
		'pay_desc_required'		=> 'Please enter the payment description',
		'pay_desc_minlength'	=> 'Payment description length should not be less than 6',
	),
		
	'pay_status' 	=> 'Payment status',
	'pay_not_exist' => 'This payment method does not exist or parameter errors!',
	'pay_disabled' 	=> 'This payment method has not been enabled!',
	'pay_success' 	=> 'Your payment operation has been successful!',
	'pay_fail' 		=> 'Payment operation failed, please return to retry!',
	
	'ctenpay'		=> 'Choi pay immediately Merchant Registration No.',
	'ctenpay_url'	=> 'http://union.tenpay.com/mch/mch_register_b2c.shtml?sp_suggestuser=542554970',
	'ctenpayc2c_url'=> 'https://www.tenpay.com/mchhelper/mch_register_c2c.shtml?sp_suggestuser=542554970',
	'tenpay'		=> 'tenpay',
	'tenpayc2c'		=> 'Intermediary security',
	
	'dualpay'			=> 'Standard dual-interface',
	'escrow'			=> 'Secured transactions interface',
	'fastpay'			=> 'Real-time interface transactions arrive',
	'alipay_pay_method'	=> 'Choose interface type：',
	'getPid'			=> 'Get Pid、Key',
		
	//追加
	'repeat'					=> 'repeat',
	'buyer'						=> 'buyer',
	'surplus_type_0'			=> 'Saving',
	'order_gift_integral'		=> 'Order %s integral gift',
	'please_view_order_detail' 	=> 'Please view order detail in Member Center',
	'plugin'					=> 'Plugin',
	'disabled'					=> 'Disabled',
	'enabled'					=> 'Enabled',
	'edit_payment'				=> 'Edit Payment Method',
	'payment_list'				=> 'Payment list',
	'number_valid'				=> 'Please enter a valid digital',
	'enter_valid_number'		=> 'Please enter a valid number or percentage%',
	'edit_free_as'				=> 'Modify Cost is %s',
	'edit_payment_name'			=> 'Edit payment name',
	'edit_payment_order'		=> 'Edit payment sort',
	'label_payment_name'		=> 'Name:',
	'label_payment_desc'		=> 'Description:',
	'label_pay_fee'				=> 'Money:',
	
	'payment_manage'		=> 'Payment Method Management',
	'payment_update'		=> 'Update Payment Method',
	'plugin_install_error'	=> 'The name of the payment method or pay_code cannot be empty',
	'plugin_uninstall_error'=> 'Payment name can not be empty',
	
	'overview'              => 'Overview',
	'more_info'             => 'More information:',
	
	'payment_list_help'		=> 'Welcome to ECJia intelligent background payment page, the system will display all the payment methods in this list.',
	'about_payment_list'	=> 'About payment methods help document '
);

//end