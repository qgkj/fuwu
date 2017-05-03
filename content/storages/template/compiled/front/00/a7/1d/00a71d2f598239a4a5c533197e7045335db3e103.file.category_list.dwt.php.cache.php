<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:41:42
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\category_list.dwt.php" */ ?>
<?php /*%%SmartyHeaderCode:97485908464613d546-06270866%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '00a71d2f598239a4a5c533197e7045335db3e103' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\category_list.dwt.php',
      1 => 1487583426,
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
    '713f1b20b6f0f094caab3d1984ff1711ef5c26d1' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\model_bar.lbi.php',
      1 => 1487583427,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '97485908464613d546-06270866',
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
  'unifunc' => 'content_5908464643fd99_79631312',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5908464643fd99_79631312')) {function content_5908464643fd99_79631312($_smarty_tpl) {?><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php $_smarty = $_smarty_tpl->smarty; if (!is_callable(\'smarty_function_url\')) include \'C:\\\\ecjia-daojia-29\\\\content\\\\system\\\\smarty\\\\function.url.php\';
?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if (!is_pjax()) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if (is_ajax()) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>


<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } else { ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta name="Generator" content="ECJIA 1.20" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="format-detection" content="telephone=no" />
	<title><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'page_title\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
</title>
	<link href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if (ecjia::config(\'wap_logo\')) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo RC_Upload::upload_url(ecjia::config(\'wap_logo\'));?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } else { ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
favicon.ico<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
" rel="shortcut icon bookmark">
	<link href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if (ecjia::config(\'wap_logo\')) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo RC_Upload::upload_url(ecjia::config(\'wap_logo\'));?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } else { ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
favicon.ico<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
" rel="apple-touch-icon-precomposed">

	
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/bootstrap3/css/bootstrap.css">

	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
dist/css/iconfont.min.css">


	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
css/ecjia.touch.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
css/ecjia.touch.develop.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
css/ecjia.touch.b2b2c.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
css/ecjia_city.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
css/ecjia_help.css">
    
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
css/ecjia.touch.models.css">
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
dist/other/swiper.min.css">
    <link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/datePicker/css/datePicker.min.css">
    <link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/winderCheck/css/winderCheck.min.css">
	
	<link rel="stylesheet" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'curr_style\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
">
	<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&libraries=convertor"></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/jquery/jquery.min.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/multi-select/js/jquery.quicksearch.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/jquery/jquery.pjax.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/jquery/jquery.cookie.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/iscroll/js/iscroll.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/bootstrap3/js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/ecjiaUI/ecjia.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/jquery-form/jquery.form.min.js" ></script>	

	

	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
js/ecjia.touch.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
js/ecjia.touch.history.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
js/ecjia.touch.others.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
js/ecjia.touch.goods.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
js/ecjia.touch.user.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
js/ecjia.touch.flow.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
js/ecjia.touch.merchant.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
js/ecjia.touch.b2b2c.js" ></script>

    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
js/ecjia.touch.goods_detail.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
js/ecjia.touch.spread.js" ></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
js/ecjia.touch.user_account.js" ></script>
    
    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
js/ecjia.touch.fly.js" ></script>
    
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
js/ecjia.touch.intro.js" ></script>
	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/Validform/Validform_v5.3.2_min.js"></script>

	<script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/swiper/js/swiper.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/datePicker/js/datePicker.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
lib/winderCheck/js/winderCheck.min.js"></script>
    <script type="text/javascript" src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
js/greenCheck.js"></script>
</head>
<body>
	<div class="ecjia" id="get_location" data-url="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo smarty_function_url(array(\'path\'=>\'location/index/get_location_msg\'),$_smarty_tpl);?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
">
		
<div class="ecjia-mod category">
	<?php /*  Call merged included template "library/index_header.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/index_header.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '97485908464613d546-06270866');
content_5908464628d007_86626469($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/index_header.lbi.php" */?>
    <ul class="ecjia-list category_left">
        <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php  $_smarty_tpl->tpl_vars[\'cat\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'cat\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'data\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'cat\']->key => $_smarty_tpl->tpl_vars[\'cat\']->value) {
$_smarty_tpl->tpl_vars[\'cat\']->_loop = true;
?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

        <li<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'cat\']->value[\'id\']==$_smarty_tpl->tpl_vars[\'cat_id\']->value) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
 class="active"<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
><a href="javascript:;" data-rh="1" data-val="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'cat\']->value[\'id\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
"><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars[\'cat\']->value[\'name\'], ENT_QUOTES, \'UTF-8\', true);?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
</a></li>
        <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

    </ul>
    <div class="category_right">
		<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php  $_smarty_tpl->tpl_vars[\'children\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'children\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'data\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'children\']->key => $_smarty_tpl->tpl_vars[\'children\']->value) {
$_smarty_tpl->tpl_vars[\'children\']->_loop = true;
?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

			<div class="cat_list ecjia-category-list <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'cat_id\']->value==$_smarty_tpl->tpl_vars[\'children\']->value[\'id\']) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
show<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } else { ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
hide<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
" id="category_<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'children\']->value[\'id\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
">
	            <a href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo RC_Uri::url(\'goods/category/store_list\');?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
&cid=<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'children\']->value[\'id\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
"><img src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'children\']->value[\'image\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
" alt="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'children\']->value[\'name\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
"></a>
	            <div class="hd">
	                <h5>
	                    <span class="line"></span>
	                    <span class="goods-index-title"><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'children\']->value[\'name\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
</span>
	                </h5>
	            </div>
	            <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'children\']->value[\'children\']) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

	            <ul class="ecjia-margin-t">
	                <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php  $_smarty_tpl->tpl_vars[\'cat\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'cat\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'children\']->value[\'children\']; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'cat\']->key => $_smarty_tpl->tpl_vars[\'cat\']->value) {
$_smarty_tpl->tpl_vars[\'cat\']->_loop = true;
?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

	                <li>
	                    <a href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo RC_Uri::url(\'goods/category/store_list\');?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
&cid=<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'cat\']->value[\'id\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
">
	                        <div class="cat-img">
	                            <img src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'cat\']->value[\'image\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
" alt="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'cat\']->value[\'name\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
">
	                        </div>
	                        <div class="child_name"><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'cat\']->value[\'name\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
</div>
	                    </a>
	                </li>
		           	<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

	            </ul>
	            <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

            </div>
    	<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

    </div>
</div>
<?php /*  Call merged included template "library/model_bar.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_bar.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '97485908464613d546-06270866');
content_59084646394338_48589302($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_bar.lbi.php" */?>

		<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->getSubTemplate ("library/page_menu.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

	</div>
	
	
	
<script type="text/javascript">
	ecjia.touch.category.init();
</script>

	<script type="text/javascript">
    	window.onunload = unload;
    	function unload (e){
    	  window.scrollTo(0,0);
    	}
	</script>
	<script type="text/javascript">
		var hidenav = <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'hidenav\']->value==1) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
1<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } else { ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
0<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
, hidetab = <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'hidetab\']->value==1) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
1<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } else { ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
0<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
, hideinfo = <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'hideinfo\']->value) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
1<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } else { ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
0<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
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
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } else { ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

<title><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'page_title\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
</title>


<div class="ecjia-mod category">
	<?php /*  Call merged included template "library/index_header.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/index_header.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '97485908464613d546-06270866');
content_5908464628d007_86626469($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/index_header.lbi.php" */?>
    <ul class="ecjia-list category_left">
        <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php  $_smarty_tpl->tpl_vars[\'cat\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'cat\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'data\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'cat\']->key => $_smarty_tpl->tpl_vars[\'cat\']->value) {
$_smarty_tpl->tpl_vars[\'cat\']->_loop = true;
?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

        <li<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'cat\']->value[\'id\']==$_smarty_tpl->tpl_vars[\'cat_id\']->value) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
 class="active"<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
><a href="javascript:;" data-rh="1" data-val="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'cat\']->value[\'id\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
"><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars[\'cat\']->value[\'name\'], ENT_QUOTES, \'UTF-8\', true);?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
</a></li>
        <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

    </ul>
    <div class="category_right">
		<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php  $_smarty_tpl->tpl_vars[\'children\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'children\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'data\']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'children\']->key => $_smarty_tpl->tpl_vars[\'children\']->value) {
$_smarty_tpl->tpl_vars[\'children\']->_loop = true;
?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

			<div class="cat_list ecjia-category-list <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'cat_id\']->value==$_smarty_tpl->tpl_vars[\'children\']->value[\'id\']) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
show<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } else { ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
hide<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
" id="category_<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'children\']->value[\'id\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
">
	            <a href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo RC_Uri::url(\'goods/category/store_list\');?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
&cid=<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'children\']->value[\'id\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
"><img src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'children\']->value[\'image\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
" alt="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'children\']->value[\'name\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
"></a>
	            <div class="hd">
	                <h5>
	                    <span class="line"></span>
	                    <span class="goods-index-title"><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'children\']->value[\'name\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
</span>
	                </h5>
	            </div>
	            <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'children\']->value[\'children\']) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

	            <ul class="ecjia-margin-t">
	                <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php  $_smarty_tpl->tpl_vars[\'cat\'] = new Smarty_Variable; $_smarty_tpl->tpl_vars[\'cat\']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars[\'children\']->value[\'children\']; if (!is_array($_from) && !is_object($_from)) { settype($_from, \'array\');}
foreach ($_from as $_smarty_tpl->tpl_vars[\'cat\']->key => $_smarty_tpl->tpl_vars[\'cat\']->value) {
$_smarty_tpl->tpl_vars[\'cat\']->_loop = true;
?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

	                <li>
	                    <a href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo RC_Uri::url(\'goods/category/store_list\');?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
&cid=<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'cat\']->value[\'id\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
">
	                        <div class="cat-img">
	                            <img src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'cat\']->value[\'image\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
" alt="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'cat\']->value[\'name\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
">
	                        </div>
	                        <div class="child_name"><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'cat\']->value[\'name\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
</div>
	                    </a>
	                </li>
		           	<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

	            </ul>
	            <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

            </div>
    	<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

    </div>
</div>
<?php /*  Call merged included template "library/model_bar.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/model_bar.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0, '97485908464613d546-06270866');
content_59084646394338_48589302($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/model_bar.lbi.php" */?>

<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->getSubTemplate ("library/page_menu.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>


<script type="text/javascript">
	ecjia.touch.category.init();
</script>

<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:41:42
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\index_header.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_5908464628d007_86626469')) {function content_5908464628d007_86626469($_smarty_tpl) {?><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php $_smarty = $_smarty_tpl->smarty; if (!is_callable(\'smarty_function_url\')) include \'C:\\\\ecjia-daojia-29\\\\content\\\\system\\\\smarty\\\\function.url.php\';
?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'address\']->value) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

<div class="ecjia-mod ecjia-header ecjia-header-index" style="height:5.5em" id="location">
	<div class="ecjia-web">
		<div class="ecjia-address">
			<a href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php ob_start();?><?php if ($_GET[\'city\']) {?><?php echo (string)$_GET[\'city\'];?><?php } else { ?><?php echo "北京";?><?php }?><?php $_tmp1=ob_get_clean();?><?php echo smarty_function_url(array(\'path\'=>\'location/index/select_location\',\'args\'=>"city=".$_tmp1),$_smarty_tpl);?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
" >
			    <span><img src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
images/address_list/50x50_2l.png"></span>
				<span class="address-text"><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_COOKIE[\'location_name\'];?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
</span>
				<span><img src="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'theme_url\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
images/address_list/down.png"></span>
			</a>
		</div>
	</div>
	
	<div class="ecjia-search-header">
		<span class="bg search-goods" style="margin-top:2em;" data-url="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo RC_Uri::url(\'touch/index/search\');?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'store_id\']->value) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
&store_id=<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'store_id\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
" <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'keywords\']->value!=\'\') {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
style="text-align: left;" data-val="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'keywords\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
"<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
>
			<i class="iconfont icon-search"></i><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'keywords\']->value!=\'\') {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<span class="keywords"><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'keywords\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
</span><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } else { ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'store_id\']->value) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
搜索店内商品<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } else { ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
搜索附近门店<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

		</span>
	</div>
</div>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } else { ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

<div class="ecjia-mod ecjia-header ecjia-header-index">
	<div class="ecjia-search-header">
		<span class="bg search-goods" data-url="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo RC_Uri::url(\'touch/index/search\');?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'store_id\']->value) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
&store_id=<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'store_id\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
" <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'keywords\']->value!=\'\') {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
style="text-align: left;" data-val="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'keywords\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
"<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
>
			<i class="iconfont icon-search"></i><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'keywords\']->value!=\'\') {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<span class="keywords"><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'keywords\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
</span><?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } else { ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php if ($_smarty_tpl->tpl_vars[\'store_id\']->value) {?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
搜索店内商品<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php } else { ?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
搜索附近门店<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

		</span>
	</div>
</div>
<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php }?>/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>

<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:41:42
         compiled from "C:\ecjia-daojia-29\sites\m\content\themes\h5\library\model_bar.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084646394338_48589302')) {function content_59084646394338_48589302($_smarty_tpl) {?><div class="ecjia-mod ecjia-floor ecjia-bottom-bar-pannel o <?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo $_smarty_tpl->tpl_vars[\'active\']->value;?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
">
	<a class="index" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo RC_Uri::url(\'touch/index/init\');?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
">首页</a>
	<a class="category" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo RC_Uri::url(\'goods/category/init\');?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
">分类</a>
	<a class="cartList" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo RC_Uri::url(\'cart/index/init\');?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
">购物车</a>
	<a class="orderList" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo RC_Uri::url(\'user/order/order_list\');?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
">订单</a>
	<a class="mine" href="<?php echo '/*%%SmartyNocache:97485908464613d546-06270866%%*/<?php echo RC_Uri::url(\'touch/my/init\');?>
/*/%%SmartyNocache:97485908464613d546-06270866%%*/';?>
">我的</a>
</div><?php }} ?>
