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
    '287c52bdef41c7265324661dcb8cd5a67c8691e9' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\page_menu.lbi.php',
      1 => 1487583428,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1890059087a98727c16-31806111',
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_59099837818c56_33204345',
  'has_nocache_code' => true,
  'cache_lifetime' => 3600,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59099837818c56_33204345')) {function content_59099837818c56_33204345($_smarty_tpl) {?><?php $_smarty = $_smarty_tpl->smarty; if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
if (!is_callable('smarty_block_t')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\block.t.php';
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
		
<a href="<?php echo RC_Uri::url('location/index/select_location');?>
<?php if ($_smarty_tpl->tpl_vars['referer_url']->value) {?>&referer_url=<?php echo $_smarty_tpl->tpl_vars['referer_url']->value;?>
<?php }?>">
	<div class="flow-address flow-cart <?php if ($_smarty_tpl->tpl_vars['address_id']->value==0||!$_smarty_tpl->tpl_vars['address_id']->value) {?>location_address<?php }?>">
		<label class="ecjiaf-fl"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
送至：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
		<div class="ecjiaf-fl address-info">
			<?php if ($_smarty_tpl->tpl_vars['address_id']->value>0) {?>
				<span><?php echo $_smarty_tpl->tpl_vars['address_info']->value['consignee'];?>
</span>
				<span><?php echo $_smarty_tpl->tpl_vars['address_info']->value['mobile'];?>
</span>
				<p class="ecjia-truncate2 address-desc"><?php echo $_smarty_tpl->tpl_vars['address_info']->value['address'];?>
<?php echo $_smarty_tpl->tpl_vars['address_info']->value['address_info'];?>
</p>
			<?php } else { ?>
				<span><?php echo $_COOKIE['location_name'];?>
</span>
			<?php }?>
		</div>
	</div>
</a>

<?php if (!$_smarty_tpl->tpl_vars['not_login']->value) {?>
	<?php if ($_smarty_tpl->tpl_vars['cart_list']->value) {?>
	<div class="ecjia-flow-cart">
		<ul>
			<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cart_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
			<li class="cart-single">
				<div class="item">
					<div class="check-wrapper">
						<span class="cart-checkbox check_all <?php if ($_smarty_tpl->tpl_vars['val']->value['total']['check_all']==1) {?>checked<?php }?>" id="store_check_<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
" data-store="<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
"></span>
					</div>
					<div class="shop-title-content">
						<a href="<?php echo RC_Uri::url('merchant/index/init');?>
&store_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
">
							<span class="shop-title-name"><i class="iconfont icon-shop"></i><?php echo $_smarty_tpl->tpl_vars['val']->value['seller_name'];?>
</span>
							<?php if ($_smarty_tpl->tpl_vars['val']->value['manage_mode']=='self') {?><span class="self-store">自营</span><?php }?>
						</a>
						<span class="shop-edit" data-store="<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
" data-type="edit">编辑</span>
					</div>
				</div>
				<ul class="items">
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['val']->value['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
					<li class="item-goods cart_item_<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
 <?php if ($_smarty_tpl->tpl_vars['v']->value['is_disabled']) {?>disabled<?php }?>">
						<span class="cart-checkbox checkbox_<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
 <?php if ($_smarty_tpl->tpl_vars['v']->value['is_checked']==1) {?>checked<?php }?> <?php if ($_smarty_tpl->tpl_vars['v']->value['is_disabled']) {?>disabled<?php }?>" data-store="<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
" rec_id="<?php echo $_smarty_tpl->tpl_vars['v']->value['rec_id'];?>
" goods_id="<?php echo $_smarty_tpl->tpl_vars['v']->value['goods_id'];?>
" data-num="<?php echo $_smarty_tpl->tpl_vars['v']->value['goods_number'];?>
"></span>
						<div class="cart-product">
							<a class="cart-product-photo" href="<?php echo RC_Uri::url('goods/index/show');?>
&goods_id=<?php echo $_smarty_tpl->tpl_vars['v']->value['goods_id'];?>
">
								<img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['img']['thumb'];?>
">
								<?php if ($_smarty_tpl->tpl_vars['v']->value['is_disabled']) {?>
								<div class="product_empty">库存不足</div>
								<?php }?>
							</a>
							<div class="cart-product-info">
								<div class="cart-product-name <?php if ($_smarty_tpl->tpl_vars['v']->value['is_disabled']) {?>disabled<?php }?>"><a href="<?php echo RC_Uri::url('goods/index/show');?>
&goods_id=<?php echo $_smarty_tpl->tpl_vars['v']->value['goods_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['goods_name'];?>
</a></div>
								<div class="cart-product-price <?php if ($_smarty_tpl->tpl_vars['v']->value['is_disabled']) {?>disabled<?php }?>"><?php if ($_smarty_tpl->tpl_vars['v']->value['goods_price']==0) {?>免费<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['v']->value['formated_goods_price'];?>
<?php }?></div>
								<div class="ecjia-input-number input_number_<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
 <?php if ($_smarty_tpl->tpl_vars['v']->value['is_disabled']) {?>disabled<?php }?>" data-store="<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
">
			                        <span class="ecjia-number-group-addon" data-toggle="remove-to-cart" rec_id="<?php echo $_smarty_tpl->tpl_vars['v']->value['rec_id'];?>
" goods_id="<?php echo $_smarty_tpl->tpl_vars['v']->value['goods_id'];?>
">－</span>
			                        <?php if ($_smarty_tpl->tpl_vars['v']->value['is_disabled']) {?>
			                        <span class="ecjia-number-contro"><?php echo $_smarty_tpl->tpl_vars['v']->value['goods_number'];?>
</span>
			                        <?php } else { ?>
			                        <input type="tel" class="ecjia-number-contro" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['goods_number'];?>
" autocomplete="off" rec_id="<?php echo $_smarty_tpl->tpl_vars['v']->value['rec_id'];?>
"/>
			                        <?php }?>
			                        <span class="ecjia-number-group-addon" data-toggle="add-to-cart" rec_id="<?php echo $_smarty_tpl->tpl_vars['v']->value['rec_id'];?>
" goods_id="<?php echo $_smarty_tpl->tpl_vars['v']->value['goods_id'];?>
">＋</span>
			                    </div>
							</div>
						</div>
					</li>
					<?php } ?>
				</ul>
				<div class="item-count">
					<span class="count">合计：</span>
					<span class="price price_<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['total']['goods_price'];?>
<?php if ($_smarty_tpl->tpl_vars['val']->value['total']['discount']!=0) {?><lable class="discount">(已减<?php echo $_smarty_tpl->tpl_vars['val']->value['total']['discount'];?>
)</lable><?php }?></span>
					<a class="check_cart check_cart_<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
 <?php if (!$_smarty_tpl->tpl_vars['val']->value['total']['check_one']) {?>disabled<?php }?>" data-href="<?php echo RC_Uri::url('cart/flow/checkout');?>
" data-store="<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
" data-address="<?php echo $_smarty_tpl->tpl_vars['address_id']->value;?>
" data-rec="<?php echo $_smarty_tpl->tpl_vars['val']->value['total']['data_rec'];?>
" href="javascript:;">去结算</a>
				</div>
			</li>
			<input type="hidden" name="update_cart_url" value="<?php echo RC_Uri::url('cart/index/update_cart');?>
">
			<?php } ?>
		</ul>
		<div class="flow-nomore-msg"></div>
	</div>
	<?php }?>
<?php }?>
<div class="flow-no-pro <?php if ($_smarty_tpl->tpl_vars['cart_list']->value) {?>hide<?php } elseif ($_smarty_tpl->tpl_vars['no_login']->value) {?>show<?php }?>">
	<div class="ecjia-nolist">
		您还没有添加商品
		<?php if ($_smarty_tpl->tpl_vars['not_login']->value) {?>
		<a class="btn btn-small" type="button" href="<?php echo smarty_function_url(array('path'=>'user/user_privilege/login'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->tpl_vars['referer_url']->value) {?>&referer_url=<?php echo $_smarty_tpl->tpl_vars['referer_url']->value;?>
<?php }?>"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
点击登录<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
		<?php } else { ?>
		<a class="btn btn-small" type="button" href="<?php echo smarty_function_url(array('path'=>'touch/index/init'),$_smarty_tpl);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
去逛逛<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
		<?php }?>
	</div>
