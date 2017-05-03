<?php
  
/**
 * 申通快递插件的语言文件
 */
defined('IN_ECJIA') or exit('No permission resources.');

$LANG['sto_express']            = '申通快递';
$LANG['sto_express_desc']       = '江、浙、沪地区首重为15元/KG，其他地区18元/KG， 续重均为5-6元/KG， 云南地区为8元';
$LANG['item_fee']              	= '单件商品费用：';
$LANG['base_fee']              	= '1000克以内费用';
$LANG['step_fee']               = '续重每1000克或其零数的费用';

/* 快递单部分 */
$LANG['lable_select_notice'] = '--选择插入标签--';
$LANG['lable_box']['shop_country'] = '网店-国家';
$LANG['lable_box']['shop_province'] = '网店-省份';
$LANG['lable_box']['shop_city'] = '网店-城市';
$LANG['lable_box']['shop_name'] = '网店-名称';
$LANG['lable_box']['shop_district'] = '网店-区/县';
$LANG['lable_box']['shop_tel'] = '网店-联系电话';
$LANG['lable_box']['shop_address'] = '网店-地址';
$LANG['lable_box']['customer_country'] = '收件人-国家';
$LANG['lable_box']['customer_province'] = '收件人-省份';
$LANG['lable_box']['customer_city'] = '收件人-城市';
$LANG['lable_box']['customer_district'] = '收件人-区/县';
$LANG['lable_box']['customer_tel'] = '收件人-电话';
$LANG['lable_box']['customer_mobel'] = '收件人-手机';
$LANG['lable_box']['customer_post'] = '收件人-邮编';
$LANG['lable_box']['customer_address'] = '收件人-详细地址';
$LANG['lable_box']['customer_name'] = '收件人-姓名';
$LANG['lable_box']['year'] = '年-当日日期';
$LANG['lable_box']['months'] = '月-当日日期';
$LANG['lable_box']['day'] = '日-当日日期';
$LANG['lable_box']['order_no'] = '订单号-订单';
$LANG['lable_box']['order_postscript'] = '备注-订单';
$LANG['lable_box']['order_best_time'] = '送货时间-订单';
$LANG['lable_box']['pigeon'] = '√-对号';
//$LANG['lable_box']['custom_content'] = '自定义内容';

$LANG['shipping_print']         = '<table border="0" cellspacing="0" cellpadding="0" style="width:18.9cm;">
  <tr>
    <td colspan="3" style="height:2cm;">&nbsp;</td>
  </tr>
  <tr>
    <td style="width:8cm; height:4cm; padding-top:0.3cm;" align="center" valign="middle">
     <table border="0" cellspacing="0" cellpadding="0" style="width:7.5cm;" align="center">
  <tr>
    <td style="width:2.3cm;">&nbsp;</td>
    <td style="height:1.5cm;">{$shop_address}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="height:0.9cm;">{$shop_name}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="height:0.9cm;">{$shop_name}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="height:0.9cm;">{$service_phone}</td>
  </tr>
</table>

    </td>
    <td style="width:8cm; height:4cm; padding-top:0.3cm;" align="center" valign="middle">
    <table border="0" cellspacing="0" cellpadding="0" style="width:7.5cm;" align="center">
  <tr>
    <td style="width:2.3cm;">&nbsp;</td>
    <td style="height:1.5cm;">{$order.address}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="height:0.9cm;"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="height:0.9cm;">{$order.consignee}</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="height:0.9cm;">{$order.tel}</td>
  </tr>
</table>
    </td>
    <td rowspan="2" style="width:3cm;">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" style="height:3.5cm;">&nbsp;</td>
  </tr>
</table>';

// end