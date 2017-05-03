<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:41:42
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\page_menu.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:230995908464648ff40-23828711%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '287c52bdef41c7265324661dcb8cd5a67c8691e9' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\page_menu.lbi.php',
      1 => 1487583428,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '230995908464648ff40-23828711',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'hidenav' => 0,
    'hidetab' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5908464649f360_68527021',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5908464649f360_68527021')) {function content_5908464649f360_68527021($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
?><?php if ($_smarty_tpl->tpl_vars['hidenav']->value!=1&&$_smarty_tpl->tpl_vars['hidetab']->value!=1) {?>
<div class="ecjia-menu" id="ecjia-menu">
	<ul>
		<li><a href="<?php echo smarty_function_url(array('path'=>'touch/index/init'),$_smarty_tpl);?>
"><i class="iconfont icon-home"></i></a></li>
		<li><a href="<?php echo smarty_function_url(array('path'=>'touch/index/search'),$_smarty_tpl);?>
"><i class="iconfont icon-search"></i></a></li>
		<li><a href="<?php echo smarty_function_url(array('path'=>'cart/index/init'),$_smarty_tpl);?>
"><i class="iconfont icon-gouwuche"></i></a></li>
		<li><a href="<?php echo smarty_function_url(array('path'=>'touch/my/init'),$_smarty_tpl);?>
"><i class="iconfont icon-gerenzhongxin"></i></a></li>
		<li><a href="javascript:;"><i class="iconfont icon-top"></i></a></li>
	</ul>
	<div class="main"><a class="nopjax" href="javascript:;"><i class="iconfont icon-add"></i></a></div>
</div>
<?php }?>
<?php }} ?>
