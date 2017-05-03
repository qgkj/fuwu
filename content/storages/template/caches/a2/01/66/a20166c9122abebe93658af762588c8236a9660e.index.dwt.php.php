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
    '287c52bdef41c7265324661dcb8cd5a67c8691e9' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\page_menu.lbi.php',
      1 => 1487583428,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3014959084adc9f8b01-16615198',
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5909733412c8d4_06565275',
  'has_nocache_code' => true,
  'cache_lifetime' => 3600,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5909733412c8d4_06565275')) {function content_5909733412c8d4_06565275($_smarty_tpl) {?><?php $_smarty = $_smarty_tpl->smarty; if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
?>
<?php if (!is_pjax()) {?>
<?php if (is_ajax()) {?>

	
	<?php  $_smarty_tpl->tpl_vars['goods'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['goods']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['goods_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['goods']->key => $_smarty_tpl->tpl_vars['goods']->value) {
$_smarty_tpl->tpl_vars['goods']->_loop = true;
?>
	<li class="single_item">
		<a class="list-page-goods-img" href="<?php echo RC_Uri::url('goods/index/show');?>
&goods_id=<?php echo $_smarty_tpl->tpl_vars['goods']->value['id'];?>
">
			<span class="goods-img">
				<img src="<?php echo $_smarty_tpl->tpl_vars['goods']->value['img']['thumb'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['goods']->value['name'];?>
">
			</span>
			<span class="list-page-box">
				<p class="merchants-name"><i class="iconfont icon-shop"></i><?php echo $_smarty_tpl->tpl_vars['goods']->value['seller_name'];?>
</p>
				<span class="goods-name"><?php echo $_smarty_tpl->tpl_vars['goods']->value['name'];?>
</span>
				<span class="list-page-goods-price">
					<span><?php echo $_smarty_tpl->tpl_vars['goods']->value['shop_price'];?>
</span>
				</span>
			</span>
		</a>
	</li>
	<?php } ?>
	

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
<?php if ($_smarty_tpl->tpl_vars['cycleimage']->value) {?>
<div class="ecjia-mod focus" id="focus">
	<div class="hd">
		<ul></ul>
	</div>
	<div class="bd">
		
		<div class="swiper-container swiper-touchIndex">
			<div class="swiper-wrapper">
				<?php  $_smarty_tpl->tpl_vars['img'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['img']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cycleimage']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['img']->key => $_smarty_tpl->tpl_vars['img']->value) {
$_smarty_tpl->tpl_vars['img']->_loop = true;
?>
				<div class="swiper-slide"><a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['img']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['img']->value['photo']['url'];?>
" /></a></div>
				<?php } ?>
			</div>
			
			<div class="swiper-pagination"></div>
		</div>
	</div>
</div>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['navigator']->value) {?>
<nav class="ecjia-mod container-fluid user-nav">
	<ul class="row ecjia-row-nav index">
		<?php  $_smarty_tpl->tpl_vars['nav'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['nav']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigator']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['nav']->key => $_smarty_tpl->tpl_vars['nav']->value) {
$_smarty_tpl->tpl_vars['nav']->_loop = true;
?>
		<li class="col-sm-3 col-xs-2">
			<a href="<?php echo $_smarty_tpl->tpl_vars['nav']->value['url'];?>
">
				<?php if ($_smarty_tpl->tpl_vars['nav']->value['image']) {?>
				<img src="<?php echo $_smarty_tpl->tpl_vars['nav']->value['image'];?>
" />
				<?php } else { ?>
				<img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
dist/images/default_icon.png" alt="">
				<?php }?>
				<p class="text-center"><?php echo $_smarty_tpl->tpl_vars['nav']->value['text'];?>
</p>
			</a>
		</li>
		<?php } ?>
	</ul>
</nav>
<?php }?>
<div class="ecjia-mod">
	<ul class="ecjia-adsense-model">
	<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['adsense_group']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
		<li class="adsense-item">
			<div class="adsense-title">
				<?php if ($_smarty_tpl->tpl_vars['val']->value['title']) {?>
				<h2><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</h2>
				<?php }?>
			</div>
			<ul class="adsense-group">
				<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['val']->value['adsense']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
				<li class="adsense-single <?php if ($_smarty_tpl->tpl_vars['val']->value['count']==3) {?>img-th-item<?php } elseif ((($_smarty_tpl->tpl_vars['val']->value['count']==1||$_smarty_tpl->tpl_vars['val']->value['count']==4)&&$_smarty_tpl->tpl_vars['key']->value>0)) {?>img-item<?php }?>">
					<a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['image'];?>
"></a>
				</li>
				<?php } ?>
			</ul>
		</li>
	<?php } ?>
	</ul>
</div>
<div class="ecjia-mod ecjia-promotion-model ecjia-margin-t">
	<div class="hd ecjia-sales-hd">
		<h2><i class="icon-goods-promotion"></i>促销商品<a href="<?php echo $_smarty_tpl->tpl_vars['more_sales']->value;?>
" class="more_info">更多</a></h2>
	</div>
	<div class="swiper-container swiper-promotion">
		<div class="swiper-wrapper">
			<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['promotion_goods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
			<div class="swiper-slide">
				<a class="list-page-goods-img" href="<?php echo RC_Uri::url('goods/index/show');?>
&goods_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">
					<span class="goods-img">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['img']['thumb'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
">
                        <span class="promote-time" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['promote_end_date'];?>
"></span>
                    </span>
					<span class="list-page-box">
						<span class="goods-name"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</span>
						<span class="list-page-goods-price">
							<?php if ($_smarty_tpl->tpl_vars['val']->value['promote_price']) {?>
							<span><?php echo $_smarty_tpl->tpl_vars['val']->value['promote_price'];?>
</span>
							<?php } else { ?>
							<span><?php echo $_smarty_tpl->tpl_vars['val']->value['shop_price'];?>
</span>
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['val']->value['shop_price']) {?>
                    		<span><del><?php echo $_smarty_tpl->tpl_vars['val']->value['shop_price'];?>
</del></span>
                    		<?php }?>
						</span>
					</span>
				</a>
				<img class="sales-icon" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
images/icon-promote@2x.png">
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="ecjia-mod ecjia-promotion-model ecjia-margin-t">
	<div class="hd ecjia-sales-hd ecjia-new-goods">
		<h2><i class="icon-goods-new"></i>新品推荐<a href="<?php echo $_smarty_tpl->tpl_vars['more_news']->value;?>
" class="more_info">更多</a></h2>
	</div>
	<div class="swiper-container swiper-promotion">
		<div class="swiper-wrapper">
			<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['new_goods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
			<div class="swiper-slide">
				<a class="list-page-goods-img" href="<?php echo RC_Uri::url('goods/index/show');?>
&goods_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">
					<span class="goods-img"><img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['img']['thumb'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
"></span>
					<span class="list-page-box">
						<span class="goods-name"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</span>
						<span class="list-page-goods-price">
							<?php if ($_smarty_tpl->tpl_vars['val']->value['promote_price']) {?>
							<span><?php echo $_smarty_tpl->tpl_vars['val']->value['promote_price'];?>
</span>
							<?php } else { ?>
							<span><?php echo $_smarty_tpl->tpl_vars['val']->value['shop_price'];?>
</span>
							<?php }?>
						</span>
					</span>
				</a>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php $_smarty = $_smarty_tpl->smarty; if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
?><div class="ecjia-mod ecjia-margin-b goods-index-list ecjia-new-goods" style="border-bottom:none;" >
	<div class="hd">
		<h2>
			<span class="line"></span>
			<span class="goods-index-title"><i class="icon-goods-hot"></i>热门推荐</span>
		</h2>
	</div>
	<div class="bd">
		<ul class="ecjia-list ecjia-list-two list-page-two" id="J_ItemList" data-toggle="asynclist" data-loadimg="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
dist/images/loader.gif" data-url="<?php echo smarty_function_url(array('path'=>'index/ajax_goods','args'=>'type=hot'),$_smarty_tpl);?>
" >
		</ul>
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
    ecjia.touch.index.init();
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
<?php if ($_smarty_tpl->tpl_vars['cycleimage']->value) {?>
<div class="ecjia-mod focus" id="focus">
	<div class="hd">
		<ul></ul>
	</div>
	<div class="bd">
		
		<div class="swiper-container swiper-touchIndex">
			<div class="swiper-wrapper">
				<?php  $_smarty_tpl->tpl_vars['img'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['img']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cycleimage']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['img']->key => $_smarty_tpl->tpl_vars['img']->value) {
$_smarty_tpl->tpl_vars['img']->_loop = true;
?>
				<div class="swiper-slide"><a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['img']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['img']->value['photo']['url'];?>
" /></a></div>
				<?php } ?>
			</div>
			
			<div class="swiper-pagination"></div>
		</div>
	</div>
</div>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['navigator']->value) {?>
<nav class="ecjia-mod container-fluid user-nav">
	<ul class="row ecjia-row-nav index">
		<?php  $_smarty_tpl->tpl_vars['nav'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['nav']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['navigator']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['nav']->key => $_smarty_tpl->tpl_vars['nav']->value) {
$_smarty_tpl->tpl_vars['nav']->_loop = true;
?>
		<li class="col-sm-3 col-xs-2">
			<a href="<?php echo $_smarty_tpl->tpl_vars['nav']->value['url'];?>
">
				<?php if ($_smarty_tpl->tpl_vars['nav']->value['image']) {?>
				<img src="<?php echo $_smarty_tpl->tpl_vars['nav']->value['image'];?>
" />
				<?php } else { ?>
				<img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
dist/images/default_icon.png" alt="">
				<?php }?>
				<p class="text-center"><?php echo $_smarty_tpl->tpl_vars['nav']->value['text'];?>
</p>
			</a>
		</li>
		<?php } ?>
	</ul>
</nav>
<?php }?>
<div class="ecjia-mod">
	<ul class="ecjia-adsense-model">
	<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['adsense_group']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
		<li class="adsense-item">
			<div class="adsense-title">
				<?php if ($_smarty_tpl->tpl_vars['val']->value['title']) {?>
				<h2><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</h2>
				<?php }?>
			</div>
			<ul class="adsense-group">
				<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['val']->value['adsense']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
				<li class="adsense-single <?php if ($_smarty_tpl->tpl_vars['val']->value['count']==3) {?>img-th-item<?php } elseif ((($_smarty_tpl->tpl_vars['val']->value['count']==1||$_smarty_tpl->tpl_vars['val']->value['count']==4)&&$_smarty_tpl->tpl_vars['key']->value>0)) {?>img-item<?php }?>">
					<a href="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['image'];?>
"></a>
				</li>
				<?php } ?>
			</ul>
		</li>
	<?php } ?>
	</ul>
</div>
<div class="ecjia-mod ecjia-promotion-model ecjia-margin-t">
	<div class="hd ecjia-sales-hd">
		<h2><i class="icon-goods-promotion"></i>促销商品<a href="<?php echo $_smarty_tpl->tpl_vars['more_sales']->value;?>
" class="more_info">更多</a></h2>
	</div>
	<div class="swiper-container swiper-promotion">
		<div class="swiper-wrapper">
			<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['promotion_goods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
			<div class="swiper-slide">
				<a class="list-page-goods-img" href="<?php echo RC_Uri::url('goods/index/show');?>
&goods_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">
					<span class="goods-img">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['img']['thumb'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
">
                        <span class="promote-time" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['promote_end_date'];?>
"></span>
                    </span>
					<span class="list-page-box">
						<span class="goods-name"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</span>
						<span class="list-page-goods-price">
							<?php if ($_smarty_tpl->tpl_vars['val']->value['promote_price']) {?>
							<span><?php echo $_smarty_tpl->tpl_vars['val']->value['promote_price'];?>
</span>
							<?php } else { ?>
							<span><?php echo $_smarty_tpl->tpl_vars['val']->value['shop_price'];?>
</span>
							<?php }?>
							<?php if ($_smarty_tpl->tpl_vars['val']->value['shop_price']) {?>
                    		<span><del><?php echo $_smarty_tpl->tpl_vars['val']->value['shop_price'];?>
</del></span>
                    		<?php }?>
						</span>
					</span>
				</a>
				<img class="sales-icon" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
images/icon-promote@2x.png">
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<div class="ecjia-mod ecjia-promotion-model ecjia-margin-t">
	<div class="hd ecjia-sales-hd ecjia-new-goods">
		<h2><i class="icon-goods-new"></i>新品推荐<a href="<?php echo $_smarty_tpl->tpl_vars['more_news']->value;?>
" class="more_info">更多</a></h2>
	</div>
	<div class="swiper-container swiper-promotion">
		<div class="swiper-wrapper">
			<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['new_goods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
			<div class="swiper-slide">
				<a class="list-page-goods-img" href="<?php echo RC_Uri::url('goods/index/show');?>
&goods_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">
					<span class="goods-img"><img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['img']['thumb'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
"></span>
					<span class="list-page-box">
						<span class="goods-name"><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</span>
						<span class="list-page-goods-price">
							<?php if ($_smarty_tpl->tpl_vars['val']->value['promote_price']) {?>
							<span><?php echo $_smarty_tpl->tpl_vars['val']->value['promote_price'];?>
</span>
							<?php } else { ?>
							<span><?php echo $_smarty_tpl->tpl_vars['val']->value['shop_price'];?>
</span>
							<?php }?>
						</span>
					</span>
				</a>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php $_smarty = $_smarty_tpl->smarty; if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
?><div class="ecjia-mod ecjia-margin-b goods-index-list ecjia-new-goods" style="border-bottom:none;" >
	<div class="hd">
		<h2>
			<span class="line"></span>
			<span class="goods-index-title"><i class="icon-goods-hot"></i>热门推荐</span>
		</h2>
	</div>
	<div class="bd">
		<ul class="ecjia-list ecjia-list-two list-page-two" id="J_ItemList" data-toggle="asynclist" data-loadimg="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
dist/images/loader.gif" data-url="<?php echo smarty_function_url(array('path'=>'index/ajax_goods','args'=>'type=hot'),$_smarty_tpl);?>
" >
		</ul>
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
    ecjia.touch.index.init();
</script>

<?php }?>
<?php }} ?>
