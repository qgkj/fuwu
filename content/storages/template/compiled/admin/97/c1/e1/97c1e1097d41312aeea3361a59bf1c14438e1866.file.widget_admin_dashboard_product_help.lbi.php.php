<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:24:29
         compiled from "C:\ecjia-daojia-29\content\apps\main\templates\admin\library\widget_admin_dashboard_product_help.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:65065908423d8355c5-63352402%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97c1e1097d41312aeea3361a59bf1c14438e1866' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\main\\templates\\admin\\library\\widget_admin_dashboard_product_help.lbi.php',
      1 => 1487583418,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '65065908423d8355c5-63352402',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'help_urls' => 0,
    'name' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5908423d8449e6_15041324',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5908423d8449e6_15041324')) {function content_5908423d8449e6_15041324($_smarty_tpl) {?>
<div class="move-mod-group" id="widget_admin_dashboard_loglist">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h3>
	</div>
	<table class="table table-striped table-bordered mediaTable ecjiaf-wwb">
		<tbody>
			<?php  $_smarty_tpl->tpl_vars['url'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['url']->_loop = false;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['help_urls']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['url']->key => $_smarty_tpl->tpl_vars['url']->value) {
$_smarty_tpl->tpl_vars['url']->_loop = true;
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['url']->key;
?>
			<tr>
				<td>
					<p class="m_b5"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
: <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
" target="_black"><?php echo $_smarty_tpl->tpl_vars['url']->value;?>
</a></p>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div><?php }} ?>
