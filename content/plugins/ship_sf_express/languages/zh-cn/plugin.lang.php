<?php
  
/**
 * 顺丰速运插件的语言文件
 */
defined('IN_ECJIA') or exit('No permission resources.');

$LANG['sf_express']             = '顺丰速运';
$LANG['sf_express_desc']        = '江、浙、沪地区首重15元/KG，续重2元/KG，其余城市首重20元/KG';
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

$LANG['shipping_print']         = '<table style="width:18.8cm; height:3cm;" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table style="width:18.8cm;" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="width:9.4cm" valign="top">
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td valign="middle" style="width:1.5cm; height:0.8cm;">&nbsp;</td>
      <td width="85%">
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
    <td valign="middle" style="width:5cm; height:0.8cm;">{$shop_name}</td>
      <td valign="middle">&nbsp;</td>
    <td valign="middle" style="width:1.8cm; height:0.8cm;">{$order.order_sn}</td>
    </tr>
   </table>
   </td>
 </tr>
 <tr valign="middle">
 <td>&nbsp;</td>
 <td class="h">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="width:1.3cm; height:0.8cm;">{$province}</td>
    <td>&nbsp;</td>
    <td style="width:1.3cm; height:0.8cm;">{$city}</td>
    <td>&nbsp;</td>
    <td style="width:1.3cm; height:0.8cm;">&nbsp;</td>
    <td>&nbsp;</td>
    <td style="width:1.3cm; height:0.8cm;">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td class="h">{$shop_address}</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td class="h">&nbsp;</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td class="h">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td style="width:1.5cm; height:0.8cm;">&nbsp;</td>
    <td>&nbsp;</td>
    <td style="width:3.5cm; height:0.8cm;">{$service_phone}</td>
  </tr>
</table>
</td>
</tr>
</table>
  </td>
    <td style="width:9.4cm;" valign="top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
<td valign="middle" style="width:1.5cm; height:0.8cm;">&nbsp;</td>
<td width="85%">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td valign="middle" style="width:5cm; height:0.8cm;">{$order.consignee}</td>
  <td valign="middle">&nbsp;</td>
  <td valign="middle" style="width:1.8cm; height:0.8cm;">&nbsp;</td>
  </tr>
</table>
</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td class="h">{$order.region}</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td class="h">{$order.address}</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td class="h">&nbsp;</td>
</tr>
<tr valign="middle">
<td>&nbsp;</td>
<td class="h">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="width:1.7cm;">&nbsp;</td>
    <td style="width:1.5cm; height:0.8cm;">&nbsp;</td>
    <td style="width:1.7cm;">&nbsp;</td>
    <td style="width:3.5cm; height:0.8cm;">{$order.tel}</td>
  </tr>
</table>
</td>
</tr>
</table>
</td>
  </tr>
</table>
<table style="width:18.8cm; height:6.5cm;" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" style="width:7.4cm;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
   <td colspan="2" style="height:0.5cm;"></td>
  </tr>
<tr>
<td rowspan="2" style="width:4.9cm;">&nbsp;</td>
<td style="height:0.8cm;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:0.8cm;">
  <tr>
    <td style="width:1cm;">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</td>
</tr>
<tr>
<td style="height:1.3cm;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td style="height:0.7cm;">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
</table>
</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:1.5cm">
<tr>
<td>&nbsp;</td>
</tr>
</table>
</td>
<td valign="top" style="width:11.4cm;">&nbsp;</td>
  </tr>
</table>';

// end