<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

RC_Lang::load_plugin('ship_sto_express');
return array(
    'shipping_code' => 'ship_sto_express',
	'insure' 		=> false,		/* 不支持保价 */
	'cod' 			=> false, 		/* 配送方式是否支持货到付款 */
	'print_model'	=> 2,			/* 模式编辑器 */
	'print_bg'		=> RC_Plugin::plugins_url('images/dly_sto_express.jpg',__FILE__) ,			/* 打印单背景 */
	'config_lable'	=> 't_shop_address,' . RC_Lang::lang('lable_box/shop_address') . ',235,48,131,152,b_shop_address||,||t_shop_name,' . RC_Lang::lang('lable_box/shop_name') . ',237,26,131,200,b_shop_name||,||t_shop_tel,' . RC_Lang::lang('lable_box/shop_tel') . ',96,36,144,257,b_shop_tel||,||t_customer_post,' . RC_Lang::lang('lable_box/customer_post') . ',86,23,578,268,b_customer_post||,||t_customer_address,' . RC_Lang::lang('lable_box/customer_address') . ',232,49,434,149,b_customer_address||,||t_customer_name,' . RC_Lang::lang('lable_box/customer_name') . ',151,27,449,231,b_customer_name||,||t_customer_tel,' . RC_Lang::lang('lable_box/customer_tel'). ',90,32,452,261,b_customer_tel||,||',			/* 打印快递单标签位置信息 */
		
	'forms' => array(
			array('name' => 'item_fee',     'value'=>15), /* 单件商品的配送费用 */
			array('name' => 'base_fee',    'value'=>15), /* 1000克以内的价格           */
			array('name' => 'step_fee',     'value'=>5),  /* 续重每1000克增加的价格 */
	),
);

// end