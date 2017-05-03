<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:24:29
         compiled from "C:\ecjia-daojia-29\content\apps\orders\templates\admin\library\widget_admin_dashboard_shopchart.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:260465908423d514536-45693425%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '89a7aaed12b7d5c76aa2fb2d84bfd1985b2739bb' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\orders\\templates\\admin\\library\\widget_admin_dashboard_shopchart.lbi.php',
      1 => 1487583419,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '260465908423d514536-45693425',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order_money' => 0,
    'month_start_time' => 0,
    'month_end_time' => 0,
    'month_order' => 0,
    'order_unconfirmed' => 0,
    'today_start_time' => 0,
    'today_end_time' => 0,
    'unconfirmed' => 0,
    'order_await_ship' => 0,
    'wait_ship' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5908423d577803_90420516',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5908423d577803_90420516')) {function content_5908423d577803_90420516($_smarty_tpl) {?><?php if (!is_callable('smarty_function_lang')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.lang.php';
if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
if (!is_callable('smarty_block_t')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\block.t.php';
?><div class="move-mod-group" id="widget_admin_dashboard_briefing">
	<ul class="list-mod list-mod-briefing move-mod-head">
		<li class="span3">
			<div class="bd ecjiaf-pre"><span class="f_s14">￥</span><?php echo $_smarty_tpl->tpl_vars['order_money']->value;?>
<span class="f_s14"><?php echo smarty_function_lang(array('key'=>'orders::order.yuan'),$_smarty_tpl);?>
</span></div>
			<a target="__blank" href='<?php echo smarty_function_url(array('path'=>"orders/admin_order_stats/init",'args'=>"start_date=".((string)$_smarty_tpl->tpl_vars['month_start_time']->value)."&end_date=".((string)$_smarty_tpl->tpl_vars['month_end_time']->value)),$_smarty_tpl);?>
'>
				<div class="ft"><i class="fontello-icon-doc-text-inv ecjiaf-fl"></i><?php echo smarty_function_lang(array('key'=>'orders::order.order_money'),$_smarty_tpl);?>
</div>
			</a>
		</li>
		<li class="span3">
			<div class="bd ecjiaf-pre"><?php echo $_smarty_tpl->tpl_vars['month_order']->value;?>
<span class="f_s14"><?php echo smarty_function_lang(array('key'=>'orders::order.monad'),$_smarty_tpl);?>
</span></div>
			<a target="__blank" href='<?php echo smarty_function_url(array('path'=>"orders/admin_order_stats/init",'args'=>"start_date=".((string)$_smarty_tpl->tpl_vars['month_start_time']->value)."&end_date=".((string)$_smarty_tpl->tpl_vars['month_end_time']->value)),$_smarty_tpl);?>
'>
				<div class="ft"><i class="fontello-icon-doc-text-inv ecjiaf-fl"></i><?php echo smarty_function_lang(array('key'=>'orders::order.order_count'),$_smarty_tpl);?>
</div>
			</a>
		</li>
		<li class="span3">
			<div class="bd ecjiaf-pre"><?php echo $_smarty_tpl->tpl_vars['order_unconfirmed']->value;?>
<span class="f_s14"><?php echo smarty_function_lang(array('key'=>'orders::order.monad'),$_smarty_tpl);?>
</span></div>
			<a target="__blank" href='<?php echo smarty_function_url(array('path'=>"orders/admin/init",'args'=>"start_time=".((string)$_smarty_tpl->tpl_vars['today_start_time']->value)."&end_time=".((string)$_smarty_tpl->tpl_vars['today_end_time']->value)."&composite_status=".((string)$_smarty_tpl->tpl_vars['unconfirmed']->value)),$_smarty_tpl);?>
'>
				<div class="ft"><i class="fontello-icon-doc-text-inv ecjiaf-fl"></i><?php echo smarty_function_lang(array('key'=>'orders::order.wait_confirm_order'),$_smarty_tpl);?>
</div>
			</a>
		</li>
		<li class="span3">
			<div class="bd ecjiaf-pre"><?php echo $_smarty_tpl->tpl_vars['order_await_ship']->value;?>
<span class="f_s14"><?php echo smarty_function_lang(array('key'=>'orders::order.monad'),$_smarty_tpl);?>
</span></div>
			<a target="__blank" href='<?php echo smarty_function_url(array('path'=>"orders/admin/init",'args'=>"start_time=".((string)$_smarty_tpl->tpl_vars['today_start_time']->value)."&end_time=".((string)$_smarty_tpl->tpl_vars['today_end_time']->value)."&composite_status=".((string)$_smarty_tpl->tpl_vars['wait_ship']->value)),$_smarty_tpl);?>
'>
				<div class="ft"><i class="fontello-icon-doc-text-inv ecjiaf-fl"></i><?php echo smarty_function_lang(array('key'=>'orders::order.today_order'),$_smarty_tpl);?>
</div>
			</a>
		</li>
	</ul>
	<!-- <div class="ecjiaf-tar"><a href="<?php echo RC_Uri::url('@admin_logs/init');?>
" title="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
查看更多<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
查看更多<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></div> -->
</div>
<style type="text/css">
	ul.list-mod-briefing {
		margin: 0;
		overflow: hidden;
		margin-bottom: 20px;
	}
	ul.list-mod-briefing li {
		position: relative;
		background: #fff;
	}
	ul.list-mod-briefing li .bd {
		height: 108px;
		font-size: 28px;
		text-align: center;
		padding: 50px 10px 0;
		border: 1px solid #ccc;
		border-bottom: none;
		border-radius: 5px;
	}
	ul.list-mod-briefing li .ft {
		position: absolute;
		left: 0;
		right: 0;
		bottom: 0;
		height: 38px;
		line-height: 38px;
		padding: 0 15px;
		text-align: right;
		color: #fff;
		background: #54bcd8;
		border-bottom-right-radius: 5px;
		border-bottom-left-radius: 5px;
	}
	ul.list-mod-briefing li:nth-of-type(1n) .ft {
		background: #9dc870;
	}
	ul.list-mod-briefing li:nth-of-type(2n) .ft {
		background: #54bcd8;
	}
	ul.list-mod-briefing li:nth-of-type(3n) .ft {
		background: #e9a954;
	}
	ul.list-mod-briefing li:nth-of-type(4n) .ft {
		background: #976390;
	}
</style><?php }} ?>
