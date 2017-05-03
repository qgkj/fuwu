<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 统计信息语言文件
 */
return array(
	/* 流量统计 */
	'stats_off' 		=> '网站流量统计已被关闭。<BR>如有需要请到: 系统设置->商店设置->基本设置 开启站点流量统计服务。',
	'last_update' 		=> '最后更新日期',
	'now_update' 		=> '更新记录',
	'update_success' 	=> '分析记录已成功更新!',
	'view_log' 			=> '查看分析记录',
	'select_year_month' => '查询年月',
	'pv_stats' 			=> '综合访问数据',
	'integration_visit' => '综合访问量',
	'seo_analyse' 		=> '搜索引擎分析',
	'area_analyse' 		=> '地域分布',
	'visit_site' 		=> '来访网站分析',
	'key_analyse' 		=> '关键字分析',
		
	'general_statement' => '综合访问量统计',
	'area_statement'	=> '地区分布统计',
	'from_statement' 	=> '来源网站统计',		
	
	'start_date' 	=> '开始日期',
	'end_date' 		=> '结束日期',
	'query' 		=> '查询',
	'result_filter' => '过滤结果',
	'compare_query' => '比较查询',
	'year_status' 	=> '年走势',
	'month_status' 	=> '月走势',
	'year' 			=> '年',
	'month' 		=> '月',
	'day' 			=> '日',
	'year_format' 	=> '%Y',
	'month_format' 	=> '%c',
	
	'from' 	=> '从',
	'to' 	=> '到',
	'view' 	=> '查看',
	
	/* 销售概况 */
	'overall_sell_circs' 	=> '当前总体销售情况',
	'order_count_trend' 	=> '订单数(单位:个)',
	'sell_out_amount' 		=> '销出产品数量',
	'period' 				=> '时间段',
	'order_amount_trend' 	=> '营业额(单位:元)',
	'order_status' 			=> '订单走势',
	'turnover_status' 		=> '销售额走势',
	'sales_statistics'      => '销售统计',
	'down_sales_stats'		=> '销售概况报表下载',
	'sale_general_statement'=> '销售概况报表',
	'report_sell' 			=> '销售概况',
	
	/* 订单统计 */
	'overall_sum' 		=> '有效订单总金额',
	'overall_choose' 	=> '总点击数',
	'kilo_buy_amount' 	=> '每千点击订单数：',
	'kilo_buy_sum' 		=> '每千点击购物额：',
	"pay_type" 			=> "支付方式",
	"succeed" 			=> "已成交",
	"confirmed" 		=> "已确认",
	"unconfirmed" 		=> "未确认",
	"invalid" 			=> "无效或已取消",
	'order_circs' 		=> '订单概况',
	'shipping_method' 	=> '配送方式',
	'pay_method' 		=> '支付方式 ',
	'down_order_statistics' => '订单统计报表下载',
	'order_statement'	=> '订单统计报表',
	
	/* 销售排行 */
	'order_by' 		=> '排行',
	'goods_name' 	=> '商品名称',
	'sell_amount' 	=> '销售量',
	'sell_sum' 		=> '销售额',
	'percent_count' => '均价',
	"to" 			=> '至',
	
	'order_by_goodsnum' 	=> '按销售量排序',
	"order_by_money" 		=> '按销售额排序',
	"download_sale_sort" 	=> '销售排行报表下载',
	'sale_order_statement' 	=> '销售排行报表',
	
	/* 客户统计 */
	'guest_order_sum' 		=> '匿名会员平均订单额',
	'member_count' 			=> '会员总数',
	'member_order_count' 	=> '会员订单总数',
	
	'guest_member_ordercount' 	=> '匿名会员订单总数',
	'guest_member_orderamount' 	=> '匿名会员购物总额',
	
	'percent_buy_member' 	=> '会员购买率 ',
	'buy_member_formula' 	=> '（会员购买率 = 有订单会员数 ÷ 会员总数）',
	'member_order_amount' 	=> '（每会员订单数 = 会员订单总数 ÷ 会员总数）',
	'member_buy_amount' 	=> '（每会员购物额 = 会员购物总额 ÷ 会员总数）',
	
	"order_turnover_peruser" 	=> "每会员平均订单数及购物额",
	"order_turnover_percus" 	=> "匿名会员平均订单额及购物总额",
	'guest_all_ordercount'	 	=> '（匿名会员平均订单额 =  匿名会员购物总额 ÷ 匿名会员订单总数）',
	
	'average_member_order' 	=> '每会员订单数',
	'member_order_sum' 		=> '每会员购物额',
	'order_member_count' 	=> '有订单会员数',
	'member_sum' 			=> '会员购物总额',
	'order_all_amount' 		=> '订单总数',
	'order_all_turnover' 	=> '总购物额',
	'down_guest_stats' 		=> '客户统计报表下载',
	'guest_statement' 		=> '客户统计报表',
	
	/* 会员排行 */
	'show_num' 		=> '显示数量',
	'member_name' 	=> '会员名',
	'order_amount' 	=> '订单数(单位:个)',
	'buy_sum' 		=> '购物金额',
	
	'order_amount_sort' 	=> '按订单数量排序',
	'buy_sum_sort' 			=> '按购物金额排序',
	'download_amount_sort' 	=> '下载购物金额报表',
	'users_order_statement' => '购物金额报表',
	
	/* 销售明细 */
	'goods_name' 	=> '商品名称',
	'goods_sn' 		=> '货号',
	'order_sn' 		=> '订单号',
	'amount' 		=> '数量',
	'to' 			=> '至',
	'sell_price' 	=> '售价',
	'sell_date' 	=> '售出日期',
	'down_sales' 	=> '下载销售明细',
	'sales_list' 	=> '销售明细',
	'sales_list_statement' => '销售明细报表',
	
	/* 访问购买比例 */
	'fav_exponential' 	=> '人气指数',
	'buy_times' 		=> '购买次数',
	'visit_buy' 		=> '访问购买率',
	'list_visit_buy' 	=> '访问购买率',
	
	'download_visit_buy' 	=> '下载访问购买率报表',
	'visit_buy_statement' 	=> '访问购买率报表',
	
	'goods_cat' 	=> '商品分类',
	'goods_brand' 	=> '商品品牌',
	
	/* 搜索引擎 */
	'down_search_stats' => '下载搜索关键字报表',
	'tab_keywords' 		=> '关键字统计',
	'searchengine' 		=> '搜索引擎',
	
	'keywords' 	=> '关键字',
	'date' 		=> '日期',
	'hits' 		=> '搜索次数',
	
	/*站外投放JS*/
	'adsense_name' 		=> '投放的名称',
	'cleck_referer' 	=> '点击来源',
	'click_count' 		=> '点击次数',
	'confirm_order' 	=> '有效订单数',
	'gen_order_amount' 	=> '产生订单总数',
	'adsense_statement' => '广告转化率报表',
	
	// 	追加
	'adsense_js_goods' 		=>  '站外JS调用商品',
	'search_keywords'		=>	'搜索关键字',
	'start_date_msg' 		=>	'开始日期',
	'end_date_msg' 			=>	'结束日期',
	'keywords' 				=>	'关键词',
	'down_searchengine' 	=> 	'下载搜索关键字报表',
	'tips'					=>	'温馨提示：',
	'searchengine_stats'	=>	'搜索引擎统计主要统计每日搜索引擎蜘蛛抓取页面的次数',
	'today'					=>	'今天',
	'yesterday'				=>	'昨天',
	'this_week'				=>	'本周',
	'this_month'			=>	'本月',
	'month'					=>	'月',
	'loading'				=>	'正在加载中……',
	'guest_stats' 			=>	'客户统计',
	
	'adsense'				=>	'广告转化率',
	'adsense_list'			=>	'广告列表',
	'down_adsense'			=>	'下载广告转化率报表',
	'no_stats_data' 		=>	'没有统计数据',
	'order_stats'			=>	'订单统计',
	'order_stats_date'		=>	'订单统计图表默认显示为按时间段查询',
	'order_stats_info'		=>	'订单统计信息',
	'overall_sum_lable' 	=>	'有效订单总金额：',
	'overall_choose_lable' 	=>	'总点击数：',
	'select_date_lable'		=>	'按时间段查询：',			
	'select_month_lable'	=>	'按月份查询：',
	
	'no_order_default'		=>	'没有完成的订单不计入销售概况，默认为月走势',
	'year_status_lable' 	=>	'年走势：',
	'month_status_lable' 	=>	'月走势：',
	'no_sales_details'		=>	'没有完成的订单不计入销售明细',
	'search'				=>	'搜索',
	'no_sale_sort'			=>	'没有完成的订单不计入销售排行',
	'no_included_member'	=>	'没有完成过订单交易的会员不计入会员排行',
	
	'no_orders_visit_buy'	=>	'没有完成的订单不计入访问购买率',
	'pls_select_category'	=>	'请选择商品分类',
	'pls_select_brand'		=>	'请选择商品品牌',
	
	'unconfirmed_order'		=> '未确认订单',
	'confirmed_order'		=> '已确认订单',
	'succeed_order'			=> '已完成订单',
	'invalid_order'			=> '已取消订单',
	
	'overview'              => '概述',
	'more_info'             => '更多信息：',
	'adsense_help'			=> '欢迎访问ECJia智能后台广告转化率页面，系统中所有的广告转化率都会显示在此列表中。',
	'about_adsense'			=> '关于广告转化率帮助文档',
	
	'guest_stats_help'		=> '欢迎访问ECJia智能后台客户统计页面，系统中所有的客户统计信息都会显示在此页面中。',
	'about_guest_stats'		=> '关于客户统计帮助文档',
	
	'order_stats_help'		=> '欢迎访问ECJia智能后台订单统计页面，系统中所有的订单统计信息都会显示在此页面中。',
	'about_order_stats'		=> '关于订单统计帮助文档',
	
	'sale_general_help'		=> '欢迎访问ECJia智能后台销售概况页面，系统中所有的销售概况信息都会显示在此页面中。',
	'about_sale_general'	=> '关于销售概况帮助文档',
	
	'sale_list_help'		=> '欢迎访问ECJia智能后台销售明细页面，系统中所有的销售明细信息都会显示在此列表中。',
	'about_sale_list'		=> '关于销售明细帮助文档',
	
	'sale_order_help'		=> '欢迎访问ECJia智能后台销售排行页面，系统中所有的销售排行信息都会显示在此页面中。',
	'about_sale_order'		=> '关于销售排行帮助文档',
	
	'users_order_help'		=> '欢迎访问ECJia智能后台会员排行页面，系统中所有的会员排行信息都会显示在此列表中。',
	'about_users_order'		=> '关于会员排行帮助文档',
	
	'visit_sold_help'		=> '欢迎访问ECJia智能后台访问购买率页面，系统中所有的访问购买率信息都会显示在此列表中。',
	'about_visit_sold'		=> '关于访问购买率帮助文档',
	
	'js_lang' => array(
		'start_time_required'	=> '查询的开始时间不能为空！',
		'end_time_required'		=> '查询的结束时间不能为空！',
		'time_exceed'			=> '查询的开始时间不能超于结束时间！',
		'time_required'			=> '查询的时间不能为空！',
		'no_stats_data' 		=> '没有统计数据',
		'unconfirmed_order'		=> '未确认订单',
		'confirmed_order'		=> '已确认订单',
		'succeed_order'			=> '已完成订单',
		'invalid_order'			=> '已取消订单',
		'number'				=> '数量',
		'start_year_required'	=> '查询的开始年份不能为空！',
		'end_year_required'		=> '查询的结束年份不能为空！',
		'order_number'			=> '订单数量',
		'sales_volume'			=> '销售额',
		'show_num_min'			=> '显示数量的值必须大于零！',
	)	
);

//end