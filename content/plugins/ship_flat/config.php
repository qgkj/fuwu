<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
return array(
    'shipping_code' => 'ship_flat',
	'insure' 		=> false,		/* 不支持保价 */
	'cod' 			=> true, 		/* 配送方式是否支持货到付款 */
	'print_model'	=> 2,			/* 模式编辑器 */
	'print_bg'		=> '',			/* 打印单背景 */
	'config_lable'	=> '',			/* 打印快递单标签位置信息 */
		
	'forms' => array(
			array('name' => 'base_fee', 'value' => 10),
	),
);

// end