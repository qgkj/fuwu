<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 07:35:41
         compiled from "46372ed37bad080076c50f03b400a1c6b8a6c375" */ ?>
<?php /*%%SmartyHeaderCode:12828590836cd92cd62-08530671%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '46372ed37bad080076c50f03b400a1c6b8a6c375' => 
    array (
      0 => '46372ed37bad080076c50f03b400a1c6b8a6c375',
      1 => 0,
      2 => 'string',
    ),
  ),
  'nocache_hash' => '12828590836cd92cd62-08530671',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'code' => 0,
    'service_phone' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_590836cd971813_35070562',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590836cd971813_35070562')) {function content_590836cd971813_35070562($_smarty_tpl) {?>您的校验码是：<?php echo $_smarty_tpl->tpl_vars['code']->value;?>
，请在页面中输入以完成验证。如非本人操作，请忽略本短信。如有问题请拨打客服电话：<?php echo $_smarty_tpl->tpl_vars['service_phone']->value;?>
。<?php }} ?>
