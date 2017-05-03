<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

RC_Lang::load_plugin('ship_zto');
return array(
    'shipping_code' => 'ship_zto',
	'insure' 		=> '2%',		/* 支持保价 */
	'cod' 			=> true, 		/* 配送方式是否支持货到付款 */
	'print_model'	=> 2,			/* 模式编辑器 */
	'print_bg'		=> RC_Plugin::plugins_url('images/dly_zto.jpg',__FILE__) ,			/* 打印单背景 */
	'config_lable'	=> 't_shop_province,' . RC_Lang::lang('lable_box/shop_province') . ',116,30,296.55,117.2,b_shop_province||,||t_customer_province,' . RC_Lang::lang('lable_box/customer_province') . ',114,32,649.95,114.3,b_customer_province||,||t_shop_address,' . RC_Lang::lang('lable_box/shop_address') . ',260,57,151.75,152.05,b_shop_address||,||t_shop_name,' . RC_Lang::lang('lable_box/shop_name')  . ',259,28,152.65,212.4,b_shop_name||,||t_shop_tel,' . RC_Lang::lang('lable_box/shop_tel') . ',131,37,138.65,246.5,b_shop_tel||,||t_customer_post,' . RC_Lang::lang('lable_box/customer_post')  . ',104,39,659.2,242.2,b_customer_post||,||t_customer_tel,' . RC_Lang::lang('lable_box/customer_tel') . ',158,22,461.9,241.9,b_customer_tel||,||t_customer_mobel,' . RC_Lang::lang('lable_box/customer_mobel') . ',159,21,463.25,265.4,b_customer_mobel||,||t_customer_name,' . RC_Lang::lang('lable_box/customer_name')  . ',109,32,498.9,115.8,b_customer_name||,||t_customer_address,' . RC_Lang::lang('lable_box/customer_address') . ',264,58,499.6,150.1,b_customer_address||,||t_months,' . RC_Lang::lang('lable_box/months') . ',35,23,135.85,392.8,b_months||,||t_day,' . RC_Lang::lang('lable_box/day') . ',24,23,180.1,392.8,b_day||,||',			/* 打印快递单标签位置信息 */
		
	'forms' => array(
			array('name' => 'item_fee',     'value'=>15),    /* 单件商品配送的价格 */
			array('name' => 'base_fee',    'value'=>10),    /* 1000克以内的价格 */
			array('name' => 'step_fee',     'value'=>5),    /* 续重每1000克增加的价格 */
	),
);