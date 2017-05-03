<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:24:29
         compiled from "C:\ecjia-daojia-29\content\apps\orders\templates\admin\library\widget_admin_dashboard_ordersstat.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:88175908423d613e55-10627233%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'de35155cab1207e745474a66ab34027cbbfefcb2' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\orders\\templates\\admin\\library\\widget_admin_dashboard_ordersstat.lbi.php',
      1 => 1487583419,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '88175908423d613e55-10627233',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'order_count' => 0,
    'status' => 0,
    'order' => 0,
    'new_repay' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5908423d66f718_12028845',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5908423d66f718_12028845')) {function content_5908423d66f718_12028845($_smarty_tpl) {?><?php if (!is_callable('smarty_function_lang')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.lang.php';
if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
?><div class="move-mod-group" id="widget_admin_dashboard_ordersstat">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h3>
		<span class="pull-right label label-important"><?php echo $_smarty_tpl->tpl_vars['order_count']->value;?>
</span>
	</div>

	<table class="table table-bordered mediaTable dash-table-oddtd">
		<thead>
			<tr>
				<th colspan="4" class="optional"><?php echo smarty_function_lang(array('key'=>'orders::order.order_stats_info'),$_smarty_tpl);?>
</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><a href='<?php echo smarty_function_url(array('path'=>"orders/admin/init",'args'=>"composite_status=".((string)$_smarty_tpl->tpl_vars['status']->value['await_ship'])),$_smarty_tpl);?>
' title="<?php echo smarty_function_lang(array('key'=>'orders::order.not_shipping_orders'),$_smarty_tpl);?>
"><?php echo smarty_function_lang(array('key'=>'orders::order.not_shipping_orders'),$_smarty_tpl);?>
</a></td>
				<td class="dash-table-color"><strong><?php echo $_smarty_tpl->tpl_vars['order']->value['await_ship'];?>
</strong></td>
				<td><a href='<?php echo smarty_function_url(array('path'=>"orders/admin/init",'args'=>"composite_status=".((string)$_smarty_tpl->tpl_vars['status']->value['unconfirmed'])),$_smarty_tpl);?>
' title="<?php echo smarty_function_lang(array('key'=>'orders::order.unconfirmed_orders'),$_smarty_tpl);?>
"><?php echo smarty_function_lang(array('key'=>'orders::order.unconfirmed_orders'),$_smarty_tpl);?>
</a></td>
				<td><strong><?php echo $_smarty_tpl->tpl_vars['order']->value['unconfirmed'];?>
</strong></td>
			</tr>
			<tr>
				<td><a href='<?php echo smarty_function_url(array('path'=>"orders/admin/init",'args'=>"composite_status=".((string)$_smarty_tpl->tpl_vars['status']->value['await_pay'])),$_smarty_tpl);?>
' title="<?php echo smarty_function_lang(array('key'=>'orders::order.unpaid_orders'),$_smarty_tpl);?>
"><?php echo smarty_function_lang(array('key'=>'orders::order.unpaid_orders'),$_smarty_tpl);?>
</a></td>
				<td><strong><?php echo $_smarty_tpl->tpl_vars['order']->value['await_pay'];?>
</strong></td>
				<td><a href='<?php echo smarty_function_url(array('path'=>"orders/admin/init",'args'=>"composite_status=".((string)$_smarty_tpl->tpl_vars['status']->value['finished'])),$_smarty_tpl);?>
' title="<?php echo smarty_function_lang(array('key'=>'orders::order.finished_orders'),$_smarty_tpl);?>
"><?php echo smarty_function_lang(array('key'=>'orders::order.finished_orders'),$_smarty_tpl);?>
</a></td>
				<td><strong><?php echo $_smarty_tpl->tpl_vars['order']->value['finished'];?>
</strong></td>
			</tr>
			<tr>
				<td><a href='<?php echo smarty_function_url(array('path'=>"orders/admin/init",'args'=>"composite_status=".((string)$_smarty_tpl->tpl_vars['status']->value['shipped_part'])),$_smarty_tpl);?>
' title="<?php echo smarty_function_lang(array('key'=>'orders::order.parts_delivery_order'),$_smarty_tpl);?>
"><?php echo smarty_function_lang(array('key'=>'orders::order.parts_delivery_order'),$_smarty_tpl);?>
</a></td>
				<td><strong><?php echo $_smarty_tpl->tpl_vars['order']->value['shipped_part'];?>
</strong></td>
				<td><a href='<?php echo smarty_function_url(array('path'=>"user/admin_account/init",'args'=>"process_type=1&is_paid=0"),$_smarty_tpl);?>
' title="<?php echo smarty_function_lang(array('key'=>'orders::order.refund_application'),$_smarty_tpl);?>
"><?php echo smarty_function_lang(array('key'=>'orders::order.refund_application'),$_smarty_tpl);?>
</a></td>
				<td><strong><?php echo $_smarty_tpl->tpl_vars['new_repay']->value;?>
</strong></td>
			</tr>
		</tbody>
	</table>
</div><?php }} ?>
