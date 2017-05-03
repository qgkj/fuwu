<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 地区列表管理语言文件
 */

return array(
	'region_id'		=> '地区编号',
	'region_name'	=> '地区名称',
	'region_type'	=> '地区类型',
	
	'area'			=> '地区',
	'area_next'		=> '以下',
	'country'		=> '一级地区',
	'province'		=> '二级地区',
	'city'			=> '三级地区',
	'cantonal'		=> '四级地区',
	'back_page'		=> '返回上一级',
	'manage_area'	=> '管理',
		
	'region_name_empty'	=> '区域名称不能为空！',
	'add_country'		=> '新增一级地区',
	'add_province'		=> '新增二级地区',
	'add_city'			=> '增加三级地区',
	'add_cantonal'		=> '增加四级地区',
	
	/* JS语言项 */
	'js_languages'  => array(
		'region_name_empty' => '您必须输入地区的名称!',
		'option_name_empty' => '必须输入调查选项名称!',
		'drop_confirm' 		=> '您确定要删除这条记录吗?',
		'drop' 				=> '删除',
		'country' 			=> '一级地区',
		'province' 			=> '二级地区',
		'city' 				=> '三级地区',
		'cantonal' 			=> '四级地区',
	),
		
	/* 提示信息 */
	'add_area_error'			=> '添加新地区失败!',
	'add_area_parentid_error'	=> '添加新地区的父级id不存在!',
	'region_name_exist'			=> '已经有相同的地区名称存在!',
	'parent_id_exist'			=> '该区域下有其它下级地区存在, 不能删除!',
	'form_notic'				=> '点击查看下级地区',
	'area_drop_confirm'			=> '如果订单或用户默认配送方式中使用以下地区，这些地区信息将显示为空。您确认要删除这条记录吗?',
);

// end