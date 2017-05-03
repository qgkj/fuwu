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
    '287c52bdef41c7265324661dcb8cd5a67c8691e9' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\page_menu.lbi.php',
      1 => 1487583428,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '97485908464613d546-06270866',
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_590946ddd6ec74_43173578',
  'has_nocache_code' => true,
  'cache_lifetime' => 3600,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_590946ddd6ec74_43173578')) {function content_590946ddd6ec74_43173578($_smarty_tpl) {?><?php $_smarty = $_smarty_tpl->smarty; if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
?>
<?php if (!is_pjax()) {?>
<?php if (is_ajax()) {?>

<?php } else { ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta name="Generator" content="ECJIA 1.20" />
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="format-detection" content="telephone=no" />
	<title><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</title>
	<link href="<?php if (ecjia::config('wap_logo')) {?><?php echo RC_Upload::upload_url(ecjia::config('wap_logo'));?>
<?php } else { ?>favicon.ico<?php }?>" rel="shortcut icon bookmark">
	<link href="<?php if (ecjia::config('wap_logo')) {?><?php echo RC_Upload::upload_url(ecjia::config('wap_logo'));?>
<?php } else { ?>favicon.ico<?php }?>" rel="apple-touch-icon-precomposed">

	
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/bootstrap3/css/bootstrap.css">

	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
dist/css/iconfont.min.css">


	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
css/ecjia.touch.css">
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
css/ecjia.touch.develop.css">
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
css/ecjia.touch.b2b2c.css">
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
css/ecjia_city.css">
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
css/ecjia_help.css">
    
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
css/ecjia.touch.models.css">
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
dist/other/swiper.min.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/datePicker/css/datePicker.min.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/winderCheck/css/winderCheck.min.css">
	
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
<?php echo $_smarty_tpl->tpl_vars['curr_style']->value;?>
">
	<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&libraries=convertor"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/jquery/jquery.min.js" ></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/multi-select/js/jquery.quicksearch.js" ></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/jquery/jquery.pjax.js" ></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/jquery/jquery.cookie.js" ></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/iscroll/js/iscroll.js" ></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/bootstrap3/js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/ecjiaUI/ecjia.js" ></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/jquery-form/jquery.form.min.js" ></script>	

	

	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
js/ecjia.touch.js" ></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
js/ecjia.touch.history.js" ></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
js/ecjia.touch.others.js" ></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
js/ecjia.touch.goods.js" ></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
js/ecjia.touch.user.js" ></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
js/ecjia.touch.flow.js" ></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
js/ecjia.touch.merchant.js" ></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
js/ecjia.touch.b2b2c.js" ></script>

    
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
js/ecjia.touch.goods_detail.js" ></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
js/ecjia.touch.spread.js" ></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
js/ecjia.touch.user_account.js" ></script>
    
    
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
js/ecjia.touch.fly.js" ></script>
    
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
js/ecjia.touch.intro.js" ></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/Validform/Validform_v5.3.2_min.js"></script>

	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/swiper/js/swiper.min.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/datePicker/js/datePicker.min.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
lib/winderCheck/js/winderCheck.min.js"></script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
js/greenCheck.js"></script>
</head>
<body>
	<div class="ecjia" id="get_location" data-url="<?php echo smarty_function_url(array('path'=>'location/index/get_location_msg'),$_smarty_tpl);?>
">
		
<div class="ecjia-mod category">
	<?php $_smarty = $_smarty_tpl->smarty; if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
