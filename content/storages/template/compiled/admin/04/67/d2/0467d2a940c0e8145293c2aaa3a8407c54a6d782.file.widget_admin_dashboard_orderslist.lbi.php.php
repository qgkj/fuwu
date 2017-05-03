<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:24:29
         compiled from "C:\ecjia-daojia-29\content\apps\orders\templates\admin\library\widget_admin_dashboard_orderslist.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:201245908423d6bf8b2-88825896%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0467d2a940c0e8145293c2aaa3a8407c54a6d782' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\orders\\templates\\admin\\library\\widget_admin_dashboard_orderslist.lbi.php',
      1 => 1487583419,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '201245908423d6bf8b2-88825896',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'order_count' => 0,
    'order_list' => 0,
    'order' => 0,
    'lang_os' => 0,
    'lang_ps' => 0,
    'lang_ss' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5908423d731fa3_25885049',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5908423d731fa3_25885049')) {function content_5908423d731fa3_25885049($_smarty_tpl) {?><?php if (!is_callable('smarty_function_lang')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.lang.php';
if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
?><div class="move-mod-group" id="widget_admin_dashboard_orderslist">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h3>
		<span class="pull-right label label-important"><?php echo $_smarty_tpl->tpl_vars['order_count']->value;?>
</span>
	</div>

	<table class="table table-striped table-bordered mediaTable">
		<thead>
			<tr>
				<th class="optional"><?php echo smarty_function_lang(array('key'=>'orders::order.order_sn'),$_smarty_tpl);?>
</th>
				<th class="essential persist"><?php echo smarty_function_lang(array('key'=>'orders::order.order_time'),$_smarty_tpl);?>
</th>
				<th class="optional"><?php echo smarty_function_lang(array('key'=>'orders::order.total_fee'),$_smarty_tpl);?>
</th>
				<th class="optional"><?php echo smarty_function_lang(array('key'=>'orders::order.order_status'),$_smarty_tpl);?>
</th>
			</tr>
		</thead>
		<tbody>
			<?php  $_smarty_tpl->tpl_vars['order'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['order']->_loop = false;
 $_smarty_tpl->tpl_vars['okey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['order_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['order']->key => $_smarty_tpl->tpl_vars['order']->value) {
$_smarty_tpl->tpl_vars['order']->_loop = true;
 $_smarty_tpl->tpl_vars['okey']->value = $_smarty_tpl->tpl_vars['order']->key;
?>
			<tr>
				<td>
					<a href='<?php echo smarty_function_url(array('path'=>"orders/admin/info",'args'=>"order_id=".((string)$_smarty_tpl->tpl_vars['order']->value['order_id'])),$_smarty_tpl);?>
' class="sepV_a" title="Edit"><?php echo $_smarty_tpl->tpl_vars['order']->value['order_sn'];?>
</a>
				</td>
				<td><?php echo $_smarty_tpl->tpl_vars['order']->value['short_order_time'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['order']->value['formated_total_fee'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['lang_os']->value[$_smarty_tpl->tpl_vars['order']->value['order_status']];?>
,<?php echo $_smarty_tpl->tpl_vars['lang_ps']->value[$_smarty_tpl->tpl_vars['order']->value['pay_status']];?>
,<?php echo $_smarty_tpl->tpl_vars['lang_ss']->value[$_smarty_tpl->tpl_vars['order']->value['shipping_status']];?>
</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<div class="ecjiaf-tar"><a href='<?php echo smarty_function_url(array('path'=>"orders/admin/init"),$_smarty_tpl);?>
' title="<?php echo smarty_function_lang(array('key'=>'orders::order.more'),$_smarty_tpl);?>
"><?php echo smarty_function_lang(array('key'=>'orders::order.more'),$_smarty_tpl);?>
</a></div>
</div><?php }} ?>
