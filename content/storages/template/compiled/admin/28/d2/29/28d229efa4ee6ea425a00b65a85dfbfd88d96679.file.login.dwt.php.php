<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:27:06
         compiled from "C:\ecjia-daojia-29\content\system\templates\login.dwt.php" */ ?>
<?php /*%%SmartyHeaderCode:26314590842da2e64f7-99649137%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '28d229efa4ee6ea425a00b65a85dfbfd88d96679' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\system\\templates\\login.dwt.php',
      1 => 1487583414,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26314590842da2e64f7-99649137',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ecjia_admin_cptitle' => 0,
    'ur_here' => 0,
    'logo_display' => 0,
    'form_action' => 0,
    'get_password_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_590842da391f62_16999499',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590842da391f62_16999499')) {function content_590842da391f62_16999499($_smarty_tpl) {?><?php if (!is_callable('smarty_function_hook')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.hook.php';
if (!is_callable('smarty_block_t')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\block.t.php';
?><!DOCTYPE html>
<html class="login_page" lang="zh">
<head>
<meta name="Generator" content="ECJIA 1.20" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php echo $_smarty_tpl->tpl_vars['ecjia_admin_cptitle']->value;?>
<?php if ($_smarty_tpl->tpl_vars['ur_here']->value) {?> - <?php echo $_smarty_tpl->tpl_vars['ur_here']->value;?>
<?php }?></title>
	<?php echo smarty_function_hook(array('id'=>'admin_print_styles'),$_smarty_tpl);?>

	<?php echo smarty_function_hook(array('id'=>'admin_print_scripts'),$_smarty_tpl);?>

</head>
<body>
	<div class="login_box">
		<?php echo $_smarty_tpl->tpl_vars['logo_display']->value;?>

		<div class="error-msg"></div>
		<form action="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
" method="post" id="login_form" name="theForm" >
			<div class="top_b"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
管理员登录<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</div>
			<div class="cnt_b">
				<div class="formRow">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-user"></i></span>
						<input id="username" name="username" type="text" placeholder="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
管理员姓名：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" value="" autocomplete="off" />
					</div>
				</div>
				<div class="formRow">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-lock"></i></span>
						<input id="password" name="password" type="password" placeholder="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
管理员密码：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" value="" autocomplete="off" />
					</div>
				</div>
				<?php echo smarty_function_hook(array('id'=>'admin_login_captcha'),$_smarty_tpl);?>

				<div class="formRow clearfix">
					<label>
						<input class="f_l" type="checkbox" name="remember" /><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
请保存我这次的登录信息。<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

					</label>
				</div>
			</div>
			<div class="btm_b clearfix">
				<input type="hidden" name="act" value="signin" />
				<button class="btn btn-inverse pull-right" type="submit"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
进入管理中心<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</button>
				<span class="link_reg"><a href="index.php"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
返回首页<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></span>
			</div>
		</form>
		<div class="links_b links_btm clearfix">
			<?php $_smarty_tpl->tpl_vars['get_password_url'] = new Smarty_variable(RC_Uri::url('@get_password/forget_pwd'), null, 0);?>
			<span class="linkform"><a href="<?php echo $_smarty_tpl->tpl_vars['get_password_url']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
您忘记了密码吗?<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></span>
		</div>
	</div>
	<?php echo smarty_function_hook(array('id'=>'admin_print_footer_scripts'),$_smarty_tpl);?>

	<script>
		
		$(document).ready(function(){
			//* boxes animation 开场动画
			form_wrapper = $('.login_box');
			form_wrapper.animate({ marginTop : ( - ( form_wrapper.height() / 2) - 24) },400);	

		});

		$('#login_form').on('submit', function(e){
			e.preventDefault();
			$this = $(this);
			$this.ajaxSubmit({
				dataType:"json",
				success:function(data){
					$('.popover').remove();
					if(data.state == 'success'){
						window.location.href = data.url;
					}else{
						var $info = $('<div class="staticalert alert alert-error ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
						$info.appendTo('.error-msg').delay(5000).hide(0);
					}
				}
			});
		})
		
	</script>
</body>
</html><?php }} ?>
