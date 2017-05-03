<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 推送消息语言包
 */
return array(
	//消息配置
	'msg_config'				=> 'Message Configuration',
	'update_config_success'		=> 'Update message configuration success',
	'platform_config'			=> 'Platform Configuration',
	'label_app_name'			=> 'Application name:',
	'app_name_help'				=> 'Only when prompted for Android application to receive message notification',
	'label_push_development'	=> 'Push environment:',
	'push_development_help'		=> 'App running on the line make sure to switch to the production environment',
	'dev_environment'			=> 'Development environment',
	'produce_environment'		=> 'Production environment',
		
	'label_android_app_key'		=> 'Android App Key:',
	'label_android_app_secret'	=> 'Android App Secret:',
	'label_iphone_app_key'		=> 'iPhone App Key:',
	'label_iphone_app_secret'	=> 'iPhone App Secret:',
	'label_ipad_app_key'		=> 'iPad App Key:',
	'label_ipad_app_secret'		=> 'iPad App Secret:',
	'label_client_order'		=> 'Customer pay order:',
	'client_order_help'			=> 'Whether to push the message to the business when the customer orders',
	'label_client_pay'			=> 'Customer payment:',
	'client_pay_help'			=> 'Whether to send messages to the business when customers pay',
	'label_seller_shipping'		=> 'Merchant shipping:',
	'seller_shipping_help'		=> 'Whether or not to send the message to the customer when the merchant shipping',
	'label_user_register'		=> 'User registration:',
	'user_register_help'		=> 'Whether the user is registered to push messages to customers',
		
	'push'		=> 'Push',
	'not_push'	=> 'Do not push',
	'resend'	=> 'Push again',
	'push_copy' => 'Message reuse',
		
	//消息模版
	'msg_template'				=> 'Message Template',
	'add_msg_template'			=> 'Add Message Template',
	'msg_template_list'			=> 'Message Template List',
	'template_name_exist'		=> 'The message template name already exists',
	'continue_add_template'		=> 'Continue to add message template',
	'back_template_list'		=> 'Return to message template',
	'add_template_success'		=> 'Add message template success',
	'edit_msg_template'			=> 'Edit message template',
	'update_template_success'	=> 'Update message template success',
	'remove_template_success'	=> 'Delete message template success',
		
	'label_msg_template'		=> 'Template name:',
	'label_msg_subject'			=> 'Message topic:',
	'label_msg_content'			=> 'Message content:',
	'update'					=> 'Update',
		
	'msg_template_name'			=> 'Template name',
	'msg_subject'				=> 'Message topic',
	'msg_content'				=> 'Message content',
	'remove_template_confirm'	=> 'Are you sure you want to delete the message template?',
		
	//消息记录
	'all'		=> 'All',
	'android'	=> 'Android',
	'iphone'	=> 'iPhone',
	'ipad'		=> 'iPad',
	
	'batch'		=> 'Batch Operations',
	
	//删除推送消息
	'remove_msg'			=> 'Delete Message',
	'remove_msg_confirm'	=> 'Are you sure you want to delete this push message?',
	'empty_select_msg'		=> 'Please select push message to be deleted',
		
	//再次推送消息
	'resend_msg'			=> 'Push message again',
	'resend_confirm'		=> 'Are you sure you want to push the message that push again?',
	'emtpy_resend_msg' 		=> 'Please select the message to be pushed again',
		
	//推送消息
	'push_confirm'			=> 'Are you sure you want to push this message?',
		
	'select_push_status'	=> 'Select push state',
	'push_fail'				=> 'Push fail',
	'push_success'			=> 'Push complete',
	'filter'				=> 'Filter',
	'msg_keywords'			=> 'Please enter a message subject keyword',
	'search'				=> 'Search',
			
	'device_type'			=> 'Device type',
	'push_status'			=> 'Push state',
	'add_time'				=> 'Add time',
	'has_pushed'			=> 'The message has been pushed',
	'time'					=> 'time',
	'label_push_on' 		=> 'Push on:',
		
	//发送消息
	'msg_subject_help'		=> 'Used to identify messages, to facilitate the search and management',
	'msg_content_help'		=> 'Here is the content of the message to be pushed',
	'push_behavior'			=> 'Push Behavior',
	'label_open_action'		=> 'Open action:',
		
	'nothing'		=> 'Nothing',
	'main_page'		=> 'Home',
	'singin'		=> 'Sign in',
	'signup'		=> 'Register',
	'discover'		=> 'Discover',
	'qrcode'		=> 'QR code scanning',
	'qrshare'		=> 'QR code sharing',
	'history'		=> 'History',
	'feedback'		=> 'Feedback',
	'map'			=> 'Map',
	'message_center'=> 'Message center',
	'webview'		=> 'Built-in browser',
	'setting'		=> 'Set up',
	'language'		=> 'Language selection',
	'cart'			=> 'Cart',
	'help'			=> 'Help center',
	'goods_list'	=> 'List of goods',
	'goods_comment'	=> 'Product reviews',
	'goods_detail'	=> 'Product details',
	'orders_list'	=> 'My order',
	'orders_detail'	=> 'Order details',
	'user_center'	=> 'User center',
	'user_wallet'	=> 'My wallet',
	'user_address'	=> 'Address management',
	'user_account'	=> 'Account balance',
	'user_password'	=> 'Change password',
		
	'label_url'			=> 'URL:',
	'label_keywords'	=> 'Keywords:',
	'lable_category_id' => 'Category ID:',
	'label_goods_id'	=> 'Product ID:',
	'label_order_id'	=> 'Order ID:',
	'push_object'		=> 'Push Object',
	'label_device_type' => 'Device type:',	
	'pleast_select'		=> 'Please select...',
	'device_type_help'	=> 'When pushed to the user or administrator, you do not need to select the device type',
	'label_push_to'		=> 'Push to:',
	'all_people'		=> 'All people',
	'unicast'			=> 'Unicast',
	'user'				=> 'User',
	'administrator'		=> 'Administrator',
	'label_device_token'=> 'Device Token:',
	'label_user_id'		=> 'User ID:',
	'label_admin_id'	=> 'Administrator ID:',
	'push_time'			=> 'Push Opportunity',
	'label_send_time'	=> 'Send time:',
	'send_now'			=> 'Send immediately',
	'send_later'		=> 'Send later',
		
	'msg_record'		=> 'Message Record',
	'add_msg_push'		=> 'Add Message Push',
	'msg_record_list'	=> 'Message Record List',
	'msg_push'			=> 'Message Push',
		
	'url_required'			=> 'Please enter the URL',
	'keywords_required'		=> 'Please enter a keyword',
	'category_id_required'	=> 'Please enter the product category ID',
	'goods_id_required'		=> 'Please enter a product ID',
	'order_id_required'		=> 'Please enter order ID',
	'admin_id_required'		=> 'Please enter the administrator ID',
	'device_info_required'	=> 'The user\'s Device Token not found',
	'user_id_required'		=> 'Please enter your user ID',
	'device_client_required'=> 'The user is not bound to the mobile terminal device',
	'device_token_required'	=> 'Please enter Token Device',
	'device_token_error'	=> 'The length of the input Token Device is not valid',
	
	'msg_push_success'		=> 'Message push success',
	'remove_msg_success'	=> 'Delete message success',
	'batch_push_success'	=> 'Batch push finished',
	'batch_drop_success'	=> 'Batch delete success',	
	'invalid_parameter'		=> 'Invalid parameter',
		
	//菜单
	'push_msg'	=> 'Push Message',
	'send_msg'	=> 'Send Message',
		
	'push_history_manage'	=> 'Message Record Management',
	'push_template_manage'	=> 'Message Template Management',
	'push_template_update'	=> 'Message Template Update',
	'push_template_delete'	=> 'Message Template Remove',
	'push_config_manage'	=> 'Message Configuration Management',
		
	'js_lang' => array(
		'title_required'	=> 'Please enter a message topic!',
		'content_required'	=> 'Please enter the message content!',
		'app_name_required'	=> 'Please fill in the application name!',
		'sFirst'			=> 'Home page',
		'sLast' 			=> 'End page',
		'sPrevious'			=> 'Last page',
		'sNext'				=> 'Next page',
		'sInfo'				=> 'A total of _TOTAL_ records section _START_ to section _END_',
		'sInfoFiltered'		=> '(retrieval from _MAX_ data)',
		'sZeroRecords' 		=> 'Did not find any record',
		'sEmptyTable' 		=> 'Did not find any record',
		'sInfoEmpty'		=> 'A total of 0 records',
		'template_required'	=> 'Template name can not be empty!',
		'subject_required'	=> 'Message theme can not be empty!',
		'msg_content_required' => 'Message content can not be empty!'	,
	)
);

// end