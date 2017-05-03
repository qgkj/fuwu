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
    '287c52bdef41c7265324661dcb8cd5a67c8691e9' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\sites\\m\\content\\themes\\h5\\library\\page_menu.lbi.php',
      1 => 1487583428,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '129359084dad6310d1-63000696',
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5908bdd4e10745_17811147',
  'has_nocache_code' => true,
  'cache_lifetime' => 3600,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5908bdd4e10745_17811147')) {function content_5908bdd4e10745_17811147($_smarty_tpl) {?><?php $_smarty = $_smarty_tpl->smarty; if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
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
		
<div class="ecjia-user-info user-new-info ecjia-user">
    <?php if ($_smarty_tpl->tpl_vars['user']->value) {?>
    	<a href="<?php echo smarty_function_url(array('path'=>'user/profile/init'),$_smarty_tpl);?>
"><div class="user-img ecjiaf-fl"><img src="<?php echo $_smarty_tpl->tpl_vars['user_img']->value;?>
" alt=""></a></div>
    	<div class="ecjiaf-fl ecjia-margin-l user-rank-name">
    		<span><?php echo $_smarty_tpl->tpl_vars['user']->value['name'];?>
</span>
    		<span class="ecjia-user-buttom"><?php echo $_smarty_tpl->tpl_vars['user']->value['rank_name'];?>
</span>
    	</div>
    	<a href="<?php echo smarty_function_url(array('path'=>'user/user_message/msg_list'),$_smarty_tpl);?>
">
    		<?php if ($_smarty_tpl->tpl_vars['order_num']->value['msg_num']) {?>
    		<span class="ecjia-icon ecjia-icon ecjia-icon-num"><?php echo $_smarty_tpl->tpl_vars['order_num']->value['msg_num'];?>
</span>
    		<?php }?>
    	</a>
	<?php } else { ?>
	   	<a href="<?php echo smarty_function_url(array('path'=>'user/privilege/login'),$_smarty_tpl);?>
"><div class="no-login">登录 / 注册</div></a>
	<?php }?>
</div>

<?php if ($_smarty_tpl->tpl_vars['user']->value['id']) {?>
<div class="ecjia-user-head ecjia-user ecjia-color-green ecjia-user-marg-t">
    <ul class="ecjia-user-marg-t ecjia-list list-short ecjia-user-no-border-t">
       <li>
        	<a href="<?php echo smarty_function_url(array('path'=>'user/account/init'),$_smarty_tpl);?>
">
        		<div class="icon-wallet"><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/images/user_center/75x75_1.png"></div>
        		<span class="icon-name"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
我的钱包<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
</div>
<div class="ecjia-user-border-b">
    <ul class="ecjia-user ecjia-list bonus ecjia-nav-child-f ecjia-list-three ecjia-login-nav-bottom">
    	<li>
    		<a href="<?php echo smarty_function_url(array('path'=>'user/account/balance'),$_smarty_tpl);?>
">
    		    <p><?php echo $_smarty_tpl->tpl_vars['user']->value['formated_user_money'];?>
</p>
    			<p>余额</p>
    		</a>
    	</li>
    	<li>
    		<a href="<?php echo smarty_function_url(array('path'=>'user/bonus/init'),$_smarty_tpl);?>
">
    		    <p><?php if ($_smarty_tpl->tpl_vars['user']->value['user_bonus_count']=='0') {?><?php echo 0;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['user']->value['user_bonus_count'];?>
<?php }?></p>
    			<p>红包</p>
    		</a>
    	</li>
    	<li>
    	    <a href="<?php echo smarty_function_url(array('path'=>'user/account/init'),$_smarty_tpl);?>
">
        		<p><?php echo $_smarty_tpl->tpl_vars['user']->value['user_points'];?>
</p>
        		<p>积分</p>
    		</a>
    	</li>
    </ul>
</div>
<?php } else { ?>
<div class="ecjia-user-head ecjia-user ecjia-color-green ecjia-user-marg-t">
    <ul class="ecjia-user-marg-t ecjia-list list-short ecjia-user-no-border-t">
       <li>
        	<a href="<?php echo smarty_function_url(array('path'=>'user/privilege/login'),$_smarty_tpl);?>
">
        		<div class="icon-wallet"><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/images/user_center/75x75_1.png"></div>
        		<span class="icon-name"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
我的钱包<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
</div>
<div class="ecjia-user-border-b">
    <ul class="ecjia-user ecjia-list bonus ecjia-nav-child-f ecjia-list-three ecjia-login-nav-bottom">
    	<li>
    		<a href="<?php echo smarty_function_url(array('path'=>'user/privilege/login'),$_smarty_tpl);?>
">
    		    <p><?php echo '- -';?>
</p>
    			<p>余额</p>
    		</a>
    	</li>
    	<li>
    		<a href="<?php echo smarty_function_url(array('path'=>'user/privilege/login'),$_smarty_tpl);?>
">
    		    <p><?php echo '- -';?>
</p>
    			<p>红包</p>
    		</a>
    	</li>
    	<li>
    	    <a href="<?php echo smarty_function_url(array('path'=>'user/privilege/login'),$_smarty_tpl);?>
">
        		<p><?php echo '- -';?>
</p>
        		<p>积分</p>
    		</a>
    	</li>
    </ul>
</div>
<?php }?>

