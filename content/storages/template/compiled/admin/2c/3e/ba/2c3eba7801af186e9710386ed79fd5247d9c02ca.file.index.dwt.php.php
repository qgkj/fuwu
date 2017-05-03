<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:24:28
         compiled from "C:\ecjia-daojia-29\content\system\templates\index.dwt.php" */ ?>
<?php /*%%SmartyHeaderCode:230275908423cef95f8-11805910%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c3eba7801af186e9710386ed79fd5247d9c02ca' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\system\\templates\\index.dwt.php',
      1 => 1487583414,
      2 => 'file',
    ),
    'd745c77605e4d0f0957e25066c04bb02a1c5464c' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\system\\templates\\ecjia.dwt.php',
      1 => 1487583414,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '230275908423cef95f8-11805910',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ur_here' => 0,
    'ecjia_admin_cptitle' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5908423d1160d7_38085555',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5908423d1160d7_38085555')) {function content_5908423d1160d7_38085555($_smarty_tpl) {?><?php if (!is_callable('smarty_function_hook')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.hook.php';
?><?php if (!is_pjax()) {?>
<!DOCTYPE html>
<html lang="zh" class="pjaxLoadding-busy">
<head>
<meta name="Generator" content="ECJIA 1.20" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php if ($_smarty_tpl->tpl_vars['ur_here']->value) {?><?php echo $_smarty_tpl->tpl_vars['ur_here']->value;?>
 - <?php }?><?php echo $_smarty_tpl->tpl_vars['ecjia_admin_cptitle']->value;?>
</title>
	<link rel="shortcut icon" href="favicon.ico" />
	<?php echo smarty_function_hook(array('id'=>'admin_print_styles'),$_smarty_tpl);?>

	<?php echo $_smarty_tpl->getSubTemplate ("library/common_meta.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	<?php echo smarty_function_hook(array('id'=>'admin_print_scripts'),$_smarty_tpl);?>

	
	
	<?php echo smarty_function_hook(array('id'=>'admin_head'),$_smarty_tpl);?>

</head>
<body>
	<div class="clearfix" id="maincontainer">
		<?php echo $_smarty_tpl->getSubTemplate ("library/common_header.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

		<div id="contentwrapper">
			<div class="main_content">
				<?php echo smarty_function_hook(array('id'=>'admin_print_main_header'),$_smarty_tpl);?>

				
<div class="row-fluid move-mods">
	<div class="span12 move-mod nomove">
		<?php echo smarty_function_hook(array('id'=>'admin_dashboard_top'),$_smarty_tpl);?>

	</div>
</div>

<div class="row-fluid move-mods" id="sortable_panels">
	<div class="span6 move-mod nomove">
		<?php echo smarty_function_hook(array('id'=>'admin_dashboard_left'),$_smarty_tpl);?>

	</div>
	<div class="span6 move-mod nomove">
		<?php echo smarty_function_hook(array('id'=>'admin_dashboard_right'),$_smarty_tpl);?>

	</div>
</div>

<div class="row-fluid move-mods">
	<div class="span3 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_left3'),$_smarty_tpl);?>

	</div>
	<div class="span3 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_center3'),$_smarty_tpl);?>

	</div>
	<div class="span6 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_right6'),$_smarty_tpl);?>

	</div>
</div>

<div class="row-fluid move-mods">
	<div class="span8 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_left8'),$_smarty_tpl);?>

	</div>
	<div class="span4 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_right4'),$_smarty_tpl);?>

	</div>
</div>

<div class="row-fluid move-mods">
	<div class="span4 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_left4'),$_smarty_tpl);?>

	</div>
	<div class="span4 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_center4'),$_smarty_tpl);?>

	</div>
	<div class="span4 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_right4'),$_smarty_tpl);?>

	</div>
</div>

<div class="row-fluid move-mods">
	<div class="span12 move-mod nomove">
	<?php echo smarty_function_hook(array('id'=>'admin_dashboard_bottom'),$_smarty_tpl);?>

	</div>
</div>
	

				<?php echo smarty_function_hook(array('id'=>'admin_print_main_bottom'),$_smarty_tpl);?>

			</div>
		</div>
		<?php echo $_smarty_tpl->getSubTemplate ("library/common_sidebar.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	</div>
	<?php echo smarty_function_hook(array('id'=>'admin_print_footer_scripts'),$_smarty_tpl);?>

	<?php echo $_smarty_tpl->getSubTemplate ("library/common_footer.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

	
	
<script type="text/javascript">
	ecjia.admin.dashboard.init();
</script>

	<?php echo smarty_function_hook(array('id'=>'admin_footer'),$_smarty_tpl);?>

    <div class="pjaxLoadding"><i class="peg"></i></div>
</body>
</html>
<?php } else { ?>
	<title><?php echo $_smarty_tpl->tpl_vars['ecjia_admin_cptitle']->value;?>
<?php if ($_smarty_tpl->tpl_vars['ur_here']->value) {?> - <?php echo $_smarty_tpl->tpl_vars['ur_here']->value;?>
<?php }?></title>
	
	<?php echo smarty_function_hook(array('id'=>'admin_pjax_head'),$_smarty_tpl);?>

	<?php echo smarty_function_hook(array('id'=>'admin_print_main_header'),$_smarty_tpl);?>

	
<div class="row-fluid move-mods">
	<div class="span12 move-mod nomove">
		<?php echo smarty_function_hook(array('id'=>'admin_dashboard_top'),$_smarty_tpl);?>

	</div>
</div>

<div class="row-fluid move-mods" id="sortable_panels">
	<div class="span6 move-mod nomove">
		<?php echo smarty_function_hook(array('id'=>'admin_dashboard_left'),$_smarty_tpl);?>

	</div>
	<div class="span6 move-mod nomove">
		<?php echo smarty_function_hook(array('id'=>'admin_dashboard_right'),$_smarty_tpl);?>

	</div>
</div>

<div class="row-fluid move-mods">
	<div class="span3 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_left3'),$_smarty_tpl);?>

	</div>
	<div class="span3 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_center3'),$_smarty_tpl);?>

	</div>
	<div class="span6 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_right6'),$_smarty_tpl);?>

	</div>
</div>

<div class="row-fluid move-mods">
	<div class="span8 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_left8'),$_smarty_tpl);?>

	</div>
	<div class="span4 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_right4'),$_smarty_tpl);?>

	</div>
</div>

<div class="row-fluid move-mods">
	<div class="span4 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_left4'),$_smarty_tpl);?>

	</div>
	<div class="span4 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_center4'),$_smarty_tpl);?>

	</div>
	<div class="span4 move-mod nomove">
	   <?php echo smarty_function_hook(array('id'=>'admin_dashboard_right4'),$_smarty_tpl);?>

	</div>
</div>

<div class="row-fluid move-mods">
	<div class="span12 move-mod nomove">
	<?php echo smarty_function_hook(array('id'=>'admin_dashboard_bottom'),$_smarty_tpl);?>

	</div>
</div>
	

	<?php echo smarty_function_hook(array('id'=>'admin_print_main_bottom'),$_smarty_tpl);?>

	
<script type="text/javascript">
	ecjia.admin.dashboard.init();
</script>

	<?php echo smarty_function_hook(array('id'=>'admin_pjax_footer'),$_smarty_tpl);?>

<?php }?>
<?php }} ?>
