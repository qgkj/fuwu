<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

RC_Lang::load_plugin('ship_sf_express');
return array(
    'shipping_code' => 'ship_sf_express',
	'insure' 		=> false,		/* 不支持保价 */
	'cod' 			=> true, 		/* 配送方式是否支持货到付款 */
	'print_model'	=> 2,			/* 模式编辑器 */
	'print_bg'		=> RC_Plugin::plugins_url('images/dly_sf_express.jpg',__FILE__) ,			/* 打印单背景 */
	'config_lable'	=> 't_shop_name,' . RC_Lang::lang('lable_box/shop_name') . ',150,29,112,137,b_shop_name||,||t_shop_address,' . RC_Lang::lang('lable_box/shop_address') . ',268,55,105,168,b_shop_address||,||t_shop_tel,' . RC_Lang::lang('lable_box/shop_tel') . ',55,25,177,224,b_shop_tel||,||t_customer_name,' . RC_Lang::lang('lable_box/customer_name') . ',78,23,299,265,b_customer_name||,||t_customer_address,' . RC_Lang::lang('lable_box/customer_address') . ',271,94,104,293,b_customer_address||,||',			/* 打印快递单标签位置信息 */
		
	'forms' => array(
			array('name' => 'item_fee',     'value' => 20),/* 单件商品的配送费用 */
			array('name' => 'base_fee',    	'value' => 15), /* 1000克以内的价格   */
			array('name' => 'step_fee',     'value' => 2),  /* 续重每1000克增加的价格 */
	),
);

// end