</div>
<div class="ecjia-modal">
	<div class="modal-inner">
		<div class="modal-title"><i class="position"></i>您当前使用的地址是：</div>
		<div class="modal-text"><?php echo $_COOKIE['location_name'];?>
</div>
	</div>
	<div class="modal-buttons modal-buttons-2 modal-buttons-vertical">
		<a href="<?php echo RC_Uri::url('user/address/add_address');?>
&clear=1<?php if ($_COOKIE['location_address']) {?>&address=<?php echo $_COOKIE['location_address'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['referer_url']->value) {?>&referer_url=<?php echo $_smarty_tpl->tpl_vars['referer_url']->value;?>
<?php }?>"><span class="modal-button" style="border-radius: 0;"><span class="create_address">新建收货地址</span></span></a>
		<a href="<?php echo RC_Uri::url('location/index/select_location');?>
<?php if ($_smarty_tpl->tpl_vars['referer_url']->value) {?>&referer_url=<?php echo $_smarty_tpl->tpl_vars['referer_url']->value;?>
<?php }?>"><span class="modal-button"><span class="edit_address">更换地址</span></span></a>
	</div>
</div>
<div class="ecjia-modal-overlay ecjia-modal-overlay-visible"></div><div class="ecjia-mod ecjia-floor ecjia-bottom-bar-pannel o <?php echo $_smarty_tpl->tpl_vars['active']->value;?>
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
	
	
	
<script type="text/javascript">ecjia.touch.category.init();</script>

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


<a href="<?php echo RC_Uri::url('location/index/select_location');?>
<?php if ($_smarty_tpl->tpl_vars['referer_url']->value) {?>&referer_url=<?php echo $_smarty_tpl->tpl_vars['referer_url']->value;?>
<?php }?>">
	<div class="flow-address flow-cart <?php if ($_smarty_tpl->tpl_vars['address_id']->value==0||!$_smarty_tpl->tpl_vars['address_id']->value) {?>location_address<?php }?>">
		<label class="ecjiaf-fl"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
送至：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
		<div class="ecjiaf-fl address-info">
			<?php if ($_smarty_tpl->tpl_vars['address_id']->value>0) {?>
				<span><?php echo $_smarty_tpl->tpl_vars['address_info']->value['consignee'];?>
</span>
				<span><?php echo $_smarty_tpl->tpl_vars['address_info']->value['mobile'];?>
</span>
				<p class="ecjia-truncate2 address-desc"><?php echo $_smarty_tpl->tpl_vars['address_info']->value['address'];?>
<?php echo $_smarty_tpl->tpl_vars['address_info']->value['address_info'];?>
</p>
			<?php } else { ?>
				<span><?php echo $_COOKIE['location_name'];?>
</span>
			<?php }?>
		</div>
	</div>
</a>

<?php if (!$_smarty_tpl->tpl_vars['not_login']->value) {?>
	<?php if ($_smarty_tpl->tpl_vars['cart_list']->value) {?>
	<div class="ecjia-flow-cart">
		<ul>
			<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cart_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
			<li class="cart-single">
				<div class="item">
					<div class="check-wrapper">
						<span class="cart-checkbox check_all <?php if ($_smarty_tpl->tpl_vars['val']->value['total']['check_all']==1) {?>checked<?php }?>" id="store_check_<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
" data-store="<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
"></span>
					</div>
					<div class="shop-title-content">
						<a href="<?php echo RC_Uri::url('merchant/index/init');?>
&store_id=<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
">
							<span class="shop-title-name"><i class="iconfont icon-shop"></i><?php echo $_smarty_tpl->tpl_vars['val']->value['seller_name'];?>
</span>
							<?php if ($_smarty_tpl->tpl_vars['val']->value['manage_mode']=='self') {?><span class="self-store">自营</span><?php }?>
						</a>
						<span class="shop-edit" data-store="<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
" data-type="edit">编辑</span>
					</div>
				</div>
				<ul class="items">
					<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['val']->value['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
					<li class="item-goods cart_item_<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
 <?php if ($_smarty_tpl->tpl_vars['v']->value['is_disabled']) {?>disabled<?php }?>">
						<span class="cart-checkbox checkbox_<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
 <?php if ($_smarty_tpl->tpl_vars['v']->value['is_checked']==1) {?>checked<?php }?> <?php if ($_smarty_tpl->tpl_vars['v']->value['is_disabled']) {?>disabled<?php }?>" data-store="<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
" rec_id="<?php echo $_smarty_tpl->tpl_vars['v']->value['rec_id'];?>
" goods_id="<?php echo $_smarty_tpl->tpl_vars['v']->value['goods_id'];?>
" data-num="<?php echo $_smarty_tpl->tpl_vars['v']->value['goods_number'];?>
"></span>
						<div class="cart-product">
							<a class="cart-product-photo" href="<?php echo RC_Uri::url('goods/index/show');?>
&goods_id=<?php echo $_smarty_tpl->tpl_vars['v']->value['goods_id'];?>
">
								<img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['img']['thumb'];?>
">
								<?php if ($_smarty_tpl->tpl_vars['v']->value['is_disabled']) {?>
								<div class="product_empty">库存不足</div>
								<?php }?>
							</a>
							<div class="cart-product-info">
								<div class="cart-product-name <?php if ($_smarty_tpl->tpl_vars['v']->value['is_disabled']) {?>disabled<?php }?>"><a href="<?php echo RC_Uri::url('goods/index/show');?>
&goods_id=<?php echo $_smarty_tpl->tpl_vars['v']->value['goods_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['goods_name'];?>
</a></div>
								<div class="cart-product-price <?php if ($_smarty_tpl->tpl_vars['v']->value['is_disabled']) {?>disabled<?php }?>"><?php if ($_smarty_tpl->tpl_vars['v']->value['goods_price']==0) {?>免费<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['v']->value['formated_goods_price'];?>
<?php }?></div>
								<div class="ecjia-input-number input_number_<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
 <?php if ($_smarty_tpl->tpl_vars['v']->value['is_disabled']) {?>disabled<?php }?>" data-store="<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
">
			                        <span class="ecjia-number-group-addon" data-toggle="remove-to-cart" rec_id="<?php echo $_smarty_tpl->tpl_vars['v']->value['rec_id'];?>
" goods_id="<?php echo $_smarty_tpl->tpl_vars['v']->value['goods_id'];?>
">－</span>
			                        <?php if ($_smarty_tpl->tpl_vars['v']->value['is_disabled']) {?>
			                        <span class="ecjia-number-contro"><?php echo $_smarty_tpl->tpl_vars['v']->value['goods_number'];?>
</span>
			                        <?php } else { ?>
			                        <input type="tel" class="ecjia-number-contro" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['goods_number'];?>
" autocomplete="off" rec_id="<?php echo $_smarty_tpl->tpl_vars['v']->value['rec_id'];?>
"/>
			                        <?php }?>
			                        <span class="ecjia-number-group-addon" data-toggle="add-to-cart" rec_id="<?php echo $_smarty_tpl->tpl_vars['v']->value['rec_id'];?>
" goods_id="<?php echo $_smarty_tpl->tpl_vars['v']->value['goods_id'];?>
">＋</span>
			                    </div>
							</div>
						</div>
					</li>
					<?php } ?>
				</ul>
				<div class="item-count">
					<span class="count">合计：</span>
					<span class="price price_<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['total']['goods_price'];?>
<?php if ($_smarty_tpl->tpl_vars['val']->value['total']['discount']!=0) {?><lable class="discount">(已减<?php echo $_smarty_tpl->tpl_vars['val']->value['total']['discount'];?>
)</lable><?php }?></span>
					<a class="check_cart check_cart_<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
 <?php if (!$_smarty_tpl->tpl_vars['val']->value['total']['check_one']) {?>disabled<?php }?>" data-href="<?php echo RC_Uri::url('cart/flow/checkout');?>
" data-store="<?php echo $_smarty_tpl->tpl_vars['val']->value['seller_id'];?>
" data-address="<?php echo $_smarty_tpl->tpl_vars['address_id']->value;?>
" data-rec="<?php echo $_smarty_tpl->tpl_vars['val']->value['total']['data_rec'];?>
" href="javascript:;">去结算</a>
				</div>
			</li>
			<input type="hidden" name="update_cart_url" value="<?php echo RC_Uri::url('cart/index/update_cart');?>
">
			<?php } ?>
		</ul>
		<div class="flow-nomore-msg"></div>
	</div>
	<?php }?>
<?php }?>
<div class="flow-no-pro <?php if ($_smarty_tpl->tpl_vars['cart_list']->value) {?>hide<?php } elseif ($_smarty_tpl->tpl_vars['no_login']->value) {?>show<?php }?>">
	<div class="ecjia-nolist">
		您还没有添加商品
		<?php if ($_smarty_tpl->tpl_vars['not_login']->value) {?>
		<a class="btn btn-small" type="button" href="<?php echo smarty_function_url(array('path'=>'user/user_privilege/login'),$_smarty_tpl);?>
<?php if ($_smarty_tpl->tpl_vars['referer_url']->value) {?>&referer_url=<?php echo $_smarty_tpl->tpl_vars['referer_url']->value;?>
<?php }?>"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
点击登录<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
		<?php } else { ?>
		<a class="btn btn-small" type="button" href="<?php echo smarty_function_url(array('path'=>'touch/index/init'),$_smarty_tpl);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
去逛逛<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
		<?php }?>
	</div>
</div>
<div class="ecjia-modal">
	<div class="modal-inner">
		<div class="modal-title"><i class="position"></i>您当前使用的地址是：</div>
		<div class="modal-text"><?php echo $_COOKIE['location_name'];?>
</div>
	</div>
	<div class="modal-buttons modal-buttons-2 modal-buttons-vertical">
		<a href="<?php echo RC_Uri::url('user/address/add_address');?>
&clear=1<?php if ($_COOKIE['location_address']) {?>&address=<?php echo $_COOKIE['location_address'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['referer_url']->value) {?>&referer_url=<?php echo $_smarty_tpl->tpl_vars['referer_url']->value;?>
<?php }?>"><span class="modal-button" style="border-radius: 0;"><span class="create_address">新建收货地址</span></span></a>
		<a href="<?php echo RC_Uri::url('location/index/select_location');?>
<?php if ($_smarty_tpl->tpl_vars['referer_url']->value) {?>&referer_url=<?php echo $_smarty_tpl->tpl_vars['referer_url']->value;?>
<?php }?>"><span class="modal-button"><span class="edit_address">更换地址</span></span></a>
	</div>
</div>
<div class="ecjia-modal-overlay ecjia-modal-overlay-visible"></div><div class="ecjia-mod ecjia-floor ecjia-bottom-bar-pannel o <?php echo $_smarty_tpl->tpl_vars['active']->value;?>
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


<script type="text/javascript">ecjia.touch.category.init();</script>

<?php }?>
<?php }} ?>
