<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:24:29
         compiled from "C:\ecjia-daojia-29\content\apps\goods\templates\admin\library\widget_admin_dashboard_goodsstat.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:67055908423d75fc08-83634608%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa66337fd9f422c9e167b7932b2b71c34c19dc68' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\goods\\templates\\admin\\library\\widget_admin_dashboard_goodsstat.lbi.php',
      1 => 1487583417,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '67055908423d75fc08-83634608',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'goods' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5908423d7afdb8_70532871',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5908423d7afdb8_70532871')) {function content_5908423d7afdb8_70532871($_smarty_tpl) {?><?php if (!is_callable('smarty_function_lang')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.lang.php';
if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
?><div class="move-mod-group" id="widget_admin_dashboard_goodsstat">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</h3>
		<span class="pull-right label label-info"><?php echo $_smarty_tpl->tpl_vars['goods']->value['total'];?>
</span>
	</div>
	<table class="table table-bordered mediaTable dash-table-oddtd">
	<thead>
	<tr>
		<th colspan="4" class="optional">
			<?php echo smarty_function_lang(array('key'=>'goods::goods.goods_count_info'),$_smarty_tpl);?>

		</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td>
			<a href='<?php echo smarty_function_url(array('path'=>"goods/admin/init"),$_smarty_tpl);?>
' title="<?php echo smarty_function_lang(array('key'=>'goods::goods.goods_total'),$_smarty_tpl);?>
"><?php echo smarty_function_lang(array('key'=>'goods::goods.goods_total'),$_smarty_tpl);?>
</a>
		</td>
		<td>
			<strong><?php echo $_smarty_tpl->tpl_vars['goods']->value['total'];?>
</strong>
		</td>
		<td>
			<a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['warn_goods_url'];?>
" title="<?php echo smarty_function_lang(array('key'=>'goods::goods.warn_goods_number'),$_smarty_tpl);?>
"><?php echo smarty_function_lang(array('key'=>'goods::goods.warn_goods_number'),$_smarty_tpl);?>
</a>
		</td>
		<td class="dash-table-color">
			<strong><?php echo $_smarty_tpl->tpl_vars['goods']->value['warn_goods'];?>
</strong>
		</td>
	</tr>
	<tr>
		<td>
			<a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['new_goods_url'];?>
" title="<?php echo smarty_function_lang(array('key'=>'goods::goods.new_goods_number'),$_smarty_tpl);?>
"><?php echo smarty_function_lang(array('key'=>'goods::goods.new_goods_number'),$_smarty_tpl);?>
</a>
		</td>
		<td>
			<strong><?php echo $_smarty_tpl->tpl_vars['goods']->value['new_goods'];?>
</strong>
		</td>
		<td>
			<a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['best_goods_url'];?>
" title="<?php echo smarty_function_lang(array('key'=>'goods::goods.best_goods_number'),$_smarty_tpl);?>
"><?php echo smarty_function_lang(array('key'=>'goods::goods.best_goods_number'),$_smarty_tpl);?>
</a>
		</td>
		<td>
			<strong><?php echo $_smarty_tpl->tpl_vars['goods']->value['best_goods'];?>
</strong>
		</td>
	</tr>
	<tr>
		<td>
			<a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['hot_goods_url'];?>
" title="<?php echo smarty_function_lang(array('key'=>'goods::goods.hot_goods_number'),$_smarty_tpl);?>
"><?php echo smarty_function_lang(array('key'=>'goods::goods.hot_goods_number'),$_smarty_tpl);?>
</a>
		</td>
		<td>
			<strong><?php echo $_smarty_tpl->tpl_vars['goods']->value['hot_goods'];?>
</strong>
		</td>
		<td>
			<a href="<?php echo $_smarty_tpl->tpl_vars['goods']->value['promote_goods_url'];?>
" title="<?php echo smarty_function_lang(array('key'=>'goods::goods.promote_goods_numeber'),$_smarty_tpl);?>
"><?php echo smarty_function_lang(array('key'=>'goods::goods.promote_goods_numeber'),$_smarty_tpl);?>
</a>
		</td>
		<td>
			<strong><?php echo $_smarty_tpl->tpl_vars['goods']->value['promote_goods'];?>
</strong>
		</td>
	</tr>
	</tbody>
	</table>
</div><?php }} ?>
