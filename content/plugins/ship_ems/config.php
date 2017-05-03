<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

RC_Lang::load_plugin('ship_ems');
return array(
    'shipping_code' => 'ship_ems',
	'insure' 		=> false,		/* 不支持保价 */
	'cod' 			=> false, 		/* 配送方式是否支持货到付款 */
	'print_model'	=> 2,			/* 模式编辑器 */
	'print_bg'		=> RC_Plugin::plugins_url('images/dly_ems.jpg',__FILE__) ,			/* 打印单背景 */
	'config_lable'	=> 't_shop_name,' .RC_Lang::lang('lable_box/shop_name') . ',236,32,182,161,b_shop_name||,||t_shop_tel,' . RC_Lang::lang('lable_box/shop_tel') . ',127,21,295,135,b_shop_tel||,||t_shop_address,' . RC_Lang::lang('lable_box/shop_address')  . ',296,68,124,190,b_shop_address||,||t_pigeon,' . RC_Lang::lang('lable_box/pigeon') . ',21,21,192,278,b_pigeon||,||t_customer_name,' . RC_Lang::lang('lable_box/customer_name')  . ',107,23,494,136,b_customer_name||,||t_customer_tel,' . RC_Lang::lang('lable_box/customer_tel') . ',155,21,639,124,b_customer_tel||,||t_customer_mobel,' . RC_Lang::lang('lable_box/customer_mobel'). ',159,21,639,147,b_customer_mobel||,||t_customer_post,' . RC_Lang::lang('lable_box/customer_post') . ',88,21,680,258,b_customer_post||,||t_year,' . RC_Lang::lang('lable_box/year') . ',37,21,534,379,b_year||,||t_months,' . RC_Lang::lang('lable_box/months'). ',29,21,592,379,b_months||,||t_day,' . RC_Lang::lang('lable_box/day') . ',27,21,642,380,b_day||,||t_order_best_time,' . RC_Lang::lang('lable_box/order_best_time') . ',104,39,688,359,b_order_best_time||,||t_order_postscript,' . RC_Lang::lang('lable_box/order_postscript') . ',305,34,485,402,b_order_postscript||,||t_customer_address,' . RC_Lang::lang('lable_box/customer_address') . ',289,48,503,190,b_customer_address||,||',			/* 打印快递单标签位置信息 */
		
	'forms' => array(
			array('name' => 'item_fee',     'value'=>20),
			array('name' => 'base_fee',     'value'=>20),
			array('name' => 'step_fee',     'value'=>15),
	),
);