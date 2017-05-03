<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:24:29
         compiled from "C:\ecjia-daojia-29\content\system\templates\library\common_header.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:236275908423d13c324-05105496%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '154f03f0ee3ed44b390c955bef3abbd5e69bcfa0' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\system\\templates\\library\\common_header.lbi.php',
      1 => 1487583414,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '236275908423d13c324-05105496',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ecjia_admin_cpname' => 0,
    'admin_message_is_show' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5908423d180db7_15738542',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5908423d180db7_15738542')) {function content_5908423d180db7_15738542($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
if (!is_callable('smarty_function_hook')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.hook.php';
if (!is_callable('smarty_block_t')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\block.t.php';
?><header>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="brand" href="<?php echo smarty_function_url(array('path'=>'@index/init'),$_smarty_tpl);?>
"><i class="icon-home icon-white"></i> <?php echo $_smarty_tpl->tpl_vars['ecjia_admin_cpname']->value;?>
</a>
				<ul class="nav user_menu pull-right">
					<li class="hidden-phone hidden-tablet">
						<div class="nb_boxes clearfix">
							<?php echo smarty_function_hook(array('id'=>'admin_dashboard_header_links'),$_smarty_tpl);?>

						</div>
					</li>
					<li class="divider-vertical hidden-phone hidden-tablet"></li>
					<li class="dropdown">
						<a class="dropdown-toggle nav_condensed" href="#" data-toggle="dropdown"><i class="flag-cn"></i> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="javascript:void(0)"><i class="flag-cn"></i> <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
简体中文<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></li>
							<!-- <li><a href="javascript:void(0)"><i class="flag-us"></i> <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
English<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></li> -->
						</ul>
					</li>
					<li class="divider-vertical hidden-phone hidden-tablet"></li>
					<li class="dropdown">
						<a class="dropdown-toggle" href="#" data-toggle="dropdown"><img src="<?php echo RC_Uri::admin_url('statics/images/user_avatar.png');?>
" alt="" class="user_avatar" /><?php echo htmlspecialchars($_SESSION['admin_name'], ENT_QUOTES, 'UTF-8', true);?>
<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo smarty_function_url(array('path'=>'@privilege/modif'),$_smarty_tpl);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
个人设置<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></li>
							<?php if ($_smarty_tpl->tpl_vars['admin_message_is_show']->value) {?>
							<li><a href="<?php echo smarty_function_url(array('path'=>'@admin_message/init'),$_smarty_tpl);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
管理员留言<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></li>
							<?php }?>
							<li class="divider"></li>
							<li><a href="<?php echo smarty_function_url(array('path'=>'@privilege/logout'),$_smarty_tpl);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
退出<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></li>
						</ul>
					</li>
				</ul>
				<?php echo smarty_function_hook(array('id'=>'admin_print_header_nav'),$_smarty_tpl);?>

			</div>
		</div>
	</div>
	<?php echo smarty_function_hook(array('id'=>'admin_dashboard_header_codes'),$_smarty_tpl);?>

</header><?php }} ?>
