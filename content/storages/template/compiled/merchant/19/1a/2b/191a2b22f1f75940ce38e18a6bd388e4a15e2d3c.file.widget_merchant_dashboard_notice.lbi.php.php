<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:23:35
         compiled from "C:\ecjia-daojia-29\content\apps\staff\templates\merchant\library\widget_merchant_dashboard_notice.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:2311359084207f1d822-98403715%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '191a2b22f1f75940ce38e18a6bd388e4a15e2d3c' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\staff\\templates\\merchant\\library\\widget_merchant_dashboard_notice.lbi.php',
      1 => 1487583420,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2311359084207f1d822-98403715',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_59084207f38361_77340795',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59084207f38361_77340795')) {function content_59084207f38361_77340795($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
?><section class="panel">
    <div class="task-thumb-details">
        <h1>公告通知</h1>
    </div>
    <table class="table">
        <tbody>
        	<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        	<tr>
        		<td><a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"merchant/merchant/shop_notice",'args'=>"id=".((string)$_smarty_tpl->tpl_vars['val']->value['article_id'])),$_smarty_tpl);?>
'><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</a></td>
        		<td class="w70"><?php echo $_smarty_tpl->tpl_vars['val']->value['add_time'];?>
</td>
        	</tr>
        	<?php }
if (!$_smarty_tpl->tpl_vars['val']->_loop) {
?>
        	<tr>
        	   <td class="no-records" colspan="1">暂无任何公告通知</td>
        	</tr>
        	<?php } ?>
        </tbody>
    </table>
</section>
<?php }} ?>
