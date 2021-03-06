<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

return array(
	'template_manage'		=>'Template Management',
	'current_template'		=> 'Current Template',
	'available_templates'	=> 'Available Templates',
	'select_template'		=> 'Please select a template:',
	'select_library'		=> 'Please select a library:',
	'library_name'			=> 'Library name',
	'region_name'			=> 'Region',
	'sort_order'			=> 'Serial number',
	'contents'				=> 'Content',
	'number'				=> 'Quantity',
	'display'				=> 'Display',
	'select_plz'			=> 'Please select...',
	'button_restore'		=> 'Repeal',
		
	//追加	
	'template_author'		=> 'Author',
	'template_info'			=> 'Template Description',
		
	/* Prompting message */
	'library_not_written'		=> 'Library file %s hasn\'t right to edit, so edit the library file has failed.',
	'install_template_success'	=> 'Enable template successfully.',
	'setup_success'				=> 'Setup template content successfully.',
	'modify_dwt_failed'			=> 'The template file %s can not modify.',
	'setup_failed'				=> 'Setup template content has failed.',
	'update_lib_success'		=> 'Library item content has uploaded successfully.',
	'update_lib_failed'			=> 'Edit library item content has failed. Please check %s directory whether can be read-in.',
	'backup_success'			=> "All template files has copied to the directory (templates/backup). \nAre you download the backup files now?",
	'backup_failed'				=> 'Backup template files has failed, please check the directory (template/backup) whether can be wrote.',
	'not_editable'				=> 'Libs in no-editable region have no options.',
	
	/* Every template file corresponding to language */
	'template_files' => array(
		'article'		=> 'Article content template',
		'article_cat'	=> 'Article category template',
		'brand'			=> 'Brand area',
		//'catalog'		=>'All categories pages',
		'category'		=> 'Products category page template',
		'flow'			=>'Shopping process template',
		'goods'			=> 'Product information template',
		'group_buy_goods'	=> 'Associates products detail template',
		'group_buy_list'	=> 'Associates products list template',
		'index'				=> 'Homepage template',
		'search'			=> 'Search template',
		'compare'			=> 'Compare template',
		'snatch'			=> 'Dutch auction',
		'tag_cloud'			=> 'Tag template',
		'brand'				=> 'Brand page',
		'auction_list'		=> 'Auction list template',
		'auction'			=> 'Auction template',
		'message_board'		=> 'Message Board',
		'exchange_list'		=> 'Mall points list',
	),
	
	/* Every library item's description */
	'template_libs' => array(
		'ad_position'	=> 'AD position',
		'index_ad'		=> 'Homepage AD position',
		'cat_articles'	=> 'Article list',
		'articles'		=> 'Articles',
		'goods_attrlinked'		=> 'Product attrlinked',
		'recommend_best'		=> 'Recommend',
		'recommend_promotion'	=> 'Recommend promotion',
		'recommend_hot'			=> 'Hot',
		'recommend_new'			=> 'New',
		'bought_goods'			=> 'Customers who bought items like this also bought.',
		'bought_note_guide'		=> 'Bought notes',
		'brand_goods'	=> 'Brand product',
		'brands'		=> 'Brands',
		'cart'			=> 'Cart',
		'cat_goods'		=> 'Category',
		'category_tree'	=> 'Category tree',
		'comments'		=> 'User comments list',
		'consignee'		=> 'Place of receipt memu',
		'goods_fittings'=> 'Relational Accessories',
		'page_footer'	=> 'Footer',
		'goods_gallery'	=> 'Gallery',
		'goods_article'	=> 'Article',
		'goods_list'	=> 'List',
		'goods_tags'	=> 'Tags',
		'group_buy'		=> 'Associates',
		'group_buy_fee'	=> 'Total money for associates products',
		'help'			=> 'Help',
		'history'		=> 'History',
		'comments_list'	=> 'Comments list',
		'invoice_query'	=> 'Invoice query',
		'member'		=> 'Members',
		'member_info'	=> 'Members information',
		'new_articles'	=> 'New articles',
		'order_total'	=> 'Total orders money',
		'page_header'	=> 'Top',
		'pages'			=> 'Pages',
		'goods_related'	=> 'Relational products',
		'search_form'	=> 'Search memu',
		'signin'		=> 'Login memu',
		'snatch'		=> 'Dutch auction',
		'snatch_price'	=> 'New bidding',
		'top10'			=> 'Top10',
		'ur_here'		=> 'Current position',
		'user_menu'		=> 'Member center menu',
		'vote'			=> 'Vote',
		'auction'		=> 'Auction',
		'article_category_tree'	=> 'Article Category tree',
		'order_query'	=> 'Front order status inquiries',
		'email_list'	=> 'E-mail Subscriptions',
		'vote_list'		=> 'Online vote',
		'price_grade'	=> 'Price range',
		'filter_attr'	=> 'Filter property',
		'promotion_info'=> 'Promotion infomation',
		'categorys'		=> 'Goods category',
		'myship'		=> 'Shipping',
		'online'		=> 'Number of persons online',
		'relatetag'		=> 'Other applications associated tag data',
		'message_list'	=> 'Message List',
		'exchange_hot'	=> 'Points Mall Hot commodity',
		'exchange_list'	=> 'Points Mall commodity',
	),	

	
	/* 模板布局备份 */
	'backup_setting'		=> 'Backup template settings',
	'cur_setting_template'	=> 'The current template settings can be backed up',
	'no_setting_template'	=> 'There is no backup of the template settings',
	'cur_backup'			=> 'Can be used to back up the template settings',
	'no_backup'				=> 'There is no template settings backup',
	'remarks'				=> 'Backup Notes',
	'backup_setting'		=> 'Backup template settings',
	'select_all'			=> 'Select All',
	'remarks_exist'			=> 'Backup Notes %s has been used, please note the name change',
	'backup_template_ok'	=> 'The success of the backup set',
	'del_backup_ok'			=> 'Delete backup success',
	'restore_backup_ok'		=> 'The success of the restoration of the backup',
	
	/* JS language item */
	'js_languages' => array(
		'setupConfirm'	=> "Enable new template and disable old template. \\nAre you sure enable the new template?",
		'reinstall'		=> 'Reinstall current template',
		'selectPlease'	=> 'Please select...',
		'removeConfirm'	=> 'Are you sure delete the selected contents?',
		'empty_content'	=> 'Sorry, library content can\'t be blank.',
		'save_confirm'	=> 'You have edit template, are you sure don\'t save it?',
	),	
	'backup'	=>  'Back-up current template',
);
