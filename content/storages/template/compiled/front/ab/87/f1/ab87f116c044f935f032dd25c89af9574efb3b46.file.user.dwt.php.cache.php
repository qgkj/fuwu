<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:13:17
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\user.dwt.php" */ ?>
<?php /*%%SmartyHeaderCode:129359084dad6310d1-63000696%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ab87f116c044f935f032dd25c89af9574efb3b46' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\user.dwt.php',
      1 => 1493702264,
      2 => 'file',
    ),
    '82da2121fdb37456a3283f7cad77348dd221fdb5' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\ecjia-touch.dwt.php',
      1 => 1487583426,
      2 => 'file',
    ),
    '713f1b20b6f0f094caab3d1984ff1711ef5c26d1' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\model_bar.lbi.php',
      1 => 1487583427,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '129359084dad6310d1-63000696',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_title' => 1,
    'theme_url' => 1,
    'curr_style' => 1,
    'hidenav' => 1,
    'hidetab' => 1,
    'hideinfo' => 1,
  ),
  'has_nocache_code' => true,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_59084dad8eb2b1_75722817',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59084dad8eb2b1_75722817')) {function content_59084dad8eb2b1_75722817($_smarty_tpl) {?><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php $_smarty = $_smarty_tpl->smarty; if (!is_callable(\'smarty_function_url\')) include \'C:\\\\ecjia-daojia-29\\\\content\\\\system\\\\smarty\\\\function.url.php\';
if (!is_callable(\'smarty_block_t\')) include \'C:\\\\ecjia-daojia-29\\\\content\\\\system\\\\smarty\\\\block.t.php\';
?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if (!is_pjax()) {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if (is_ajax()) {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>


<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php } else { ?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta name="Generator" content="ECJIA 1.20" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="format-detection" content="telephone=no" />
	<title><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'page_title\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</title>
	<link href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if (ecjia::config(\'wap_logo\')) {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo RC_Upload::upload_url(ecjia::config(\'wap_logo\'));?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php } else { ?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
favicon.ico<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
" rel="shortcut icon bookmark">
	<link href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if (ecjia::config(\'wap_logo\')) {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo RC_Upload::upload_url(ecjia::config(\'wap_logo\'));?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php } else { ?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
favicon.ico<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
" rel="apple-touch-icon-precomposed">

	
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/bootstrap3/css/bootstrap.css">

	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
dist/css/iconfont.min.css">


	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
css/ecjia.touch.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
css/ecjia.touch.develop.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
css/ecjia.touch.b2b2c.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
css/ecjia_city.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
css/ecjia_help.css">
    
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
css/ecjia.touch.models.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
dist/other/swiper.min.css">
    <link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/datePicker/css/datePicker.min.css">
    <link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/winderCheck/css/winderCheck.min.css">
	
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'curr_style\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
	<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&libraries=convertor"></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/jquery/jquery.min.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/multi-select/js/jquery.quicksearch.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/jquery/jquery.pjax.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/jquery/jquery.cookie.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/iscroll/js/iscroll.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/bootstrap3/js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/ecjiaUI/ecjia.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/jquery-form/jquery.form.min.js" ></script>	

	

	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
js/ecjia.touch.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
js/ecjia.touch.history.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
js/ecjia.touch.others.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
js/ecjia.touch.goods.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
js/ecjia.touch.user.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
js/ecjia.touch.flow.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
js/ecjia.touch.merchant.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
js/ecjia.touch.b2b2c.js" ></script>

    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
js/ecjia.touch.goods_detail.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
js/ecjia.touch.spread.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
js/ecjia.touch.user_account.js" ></script>
    
    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
js/ecjia.touch.fly.js" ></script>
    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
js/ecjia.touch.intro.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/Validform/Validform_v5.3.2_min.js"></script>

	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/swiper/js/swiper.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/datePicker/js/datePicker.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
lib/winderCheck/js/winderCheck.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
js/greenCheck.js"></script>
</head>
<body>
	<div class="ecjia" id="get_location" data-url="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'location/index/get_location_msg\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
		
<div class="ecjia-user-info user-new-info ecjia-user">
    <?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if ($_smarty_tpl->tpl_vars[\'user\']->value) {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

    	<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/profile/init\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
"><div class="user-img ecjiaf-fl"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'user_img\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
" alt=""></a></div>
    	<div class="ecjiaf-fl ecjia-margin-l user-rank-name">
    		<span><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'user\']->value[\'name\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
    		<span class="ecjia-user-buttom"><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'user\']->value[\'rank_name\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
    	</div>
    	<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/user_message/msg_list\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
    		<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if ($_smarty_tpl->tpl_vars[\'order_num\']->value[\'msg_num\']) {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

    		<span class="ecjia-icon ecjia-icon ecjia-icon-num"><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'order_num\']->value[\'msg_num\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
    		<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

    	</a>
	<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php } else { ?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

	   	<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/privilege/login\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
"><div class="no-login">登录 / 注册</div></a>
	<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

</div>

<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if ($_smarty_tpl->tpl_vars[\'user\']->value[\'id\']) {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

<div class="ecjia-user-head ecjia-user ecjia-color-green ecjia-user-marg-t">
    <ul class="ecjia-user-marg-t ecjia-list list-short ecjia-user-no-border-t">
       <li>
        	<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/account/init\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
        		<div class="icon-wallet"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
/images/user_center/75x75_1.png"></div>
        		<span class="icon-name"><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php $_smarty_tpl->smarty->_tag_stack[] = array(\'t\', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
我的钱包<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
</div>
<div class="ecjia-user-border-b">
    <ul class="ecjia-user ecjia-list bonus ecjia-nav-child-f ecjia-list-three ecjia-login-nav-bottom">
    	<li>
    		<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/account/balance\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
    		    <p><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'user\']->value[\'formated_user_money\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</p>
    			<p>余额</p>
    		</a>
    	</li>
    	<li>
    		<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/bonus/init\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
    		    <p><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if ($_smarty_tpl->tpl_vars[\'user\']->value[\'user_bonus_count\']==\'0\') {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo 0;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php } else { ?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'user\']->value[\'user_bonus_count\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</p>
    			<p>红包</p>
    		</a>
    	</li>
    	<li>
    	    <a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/account/init\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
        		<p><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'user\']->value[\'user_points\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</p>
        		<p>积分</p>
    		</a>
    	</li>
    </ul>
</div>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php } else { ?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

<div class="ecjia-user-head ecjia-user ecjia-color-green ecjia-user-marg-t">
    <ul class="ecjia-user-marg-t ecjia-list list-short ecjia-user-no-border-t">
       <li>
        	<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/privilege/login\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
        		<div class="icon-wallet"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
/images/user_center/75x75_1.png"></div>
        		<span class="icon-name"><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php $_smarty_tpl->smarty->_tag_stack[] = array(\'t\', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
我的钱包<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
</div>
<div class="ecjia-user-border-b">
    <ul class="ecjia-user ecjia-list bonus ecjia-nav-child-f ecjia-list-three ecjia-login-nav-bottom">
    	<li>
    		<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/privilege/login\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
    		    <p><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo \'- -\';?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</p>
    			<p>余额</p>
    		</a>
    	</li>
    	<li>
    		<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/privilege/login\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
    		    <p><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo \'- -\';?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</p>
    			<p>红包</p>
    		</a>
    	</li>
    	<li>
    	    <a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/privilege/login\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
        		<p><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo \'- -\';?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</p>
        		<p>积分</p>
    		</a>
    	</li>
    </ul>
</div>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>


<div class="ecjia-user ecjia-margin-b">
    <ul class="ecjia-list list-short">
		<li>
			<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/address/address_list\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
        		<div class="icon-address-list"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
/images/user_center/75x75_3.png"></div>
        		<span class="icon-name">收货地址</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
		</li>
       	<li>
        	<a class="nopjax external" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/index/spread\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
&name=<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'user\']->value[\'name\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
        		<div class="icon-expand"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
/images/user_center/expand.png"></div>
        		<span class="icon-name">我的推广</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>

    <ul class="ecjia-list list-short">
        <li>
        	<a class="external" href="tel:xxx">
        		<div class="icon-website-service"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
/images/user_center/75x75_5.png"></div>
        		<span class="icon-name">联系客服</span>
        		<span class="icon-price"><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo \'xxx\';?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
        <!-- <li>
        	<a class="external" href="https://ecjia.com" target="_blank">
        		<div class="icon-offical-website"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
/images/user_center/75x75_6.png"></div>
        		<span class="icon-name">官网网站</span>
        		<span class="icon-price"><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo \'www.ecjia.com\';?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li> -->
    </ul>
   <!--  <ul class="ecjia-list list-short">
        <li>
        	<a class="external" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'article/help/init\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
        		<div class="icon-help-center"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
/images/user_center/help75_3.png"></div>
        		<span class="icon-name">帮助中心</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul> -->
    <!-- <ul class="ecjia-list list-short">
            <li>
            	<a class="external" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo RC_uri::url(\'article/shop/detail\');?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
&title=<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'value\']->value[\'title\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
&article_id=<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'value\']->value[\'id\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
            		<div class="icon-shop-info"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'value\']->value[\'image\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
"></div>
            		<span class="icon-name"><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'value\']->value[\'title\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
            		<i class="iconfont  icon-jiantou-right"></i>
            	</a>
            </li>
    </ul> -->
</div>
<?php /*  Call merged included template "library/model_bar.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_bar.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '129359084dad6310d1-63000696');
content_59084dad7eb939_61011199($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_bar.lbi.php" */?>

		<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->getSubTemplate ("library/page_menu.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

	</div>
	
	
	
<script type="text/javascript">
	ecjia.touch.user.init();
</script>

	<script type="text/javascript">
    	window.onunload = unload;
    	function unload (e){
    	  window.scrollTo(0,0);
    	}
	</script>
	<script type="text/javascript">
		var hidenav = <?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if ($_smarty_tpl->tpl_vars[\'hidenav\']->value==1) {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
1<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php } else { ?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
0<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
, hidetab = <?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if ($_smarty_tpl->tpl_vars[\'hidetab\']->value==1) {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
1<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php } else { ?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
0<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
, hideinfo = <?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if ($_smarty_tpl->tpl_vars[\'hideinfo\']->value) {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
1<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php } else { ?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
0<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
;
		if (hideinfo) {
			$('header').hide();
			$('footer').hide();
			$('.ecjia-menu').hide();
		} else {
			hidenav && $('header').hide();
			hidetab && $('footer').hide();
		}
	</script>
</body>
</html>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php } else { ?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

<title><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'page_title\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</title>


<div class="ecjia-user-info user-new-info ecjia-user">
    <?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if ($_smarty_tpl->tpl_vars[\'user\']->value) {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

    	<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/profile/init\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
"><div class="user-img ecjiaf-fl"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'user_img\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
" alt=""></a></div>
    	<div class="ecjiaf-fl ecjia-margin-l user-rank-name">
    		<span><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'user\']->value[\'name\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
    		<span class="ecjia-user-buttom"><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'user\']->value[\'rank_name\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
    	</div>
    	<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/user_message/msg_list\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
    		<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if ($_smarty_tpl->tpl_vars[\'order_num\']->value[\'msg_num\']) {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

    		<span class="ecjia-icon ecjia-icon ecjia-icon-num"><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'order_num\']->value[\'msg_num\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
    		<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

    	</a>
	<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php } else { ?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

	   	<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/privilege/login\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
"><div class="no-login">登录 / 注册</div></a>
	<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

</div>

<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if ($_smarty_tpl->tpl_vars[\'user\']->value[\'id\']) {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

<div class="ecjia-user-head ecjia-user ecjia-color-green ecjia-user-marg-t">
    <ul class="ecjia-user-marg-t ecjia-list list-short ecjia-user-no-border-t">
       <li>
        	<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/account/init\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
        		<div class="icon-wallet"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
/images/user_center/75x75_1.png"></div>
        		<span class="icon-name"><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php $_smarty_tpl->smarty->_tag_stack[] = array(\'t\', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
我的钱包<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
</div>
<div class="ecjia-user-border-b">
    <ul class="ecjia-user ecjia-list bonus ecjia-nav-child-f ecjia-list-three ecjia-login-nav-bottom">
    	<li>
    		<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/account/balance\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
    		    <p><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'user\']->value[\'formated_user_money\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</p>
    			<p>余额</p>
    		</a>
    	</li>
    	<li>
    		<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/bonus/init\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
    		    <p><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php if ($_smarty_tpl->tpl_vars[\'user\']->value[\'user_bonus_count\']==\'0\') {?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo 0;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php } else { ?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'user\']->value[\'user_bonus_count\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</p>
    			<p>红包</p>
    		</a>
    	</li>
    	<li>
    	    <a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/account/init\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
        		<p><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'user\']->value[\'user_points\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</p>
        		<p>积分</p>
    		</a>
    	</li>
    </ul>
</div>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php } else { ?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

<div class="ecjia-user-head ecjia-user ecjia-color-green ecjia-user-marg-t">
    <ul class="ecjia-user-marg-t ecjia-list list-short ecjia-user-no-border-t">
       <li>
        	<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/privilege/login\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
        		<div class="icon-wallet"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
/images/user_center/75x75_1.png"></div>
        		<span class="icon-name"><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php $_smarty_tpl->smarty->_tag_stack[] = array(\'t\', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
我的钱包<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
</div>
<div class="ecjia-user-border-b">
    <ul class="ecjia-user ecjia-list bonus ecjia-nav-child-f ecjia-list-three ecjia-login-nav-bottom">
    	<li>
    		<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/privilege/login\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
    		    <p><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo \'- -\';?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</p>
    			<p>余额</p>
    		</a>
    	</li>
    	<li>
    		<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/privilege/login\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
    		    <p><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo \'- -\';?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</p>
    			<p>红包</p>
    		</a>
    	</li>
    	<li>
    	    <a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/privilege/login\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
        		<p><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo \'- -\';?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</p>
        		<p>积分</p>
    		</a>
    	</li>
    </ul>
</div>
<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>


<div class="ecjia-user ecjia-margin-b">
    <ul class="ecjia-list list-short">
		<li>
			<a href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/address/address_list\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
        		<div class="icon-address-list"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
/images/user_center/75x75_3.png"></div>
        		<span class="icon-name">收货地址</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
		</li>
       	<li>
        	<a class="nopjax external" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/index/spread\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
&name=<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'user\']->value[\'name\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
        		<div class="icon-expand"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
/images/user_center/expand.png"></div>
        		<span class="icon-name">我的推广</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>

    <ul class="ecjia-list list-short">
        <li>
        	<a class="external" href="tel:xxx">
        		<div class="icon-website-service"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
/images/user_center/75x75_5.png"></div>
        		<span class="icon-name">联系客服</span>
        		<span class="icon-price"><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo \'xxx\';?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
        <!-- <li>
        	<a class="external" href="https://ecjia.com" target="_blank">
        		<div class="icon-offical-website"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
/images/user_center/75x75_6.png"></div>
        		<span class="icon-name">官网网站</span>
        		<span class="icon-price"><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo \'www.ecjia.com\';?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li> -->
    </ul>
   <!--  <ul class="ecjia-list list-short">
        <li>
        	<a class="external" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo smarty_function_url(array(\'path\'=>\'article/help/init\'),$_smarty_tpl);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
        		<div class="icon-help-center"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
/images/user_center/help75_3.png"></div>
        		<span class="icon-name">帮助中心</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul> -->
    <!-- <ul class="ecjia-list list-short">
            <li>
            	<a class="external" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo RC_uri::url(\'article/shop/detail\');?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
&title=<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'value\']->value[\'title\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
&article_id=<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'value\']->value[\'id\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
            		<div class="icon-shop-info"><img src="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'value\']->value[\'image\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
"></div>
            		<span class="icon-name"><?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'value\']->value[\'title\'];?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
</span>
            		<i class="iconfont  icon-jiantou-right"></i>
            	</a>
            </li>
    </ul> -->
</div>
<?php /*  Call merged included template "library/model_bar.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_bar.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '129359084dad6310d1-63000696');
content_59084dad7eb939_61011199($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_bar.lbi.php" */?>

<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->getSubTemplate ("library/page_menu.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>


<script type="text/javascript">
	ecjia.touch.user.init();
</script>

<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php }?>/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>

<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:13:17
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\model_bar.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084dad7eb939_61011199')) {function content_59084dad7eb939_61011199($_smarty_tpl) {?><div class="ecjia-mod ecjia-floor ecjia-bottom-bar-pannel o <?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo $_smarty_tpl->tpl_vars[\'active\']->value;?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">
	<a class="index" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo RC_Uri::url(\'touch/index/init\');?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">首页</a>
	<a class="category" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo RC_Uri::url(\'goods/category/init\');?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">分类</a>
	<a class="cartList" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo RC_Uri::url(\'cart/index/init\');?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">购物车</a>
	<a class="orderList" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo RC_Uri::url(\'user/order/order_list\');?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">订单</a>
	<a class="mine" href="<?php echo '/*%%SmartyNocache:129359084dad6310d1-63000696%%*/<?php echo RC_Uri::url(\'touch/my/init\');?>
/*/%%SmartyNocache:129359084dad6310d1-63000696%%*/';?>
">我的</a>
</div><?php }} ?>
