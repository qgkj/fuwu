<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

return array(
	'app_name'		=> 'ECJIA',
	'cp_home'		=> 'ECJIA Management',
	'copyright'		=> ' &copy, 2005-2012 ECJIA Copyright, <br> All Right Reserved.',
	'query_info'	=> 'Run %d queries, spend %s seconds',
	'memory_info'	=> ',memory occupied:%0.3f MB',
	'gzip_enabled'	=> ',Gzip enabled',
	'gzip_disabled'	=> ',Gzip disabled',
	'loading'		=> 'Processing...',
		
	'js_languages' => array(
		'process_request'	=> 'Processing...',
		'todolist_caption'	=> 'To do list',
		'todolist_autosave'	=> 'Auto save',
		'todolist_save'		=> 'Save',
		'todolist_clear'	=> 'Clear',
		'todolist_confirm_save'	=> 'Are you sure save change to To do list?',
		'todolist_confirm_clear'=> 'Are you sure clear text?',
	),

	'auto_redirection'	=> 'If you don\'t select, <span id="spanSeconds">3</span> seconds ago, it will jump to the first URL.',
	'password_rule'		=> 'Password should only contain english character, figure, long between 6 and 16 bits.',
	'username_rule'		=> 'Username should be chinese ,english character, figure combination, between 3 and 15 bits.',
	'plugins_not_found'	=> 'Plug-in %s can\'t be fixed position',
	'no_records'		=> 'Did not find any record',
	'role_describe'		=> 'Description',
	
	'require_field'	=> '<span class="require-field">*</span>',
	'yes'			=> 'Yes',
	'no'			=> 'No',
	'record_id'		=> 'ID',
	'handler'		=> 'Operate',
	'install'		=> 'Install',
	'uninstall'		=> 'Uninstall',
	'list'			=> 'List',
	'add'			=> 'Add',
	'edit'			=> 'Edit',
	'view'			=> 'View',
	'remove'		=> 'Remove',
	'drop'			=> 'Delete',
	'confirm_delete'=> 'Are you sure you want to delete?',
	'disabled'		=> 'Disabled',
	'enabled'		=> 'Enabled',
	'setup'			=> 'Setup',
	'success'		=> 'Success',
	'sort_order'	=> 'Sort',
	'trash'			=> 'Recycle bin',
	'restore'		=> 'Restore',
	'close_window'	=> 'Close Window',
	'btn_select'	=> 'Choose',
	'operator'		=> 'Operator',
	'cancel'		=> 'Cancel',
	'operate_fail'		=> 'Operate Fail',
	'invalid_parameter' => 'Invalid parameter',
	
	'empty'			=> 'Can\'t be blank',
	'repeat'		=> 'Existed',
	'is_int'		=> 'It must be an integer',
	
	'button_submit'	=> ' Submit ',
	'button_save'	=> ' Save ',
	'button_reset'	=> ' Reset ',
	'button_search'	=> ' Search ',
	
	'priv_error'	=> 'Sorry, you haven\'t authorization to run this operation!',
	'drop_confirm'	=> 'Are you sure delete this record?',
	'form_notice'	=> 'View notices',
	'upfile_type_error'	=> 'Upload file type error!',
	'upfile_error'		=> 'Upload file error!',
	'no_operation'		=> 'You do not choose any action',
	
	'go_back'		=> 'Previous',
	'back'			=> 'Back',
	'continue'		=> 'Continue',
	'system_message'=> 'System information',
	'check_all'		=> 'Check all',
	'select_please'	=> 'Please select...',
	'all_category'	=> 'All categories',
	'all_brand'		=> 'All brand',
	'refresh'		=> 'Refresh',
	'update_sort'	=> 'Update sort',
	'modify_failure'=> 'Modify failure!',
	'attradd_succed'=> 'Operate successfully!',
	'todolist'		=> 'To do list',
	'n_a'			=> 'N/A',
	
	//追加
	'sys' => array(
			'wrong' => 'Wrong：',
	),
		
		
	/* Coding */
	'charset' => array(
		'utf8'	=> 'Internationalization coding(utf8)',
		'zh_cn'	=> 'Simplified chinese',
		'zh_tw'	=> 'Traditional Chinese',
		'en_us'	=> 'America english',
		'en_uk'	=> 'English',
	),
		
	/* New order notify */
	'order_notify'	=> 'New order notify',
	'new_order_1'	=> 'You have ',
	'new_order_2'	=> ' New orders and ',
	'new_order_3'	=> ' New paid orders',
	'new_order_link'=> 'View new orders',
	
	/* Language item*/
	'chinese_simplified'	=> 'Simplified chinese',
	'english'				=> 'English',
	
	/* Pagination */
	'total_records'	=> 'Total ',
	'total_pages'	=> 'records, divided into ',
	'page_size'		=> 'page, per page',
	'page_current'	=> 'pages,  current No.',
	'page_first'	=> 'First',
	'page_prev'		=> 'Prev',
	'page_next'		=> 'Next',
	'page_last'		=> 'Last',
	'admin_home'	=> 'HOME',
	
	/* Weight */
	'gram'		=> 'Gram',
	'kilogram'	=> 'Kilogram',
	
	/* Menu category */
	'02_cat_and_goods'	=> 'Product',
	'03_promotion'		=> 'Sales promotion',
	'04_order'			=> 'Order',
	'05_banner'			=> 'Advertisement',
	'06_stats'			=> 'Reports Statistic',
	'07_content'		=> 'Article',
	'08_members'		=> 'Member',
	'09_others'			=> 'Others',
	'10_priv_admin'		=> 'Authorization',
	'11_system'			=> 'System Setup',
	'12_template'		=> 'Template',
	'13_backup'			=> 'Database',
	'14_sms'			=> 'Short Message',
	'15_rec'			=> 'Recommend management',
	'16_email_manage'	=> 'Mass-mailing management',
	
	/* Product management */
	'01_goods_list'		=> 'Product List',
	'02_goods_add'		=> 'New Product',
	'03_category_list'	=> 'Product Category',
	'04_category_add'	=> 'New Category',
	'05_comment_manage'	=> 'User Comments',
	'06_goods_brand_list'	=> 'Product Brand',
	'07_brand_add'			=> 'New Brand',
	'08_goods_type'			=> 'Product Type',
	'09_attribute_list'		=> 'Product Attribute',
	'10_attribute_add'		=> 'Add Attribute',
	'11_goods_trash'		=> 'Recycle Bin',
	'12_batch_pic'			=> 'Pictures Processor ',
	'13_batch_add'			=> 'Upload Products',
	'15_batch_edit'			=> 'Batch Edit',
	'16_goods_script'		=> 'Product Code',
	'17_tag_manage'			=> 'Tag',
	'52_attribute_add'		=> 'Edit Attribute',
	'53_suppliers_goods'	=> 'Management of suppliers of goods',
	
	'14_goods_export'		=> 'Merchandise export volume',
	
	'50_virtual_card_list'	=> 'Virtual Goods List',
	'51_virtual_card_add'	=> 'New Virtual Goods',
	'52_virtual_card_change'=> 'Change encrypt string',
	'goods_auto'			=> 'Automatic merchandise from top to bottom rack',
	'article_auto'			=> 'Published article automatically',
	'navigator'				=> 'Custom navigation bar',
	
	/* Sales promotion management */
	'02_snatch_list'	=> 'Dutch Auction',
	'snatch_add'		=> 'Add Dutch Auction',
	'04_bonustype_list'	=> 'Bonus Type',
	'bonustype_add'		=> 'Add Bonus Type',
	'05_bonus_list'		=> 'Bonus Offline',
	'bonus_add'			=> 'Add User Bonus',
	'06_pack_list'		=> 'Product Packing',
	'07_card_list'		=> 'Greetings Card',
	'pack_add'			=> 'New Packing',
	'card_add'			=> 'New Card',
	'08_group_buy'		=> 'Associates',
	'09_topic'			=> 'Topic',
	'topic_add'			=> 'Add Topic',
	'topic_list'		=> 'Topic List',
	'10_auction'		=> 'Auction',
	'12_favourable'		=> 'Favourable Activity',
	'13_wholesale'		=> 'Wholesale',
	'ebao_commend'		=> 'Ebao commend',
	'14_package_list'	=> 'Preferential Packeage',
	'package_add'		=> 'Add Preferential Packeage',
	
	/* Orders management */
	'02_order_list'		=> 'Order List',
	'03_order_query'	=> 'Order Query',
	'04_merge_order'	=> 'Combine Orders',
	'05_edit_order_print'	=> 'Print Orders',
	'06_undispose_booking'	=> 'Booking Records',
	'08_add_order'			=> 'Add Order',
	'09_delivery_order'		=> 'Delivery Order',
	'10_back_order'			=> 'Returned Order',
	
	/* AD management */
	'ad_position'	=> 'AD Position',
	'ad_list'		=> 'AD List',
	
	/* Report statistic */
	'flow_stats'			=> 'Flux Analyse',
	'searchengine_stats'	=> 'Search engine',
	'report_order'		=> 'Order Statistic',
	'report_sell'		=> 'Sales Survey',
	'sell_stats'		=> 'Sales Ranking',
	'sale_list'			=> 'Sales Details',
	'report_guest'		=> 'Client Statistic',
	'report_users'		=> 'User Ranking',
	'visit_buy_per'		=> 'Visit Purchase Rate',
	'z_clicks_stats'	=> 'External Laid JS',
	
	/* Article management */
	'02_articlecat_list'	=> 'Article Category',
	'articlecat_add'		=> 'New Article Category',
	'03_article_list'		=> 'Articles',
	'article_add'			=> 'New Article',
	'shop_article'			=> 'Shop Article',
	'shop_info'				=> 'Shop Information',
	'shop_help'				=> 'Shop Help',
	'vote_list'				=> 'Vote Online',
	
	/* User management */
	'03_users_list'		=> 'Users',
	'04_users_add'		=> 'New User',
	'05_user_rank_list'	=> 'User Rank',
	'06_list_integrate'	=> 'Integrate User',
	'09_user_account'	=> 'Saving and drawing application',
	'10_user_account_manage'	=> 'account_manage',
		
	//追加
	'menu_user_integrate' 	=> 'Member Integration',
	'menu_user_connect'		=> 'Account connection',
		
	'17_msg_mmanage'		=> 'Feedback',
	'08_unreply_msg'		=> 'User Message',
	'01_order_msg'			=> 'Order Message',
	'02_comment_msg'		=> 'Public messages',
	
	/* Authorization  management */
	'admin_list'		=> 'Administrators',
	'admin_list_role'	=> 'Role list',
	'admin_role'		=> 'Management role',
	'admin_add'			=> 'New Administrator',
	'admin_add_role'	=> 'Add role',
	'admin_edit_role'	=> 'Modify role',
	'admin_logs'		=> 'Logs',
	'agency_list'		=> 'Agency',
	'suppliers_list'	=> 'Suppliers',
	
	/* System setup */
	'01_shop_config'	=> 'Configuration',
	'shop_authorized'	=> 'Authorized',
	'shp_webcollect'	=> 'Webcollect',
		
	'04_mail_settings'	=> 'Mail Settings',
	'05_area_list'		=> 'Area List',
	'shipping_area_list'=> 'Shipping Area',
	'sitemap'			=> 'Sitemap',
	'check_file_priv'	=> 'File Authorization',
// 	'captcha_manage'	=> 'Verification Code Management',
	'fckfile_manage'	=> 'Fck From document management',
	'ucenter_setup'		=> 'UCenter Set',
	'file_check'		=> 'Check File',
// 	'021_reg_fields'	=> 'Register options settings',
	'21_reg_fields'	=> 'Register options settings',
		
		
	'01_payment_list'	=> 'Payment',
	'02_shipping_list'	=> 'Shipping',
	'03_cron_list' 		=> 'Cron',
	'04_cycleimage_manage' => '轮播图管理',
	'05_captcha_setting' => '验证码设置',
	'06_friendlink_list' => '友情链接',
// 	'07_cron_schcron'	=> 'Cron',
// 	'08_friendlink_list'=> 'Links',


	/* Template management */
	'02_template_select'	=> 'Select Template',
	'03_template_setup'		=> 'Setup Template',
	'04_template_library'	=> 'Library Item',
	'mail_template_manage'	=> 'Mail Template',
	'05_edit_languages'		=> 'Language Item',
	'06_template_backup'	=> 'Template Settings backup',
		
	/* Database management */
	'02_db_manage'		=> 'Backup',
	'03_db_optimize'	=> 'Optimize',
	'04_sql_query'		=> 'SQL Query',
	'05_synchronous'	=> 'Synchronous',
	'convert'			=> 'Convertor',
	
	/* Short management */
	'02_sms_my_info'	=> 'Accounts',
	'03_sms_send'		=> 'Send Message',
	'04_sms_charge'		=> 'Accounts Charge',
	'05_sms_send_history'	=> 'Send Record',
	'06_sms_charge_history'	=> 'Charge History',
	
	'affiliate'		=> 'Recommended settings',
	'affiliate_ck'	=> 'Divided into management',
	'flashplay'		=> 'Flash Player Management',
	'search_log'	=> 'Search keywords',
	'email_list'	=> 'E-mail subscription management',
	'magazine_list'	=> 'Journal of Management',
	'attention_list'=> 'Concerned about the management',
	'view_sendlist'	=> 'Mail queue management',
	
	/* 积分兑换管理 */
	'15_exchange_goods'		=> 'Integral Mall Goods',
	'15_exchange_goods_list'=> 'Points Mall commodity list',
	'exchange_goods_add'	=> 'Add new merchandise',
	
	/* cls_image */
	'directory_readonly'		=> 'The directory % is not existed or unable to write.',
	'invalid_upload_image_type'	=> 'Not a allowable image type.',
	'upload_failure'			=> '%s failed to upload',
	'missing_gd'				=> 'GD is missing',
	'missing_orgin_image'		=> 'Can not find %s.',
	'nonsupport_type'			=> 'Nonsupport type of %s.',
	'creating_failure'			=> 'Fail to create image.',
	'writting_failure'			=> 'Fail to write image.',
	'empty_watermark'			=> 'The parameter of watermark is empty.',
	'missing_watermark'			=> 'Can not find %s.',
	'create_watermark_res'		=> 'Fail to create resource of watermark. The image type is %s.',
	'create_origin_image_res'	=> 'Fail to create resource of origin image. The image type is %s.',
	'invalid_image_type'		=> 'Unknown watermark image %s.',
	'file_unavailable'			=> 'File %s don\'t exist or are unreadable.',
	
	/* SMTP ERROR */
	'smtp_setting_error'		=> 'There is an error in SMTP setting.',
	'smtp_connect_failure'		=> 'Unable to connect to SMTP server %s.',
	'smtp_login_failure'		=> 'Invalid SMTP username or password.',
	'sendemail_false'			=> 'E-mail failed, please check your mail server settings!',
	'smtp_refuse'				=> 'SMTP server refuse to send this mail.',
	'disabled_fsockopen'		=> 'Fsocketopen server function is disabled.',
	
	/* 虚拟卡 */
	'virtual_card_oos'	=> 'Virtual card out of stock',
	
	'span_edit_help'	=> 'Click to edit content',
	'href_sort_help'	=> 'Click on the list to sort',
	
	'catname_exist'		=> 'Has exist the same category!',
	'brand_name_exist'	=> 'Has exist the same brand!',
	
	'alipay_login'	=> '<a href="https://www.alipay.com/user/login.htm?goto=https%3A%2F%2Fwww.alipay.com%2Fhimalayas%2Fpracticality_profile_edit.htm%3Fmarket_type%3Dfrom_agent_contract%26customer_external_id%3D%2BC4335319945672464113" target="_blank">Immediate payment interface for free jurisdiction</a>',
	'alipay_look'	=> '<a href=\"https://www.alipay.com/himalayas/practicality.htm\" target=\"_blank\">Please apply after successful login pay treasure account check</a>',	
);

//end