<div class="ecjia-user ecjia-margin-b">
    <ul class="ecjia-list list-short">
		<li>
			<a href="<?php echo smarty_function_url(array('path'=>'user/address/address_list'),$_smarty_tpl);?>
">
        		<div class="icon-address-list"><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/images/user_center/75x75_3.png"></div>
        		<span class="icon-name">收货地址</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
		</li>
       	<li>
        	<a class="nopjax external" href="<?php echo smarty_function_url(array('path'=>'user/index/spread'),$_smarty_tpl);?>
&name=<?php echo $_smarty_tpl->tpl_vars['user']->value['name'];?>
">
        		<div class="icon-expand"><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/images/user_center/expand.png"></div>
        		<span class="icon-name">我的推广</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>

    <ul class="ecjia-list list-short">
        <li>
        	<a class="external" href="tel:xxx">
        		<div class="icon-website-service"><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/images/user_center/75x75_5.png"></div>
        		<span class="icon-name">联系客服</span>
        		<span class="icon-price"><?php echo 'xxx';?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
        <!-- <li>
        	<a class="external" href="https://ecjia.com" target="_blank">
        		<div class="icon-offical-website"><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/images/user_center/75x75_6.png"></div>
        		<span class="icon-name">官网网站</span>
        		<span class="icon-price"><?php echo 'www.ecjia.com';?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li> -->
    </ul>
   <!--  <ul class="ecjia-list list-short">
        <li>
        	<a class="external" href="<?php echo smarty_function_url(array('path'=>'article/help/init'),$_smarty_tpl);?>
">
        		<div class="icon-help-center"><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/images/user_center/help75_3.png"></div>
        		<span class="icon-name">帮助中心</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul> -->
    <!-- <ul class="ecjia-list list-short">
            <li>
            	<a class="external" href="<?php echo RC_uri::url('article/shop/detail');?>
&title=<?php echo $_smarty_tpl->tpl_vars['value']->value['title'];?>
&article_id=<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
">
            		<div class="icon-shop-info"><img src="<?php echo $_smarty_tpl->tpl_vars['value']->value['image'];?>
"></div>
            		<span class="icon-name"><?php echo $_smarty_tpl->tpl_vars['value']->value['title'];?>
</span>
            		<i class="iconfont  icon-jiantou-right"></i>
            	</a>
            </li>
    </ul> -->
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
	ecjia.touch.user.init();
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


<div class="ecjia-user-info user-new-info ecjia-user">
    <?php if ($_smarty_tpl->tpl_vars['user']->value) {?>
    	<a href="<?php echo smarty_function_url(array('path'=>'user/profile/init'),$_smarty_tpl);?>
"><div class="user-img ecjiaf-fl"><img src="<?php echo $_smarty_tpl->tpl_vars['user_img']->value;?>
" alt=""></a></div>
    	<div class="ecjiaf-fl ecjia-margin-l user-rank-name">
    		<span><?php echo $_smarty_tpl->tpl_vars['user']->value['name'];?>
</span>
    		<span class="ecjia-user-buttom"><?php echo $_smarty_tpl->tpl_vars['user']->value['rank_name'];?>
</span>
    	</div>
    	<a href="<?php echo smarty_function_url(array('path'=>'user/user_message/msg_list'),$_smarty_tpl);?>
">
    		<?php if ($_smarty_tpl->tpl_vars['order_num']->value['msg_num']) {?>
    		<span class="ecjia-icon ecjia-icon ecjia-icon-num"><?php echo $_smarty_tpl->tpl_vars['order_num']->value['msg_num'];?>
</span>
    		<?php }?>
    	</a>
	<?php } else { ?>
	   	<a href="<?php echo smarty_function_url(array('path'=>'user/privilege/login'),$_smarty_tpl);?>
"><div class="no-login">登录 / 注册</div></a>
	<?php }?>
</div>

