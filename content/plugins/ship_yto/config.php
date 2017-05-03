<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

RC_Lang::load_plugin('ship_yto');
return array(
    'shipping_code' => 'ship_yto',
	'insure' 		=> false,		/* 不支持保价 */
	'cod' 			=> true, 		/* 配送方式是否支持货到付款 */
	'print_model'	=> 2,			/* 模式编辑器 */
	'print_bg'		=> RC_Plugin::plugins_url('images/dly_yto.jpg',__FILE__) ,			/* 打印单背景 */
	'config_lable'	=> 't_shop_province,' . RC_Lang::lang('lable_box/shop_province') . ',132,24,279.6,105.7,b_shop_province||,||t_shop_name,' . RC_Lang::lang('lable_box/shop_name') . ',268,29,142.95,133.85,b_shop_name||,||t_shop_address,' . RC_Lang::lang('lable_box/shop_address') . ',346,40,67.3,199.95,b_shop_address||,||t_shop_city,' . RC_Lang::lang('lable_box/shop_city') . ',64,35,223.8,163.95,b_shop_city||,||t_shop_district,' . RC_Lang::lang('lable_box/shop_district') . ',56,35,314.9,164.25,b_shop_district||,||t_pigeon,' . RC_Lang::lang('lable_box/pigeon') . ',21,21,143.1,263.2,b_pigeon||,||t_customer_name,' . RC_Lang::lang('lable_box/customer_name') . ',89,25,488.65,121.05,b_customer_name||,||t_customer_tel,' . RC_Lang::lang('lable_box/customer_tel') . ',136,21,656,110.6,b_customer_tel||,||t_customer_mobel,' . RC_Lang::lang('lable_box/customer_mobel') . ',137,21,655.6,132.8,b_customer_mobel||,||t_customer_province,' . RC_Lang::lang('lable_box/customer_province') . ',115,24,480.2,173.5,b_customer_province||,||t_customer_city,' . RC_Lang::lang('lable_box/customer_city') . ',60,27,609.3,172.5,b_customer_city||,||t_customer_district,' . RC_Lang::lang('lable_box/customer_district') . ',58,28,696.8,173.25,b_customer_district||,||t_customer_post,' . RC_Lang::lang('lable_box/customer_post'). ',93,21,701.1,240.25,b_customer_post||,||',			/* 打印快递单标签位置信息 */
		
	'forms' => array(
			array('name' => 'item_fee',     'value'=>10),   /* 单件商品的配送价格 */
			array('name' => 'base_fee',    'value'=>5),    /* 1000克以内的价格 */
			array('name' => 'step_fee',     'value'=>5),    /* 续重每1000克增加的价格 */
	),
);

// end