?>
<?php if ($_smarty_tpl->tpl_vars['address']->value) {?>
<div class="ecjia-mod ecjia-header ecjia-header-index" style="height:5.5em" id="location">
	<div class="ecjia-web">
		<div class="ecjia-address">
			<a href="<?php ob_start();?><?php if ($_GET['city']) {?><?php echo (string)$_GET['city'];?><?php } else { ?><?php echo "北京";?><?php }?><?php $_tmp1=ob_get_clean();?><?php echo smarty_function_url(array('path'=>'location/index/select_location','args'=>"city=".$_tmp1),$_smarty_tpl);?>
" >
			    <span><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
images/address_list/50x50_2l.png"></span>
				<span class="address-text"><?php echo $_COOKIE['location_name'];?>
</span>
				<span><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
images/address_list/down.png"></span>
			</a>
		</div>
	</div>
	
	<div class="ecjia-search-header">
		<span class="bg search-goods" style="margin-top:2em;" data-url="<?php echo RC_Uri::url('touch/index/search');?>
<?php if ($_smarty_tpl->tpl_vars['store_id']->value) {?>&store_id=<?php echo $_smarty_tpl->tpl_vars['store_id']->value;?>
<?php }?>" <?php if ($_smarty_tpl->tpl_vars['keywords']->value!='') {?>style="text-align: left;" data-val="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
"<?php }?>>
			<i class="iconfont icon-search"></i><?php if ($_smarty_tpl->tpl_vars['keywords']->value!='') {?><span class="keywords"><?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
</span><?php } else { ?><?php if ($_smarty_tpl->tpl_vars['store_id']->value) {?>搜索店内商品<?php } else { ?>搜索附近门店<?php }?><?php }?>
		</span>
	</div>
</div>
<?php } else { ?>
<div class="ecjia-mod ecjia-header ecjia-header-index">
	<div class="ecjia-search-header">
		<span class="bg search-goods" data-url="<?php echo RC_Uri::url('touch/index/search');?>
<?php if ($_smarty_tpl->tpl_vars['store_id']->value) {?>&store_id=<?php echo $_smarty_tpl->tpl_vars['store_id']->value;?>
<?php }?>" <?php if ($_smarty_tpl->tpl_vars['keywords']->value!='') {?>style="text-align: left;" data-val="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
"<?php }?>>
			<i class="iconfont icon-search"></i><?php if ($_smarty_tpl->tpl_vars['keywords']->value!='') {?><span class="keywords"><?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
</span><?php } else { ?><?php if ($_smarty_tpl->tpl_vars['store_id']->value) {?>搜索店内商品<?php } else { ?>搜索附近门店<?php }?><?php }?>
		</span>
	</div>
</div>
<?php }?>
    <ul class="ecjia-list category_left">
        <?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value) {
$_smarty_tpl->tpl_vars['cat']->_loop = true;
?>
        <li<?php if ($_smarty_tpl->tpl_vars['cat']->value['id']==$_smarty_tpl->tpl_vars['cat_id']->value) {?> class="active"<?php }?>><a href="javascript:;" data-rh="1" data-val="<?php echo $_smarty_tpl->tpl_vars['cat']->value['id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cat']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
        <?php } ?>
    </ul>
    <div class="category_right">
		<?php  $_smarty_tpl->tpl_vars['children'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['children']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['children']->key => $_smarty_tpl->tpl_vars['children']->value) {
$_smarty_tpl->tpl_vars['children']->_loop = true;
?>
			<div class="cat_list ecjia-category-list <?php if ($_smarty_tpl->tpl_vars['cat_id']->value==$_smarty_tpl->tpl_vars['children']->value['id']) {?>show<?php } else { ?>hide<?php }?>" id="category_<?php echo $_smarty_tpl->tpl_vars['children']->value['id'];?>
">
	            <a href="<?php echo RC_Uri::url('goods/category/store_list');?>
&cid=<?php echo $_smarty_tpl->tpl_vars['children']->value['id'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['children']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['children']->value['name'];?>
"></a>
	            <div class="hd">
	                <h5>
	                    <span class="line"></span>
	                    <span class="goods-index-title"><?php echo $_smarty_tpl->tpl_vars['children']->value['name'];?>
</span>
	                </h5>
	            </div>
	            <?php if ($_smarty_tpl->tpl_vars['children']->value['children']) {?>
	            <ul class="ecjia-margin-t">
	                <?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['children']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value) {
$_smarty_tpl->tpl_vars['cat']->_loop = true;
?>
	                <li>
	                    <a href="<?php echo RC_Uri::url('goods/category/store_list');?>
&cid=<?php echo $_smarty_tpl->tpl_vars['cat']->value['id'];?>
">
	                        <div class="cat-img">
	                            <img src="<?php echo $_smarty_tpl->tpl_vars['cat']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['cat']->value['name'];?>
">
	                        </div>
	                        <div class="child_name"><?php echo $_smarty_tpl->tpl_vars['cat']->value['name'];?>
</div>
	                    </a>
	                </li>
		           	<?php } ?>
	            </ul>
	            <?php }?>
            </div>
    	<?php } ?>
    </div>
