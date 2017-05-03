<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:01:16
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\index.dwt.php" */ ?>
<?php /*%%SmartyHeaderCode:3014959084adc9f8b01-16615198%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a20166c9122abebe93658af762588c8236a9660e' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\index.dwt.php',
      1 => 1487583428,
      2 => 'file',
    ),
    '82da2121fdb37456a3283f7cad77348dd221fdb5' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\ecjia-touch.dwt.php',
      1 => 1487583426,
      2 => 'file',
    ),
    '7b723a26394bd2a8eed69ae59f14ba0527d1ce70' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\index_header.lbi.php',
      1 => 1487583427,
      2 => 'file',
    ),
    'a7d832d4ce1633daa966014de7c4b9757b8dfff7' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\model_banner.lbi.php',
      1 => 1487583427,
      2 => 'file',
    ),
    'cfec3449d0f847b2a7d52da99388ed3356c8a9dc' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\model_nav.lbi.php',
      1 => 1487583427,
      2 => 'file',
    ),
    '709bb9d88fdd38725027baf32cb5263a771c4e30' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\model_adsense.lbi.php',
      1 => 1487583427,
      2 => 'file',
    ),
    '8337e3fbe8668ffcb0481128509d50302001c8ca' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\model_promotions.lbi.php',
      1 => 1493696724,
      2 => 'file',
    ),
    '7f97beba8e3757dfc0af6a1ce9a549e45fc90498' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\model_newgoods.lbi.php',
      1 => 1487583427,
      2 => 'file',
    ),
    'e774528e9f095831a18438d3da4bb0c02c6c2e3e' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\model_hotgoods.lbi.php',
      1 => 1487583427,
      2 => 'file',
    ),
    '713f1b20b6f0f094caab3d1984ff1711ef5c26d1' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\model_bar.lbi.php',
      1 => 1487583427,
      2 => 'file',
    ),
    '3fe483e2c59a07c30c7e8a38e768748a6adb0630' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\model_download.lbi.php',
      1 => 1493695387,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3014959084adc9f8b01-16615198',
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
  'unifunc' => 'content_59084adcd19ce3_52409576',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59084adcd19ce3_52409576')) {function content_59084adcd19ce3_52409576($_smarty_tpl) {?><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php $_smarty = $_smarty_tpl->smarty; if (!is_callable(\'smarty_function_url\')) include \'C:\\\\ecjia-daojia-29\\\\content\\\\system\\\\smarty\\\\function.url.php\';
?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if (!is_pjax()) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if (is_ajax()) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>


	
	<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php  $_smarty_tpl->tpl_vars[\'goods\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'goods\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'goods_list\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'goods\']->key => $_smarty_tpl->tpl_vars[\'goods\']->value) {
$_smarty_tpl->tpl_vars[\'goods\']->_loop = true;
?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

	<li class="single_item">
		<a class="list-page-goods-img" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo RC_Uri::url(\'goods/index/show\');?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
&goods_id=<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'goods\']->value[\'id\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">
			<span class="goods-img">
				<img src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'goods\']->value[\'img\'][\'thumb\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
" alt="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'goods\']->value[\'name\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">
			</span>
			<span class="list-page-box">
				<p class="merchants-name"><i class="iconfont icon-shop"></i><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'goods\']->value[\'seller_name\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</p>
				<span class="goods-name"><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'goods\']->value[\'name\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</span>
				<span class="list-page-goods-price">
					<span><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'goods\']->value[\'shop_price\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</span>
				</span>
			</span>
		</a>
	</li>
	<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

	

<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta name="Generator" content="ECJIA 1.20" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="format-detection" content="telephone=no" />
	<title><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'page_title\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</title>
	<link href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if (ecjia::config(\'wap_logo\')) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo RC_Upload::upload_url(ecjia::config(\'wap_logo\'));?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
favicon.ico<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
" rel="shortcut icon bookmark">
	<link href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if (ecjia::config(\'wap_logo\')) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo RC_Upload::upload_url(ecjia::config(\'wap_logo\'));?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
favicon.ico<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
" rel="apple-touch-icon-precomposed">

	
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/bootstrap3/css/bootstrap.css">

	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
dist/css/iconfont.min.css">


	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
css/ecjia.touch.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
css/ecjia.touch.develop.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
css/ecjia.touch.b2b2c.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
css/ecjia_city.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
css/ecjia_help.css">
    
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
css/ecjia.touch.models.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
dist/other/swiper.min.css">
    <link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/datePicker/css/datePicker.min.css">
    <link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/winderCheck/css/winderCheck.min.css">
	
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'curr_style\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">
	<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&libraries=convertor"></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/jquery/jquery.min.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/multi-select/js/jquery.quicksearch.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/jquery/jquery.pjax.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/jquery/jquery.cookie.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/iscroll/js/iscroll.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/bootstrap3/js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/ecjiaUI/ecjia.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/jquery-form/jquery.form.min.js" ></script>	

	

	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
js/ecjia.touch.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
js/ecjia.touch.history.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
js/ecjia.touch.others.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
js/ecjia.touch.goods.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
js/ecjia.touch.user.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
js/ecjia.touch.flow.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
js/ecjia.touch.merchant.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
js/ecjia.touch.b2b2c.js" ></script>

    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
js/ecjia.touch.goods_detail.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
js/ecjia.touch.spread.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
js/ecjia.touch.user_account.js" ></script>
    
    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
js/ecjia.touch.fly.js" ></script>
    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
js/ecjia.touch.intro.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/Validform/Validform_v5.3.2_min.js"></script>

	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/swiper/js/swiper.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/datePicker/js/datePicker.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
lib/winderCheck/js/winderCheck.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
js/greenCheck.js"></script>
</head>
<body>
	<div class="ecjia" id="get_location" data-url="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo smarty_function_url(array(\'path\'=>\'location/index/get_location_msg\'),$_smarty_tpl);?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">
		


<?php /*  Call merged included template "library/index_header.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/index_header.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcb98818_42062924($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/index_header.lbi.php" */?>
<?php /*  Call merged included template "library/model_banner.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_banner.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcbe89e0_78022732($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_banner.lbi.php" */?>
<?php /*  Call merged included template "library/model_nav.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_nav.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcbfbb14_26851705($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_nav.lbi.php" */?>
<?php /*  Call merged included template "library/model_adsense.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_adsense.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcc16653_53871005($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_adsense.lbi.php" */?>
<?php /*  Call merged included template "library/model_promotions.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_promotions.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcc3c8b7_47344322($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_promotions.lbi.php" */?>
<?php /*  Call merged included template "library/model_newgoods.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_newgoods.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcc5b103_28978991($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_newgoods.lbi.php" */?>
<?php /*  Call merged included template "library/model_hotgoods.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_hotgoods.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcc8ca89_26785096($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_hotgoods.lbi.php" */?>
<?php /*  Call merged included template "library/model_bar.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_bar.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcc98192_76599221($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_bar.lbi.php" */?>



