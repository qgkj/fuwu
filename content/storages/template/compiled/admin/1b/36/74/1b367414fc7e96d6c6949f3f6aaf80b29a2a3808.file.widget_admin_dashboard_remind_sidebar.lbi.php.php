<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:24:29
         compiled from "C:\ecjia-daojia-29\content\system\templates\library\widget_admin_dashboard_remind_sidebar.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:203005908423d90ec95-40544449%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1b367414fc7e96d6c6949f3f6aaf80b29a2a3808' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\system\\templates\\library\\widget_admin_dashboard_remind_sidebar.lbi.php',
      1 => 1487583414,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '203005908423d90ec95-40544449',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'remind' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5908423d921db3_14639892',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5908423d921db3_14639892')) {function content_5908423d921db3_14639892($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['remind']->value) {?>
<ul class="unstyled">
	<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['remind']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
	<li>
		<span class="act act-<?php echo $_smarty_tpl->tpl_vars['item']->value['style'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['total'];?>
</span>
		<strong><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
</strong>
	</li>
	<?php } ?>
</ul>
<?php }?><?php }} ?>