<?php if ($_smarty_tpl->tpl_vars['user']->value['id']) {?>
<div class="ecjia-user-head ecjia-user ecjia-color-green ecjia-user-marg-t">
    <ul class="ecjia-user-marg-t ecjia-list list-short ecjia-user-no-border-t">
       <li>
        	<a href="<?php echo smarty_function_url(array('path'=>'user/account/init'),$_smarty_tpl);?>
">
        		<div class="icon-wallet"><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/images/user_center/75x75_1.png"></div>
        		<span class="icon-name"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
我的钱包<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
</div>
<div class="ecjia-user-border-b">
    <ul class="ecjia-user ecjia-list bonus ecjia-nav-child-f ecjia-list-three ecjia-login-nav-bottom">
    	<li>
    		<a href="<?php echo smarty_function_url(array('path'=>'user/account/balance'),$_smarty_tpl);?>
">
    		    <p><?php echo $_smarty_tpl->tpl_vars['user']->value['formated_user_money'];?>
</p>
    			<p>余额</p>
    		</a>
    	</li>
    	<li>
    		<a href="<?php echo smarty_function_url(array('path'=>'user/bonus/init'),$_smarty_tpl);?>
">
    		    <p><?php if ($_smarty_tpl->tpl_vars['user']->value['user_bonus_count']=='0') {?><?php echo 0;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['user']->value['user_bonus_count'];?>
<?php }?></p>
    			<p>红包</p>
    		</a>
    	</li>
    	<li>
    	    <a href="<?php echo smarty_function_url(array('path'=>'user/account/init'),$_smarty_tpl);?>
">
        		<p><?php echo $_smarty_tpl->tpl_vars['user']->value['user_points'];?>
</p>
        		<p>积分</p>
    		</a>
    	</li>
    </ul>
</div>
<?php } else { ?>
<div class="ecjia-user-head ecjia-user ecjia-color-green ecjia-user-marg-t">
    <ul class="ecjia-user-marg-t ecjia-list list-short ecjia-user-no-border-t">
       <li>
        	<a href="<?php echo smarty_function_url(array('path'=>'user/privilege/login'),$_smarty_tpl);?>
">
        		<div class="icon-wallet"><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/images/user_center/75x75_1.png"></div>
        		<span class="icon-name"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
我的钱包<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
</div>
<div class="ecjia-user-border-b">
    <ul class="ecjia-user ecjia-list bonus ecjia-nav-child-f ecjia-list-three ecjia-login-nav-bottom">
    	<li>
    		<a href="<?php echo smarty_function_url(array('path'=>'user/privilege/login'),$_smarty_tpl);?>
">
    		    <p><?php echo '- -';?>
</p>
    			<p>余额</p>
    		</a>
    	</li>
    	<li>
    		<a href="<?php echo smarty_function_url(array('path'=>'user/privilege/login'),$_smarty_tpl);?>
">
    		    <p><?php echo '- -';?>
</p>
    			<p>红包</p>
    		</a>
    	</li>
    	<li>
    	    <a href="<?php echo smarty_function_url(array('path'=>'user/privilege/login'),$_smarty_tpl);?>
">
        		<p><?php echo '- -';?>
</p>
        		<p>积分</p>
    		</a>
    	</li>
    </ul>
</div>
<?php }?>

<div class="ecjia-user ecjia-margin-b">
    <ul class="ecjia-list list-short">
		<li>
			<a href="<?php echo smarty_function_url(array('path'=>'user/address/address_list'),$_smarty_tpl);?>
">
        		<div class="icon-address-list"><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/images/user_center/75x75_3.png"></div>
        		<span class="icon-name">收货地址</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
		</li>
       	<li>
        	<a class="nopjax external" href="<?php echo smarty_function_url(array('path'=>'user/index/spread'),$_smarty_tpl);?>
&name=<?php echo $_smarty_tpl->tpl_vars['user']->value['name'];?>
">
        		<div class="icon-expand"><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/images/user_center/expand.png"></div>
        		<span class="icon-name">我的推广</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>

    <ul class="ecjia-list list-short">
        <li>
        	<a class="external" href="tel:xxx">
        		<div class="icon-website-service"><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/images/user_center/75x75_5.png"></div>
        		<span class="icon-name">联系客服</span>
        		<span class="icon-price"><?php echo 'xxx';?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
        <!-- <li>
        	<a class="external" href="https://ecjia.com" target="_blank">
        		<div class="icon-offical-website"><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/images/user_center/75x75_6.png"></div>
        		<span class="icon-name">官网网站</span>
        		<span class="icon-price"><?php echo 'www.ecjia.com';?>
</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li> -->
    </ul>
   <!--  <ul class="ecjia-list list-short">
        <li>
        	<a class="external" href="<?php echo smarty_function_url(array('path'=>'article/help/init'),$_smarty_tpl);?>
">
        		<div class="icon-help-center"><img src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/images/user_center/help75_3.png"></div>
        		<span class="icon-name">帮助中心</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul> -->
    <!-- <ul class="ecjia-list list-short">
            <li>
            	<a class="external" href="<?php echo RC_uri::url('article/shop/detail');?>
&title=<?php echo $_smarty_tpl->tpl_vars['value']->value['title'];?>
&article_id=<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
">
            		<div class="icon-shop-info"><img src="<?php echo $_smarty_tpl->tpl_vars['value']->value['image'];?>
"></div>
            		<span class="icon-name"><?php echo $_smarty_tpl->tpl_vars['value']->value['title'];?>
</span>
            		<i class="iconfont  icon-jiantou-right"></i>
            	</a>
            </li>
    </ul> -->
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
	ecjia.touch.user.init();
</script>

<?php }?>
<?php }} ?>