<?php /*  Call merged included template "library/model_download.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_download.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adccc5e17_62165629($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_download.lbi.php" */?>



		<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->getSubTemplate ("library/page_menu.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

	</div>
	
	
	
<script type="text/javascript">
    ecjia.touch.index.init();
</script>

	<script type="text/javascript">
    	window.onunload = unload;
    	function unload (e){
    	  window.scrollTo(0,0);
    	}
	</script>
	<script type="text/javascript">
		var hidenav = <?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'hidenav\']->value==1) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
1<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
0<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
, hidetab = <?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'hidetab\']->value==1) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
1<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
0<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
, hideinfo = <?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'hideinfo\']->value) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
1<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
0<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
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
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

<title><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'page_title\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</title>




<?php /*  Call merged included template "library/index_header.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/index_header.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcb98818_42062924($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/index_header.lbi.php" */?>
<?php /*  Call merged included template "library/model_banner.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_banner.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcbe89e0_78022732($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_banner.lbi.php" */?>
<?php /*  Call merged included template "library/model_nav.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_nav.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcbfbb14_26851705($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_nav.lbi.php" */?>
<?php /*  Call merged included template "library/model_adsense.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_adsense.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcc16653_53871005($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_adsense.lbi.php" */?>
<?php /*  Call merged included template "library/model_promotions.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_promotions.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcc3c8b7_47344322($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_promotions.lbi.php" */?>
<?php /*  Call merged included template "library/model_newgoods.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_newgoods.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcc5b103_28978991($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_newgoods.lbi.php" */?>
<?php /*  Call merged included template "library/model_hotgoods.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_hotgoods.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcc8ca89_26785096($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_hotgoods.lbi.php" */?>
<?php /*  Call merged included template "library/model_bar.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_bar.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adcc98192_76599221($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_bar.lbi.php" */?>



<?php /*  Call merged included template "library/model_download.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_download.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '3014959084adc9f8b01-16615198');
content_59084adccc5e17_62165629($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_download.lbi.php" */?>



<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->getSubTemplate ("library/page_menu.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>


<script type="text/javascript">
    ecjia.touch.index.init();
</script>

<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:01:16
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\index_header.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084adcb98818_42062924')) {function content_59084adcb98818_42062924($_smarty_tpl) {?><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php $_smarty = $_smarty_tpl->smarty; if (!is_callable(\'smarty_function_url\')) include \'C:\\\\ecjia-daojia-29\\\\content\\\\system\\\\smarty\\\\function.url.php\';
?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'address\']->value) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

<div class="ecjia-mod ecjia-header ecjia-header-index" style="height:5.5em" id="location">
	<div class="ecjia-web">
		<div class="ecjia-address">
			<a href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php ob_start();?><?php if ($_GET[\'city\']) {?><?php echo (string)$_GET[\'city\'];?><?php } else { ?><?php echo "北京";?><?php }?><?php $_tmp1=ob_get_clean();?><?php echo smarty_function_url(array(\'path\'=>\'location/index/select_location\',\'args\'=>"city=".$_tmp1),$_smarty_tpl);?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
" >
			    <span><img src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
images/address_list/50x50_2l.png"></span>
				<span class="address-text"><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_COOKIE[\'location_name\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</span>
				<span><img src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
images/address_list/down.png"></span>
			</a>
		</div>
	</div>
	
	<div class="ecjia-search-header">
		<span class="bg search-goods" style="margin-top:2em;" data-url="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo RC_Uri::url(\'touch/index/search\');?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'store_id\']->value) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
&store_id=<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'store_id\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
" <?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'keywords\']->value!=\'\') {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
style="text-align: left;" data-val="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'keywords\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
"<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
>
			<i class="iconfont icon-search"></i><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'keywords\']->value!=\'\') {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<span class="keywords"><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'keywords\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</span><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'store_id\']->value) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
搜索店内商品<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
搜索附近门店<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

		</span>
	</div>
</div>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

<div class="ecjia-mod ecjia-header ecjia-header-index">
	<div class="ecjia-search-header">
		<span class="bg search-goods" data-url="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo RC_Uri::url(\'touch/index/search\');?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'store_id\']->value) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
&store_id=<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'store_id\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
" <?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'keywords\']->value!=\'\') {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
style="text-align: left;" data-val="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'keywords\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
"<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
>
			<i class="iconfont icon-search"></i><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'keywords\']->value!=\'\') {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<span class="keywords"><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'keywords\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</span><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'store_id\']->value) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
搜索店内商品<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
搜索附近门店<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

		</span>
	</div>
</div>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:01:16
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\model_banner.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084adcbe89e0_78022732')) {function content_59084adcbe89e0_78022732($_smarty_tpl) {?><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'cycleimage\']->value) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

<div class="ecjia-mod focus" id="focus">
	<div class="hd">
		<ul></ul>
	</div>
	<div class="bd">
		
		<div class="swiper-container swiper-touchIndex">
			<div class="swiper-wrapper">
				<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php  $_smarty_tpl->tpl_vars[\'img\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'img\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'cycleimage\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'img\']->key => $_smarty_tpl->tpl_vars[\'img\']->value) {
$_smarty_tpl->tpl_vars[\'img\']->_loop = true;
?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

				<div class="swiper-slide"><a target="_blank" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'img\']->value[\'url\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
"><img src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'img\']->value[\'photo\'][\'url\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
" /></a></div>
				<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

			</div>
			
			<div class="swiper-pagination"></div>
		</div>
	</div>
</div>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:01:16
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\model_nav.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084adcbfbb14_26851705')) {function content_59084adcbfbb14_26851705($_smarty_tpl) {?><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'navigator\']->value) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

<nav class="ecjia-mod container-fluid user-nav">
	<ul class="row ecjia-row-nav index">
		<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php  $_smarty_tpl->tpl_vars[\'nav\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'nav\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'navigator\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'nav\']->key => $_smarty_tpl->tpl_vars[\'nav\']->value) {
$_smarty_tpl->tpl_vars[\'nav\']->_loop = true;
?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

		<li class="col-sm-3 col-xs-2">
			<a href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'nav\']->value[\'url\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">
				<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'nav\']->value[\'image\']) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

				<img src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'nav\']->value[\'image\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
" />
				<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

				<img src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
dist/images/default_icon.png" alt="">
				<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

				<p class="text-center"><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'nav\']->value[\'text\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</p>
			</a>
		</li>
		<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

	</ul>
</nav>
<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:01:16
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\model_adsense.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084adcc16653_53871005')) {function content_59084adcc16653_53871005($_smarty_tpl) {?><div class="ecjia-mod">
	<ul class="ecjia-adsense-model">
	<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php  $_smarty_tpl->tpl_vars[\'val\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'val\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'adsense_group\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'val\']->key => $_smarty_tpl->tpl_vars[\'val\']->value) {
$_smarty_tpl->tpl_vars[\'val\']->_loop = true;
?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

		<li class="adsense-item">
			<div class="adsense-title">
				<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'val\']->value[\'title\']) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

				<h2><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'title\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</h2>
				<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

			</div>
			<ul class="adsense-group">
				<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php  $_smarty_tpl->tpl_vars[\'v\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'v\']->_loop = false;
 $_smarty_tpl->tpl_vars[\'key\'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars[\'val\']->value[\'adsense\']; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'v\']->key => $_smarty_tpl->tpl_vars[\'v\']->value) {
$_smarty_tpl->tpl_vars[\'v\']->_loop = true;
 $_smarty_tpl->tpl_vars[\'key\']->value = $_smarty_tpl->tpl_vars[\'v\']->key;
?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

				<li class="adsense-single <?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'val\']->value[\'count\']==3) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
img-th-item<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } elseif ((($_smarty_tpl->tpl_vars[\'val\']->value[\'count\']==1||$_smarty_tpl->tpl_vars[\'val\']->value[\'count\']==4)&&$_smarty_tpl->tpl_vars[\'key\']->value>0)) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
img-item<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">
					<a href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'url\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
"><img src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'image\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
"></a>
				</li>
				<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

			</ul>
		</li>
	<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

	</ul>
</div>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:01:16
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\model_promotions.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084adcc3c8b7_47344322')) {function content_59084adcc3c8b7_47344322($_smarty_tpl) {?><div class="ecjia-mod ecjia-promotion-model ecjia-margin-t">
	<div class="hd ecjia-sales-hd">
		<h2><i class="icon-goods-promotion"></i>促销商品<a href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'more_sales\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
" class="more_info">更多</a></h2>
	</div>
	<div class="swiper-container swiper-promotion">
		<div class="swiper-wrapper">
			<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php  $_smarty_tpl->tpl_vars[\'val\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'val\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'promotion_goods\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'val\']->key => $_smarty_tpl->tpl_vars[\'val\']->value) {
$_smarty_tpl->tpl_vars[\'val\']->_loop = true;
?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

			<div class="swiper-slide">
				<a class="list-page-goods-img" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo RC_Uri::url(\'goods/index/show\');?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
&goods_id=<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'id\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">
					<span class="goods-img">
                        <img src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'img\'][\'thumb\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
" alt="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'name\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">
                        <span class="promote-time" value="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'promote_end_date\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
"></span>
                    </span>
					<span class="list-page-box">
						<span class="goods-name"><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'name\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</span>
						<span class="list-page-goods-price">
							<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'val\']->value[\'promote_price\']) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

							<span><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'promote_price\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</span>
							<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

							<span><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'shop_price\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</span>
							<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

							<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'val\']->value[\'shop_price\']) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

                    		<span><del><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'shop_price\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</del></span>
                    		<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

						</span>
					</span>
				</a>
				<img class="sales-icon" src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
images/icon-promote@2x.png">
			</div>
			<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

		</div>
	</div>
</div>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:01:16
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\model_newgoods.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084adcc5b103_28978991')) {function content_59084adcc5b103_28978991($_smarty_tpl) {?><div class="ecjia-mod ecjia-promotion-model ecjia-margin-t">
	<div class="hd ecjia-sales-hd ecjia-new-goods">
		<h2><i class="icon-goods-new"></i>新品推荐<a href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'more_news\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
" class="more_info">更多</a></h2>
	</div>
	<div class="swiper-container swiper-promotion">
		<div class="swiper-wrapper">
			<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php  $_smarty_tpl->tpl_vars[\'val\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'val\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'new_goods\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'val\']->key => $_smarty_tpl->tpl_vars[\'val\']->value) {
$_smarty_tpl->tpl_vars[\'val\']->_loop = true;
?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

			<div class="swiper-slide">
				<a class="list-page-goods-img" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo RC_Uri::url(\'goods/index/show\');?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
&goods_id=<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'id\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">
					<span class="goods-img"><img src="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'img\'][\'thumb\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
" alt="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'name\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
"></span>
					<span class="list-page-box">
						<span class="goods-name"><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'name\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</span>
						<span class="list-page-goods-price">
							<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php if ($_smarty_tpl->tpl_vars[\'val\']->value[\'promote_price\']) {?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

							<span><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'promote_price\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</span>
							<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } else { ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

							<span><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'shop_price\'];?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
</span>
							<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php }?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

						</span>
					</span>
				</a>
			</div>
			<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php } ?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>

		</div>
	</div>
</div>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:01:16
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\model_hotgoods.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084adcc8ca89_26785096')) {function content_59084adcc8ca89_26785096($_smarty_tpl) {?><?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php $_smarty = $_smarty_tpl->smarty; if (!is_callable(\'smarty_function_url\')) include \'C:\\\\ecjia-daojia-29\\\\content\\\\system\\\\smarty\\\\function.url.php\';
?>/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
<div class="ecjia-mod ecjia-margin-b goods-index-list ecjia-new-goods" style="border-bottom:none;" >
	<div class="hd">
		<h2>
			<span class="line"></span>
			<span class="goods-index-title"><i class="icon-goods-hot"></i>热门推荐</span>
		</h2>
	</div>
	<div class="bd">
		<ul class="ecjia-list ecjia-list-two list-page-two" id="J_ItemList" data-toggle="asynclist" data-loadimg="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
dist/images/loader.gif" data-url="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo smarty_function_url(array(\'path\'=>\'index/ajax_goods\',\'args\'=>\'type=hot\'),$_smarty_tpl);?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
" >
		</ul>
	</div>
</div>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:01:16
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\model_bar.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084adcc98192_76599221')) {function content_59084adcc98192_76599221($_smarty_tpl) {?><div class="ecjia-mod ecjia-floor ecjia-bottom-bar-pannel o <?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo $_smarty_tpl->tpl_vars[\'active\']->value;?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">
	<a class="index" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo RC_Uri::url(\'touch/index/init\');?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">首页</a>
	<a class="category" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo RC_Uri::url(\'goods/category/init\');?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">分类</a>
	<a class="cartList" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo RC_Uri::url(\'cart/index/init\');?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">购物车</a>
	<a class="orderList" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo RC_Uri::url(\'user/order/order_list\');?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">订单</a>
	<a class="mine" href="<?php echo '/*%%SmartyNocache:3014959084adc9f8b01-16615198%%*/<?php echo RC_Uri::url(\'touch/my/init\');?>
/*/%%SmartyNocache:3014959084adc9f8b01-16615198%%*/';?>
">我的</a>
</div><?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:01:16
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\model_download.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084adccc5e17_62165629')) {function content_59084adccc5e17_62165629($_smarty_tpl) {?><?php }} ?>
