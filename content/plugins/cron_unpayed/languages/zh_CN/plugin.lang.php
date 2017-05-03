<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 自动处理语言文件
 */

return array(
	'unpayed' 		=> '自动关闭未付款订单',
	'unpayed_desc' 	=> '计划任务-自动关闭未付款订单',
    'unpayed_hours'  => '关闭多久未付款的订单：',
	'unpayed_count' => '每次关闭的个数：',

	'unpayed_hours_range' => array(
	    '1' 	=> '1小时',
	    '3' 	=> '3小时',
	    '6' 	=> '6小时',
		'12' 	=> '12小时',
	    '24' 	=> '1天',
	    '48' 	=> '2天',
	    '72' 	=> '3天',
	),
    'unpayed_count_range' => array(
        '1' 	=> '1',
        '100' 	=> '100',
        '500' 	=> '500',
        '1000' 	=> '1000',
    ),
);

// end