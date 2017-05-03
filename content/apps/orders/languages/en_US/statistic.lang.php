<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 统计信息语言文件
 */
return array(
	/* Count of visitor statistics */
	'stats_off'			=> 'Web site traffic statistics have been closed. <BR>If necessary go to: System Setup -> Configuration -> Basic to open the site traffic statistics service.',
	'last_update'		=> 'Latest update',
	'now_update'		=> 'Update log',
	'update_success'	=> 'Update successfully!',
	'view_log'			=> 'View log',
	'select_year_month'	=> 'Year/month',
	'pv_stats'			=> 'General visit data',
	'integration_visit'	=> 'Integration visit',
	'seo_analyse'		=> 'Search engine analyse',
	'area_analyse'		=> 'Area analyse',
	'visit_site'		=> 'Visit site analyse',
	'key_analyse'		=> 'Key word analyse',
		
	'general_statement' => 'Comprehensive views Report',
	'area_statement'	=> 'Distribution Report Region',
	'from_statement' 	=> 'Source Site Report',
	
	'start_date'	=> 'Start date',
	'end_date'		=> 'End date',
	'query'			=> 'Query',
	'result_filter'	=> 'Filter results',
	'compare_query'	=> 'Compare query',
	'year_status'	=> 'Year status',
	'month_status'	=> 'Mouth status',
	'year'			=> 'year',
	'month'			=> 'mouth',
	'day'			=> 'day',
	'year_format'	=> '%Y',
	'month_format'	=> '%c',
	
	'from'	=> 'from',
	'to'	=> 'to',
	'view'	=> 'View',
	
	/* Sales general situation */
	'overall_sell_circs'	=> 'Current overall sell circs',
	'order_count_trend'		=> 'Order quantity',
	'sell_out_amount'		=> 'Sell out quantity',
	'period'				=> 'period',
	'order_amount_trend'	=> 'Turnover(monetary unit:yuan)',
	'order_status'			=> 'Order status',
	'turnover_status'		=> 'Turnover status',
	'sales_statistics'		=> 'Sales statistics',
	'down_sales_stats'		=> 'Download Sales Status Report',
	'sale_general_statement'=> 'Sales profile report',
	'report_sell' 			=> 'Sales Overview',
	
	/* Orders\' statistics */
	'overall_sum'		=> 'Total',
	'overall_choose'	=> 'Clicks sum:',
	'kilo_buy_amount'	=> 'Orders quantity every 1000 clicks:',
	'kilo_buy_sum'		=> 'Shopping quantum every 1000 clicks:',
	"pay_type"			=> "Payment mode",
	"succeed"			=> "Succeed",
	"confirmed"			=> "Confirmed",
	"unconfirmed"		=> "Unconfirmed",
	"invalid"			=> "Invalid",
	'order_circs'		=> 'Order profile',
	'shipping_method'	=> 'Shipping method',
	'pay_method'		=> 'Payment method',
	'down_order_statistics'	=> 'Download Order Status Report',
	'order_statement'	=> 'Order Statistics Report',
	
	/* Sales ranking */
	'order_by'		=> 'Ranking',
	'goods_name'	=> 'Name',
	'sell_amount'	=> 'Sales',
	'sell_sum'		=> 'Saleroom',
	'percent_count'	=> 'Average price',
	"to"			=> 'to',
		
	'order_by_goodsnum'		=> 'Sort by sales quantity',
	"order_by_money"		=> 'Sort by sales money',
	"download_sale_sort"	=> "Download Sale Sort Report",
	'sale_order_statement' 	=> 'Sales Report',
	
	/* Clients\' statistics */
	'guest_order_sum'		=> 'Anonymous member average order sum:',
	'member_count'			=> 'Members quantity:',
	'member_order_count'	=> 'Member orders quantity:',
	
	'guest_member_ordercount'	=>'Anonymous member order total quantity:',
	'guest_member_orderamount'	=>'Anonymous member shopping total quantity:',
		
	'percent_buy_member'		=> 'Purchase rate:',
	'buy_member_formula'		=> '(Member purchase rate = Members with orders ÷ Total members)',
	'member_order_amount'		=> '(Orders every member = Total member order ÷ Total members)',
	'member_buy_amount'			=> '(Shopping sum every member = Total members shopping sum ÷ Total members)',
	
	"order_turnover_peruser"	=> "Average orders and shopping sum every member",
	"order_turnover_percus"		=> "Anonymous member average order sum and total shopping sum",
	'guest_all_ordercount'		=> '(Anonymous member average order sum = Total anonymous member shopping sum ÷ Total anonymous member orders)',
	
	'average_member_order'	=> 'Orders quantity every member:',
	'member_order_sum'		=> 'Shopping quantum every member:',
	'order_member_count'	=> 'Count of members with orders:',
	'member_sum'			=> 'Total shopping quantum of members:',
	'order_all_amount'		=> 'Oreders quantity',
	'order_all_turnover'	=> 'Total turnover',
	'down_guest_stats'		=> 'Customers Download Statistics',
	'guest_statistics'		=> 'Customer Statistics',
	
	/* Member ranking */
	'show_num'		=> 'Display',
	'member_name'	=> 'Username',
	'order_amount'	=> 'Order quantity(Unit:Yuan)',
	'buy_sum'		=> 'Money of shopping',
	
	'order_amount_sort'		=> 'Sort by quantity',
	'buy_sum_sort'			=> 'Sort by money',
	'download_amount_sort'	=> 'Download Rate Statements',
	'users_order_statement' => 'Shopping amount Report',
	
	/* Sales details */
	'goods_name'	=> 'Name',
	'goods_sn'		=> 'Product No.',
	'order_sn'		=> 'Order No.',
	'amount'		=> 'Quantity',
	'to'			=> 'to',
	'sell_price'	=> 'Price',
	'sell_date'		=> 'Date',
	'down_sales'	=> 'Download sales list',
	'sales_list'	=> 'Sales List',
	'sales_list_statement' => 'Sales detail report',
	
	/* Visit and purchase proportion */
	'fav_exponential'	=> 'Favorite exponential',
	'buy_times'			=> 'Time',
	'visit_buy'			=> 'Purchase Rate',
	'list_visit_buy'	=> 'Purchase rate',
	
	'download_visit_buy'	=> 'Download Visit Purchase Rate Statements',
	'visit_buy_statement' 	=> 'Access purchase rate report',
	
	'goods_cat'		=> 'Category',
	'goods_brand'	=> 'Brand',
	
	/* 搜索引擎 */
	'down_search_stats'		=> 'Download search keyword statements',
	'tab_keywords'			=> 'Keyword Statistics',
	'searchengine' 			=> 'search engine',
	
	'keywords'				=> 'Keyword',
	'date'					=> 'Date',
	'hits'					=> 'Search Views',
		
	/*站外投放JS*/
	'adsense_name' 		=> 'Name',
	'cleck_referer' 	=> 'Click source',
	'click_count' 		=> 'Click count',
	'confirm_order' 	=> 'Valid orders',
	'gen_order_amount' 	=> 'Total orders quantity',
	'adsense_statement' => 'Ad Conversion Rate Report',
		
	//追加
	'adsense_js_goods' 		=>  'Stations outside the JS call goods',
	'search_keywords'		=>	'search for the keyword',	
	'start_date_msg' 		=>	'Start Date',
	'end_date_msg' 			=>	'End Date',
	'keywords' 				=>	'Keywords',
	'down_searchengine' 	=> 	'Download Search Keyword Report',
	'tips'					=>	'Tips:',
	'searchengine_stats'	=>	'Search engine statistics major statistical number of daily search engine spiders to crawl pages',
	'today'					=>	'Nowadays',
	'yesterday'				=>	'yesterday',
	'this_week'				=>	'This week',
	'this_month'			=>	'this month',
	'month'					=>	'month',
	'loading'				=>	'Loading in ......',
	'guest_stats' 			=>	'Customer Statistics',
		
	'adsense'				=>	'Conversion Rate',
	'adsense_list'			=>	'AD List',
	'down_adsense'			=>	'Download Advertisement Statistics',
	'no_stats_data' 		=>	'No statistical data',
	'order_stats'			=>	'Order Statistics',
	'order_stats_date'		=>	'Order charts displayed by default by the time query.',
	'order_stats_info'		=>	'Order statistics information',
	'overall_sum_lable' 	=>	'The total amount of active orders:',
	'overall_choose_lable' 	=>	'Total number of hits:',
	'select_date_lable'		=>	'Query by time period:',
	'select_month_lable'	=>	'Query by month:',
	
	'no_order_default'		=>	'Have not complete the sales before orders are not included in the default trend for the month',
	'year_status_lable' 	=>	'Year trend:',
	'month_status_lable' 	=>	'Month trend:',
	'no_sales_details'		=>	'No completed orders not included in the sales details.',
	'search'				=>	'Search',
	'no_sale_sort'			=>	'No completed orders not included in the sales ranking.',
	'no_included_member'	=>	'Have not completed a transaction order is not included in Member Ranking Member.',
	
	'no_orders_visit_buy'	=>	'did not complete the purchase orders are not included in the rate of access.',
	'pls_select_category'	=>	'Please select category',
	'pls_select_brand'		=>	'Please select brand',
		
	'unconfirmed_order'		=> 'Unconfirmed order',
	'confirmed_order'		=> 'Confirmed order',
	'succeed_order'			=> 'Completed order',
	'invalid_order'			=> 'Invalid order',
	
	'overview'              => 'Overview',
	'more_info'             => 'More information:',
	'adsense_help'			=> 'Welcome to ECJia intelligent background advertising conversion page, the system in all the advertising conversion rate will be displayed in this list.',
	'about_adsense'			=> 'About Ad conversion rate help document',
	
	'guest_stats_help'		=> 'Welcome to ECJia intelligent background customer statistics page, the system of all customer statistics will be displayed on this page.',
	'about_guest_stats'		=> 'About customer statistics help document',
	
	'order_stats_help'		=> 'Welcome to ECJia intelligent background order statistics page, all the order statistics in the system will be displayed on this page.',
	'about_order_stats'		=> 'About order statistics to help document',
	
	'sale_general_help'		=> 'Welcome to ECJia intelligent background sales profile page, the system of all the sales profile information will be displayed on this page.',
	'about_sale_general'	=> 'About sales profiles help document',
	
	'sale_list_help'		=> 'Welcome to ECJia intelligent background sales details page, the details of all sales information will be displayed in this list.',
	'about_sale_list'		=> 'About sales details help document',
	
	'sale_order_help'		=> 'Welcome to ECJia intelligent background sales ranking page, ranking system in all sales information will be displayed on this page.',
	'about_sale_order'		=> 'About sales ranking help document',
	
	'users_order_help'		=> 'Welcome to ECJia intelligent background members page, ranking system in all Member ranking information is displayed in this list.',
	'about_users_order'		=> 'About ranking member help document',
	
	'visit_sold_help'		=> 'Welcome to ECJia intelligent background purchase rate access page, the system of all access to rate information will be displayed later in this list.',
	'about_visit_sold'		=> 'About purchase rate help document ',
	
	'js_lang' => array(
		'start_time_required'	=> 'The start time of the query cannot be empty!',
		'end_time_required'		=> 'The end time of the query cannot be empty!',
		'time_exceed'			=> 'The start time of the query cannot exceed the end time!',
		'time_required'			=> 'Query time cannot be empty!',
		'no_stats_data' 		=>	'No statistical data',
		'unconfirmed_order'		=> 'Unconfirmed order',
		'confirmed_order'		=> 'Confirmed order',
		'succeed_order'			=> 'Completed order',
		'invalid_order'			=> 'Invalid order',
		'number'				=> 'Number',
		'start_year_required'	=> 'The beginning of the query cannot be empty!',
		'end_year_required'		=> 'The end year of the query cannot be empty!',
		'order_number'			=> 'Order quantity',
		'sales_volume'			=> 'Sales volume',
		'show_num_min'			=> 'Display the number of values must be greater than zero!',
	)
);

//end