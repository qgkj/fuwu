<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

RC_Lang::load_plugin('ship_o2o_express');
return array(
    'shipping_code' => 'ship_o2o_express',
	'insure' 		=> false,		/* 不支持保价 */
	'cod' 			=> true, 		/* 配送方式是否支持货到付款 */
	'print_model'	=> 2,			/* 模式编辑器 */
	'print_bg'		=> '',			/* 打印单背景 */
	'config_lable'	=> '',			/* 打印快递单标签位置信息 */
		
	'forms' => array(
			array('name' => 'item_fee',     'value'=>10),   /* 单件商品的配送价格 */
			array('name' => 'base_fee',    	'value'=>5),    /* 1000克以内的价格 */
			array('name' => 'step_fee',     'value'=>5),    /* 续重每1000克增加的价格 */
	),
);

// end