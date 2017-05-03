<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA Statistics language file
 */
return array(
	/* Count of visitor statistics */
	'stats_off'		=> 'Web site traffic statistics have been closed. <BR>If necessary go to: System Setup -> Configuration -> Basic to open the site traffic statistics service.',
	'last_update'	=> 'Latest update',
	'now_update'	=> 'Update log',
	'update_success'=> 'Update successfully!',
	'view_log'		=> 'View log',
		
	'select_year_month'	=> 'Year/month',
	'general_statement' => 'Comprehensive views Report',
	'area_statement'	=> 'Distribution Report Region',
	'from_statement' 	=> 'Source Site Report',
		
	'pv_stats'			=> 'General visit data',
	'integration_visit'	=> 'Integration visit',
	'seo_analyse'		=> 'Search engine analyse',
	'area_analyse'		=> 'Area analyse',
	'visit_site'		=> 'Visit site analyse',
	'key_analyse'		=> 'Key word analyse',
	
	'start_date'	=> 'Start date',
	'end_date'		=> 'End date',
	'query'			=> 'Query',
	'result_filter'	=> 'Filter results',
	'compare_query'	=> 'Compare query',
	'year_status'	=> 'Year status',
	'month_status'	=> 'Mouth status',
	
	'year'	=> 'year',
	'month'	=> 'mouth',
	'day'	=> 'day',
	'times'	=> 'times',
	
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
	'down_sales_stats'		=> 'Download sales status report',
	'report_sell' 			=> 'Sales Overview',
	
	/* Orders\' statistics */
	'overall_sum'		=> 'Total',
	'overall_choose'	=> ', Clicks sum',
	'kilo_buy_amount'	=> ', Orders quantity every 1000 clicks.',
	'kilo_buy_sum'		=> ', Shopping quantum every 1000 clicks.',
	"pay_type"			=> "Payment mode",
	"succeed"			=> "Succeed",
	"confirmed"			=> "Confirmed",
	"unconfirmed"		=> "Unconfirmed",
	"invalid"			=> "Invalid",
	'order_circs'		=> 'Order profile',
	'shipping_method'	=> 'Shipping method',
	'pay_method'		=> 'Payment method',
	'down_order_statistics'	=> 'Download order status report',
	
	/* Sales ranking */
	'order_by'		=> 'Ranking',
	'goods_name'	=> 'Name',
	'sell_amount'	=> 'Sales',
	'sell_sum'		=> 'Saleroom',
	'percent_count'	=> 'Average price',
	"to"			=> 'to',
		
	'order_by_goodsnum'		=> 'Sort by sales quantity',
	"order_by_money"		=> 'Sort by sales money',
	"download_sale_sort"	=> "Download sale sort report",
	
	/* Clients\' statistics */
	'guest_order_sum'		=>'Anonymous member average order sum.',
	'member_count'			=>'Members quantity',
		
	'member_order_count'	=>'Member orders quantity',
	'guest_member_ordercount'	=>'Anonymous member order total quantity.',
	'guest_member_orderamount'	=>'Anonymous member shopping total quantity.',
		
	'percent_buy_member'	=>'Purchase rate',
	'buy_member_formula'	=>'(Member purchase rate = Members with orders ÷ Total members)',
	'member_order_amount'	=>'(Orders every member = Total member order ÷ Total members)',
	'member_buy_amount'		=>'(Shopping sum every member = Total members shopping sum ÷ Total members)',
	"order_turnover_peruser"	=>"Average orders and shopping sum every member",
	"order_turnover_percus"		=>"Anonymous member average order sum and total shopping sum",
	'guest_all_ordercount'		=>'(Anonymous member average order sum = Total anonymous member shopping sum ÷ Total anonymous member orders)',
	
	'average_member_order'	=> 'Orders quantity every member',
	'member_order_sum'		=> 'Shopping quantum every member',
	'order_member_count'	=> 'Count of members with orders',
	'member_sum'			=> 'Total shopping quantum of members',
	'order_all_amount'		=> 'Oreders quantity',
	'order_all_turnover'	=> 'Total turnover',
	
	'down_guest_stats'		=> 'Customers download statistics',
	'guest_statistics'		=> 'Client statistics',
	
	/* Member ranking */
	'show_num'		=> 'Display',
	'member_name'	=> 'Username',
	'order_amount'	=> 'Order quantity(unit:unit)',
	'buy_sum'		=> 'Money of shopping',
	
	'order_amount_sort'		=> 'Sort by quantity',
	'buy_sum_sort'			=> 'Sort by money',
	'download_amount_sort'	=> 'Download to rate statements',
	
	/* Sales details */
	'goods_name'	=> 'Name',
	'goods_sn'		=> 'Product NO.',
	'order_sn'		=> 'Order NO.',
	'amount'		=> 'Quantity',
	'to'			=> 'to',
	'sell_price'	=> 'Price',
	'sell_date'		=> 'Date',
	'down_sales'	=> 'Download sales list',
	'sales_list'	=> 'Sales list',
	
	/* Visit and purchase proportion */
	'fav_exponential'	=> 'Favorite exponential',
	'buy_times'			=> 'Time',
	'visit_buy'			=> 'Purchase rate',
	'download_visit_buy'=> 'Download visit purchase rate statements',
	'goods_cat'			=> 'Category',
	'goods_brand'		=> 'Brand',
	
	/* 搜索引擎 */
	'down_search_stats'	=> 'Download Search Keyword Statements',
	'tab_keywords'		=> 'Keyword Statistics',
	'keywords'			=> 'Keyword',
	'date'				=> 'Date',
	'hits'				=> 'Search views',
		
	/*站外投放JS*/
	'searchengine' 		=> 'Search Engine',
	'list_searchengine' => 'Search engine',
	'adsense_name' 		=> 'Trafficking name',
	'cleck_referer' 	=> 'Click Source',
	'click_count' 		=> 'click count',
	'confirm_order' 	=> 'Number of active orders',
	'gen_order_amount' 	=> 'Generating total number of orders',

	//追加
	'adsense_js_goods' 		=>  'Stations outside the JS call goods',
	'search_keywords'		=>	'Search Keywords',	
	'start_date_msg' 		=>	'Start Date',
	'end_date_msg' 			=>	'End Date',
	'keywords' 				=>	'Keywords',
	'down_searchengine' 	=> 	'Download Search Keyword Report',
	'tips'					=>	'Tips:',
	'searchengine_stats'	=>	'Search engine statistics major statistical number of daily search engine spiders to crawl pages',
	'today'					=>	'Today',
	'yesterday'				=>	'Yesterday',
	'this_week'				=>	'This Week',
	'this_month'			=>	'This Year',
	'month'					=>	'month',
	'loading'				=>	'Loading in...',

	'overview'             	=> 'Overview',
	'more_info'             => 'More information:',
	
	'keywords_stats_help'	=> 'Welcome to ECJia intelligent background search engine page, the system on all the search engine information will be displayed on this page.',
	'about_keywords_help'	=> 'About search keywords help document',
	'search_engine_report'	=> 'Search engine statistics',
	'day_list'				=> array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
	'month_list' 			=> array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
	
	'js_lang' => array(
		'start_date_required'	=> 'The start time of the query cannot be empty!',
		'end_date_required'		=> 'The end time of the query cannot be empty!',
		'start_lt_end_date'		=> 'The start time of the query cannot exceed the end time!',
		'no_records'			=> 'Did not find any record',
		'day_list'				=> array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
		'times'					=> 'times',
	),
);

//end