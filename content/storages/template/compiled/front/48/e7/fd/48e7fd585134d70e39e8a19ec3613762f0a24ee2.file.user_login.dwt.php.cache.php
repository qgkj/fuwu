<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 11:52:17
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\user_login.dwt.php" */ ?>
<?php /*%%SmartyHeaderCode:30210590872f1283d32-93097057%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '48e7fd585134d70e39e8a19ec3613762f0a24ee2' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\user_login.dwt.php',
      1 => 1487583428,
      2 => 'file',
    ),
    '82da2121fdb37456a3283f7cad77348dd221fdb5' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\ecjia-touch.dwt.php',
      1 => 1487583426,
      2 => 'file',
    ),
    '23e0c64644d7ba1fdf43d136c86410a4909df1ee' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\page_header.lbi.php',
      1 => 1487583427,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '30210590872f1283d32-93097057',
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
  'unifunc' => 'content_590872f14b0bc0_13365661',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590872f14b0bc0_13365661')) {function content_590872f14b0bc0_13365661($_smarty_tpl) {?><?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php $_smarty = $_smarty_tpl->smarty; if (!is_callable(\'smarty_function_url\')) include \'C:\\\\ecjia-daojia-29\\\\content\\\\system\\\\smarty\\\\function.url.php\';
?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>

<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php if (!is_pjax()) {?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>

<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php if (is_ajax()) {?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>


<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php } else { ?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta name="Generator" content="ECJIA 1.20" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="format-detection" content="telephone=no" />
	<title><?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'page_title\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
</title>
	<link href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php if (ecjia::config(\'wap_logo\')) {?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo RC_Upload::upload_url(ecjia::config(\'wap_logo\'));?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php } else { ?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
favicon.ico<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php }?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
" rel="shortcut icon bookmark">
	<link href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php if (ecjia::config(\'wap_logo\')) {?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo RC_Upload::upload_url(ecjia::config(\'wap_logo\'));?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php } else { ?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
favicon.ico<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php }?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
" rel="apple-touch-icon-precomposed">

	
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/bootstrap3/css/bootstrap.css">

	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
dist/css/iconfont.min.css">


	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
css/ecjia.touch.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
css/ecjia.touch.develop.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
css/ecjia.touch.b2b2c.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
css/ecjia_city.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
css/ecjia_help.css">
    
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
css/ecjia.touch.models.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
dist/other/swiper.min.css">
    <link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/datePicker/css/datePicker.min.css">
    <link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/winderCheck/css/winderCheck.min.css">
	
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'curr_style\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
">
	<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&libraries=convertor"></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/jquery/jquery.min.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/multi-select/js/jquery.quicksearch.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/jquery/jquery.pjax.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/jquery/jquery.cookie.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/iscroll/js/iscroll.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/bootstrap3/js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/ecjiaUI/ecjia.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/jquery-form/jquery.form.min.js" ></script>	

	

	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
js/ecjia.touch.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
js/ecjia.touch.history.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
js/ecjia.touch.others.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
js/ecjia.touch.goods.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
js/ecjia.touch.user.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
js/ecjia.touch.flow.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
js/ecjia.touch.merchant.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
js/ecjia.touch.b2b2c.js" ></script>

    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
js/ecjia.touch.goods_detail.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
js/ecjia.touch.spread.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
js/ecjia.touch.user_account.js" ></script>
    
    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
js/ecjia.touch.fly.js" ></script>
    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
js/ecjia.touch.intro.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/Validform/Validform_v5.3.2_min.js"></script>

	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/swiper/js/swiper.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/datePicker/js/datePicker.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
lib/winderCheck/js/winderCheck.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
js/greenCheck.js"></script>
</head>
<body>
	<div class="ecjia" id="get_location" data-url="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo smarty_function_url(array(\'path\'=>\'location/index/get_location_msg\'),$_smarty_tpl);?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
">
		
<?php /*  Call merged included template "library/page_header.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/page_header.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '30210590872f1283d32-93097057');
content_590872f1408e63_94098987($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/page_header.lbi.php" */?>
<div class="ecjia-form  ecjia-login">
	<div class="user-img"><img src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'user_img\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
"></div>
	<div class="form-group margin-right-left">
		<label class="input">
			<i class="iconfont icon-dengluyonghuming"></i>
			<input placeholder="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'lang\']->value[\'name_or_mobile\'];?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
" name="username">
		</label>
	</div>
	<div class="form-group ecjia-margin-t margin-right-left">
		<label class="input">
			<i class="iconfont icon-lock "></i>
			<i class="iconfont icon-attention ecjia-login-margin-l" id="password1"></i>
			<input placeholder="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'lang\']->value[\'input_passwd\'];?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
" id="password-1" name="password" type="password">
		</label>
	</div>
	<div class="ecjia-login-login-foot ecjia-margin-b">
		<a class="ecjiaf-fr ecjia-margin-t" href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/get_password/mobile_register\'),$_smarty_tpl);?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
"><?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'lang\']->value[\'forgot_password\'];?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
?</a>
	</div>
    <div class="around">
        <input type="hidden" name="referer_url" value="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_GET[\'referer_url\'];?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
