<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 管理中心配送方式管理语言文件
 */
return array(
	'shipping_area_name' 		=> '配送区域名称',
	'shipping_area_districts' 	=> '地区列表',
	'shipping_area_regions' 	=> '所辖地区',
	'shipping_area_assign' 		=> '配送方式',
	
	'merchant_name'		=> '商家名称',
	'area_region' 		=> '地区',
	'removed_region' 	=> '该区域已被移除',
	'area_shipping' 	=> '配送方式',
	'fee_compute_mode' 	=> '费用计算方式',
	'fee_by_weight' 	=> '按重量计算',
	'fee_by_number' 	=> '按商品件数计算',
	'new_area' 			=> '新建配送区域',
	'label_country' 	=> '国家：',
	'label_province' 	=> '省份：',
	'label_city' 		=> '城市：',
	'label_district' 	=> '区/县：',
	'batch' 			=> '批量操作',
	'batch_delete' 		=> '批量删除操作',
		
	'batch_no_select_falid' => '未选中元素，批量删除操作失败',
	'delete_selected' 		=> '移除选定的配送区域',
		
	'btn_add_region'=> '添加选定地区',
	'free_money' 	=> '免费额度',
	'pay_fee' 		=> '货到付款支付费用',
	'edit_area' 	=> '编辑配送区域',
	'add_continue' 	=> '继续添加配送区域',
	'back_list' 	=> '返回列表页',
	'empty_regions' => '当前区域下没有任何关联地区',
	
	/* 提示信息 */
	'repeat_area_name' 	=> '已经存在一个同名的配送区域。',
	'not_find_plugin' 	=> '没有找到指定的配送方式的插件。',
	'remove_confirm' 	=> '您确定要删除选定的配送区域吗？',
	'remove_success' 	=> '指定的配送区域已经删除成功！',
	'remove_fail'		=> '删除失败',
	'no_shippings' 		=> '没有找到任何可用的配送方式。',
	'add_area_success' 	=> '添加配送区域成功。',
	'edit_area_success' => '编辑配送区域成功。',
	'disable_shipping_success' => '指定的配送方式已经从该配送区域中移除。',
	
	/* 需要用到的JS语言项 */
	'js_languages' => array(
		'no_area_name' 			=> '配送区域名称不能为空。',
		'del_shipping_area' 	=> '请先删除该配送区域，然后重新添加。',
		'invalid_free_mondy' 	=> '免费额度不能为空且必须是一个整数。',
		'blank_shipping_area' 	=> '配送区域的所辖区域不能为空。',
		'lang_remove' 			=> '移除',
		'lang_remove_confirm' 	=> '您确定要移除该地区吗？',
		
		'lang_disabled'	=> '禁用',
		'lang_enabled' 	=> '启用',
		'lang_setup' 	=> '设置',
		'lang_region'	=> '地区',
		'lang_shipping' => '配送方式',
		'region_exists' => '选定的地区已经存在。'
	),
	
	//追加
	'item_fee' 			=> '单件商品费用',
	'shipping_area'		=> '配送区域',
	'list'				=> '列表',
	'shipping_way'		=> '所属配送方式是 ',
	'add_area_success'	=> '添加配送区域成功',
	'add'				=> '添加',
	
	'select_shipping_area'	=> '选择配送区域：',
	'search_country_name'	=> '搜索的国家名称',
	'no_country_choose'		=> '没有国家地区可选...',
	'search_province_name'	=> '搜索的省份名称',
	'choose_province_first'	=> '请先选择省份名称...',
	'search_city_name'		=> '搜索的市/区名称',
	'choose_city_first'		=> '请先选择市/区名称...',
	'search_districe_name'	=> '搜索的县/乡名称',
	'choose_districe_first'	=> '请先选择县/乡名称...',
	'shipping_method'		=> '配送方式',
	
	'batch_drop_confirm'	=> '您确定要删除选中的配送区域吗？',
	'select_drop_area'		=> '请先选中要删除的配送区域！',
	'area_name_keywords'	=> '请输入配送区域名称关键字',
	'drop_area_confirm'		=> '您确定要删除该配送区域吗？',
	
	'search'	=> '搜索',
	'yes'		=> '是',
	'no'		=> '否',
	
	'label_shipping_area_name' 	=> '配送区域名称：',
	'label_fee_compute_mode'	=> '费用计算方式：',
	'shiparea_manage'			=> '配送区域管理',
	'shiparea_delete'			=> '删除配送区域',
	
	'overview'				=> '概述',
	'more_info'         	=> '更多信息：',
	
	'shipping_area_help' 	=> '欢迎访问ECJia智能后台配送区域页面，可以在此页面查看相应的配送区域列表。',
	'about_shipping_area'	=> '关于配送区域帮助文档',
	
	'add_area_help'			=> '欢迎访问ECJia智能后台新建配送区域页面，可以在此页面新建配送区域信息。',
	'about_add_area'		=> '关于新建配送区域帮助文档',
	
	'edit_area_help'		=> '欢迎访问ECJia智能后台编辑配送区域页面，可以在此页面编辑相应配送区域信息。',
	'about_edit_area'		=> '关于编辑配送区域帮助文档',
);

// end