</div>
<div class="ecjia-mod ecjia-floor ecjia-bottom-bar-pannel o <?php echo $_smarty_tpl->tpl_vars['active']->value;?>
">
	<a class="index" href="<?php echo RC_Uri::url('touch/index/init');?>
">首页</a>
	<a class="category" href="<?php echo RC_Uri::url('goods/category/init');?>
">分类</a>
	<a class="cartList" href="<?php echo RC_Uri::url('cart/index/init');?>
">购物车</a>
	<a class="orderList" href="<?php echo RC_Uri::url('user/order/order_list');?>
">订单</a>
	<a class="mine" href="<?php echo RC_Uri::url('touch/my/init');?>
">我的</a>
</div>
		<?php echo $_smarty_tpl->getSubTemplate ("library/page_menu.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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
		var hidenav = <?php if ($_smarty_tpl->tpl_vars['hidenav']->value==1) {?>1<?php } else { ?>0<?php }?>, hidetab = <?php if ($_smarty_tpl->tpl_vars['hidetab']->value==1) {?>1<?php } else { ?>0<?php }?>, hideinfo = <?php if ($_smarty_tpl->tpl_vars['hideinfo']->value) {?>1<?php } else { ?>0<?php }?>;
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
<?php }?>
<?php } else { ?>
<title><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</title>


<div class="ecjia-mod category">
	<?php $_smarty = $_smarty_tpl->smarty; if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
?>
<?php if ($_smarty_tpl->tpl_vars['address']->value) {?>
<div class="ecjia-mod ecjia-header ecjia-header-index" style="height:5.5em" id="location">
	<div class="ecjia-web">
		<div class="ecjia-address">
			<a href="<?php ob_start();?><?php if ($_GET['city']) {?><?php echo (string)$_GET['city'];?><?php } else { ?><?php echo "北京";?><?php }?><?php $_tmp1=ob_get_clean();?><?php echo smarty_function_url(array('path'=>'location/index/select_location','args'=>"city=".$_tmp1),$_smarty_tpl);?>
" >
			    <span><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
images/address_list/50x50_2l.png"></span>
				<span class="address-text"><?php echo $_COOKIE['location_name'];?>
</span>
				<span><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
images/address_list/down.png"></span>
			</a>
		</div>
	</div>
	
	<div class="ecjia-search-header">
		<span class="bg search-goods" style="margin-top:2em;" data-url="<?php echo RC_Uri::url('touch/index/search');?>
<?php if ($_smarty_tpl->tpl_vars['store_id']->value) {?>&store_id=<?php echo $_smarty_tpl->tpl_vars['store_id']->value;?>
<?php }?>" <?php if ($_smarty_tpl->tpl_vars['keywords']->value!='') {?>style="text-align: left;" data-val="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
"<?php }?>>
			<i class="iconfont icon-search"></i><?php if ($_smarty_tpl->tpl_vars['keywords']->value!='') {?><span class="keywords"><?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
</span><?php } else { ?><?php if ($_smarty_tpl->tpl_vars['store_id']->value) {?>搜索店内商品<?php } else { ?>搜索附近门店<?php }?><?php }?>
		</span>
	</div>
</div>
<?php } else { ?>
<div class="ecjia-mod ecjia-header ecjia-header-index">
	<div class="ecjia-search-header">
		<span class="bg search-goods" data-url="<?php echo RC_Uri::url('touch/index/search');?>
<?php if ($_smarty_tpl->tpl_vars['store_id']->value) {?>&store_id=<?php echo $_smarty_tpl->tpl_vars['store_id']->value;?>
<?php }?>" <?php if ($_smarty_tpl->tpl_vars['keywords']->value!='') {?>style="text-align: left;" data-val="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
"<?php }?>>
			<i class="iconfont icon-search"></i><?php if ($_smarty_tpl->tpl_vars['keywords']->value!='') {?><span class="keywords"><?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
</span><?php } else { ?><?php if ($_smarty_tpl->tpl_vars['store_id']->value) {?>搜索店内商品<?php } else { ?>搜索附近门店<?php }?><?php }?>
		</span>
	</div>
</div>
<?php }?>
    <ul class="ecjia-list category_left">
        <?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value) {
$_smarty_tpl->tpl_vars['cat']->_loop = true;
?>
        <li<?php if ($_smarty_tpl->tpl_vars['cat']->value['id']==$_smarty_tpl->tpl_vars['cat_id']->value) {?> class="active"<?php }?>><a href="javascript:;" data-rh="1" data-val="<?php echo $_smarty_tpl->tpl_vars['cat']->value['id'];?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cat']->value['name'], ENT_QUOTES, 'UTF-8', true);?>
</a></li>
        <?php } ?>
    </ul>
    <div class="category_right">
		<?php  $_smarty_tpl->tpl_vars['children'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['children']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['children']->key => $_smarty_tpl->tpl_vars['children']->value) {
$_smarty_tpl->tpl_vars['children']->_loop = true;
?>
			<div class="cat_list ecjia-category-list <?php if ($_smarty_tpl->tpl_vars['cat_id']->value==$_smarty_tpl->tpl_vars['children']->value['id']) {?>show<?php } else { ?>hide<?php }?>" id="category_<?php echo $_smarty_tpl->tpl_vars['children']->value['id'];?>
">
	            <a href="<?php echo RC_Uri::url('goods/category/store_list');?>
&cid=<?php echo $_smarty_tpl->tpl_vars['children']->value['id'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['children']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['children']->value['name'];?>
"></a>
	            <div class="hd">
	                <h5>
	                    <span class="line"></span>
	                    <span class="goods-index-title"><?php echo $_smarty_tpl->tpl_vars['children']->value['name'];?>
</span>
	                </h5>
	            </div>
	            <?php if ($_smarty_tpl->tpl_vars['children']->value['children']) {?>
	            <ul class="ecjia-margin-t">
	                <?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['children']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value) {
$_smarty_tpl->tpl_vars['cat']->_loop = true;
?>
	                <li>
	                    <a href="<?php echo RC_Uri::url('goods/category/store_list');?>
&cid=<?php echo $_smarty_tpl->tpl_vars['cat']->value['id'];?>
">
	                        <div class="cat-img">
	                            <img src="<?php echo $_smarty_tpl->tpl_vars['cat']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['cat']->value['name'];?>
">
	                        </div>
	                        <div class="child_name"><?php echo $_smarty_tpl->tpl_vars['cat']->value['name'];?>
</div>
	                    </a>
	                </li>
		           	<?php } ?>
	            </ul>
	            <?php }?>
            </div>
    	<?php } ?>
    </div>
</div>
<div class="ecjia-mod ecjia-floor ecjia-bottom-bar-pannel o <?php echo $_smarty_tpl->tpl_vars['active']->value;?>
">
	<a class="index" href="<?php echo RC_Uri::url('touch/index/init');?>
">首页</a>
	<a class="category" href="<?php echo RC_Uri::url('goods/category/init');?>
">分类</a>
	<a class="cartList" href="<?php echo RC_Uri::url('cart/index/init');?>
">购物车</a>
	<a class="orderList" href="<?php echo RC_Uri::url('user/order/order_list');?>
">订单</a>
	<a class="mine" href="<?php echo RC_Uri::url('touch/my/init');?>
">我的</a>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("library/page_menu.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<script type="text/javascript">
	ecjia.touch.category.init();
</script>

<?php }?>
<?php }} ?>
