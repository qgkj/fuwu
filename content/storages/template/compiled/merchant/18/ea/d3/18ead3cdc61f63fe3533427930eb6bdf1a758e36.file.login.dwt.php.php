<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 05:19:02
         compiled from "C:\ecjia-daojia-29\content\apps\staff\templates\merchant\login.dwt.php" */ ?>
<?php /*%%SmartyHeaderCode:17935590816c63f05b8-83050971%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '18ead3cdc61f63fe3533427930eb6bdf1a758e36' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\staff\\templates\\merchant\\login.dwt.php',
      1 => 1487583420,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17935590816c63f05b8-83050971',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ur_here' => 0,
    'shop_name' => 0,
    'form_action' => 0,
    'logo_display' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_590816c645efd3_92015616',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590816c645efd3_92015616')) {function content_590816c645efd3_92015616($_smarty_tpl) {?><?php if (!is_callable('smarty_function_hook')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.hook.php';
if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
?><!DOCTYPE html>
<html class="login_page" lang="zh">
<head>
<meta name="Generator" content="ECJIA 1.20" />
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title><?php if ($_smarty_tpl->tpl_vars['ur_here']->value) {?><?php echo $_smarty_tpl->tpl_vars['ur_here']->value;?>
 - <?php }?><?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
</title>
	<?php echo smarty_function_hook(array('id'=>'merchant_print_styles'),$_smarty_tpl);?>

    <?php echo smarty_function_hook(array('id'=>'merchant_print_scripts'),$_smarty_tpl);?>

    

</head>
<body>
    <div class="container">
        <form class="form-login" action="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
" method="post" id="login_form" name="theForm">
         <div class="error-msg"></div>
         <div class="store_logo"><?php echo $_smarty_tpl->tpl_vars['logo_display']->value;?>
</div>
            <h2 class="form-login-heading">商家登录</h2>
            <div class="login-wrap">
                <input type="text" class="form-control"  id="mobile" name="mobile" placeholder="手机号" value="" autofocus>
                <input type="password" id="password" name="password" class="form-control"  value="" placeholder="密码">
                <?php echo smarty_function_hook(array('id'=>'merchant_login_captcha'),$_smarty_tpl);?>

                <div class="checkbox">
                     <input id="remember" type="checkbox" name="remember" value="remember-me">
                     <label for="remember">记住我</label>
                </div>
                <input type="hidden" name="act" value="signin" />
                <button class="btn btn-lg btn-block btn-primary" type="submit">进入管理中心</button>
                <div  class="text-center" style="margin-top: 10px;">
                    <a href="<?php echo smarty_function_url(array('path'=>'staff/get_password/forget_fast'),$_smarty_tpl);?>
">忘记密码？</a>
                </div>
            </div>
        </form>
    </div>
    <?php echo smarty_function_hook(array('id'=>'merchant_print_footer_scripts'),$_smarty_tpl);?>

    <script>
		
		$(document).ready(function(){
			//* boxes animation 开场动画
			form_wrapper = $('.container');
			form_wrapper.animate({ marginTop : ( - ( form_wrapper.height() / 3) - 24) },500);	
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
						var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
						$info.appendTo('.error-msg').delay(5000).hide(0);
					}
				}
			});
		})
		
	</script>
</body>
</html>	<?php }} ?>
