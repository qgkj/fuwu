<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:24:29
         compiled from "C:\ecjia-daojia-29\content\system\templates\library\common_sidebar.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:165595908423d863224-64936243%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1a09f73211eaa37ceb032cda7d3c29b9b611cf71' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\system\\templates\\library\\common_sidebar.lbi.php',
      1 => 1487583414,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '165595908423d863224-64936243',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5908423d881a64_23889394',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5908423d881a64_23889394')) {function content_5908423d881a64_23889394($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\block.t.php';
if (!is_callable('smarty_function_hook')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.hook.php';
?><a class="sidebar_switch on_switch ttip_r" href="javascript:void(0)" title="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
隐藏侧边栏<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
侧边栏开关<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
<div class="sidebar">
	<div class="antiScroll">
		<div class="antiscroll-inner">
			<div class="antiscroll-content">
				<div class="sidebar_inner">
					<form class="input-append" onsubmit="return false">
						<input class="search_query input-medium" autocomplete="off" name="query" size="16" type="text" placeholder="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
搜索导航<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" /><a class="btn search_query_btn"><i class="icon-search"></i></a>
					</form>
					<div class="accordion" id="side_accordion">
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle search_query_close" href="#collapse_search_query" data-parent="#side_accordion" data-toggle="collapse">
									<i class="icon-search"></i> <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
快速搜索<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

								</a>
							</div>
							<div class="accordion-body collapse" id="collapse_search_query">
								<div class="accordion-inner">
									<ul class="nav nav-list">
										<li class="search_query_none"><a href="javascript:;"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
请先输入搜索信息<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></li>
										<?php echo smarty_function_hook(array('id'=>'admin_sidebar_collapse_search'),$_smarty_tpl);?>

									</ul>
								</div>
							</div>
						</div>
						<?php echo smarty_function_hook(array('id'=>'admin_sidebar_collapse'),$_smarty_tpl);?>

					</div>
					<div class="push"></div>
				</div>

				<div class="sidebar_info">
					<?php echo smarty_function_hook(array('id'=>'admin_sidebar_info'),$_smarty_tpl);?>

				</div>
			</div>
		</div>
	</div>
</div>
<?php }} ?>