" />
        <input type="button" class="btn btn-info login-btn" name="ecjia-login" value="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'lang\']->value[\'login\'];?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
" data-url="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/privilege/signin\'),$_smarty_tpl);?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
"/>
    </div>
    <p class="ecjiaf-tac">其他帐号登录</p>
	<ul class="thirdparty-wrap">
    	<a href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo smarty_function_url(array(\'path\'=>\'connect/index/init\',\'args\'=>\'connect_code=sns_qq\'),$_smarty_tpl);?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
"><li class="thirdparty-qq"></li></a>
    	<a href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo smarty_function_url(array(\'path\'=>\'connect/index/init\',\'args\'=>\'connect_code=sns_wechat&login_type=platform_userinfo\'),$_smarty_tpl);?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
"><li class="thirdparty-weixin"></li></a>
	</ul>
</div>

		<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->getSubTemplate ("library/page_menu.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>

	</div>
	
	
	
<script type="text/javascript">ecjia.touch.user.init();</script>

	<script type="text/javascript">
    	window.onunload = unload;
    	function unload (e){
    	  window.scrollTo(0,0);
    	}
	</script>
	<script type="text/javascript">
		var hidenav = <?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php if ($_smarty_tpl->tpl_vars[\'hidenav\']->value==1) {?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
1<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php } else { ?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
0<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php }?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
, hidetab = <?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php if ($_smarty_tpl->tpl_vars[\'hidetab\']->value==1) {?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
1<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php } else { ?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
0<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php }?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
, hideinfo = <?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php if ($_smarty_tpl->tpl_vars[\'hideinfo\']->value) {?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
1<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php } else { ?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
0<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php }?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
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
<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php }?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>

<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php } else { ?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>

<title><?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'page_title\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
</title>


<?php /*  Call merged included template "library/page_header.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/page_header.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '30210590872f1283d32-93097057');
content_590872f1408e63_94098987($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/page_header.lbi.php" */?>
<div class="ecjia-form  ecjia-login">
	<div class="user-img"><img src="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'user_img\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
"></div>
	<div class="form-group margin-right-left">
		<label class="input">
			<i class="iconfont icon-dengluyonghuming"></i>
			<input placeholder="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'lang\']->value[\'name_or_mobile\'];?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
" name="username">
		</label>
	</div>
	<div class="form-group ecjia-margin-t margin-right-left">
		<label class="input">
			<i class="iconfont icon-lock "></i>
			<i class="iconfont icon-attention ecjia-login-margin-l" id="password1"></i>
			<input placeholder="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'lang\']->value[\'input_passwd\'];?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
" id="password-1" name="password" type="password">
		</label>
	</div>
	<div class="ecjia-login-login-foot ecjia-margin-b">
		<a class="ecjiaf-fr ecjia-margin-t" href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/get_password/mobile_register\'),$_smarty_tpl);?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
"><?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'lang\']->value[\'forgot_password\'];?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
?</a>
	</div>
    <div class="around">
        <input type="hidden" name="referer_url" value="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_GET[\'referer_url\'];?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
" />
        <input type="button" class="btn btn-info login-btn" name="ecjia-login" value="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'lang\']->value[\'login\'];?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
" data-url="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/privilege/signin\'),$_smarty_tpl);?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
"/>
    </div>
    <p class="ecjiaf-tac">其他帐号登录</p>
	<ul class="thirdparty-wrap">
    	<a href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo smarty_function_url(array(\'path\'=>\'connect/index/init\',\'args\'=>\'connect_code=sns_qq\'),$_smarty_tpl);?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
"><li class="thirdparty-qq"></li></a>
    	<a href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo smarty_function_url(array(\'path\'=>\'connect/index/init\',\'args\'=>\'connect_code=sns_wechat&login_type=platform_userinfo\'),$_smarty_tpl);?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
"><li class="thirdparty-weixin"></li></a>
	</ul>
</div>

<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->getSubTemplate ("library/page_menu.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>


<script type="text/javascript">ecjia.touch.user.init();</script>

<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php }?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>

<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 11:52:17
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\page_header.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_590872f1408e63_94098987')) {function content_590872f1408e63_94098987($_smarty_tpl) {?><header class="ecjia-header">
	<div class="ecjia-header-left">
	</div>
	<div class="ecjia-header-title"><?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'title\']->value;?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
</div>
	<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php if ($_smarty_tpl->tpl_vars[\'header_right\']->value) {?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>

	<div class="ecjia-header-right">
		<a href="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'header_right\']->value[\'href\'];?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
">
			<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php if ($_smarty_tpl->tpl_vars[\'header_right\']->value[\'icon\']!=\'\') {?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>

			<i class="<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'header_left\']->value[\'icon\'];?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
"></i>
			<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php } elseif ($_smarty_tpl->tpl_vars[\'header_right\']->value[\'info\']!=\'\') {?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>

			<span><?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php echo $_smarty_tpl->tpl_vars[\'header_right\']->value[\'info\'];?>
/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>
</span>
			<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php }?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>

		</a>
	</div>
	<?php echo '/*%%SmartyNocache:30210590872f1283d32-93097057%%*/<?php }?>/*/%%SmartyNocache:30210590872f1283d32-93097057%%*/';?>

</header>
<?php }} ?>
