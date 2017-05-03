<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 12:24:56
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\cart_list.dwt.php" */ ?>
<?php /*%%SmartyHeaderCode:1890059087a98727c16-31806111%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2442dced770a1635756bd43c91e1494bc238c753' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\cart_list.dwt.php',
      1 => 1487583426,
      2 => 'file',
    ),
    '82da2121fdb37456a3283f7cad77348dd221fdb5' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\ecjia-touch.dwt.php',
      1 => 1487583426,
      2 => 'file',
    ),
    '033e665d380e7c78702b36b313eb858ad8ef2ebc' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\choose_address_modal.lbi.php',
      1 => 1487583427,
      2 => 'file',
    ),
    '713f1b20b6f0f094caab3d1984ff1711ef5c26d1' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\model_bar.lbi.php',
      1 => 1487583427,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1890059087a98727c16-31806111',
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
  'unifunc' => 'content_59087a98a48df1_54954365',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59087a98a48df1_54954365')) {function content_59087a98a48df1_54954365($_smarty_tpl) {?><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php $_smarty = $_smarty_tpl->smarty; if (!is_callable(\'smarty_function_url\')) include \'C:\\\\ecjia-daojia-29\\\\content\\\\system\\\\smarty\\\\function.url.php\';
if (!is_callable(\'smarty_block_t\')) include \'C:\\\\ecjia-daojia-29\\\\content\\\\system\\\\smarty\\\\block.t.php\';
?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if (!is_pjax()) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if (is_ajax()) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>


<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta name="Generator" content="ECJIA 1.20" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="format-detection" content="telephone=no" />
	<title><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'page_title\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</title>
	<link href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if (ecjia::config(\'wap_logo\')) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Upload::upload_url(ecjia::config(\'wap_logo\'));?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
favicon.ico<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" rel="shortcut icon bookmark">
	<link href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if (ecjia::config(\'wap_logo\')) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Upload::upload_url(ecjia::config(\'wap_logo\'));?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
favicon.ico<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" rel="apple-touch-icon-precomposed">

	
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/bootstrap3/css/bootstrap.css">

	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
dist/css/iconfont.min.css">


	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
css/ecjia.touch.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
css/ecjia.touch.develop.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
css/ecjia.touch.b2b2c.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
css/ecjia_city.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
css/ecjia_help.css">
    
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
css/ecjia.touch.models.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
dist/other/swiper.min.css">
    <link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/datePicker/css/datePicker.min.css">
    <link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/winderCheck/css/winderCheck.min.css">
	
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'curr_style\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
	<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&libraries=convertor"></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/jquery/jquery.min.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/multi-select/js/jquery.quicksearch.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/jquery/jquery.pjax.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/jquery/jquery.cookie.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/iscroll/js/iscroll.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/bootstrap3/js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/ecjiaUI/ecjia.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/jquery-form/jquery.form.min.js" ></script>	

	

	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
js/ecjia.touch.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
js/ecjia.touch.history.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
js/ecjia.touch.others.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
js/ecjia.touch.goods.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
js/ecjia.touch.user.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
js/ecjia.touch.flow.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
js/ecjia.touch.merchant.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
js/ecjia.touch.b2b2c.js" ></script>

    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
js/ecjia.touch.goods_detail.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
js/ecjia.touch.spread.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
js/ecjia.touch.user_account.js" ></script>
    
    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
js/ecjia.touch.fly.js" ></script>
    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
js/ecjia.touch.intro.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/Validform/Validform_v5.3.2_min.js"></script>

	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/swiper/js/swiper.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/datePicker/js/datePicker.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
lib/winderCheck/js/winderCheck.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
js/greenCheck.js"></script>
</head>
<body>
	<div class="ecjia" id="get_location" data-url="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo smarty_function_url(array(\'path\'=>\'location/index/get_location_msg\'),$_smarty_tpl);?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
		
<a href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'location/index/select_location\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'referer_url\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
&referer_url=<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'referer_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
	<div class="flow-address flow-cart <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'address_id\']->value==0||!$_smarty_tpl->tpl_vars[\'address_id\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
location_address<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
		<label class="ecjiaf-fl"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php $_smarty_tpl->smarty->_tag_stack[] = array(\'t\', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
送至：<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</label>
		<div class="ecjiaf-fl address-info">
			<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'address_id\']->value>0) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

				<span><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'address_info\']->value[\'consignee\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</span>
				<span><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'address_info\']->value[\'mobile\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</span>
				<p class="ecjia-truncate2 address-desc"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'address_info\']->value[\'address\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'address_info\']->value[\'address_info\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</p>
			<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

				<span><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_COOKIE[\'location_name\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</span>
			<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

		</div>
	</div>
</a>

<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if (!$_smarty_tpl->tpl_vars[\'not_login\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

	<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'cart_list\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

	<div class="ecjia-flow-cart">
		<ul>
			<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php  $_smarty_tpl->tpl_vars[\'val\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'val\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'cart_list\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'val\']->key => $_smarty_tpl->tpl_vars[\'val\']->value) {
$_smarty_tpl->tpl_vars[\'val\']->_loop = true;
?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

			<li class="cart-single">
				<div class="item">
					<div class="check-wrapper">
						<span class="cart-checkbox check_all <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'val\']->value[\'total\'][\'check_all\']==1) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
checked<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" id="store_check_<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-store="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"></span>
					</div>
					<div class="shop-title-content">
						<a href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'merchant/index/init\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
&store_id=<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
							<span class="shop-title-name"><i class="iconfont icon-shop"></i><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_name\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</span>
							<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'val\']->value[\'manage_mode\']==\'self\') {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<span class="self-store">自营</span><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

						</a>
						<span class="shop-edit" data-store="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-type="edit">编辑</span>
					</div>
				</div>
				<ul class="items">
					<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php  $_smarty_tpl->tpl_vars[\'v\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'v\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'val\']->value[\'goods_list\']; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'v\']->key => $_smarty_tpl->tpl_vars[\'v\']->value) {
$_smarty_tpl->tpl_vars[\'v\']->_loop = true;
?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

					<li class="item-goods cart_item_<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
 <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_disabled\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
disabled<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
						<span class="cart-checkbox checkbox_<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
 <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_checked\']==1) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
checked<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
 <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_disabled\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
disabled<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-store="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" rec_id="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'rec_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" goods_id="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-num="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_number\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"></span>
						<div class="cart-product">
							<a class="cart-product-photo" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'goods/index/show\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
&goods_id=<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
								<img src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'img\'][\'thumb\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
								<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_disabled\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

								<div class="product_empty">库存不足</div>
								<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

							</a>
							<div class="cart-product-info">
								<div class="cart-product-name <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_disabled\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
disabled<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"><a href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'goods/index/show\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
&goods_id=<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_name\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</a></div>
								<div class="cart-product-price <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_disabled\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
disabled<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'goods_price\']==0) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
免费<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'formated_goods_price\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</div>
								<div class="ecjia-input-number input_number_<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
 <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_disabled\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
disabled<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-store="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
			                        <span class="ecjia-number-group-addon" data-toggle="remove-to-cart" rec_id="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'rec_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" goods_id="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">－</span>
			                        <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_disabled\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

			                        <span class="ecjia-number-contro"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_number\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</span>
			                        <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

			                        <input type="tel" class="ecjia-number-contro" value="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_number\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" autocomplete="off" rec_id="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'rec_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"/>
			                        <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

			                        <span class="ecjia-number-group-addon" data-toggle="add-to-cart" rec_id="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'rec_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" goods_id="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">＋</span>
			                    </div>
							</div>
						</div>
					</li>
					<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

				</ul>
				<div class="item-count">
					<span class="count">合计：</span>
					<span class="price price_<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'total\'][\'goods_price\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'val\']->value[\'total\'][\'discount\']!=0) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<lable class="discount">(已减<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'total\'][\'discount\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
)</lable><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</span>
					<a class="check_cart check_cart_<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
 <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if (!$_smarty_tpl->tpl_vars[\'val\']->value[\'total\'][\'check_one\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
disabled<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'cart/flow/checkout\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-store="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-address="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'address_id\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-rec="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'total\'][\'data_rec\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" href="javascript:;">去结算</a>
				</div>
			</li>
			<input type="hidden" name="update_cart_url" value="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'cart/index/update_cart\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
			<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

		</ul>
		<div class="flow-nomore-msg"></div>
	</div>
	<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

<div class="flow-no-pro <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'cart_list\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
hide<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } elseif ($_smarty_tpl->tpl_vars[\'no_login\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
show<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
	<div class="ecjia-nolist">
		您还没有添加商品
		<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'not_login\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

		<a class="btn btn-small" type="button" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/user_privilege/login\'),$_smarty_tpl);?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'referer_url\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
&referer_url=<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'referer_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php $_smarty_tpl->smarty->_tag_stack[] = array(\'t\', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
点击登录<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</a>
		<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

		<a class="btn btn-small" type="button" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo smarty_function_url(array(\'path\'=>\'touch/index/init\'),$_smarty_tpl);?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php $_smarty_tpl->smarty->_tag_stack[] = array(\'t\', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
去逛逛<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</a>
		<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

	</div>
</div>
<?php /*  Call merged included template "library/choose_address_modal.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/choose_address_modal.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '1890059087a98727c16-31806111');
content_59087a988f92a6_65454971($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/choose_address_modal.lbi.php" */?>
<?php /*  Call merged included template "library/model_bar.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_bar.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '1890059087a98727c16-31806111');
content_59087a9892ac29_53714487($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_bar.lbi.php" */?>

		<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->getSubTemplate ("library/page_menu.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

	</div>
	
	
	
<script type="text/javascript">ecjia.touch.category.init();</script>

	<script type="text/javascript">
    	window.onunload = unload;
    	function unload (e){
    	  window.scrollTo(0,0);
    	}
	</script>
	<script type="text/javascript">
		var hidenav = <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'hidenav\']->value==1) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
1<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
0<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
, hidetab = <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'hidetab\']->value==1) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
1<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
0<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
, hideinfo = <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'hideinfo\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
1<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
0<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
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
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

<title><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'page_title\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</title>


<a href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'location/index/select_location\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'referer_url\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
&referer_url=<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'referer_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
	<div class="flow-address flow-cart <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'address_id\']->value==0||!$_smarty_tpl->tpl_vars[\'address_id\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
location_address<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
		<label class="ecjiaf-fl"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php $_smarty_tpl->smarty->_tag_stack[] = array(\'t\', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
送至：<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</label>
		<div class="ecjiaf-fl address-info">
			<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'address_id\']->value>0) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

				<span><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'address_info\']->value[\'consignee\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</span>
				<span><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'address_info\']->value[\'mobile\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</span>
				<p class="ecjia-truncate2 address-desc"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'address_info\']->value[\'address\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'address_info\']->value[\'address_info\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</p>
			<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

				<span><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_COOKIE[\'location_name\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</span>
			<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

		</div>
	</div>
</a>

<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if (!$_smarty_tpl->tpl_vars[\'not_login\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

	<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'cart_list\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

	<div class="ecjia-flow-cart">
		<ul>
			<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php  $_smarty_tpl->tpl_vars[\'val\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'val\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'cart_list\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'val\']->key => $_smarty_tpl->tpl_vars[\'val\']->value) {
$_smarty_tpl->tpl_vars[\'val\']->_loop = true;
?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

			<li class="cart-single">
				<div class="item">
					<div class="check-wrapper">
						<span class="cart-checkbox check_all <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'val\']->value[\'total\'][\'check_all\']==1) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
checked<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" id="store_check_<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-store="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"></span>
					</div>
					<div class="shop-title-content">
						<a href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'merchant/index/init\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
&store_id=<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
							<span class="shop-title-name"><i class="iconfont icon-shop"></i><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_name\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</span>
							<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'val\']->value[\'manage_mode\']==\'self\') {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<span class="self-store">自营</span><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

						</a>
						<span class="shop-edit" data-store="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-type="edit">编辑</span>
					</div>
				</div>
				<ul class="items">
					<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php  $_smarty_tpl->tpl_vars[\'v\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'v\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'val\']->value[\'goods_list\']; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'v\']->key => $_smarty_tpl->tpl_vars[\'v\']->value) {
$_smarty_tpl->tpl_vars[\'v\']->_loop = true;
?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

					<li class="item-goods cart_item_<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
 <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_disabled\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
disabled<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
						<span class="cart-checkbox checkbox_<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
 <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_checked\']==1) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
checked<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
 <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_disabled\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
disabled<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-store="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" rec_id="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'rec_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" goods_id="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-num="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_number\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"></span>
						<div class="cart-product">
							<a class="cart-product-photo" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'goods/index/show\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
&goods_id=<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
								<img src="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'img\'][\'thumb\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
								<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_disabled\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

								<div class="product_empty">库存不足</div>
								<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

							</a>
							<div class="cart-product-info">
								<div class="cart-product-name <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_disabled\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
disabled<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"><a href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'goods/index/show\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
&goods_id=<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_name\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</a></div>
								<div class="cart-product-price <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_disabled\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
disabled<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'goods_price\']==0) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
免费<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'formated_goods_price\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</div>
								<div class="ecjia-input-number input_number_<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
 <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_disabled\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
disabled<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-store="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
			                        <span class="ecjia-number-group-addon" data-toggle="remove-to-cart" rec_id="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'rec_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" goods_id="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">－</span>
			                        <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'v\']->value[\'is_disabled\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

			                        <span class="ecjia-number-contro"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_number\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</span>
			                        <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

			                        <input type="tel" class="ecjia-number-contro" value="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_number\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" autocomplete="off" rec_id="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'rec_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"/>
			                        <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

			                        <span class="ecjia-number-group-addon" data-toggle="add-to-cart" rec_id="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'rec_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" goods_id="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'v\']->value[\'goods_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">＋</span>
			                    </div>
							</div>
						</div>
					</li>
					<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

				</ul>
				<div class="item-count">
					<span class="count">合计：</span>
					<span class="price price_<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'total\'][\'goods_price\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'val\']->value[\'total\'][\'discount\']!=0) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<lable class="discount">(已减<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'total\'][\'discount\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
)</lable><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</span>
					<a class="check_cart check_cart_<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
 <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if (!$_smarty_tpl->tpl_vars[\'val\']->value[\'total\'][\'check_one\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
disabled<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'cart/flow/checkout\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-store="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'seller_id\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-address="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'address_id\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" data-rec="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'val\']->value[\'total\'][\'data_rec\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
" href="javascript:;">去结算</a>
				</div>
			</li>
			<input type="hidden" name="update_cart_url" value="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'cart/index/update_cart\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
			<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

		</ul>
		<div class="flow-nomore-msg"></div>
	</div>
	<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

<div class="flow-no-pro <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'cart_list\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
hide<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } elseif ($_smarty_tpl->tpl_vars[\'no_login\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
show<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
	<div class="ecjia-nolist">
		您还没有添加商品
		<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'not_login\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

		<a class="btn btn-small" type="button" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo smarty_function_url(array(\'path\'=>\'user/user_privilege/login\'),$_smarty_tpl);?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'referer_url\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
&referer_url=<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'referer_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php $_smarty_tpl->smarty->_tag_stack[] = array(\'t\', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
点击登录<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</a>
		<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php } else { ?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

		<a class="btn btn-small" type="button" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo smarty_function_url(array(\'path\'=>\'touch/index/init\'),$_smarty_tpl);?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php $_smarty_tpl->smarty->_tag_stack[] = array(\'t\', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
去逛逛<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</a>
		<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

	</div>
</div>
<?php /*  Call merged included template "library/choose_address_modal.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/choose_address_modal.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '1890059087a98727c16-31806111');
content_59087a988f92a6_65454971($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/choose_address_modal.lbi.php" */?>
<?php /*  Call merged included template "library/model_bar.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_bar.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '1890059087a98727c16-31806111');
content_59087a9892ac29_53714487($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_bar.lbi.php" */?>

<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->getSubTemplate ("library/page_menu.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>


<script type="text/javascript">ecjia.touch.category.init();</script>

<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>

<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 12:24:56
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\choose_address_modal.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59087a988f92a6_65454971')) {function content_59087a988f92a6_65454971($_smarty_tpl) {?>
<div class="ecjia-modal">
	<div class="modal-inner">
		<div class="modal-title"><i class="position"></i>您当前使用的地址是：</div>
		<div class="modal-text"><?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_COOKIE[\'location_name\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
</div>
	</div>
	<div class="modal-buttons modal-buttons-2 modal-buttons-vertical">
		<a href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'user/address/add_address\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
&clear=1<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_COOKIE[\'location_address\']) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
&address=<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_COOKIE[\'location_address\'];?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'referer_url\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
&referer_url=<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'referer_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"><span class="modal-button" style="border-radius: 0;"><span class="create_address">新建收货地址</span></span></a>
		<a href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'location/index/select_location\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php if ($_smarty_tpl->tpl_vars[\'referer_url\']->value) {?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
&referer_url=<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'referer_url\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php }?>/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
"><span class="modal-button"><span class="edit_address">更换地址</span></span></a>
	</div>
</div>
<div class="ecjia-modal-overlay ecjia-modal-overlay-visible"></div><?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 12:24:56
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\model_bar.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59087a9892ac29_53714487')) {function content_59087a9892ac29_53714487($_smarty_tpl) {?><div class="ecjia-mod ecjia-floor ecjia-bottom-bar-pannel o <?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo $_smarty_tpl->tpl_vars[\'active\']->value;?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">
	<a class="index" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'touch/index/init\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">首页</a>
	<a class="category" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'goods/category/init\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">分类</a>
	<a class="cartList" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'cart/index/init\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">购物车</a>
	<a class="orderList" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'user/order/order_list\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">订单</a>
	<a class="mine" href="<?php echo '/*%%SmartyNocache:1890059087a98727c16-31806111%%*/<?php echo RC_Uri::url(\'touch/my/init\');?>
/*/%%SmartyNocache:1890059087a98727c16-31806111%%*/';?>
">我的</a>
</div><?php }} ?>
