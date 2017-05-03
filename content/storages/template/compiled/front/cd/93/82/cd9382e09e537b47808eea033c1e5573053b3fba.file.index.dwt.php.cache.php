<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:24:24
         compiled from "C:\ecjia-daojia-29\content\themes\ecjia-intro\index.dwt.php" */ ?>
<?php /*%%SmartyHeaderCode:1332259084238480d06-96922129%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cd9382e09e537b47808eea033c1e5573053b3fba' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\themes\\ecjia-intro\\index.dwt.php',
      1 => 1493699977,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1332259084238480d06-96922129',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_title' => 0,
    'theme_url' => 0,
    'shop_logo' => 0,
    'merchant_url' => 0,
    'merchant_login' => 0,
    'mobile_touch_url' => 0,
    'mobile_app_privew1' => 0,
    'mobile_app_privew2' => 0,
    'mobile_app_name' => 0,
    'mobile_app_version' => 0,
    'mobile_iphone_download' => 0,
    'mobile_android_download' => 0,
    'mobile_iphone_qrcode' => 0,
    'touch_qrcode' => 0,
    'shop_weibo_url' => 0,
    'shop_wechat_qrcode' => 0,
    'shop_info' => 0,
    'rs' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_59084238534172_65795091',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59084238534172_65795091')) {function content_59084238534172_65795091($_smarty_tpl) {?><!DOCTYPE html>
<html>
    <head>
<meta name="Generator" content="ECJIA 1.20" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui">
        <title><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</title>
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/js/swiper/swiper.css">
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/css/style.css?16">
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/js/swiper/swiper.js"></script>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
/js/jquery.min.js"></script>
    </head>
    <body>
        <div class="ecjia-header fixed">
            <div class="ecjia-content">
                <div class="ecjia-fl ecjia-logo wt-10"><img src="<?php if ($_smarty_tpl->tpl_vars['shop_logo']->value) {?><?php echo $_smarty_tpl->tpl_vars['shop_logo']->value;?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['theme_url']->value;?>
images/logo.png<?php }?>"></div>
                <div class="ecjia-fr">
                    <ul class="nav">
                        <li><a href="#">首页</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['merchant_url']->value;?>
" target="_blank">商家入驻</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['merchant_login']->value;?>
" target="_blank">商家登录</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="ecjia-container">
            <div class="ecjia-content">
                <div class="ecjia-fl wt-phone">
                    <div class="project-view ecjia-fl m-t-50">
                    <?php if ($_smarty_tpl->tpl_vars['mobile_touch_url']->value) {?>
                        <iframe src="<?php echo $_smarty_tpl->tpl_vars['mobile_touch_url']->value;?>
" frameborder="0" scrolling="auto"></iframe>
                        <div class="ecjia-fl phone-tips">鼠标点击手机体验</div>
                    <?php } else { ?> 
                    
                        <div class="swiper-container-phone">
                            <div class="swiper-wrapper">
                                <?php if ($_smarty_tpl->tpl_vars['mobile_app_privew1']->value) {?>
                                <div class="swiper-slide">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['mobile_app_privew1']->value;?>
" alt="" width="320" height="567">
                                </div>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['mobile_app_privew2']->value) {?>
                                <div class="swiper-slide">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['mobile_app_privew2']->value;?>
" alt="" width="320" height="567">
                                </div>
                                <?php }?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <script type="text/javascript">
                            var swiper = new Swiper('.swiper-container-phone', {
                            	autoplay: 3000,
                                slidesPerView: 1,
                                paginationClickable: true,
                                spaceBetween: 30,
                                pagination: '.swiper-pagination',
                               /*  nextButton: '.swiper-button-next',
                                prevButton: '.swiper-button-prev', */
                                loop: true
                            });
                        </script>
                    <?php }?>
                    </div>
                </div>
                <div class="ecjia-fl wt-135">
                    <div class="ecjia-desc">
                        <span class="ecjia-text-name fsize-36"><?php echo $_smarty_tpl->tpl_vars['mobile_app_name']->value;?>
</span>
						<span class="arrow-left edition-icon"></span>
                        <span class="ecjia-edition"><?php if ($_smarty_tpl->tpl_vars['mobile_app_version']->value) {?><?php echo $_smarty_tpl->tpl_vars['mobile_app_version']->value;?>
<?php } else { ?>1.0.0<?php }?></span>
                        <h2 class="fsize-48 ecjia-truncate"><?php echo $_smarty_tpl->getSubTemplate ("library/shop_subtitle.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
</h2>
                        <p class="fsize-24 ecjia-truncate"><?php echo $_smarty_tpl->getSubTemplate ("library/brief_intro.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
</p>
                        <div class="two-btn wt-30 hover-font">
                            <?php if ($_smarty_tpl->tpl_vars['mobile_iphone_download']->value) {?><a class="ecjia-btn icon-btn" href="<?php echo $_smarty_tpl->tpl_vars['mobile_iphone_download']->value;?>
" target="_blank"><i class="iphone icon"></i>iPhone端下载</a><?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['mobile_android_download']->value) {?><a class="ecjia-btn icon-btn" href="<?php echo $_smarty_tpl->tpl_vars['mobile_android_download']->value;?>
" target="_blank"><i class="android icon"></i>Android端下载</a><?php }?>
                        </div>
                        <div class="ecjia-code wt-50">
                            <?php if ($_smarty_tpl->tpl_vars['mobile_iphone_qrcode']->value) {?>
                            <span class="mr-20">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['mobile_iphone_qrcode']->value;?>
" alt="" width="200" height="200">扫一扫，体验APP
                            </span>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['touch_qrcode']->value) {?>
                            <span style="margin-right:32px;">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['touch_qrcode']->value;?>
" alt="" width="200" height="200">扫一扫，体验微信H5界面
                            </span>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-footer">
				<div class="outlink">
					<?php if ($_smarty_tpl->tpl_vars['shop_weibo_url']->value) {?>
                    <span>
                        <a class="blog-ico" href="<?php echo $_smarty_tpl->tpl_vars['shop_weibo_url']->value;?>
" target="_blank"></a>
                    </span>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['shop_wechat_qrcode']->value) {?>
					<span class="outlink-qrcode">
                        <div class="wechar-code">
							<img src="<?php echo $_smarty_tpl->tpl_vars['shop_wechat_qrcode']->value;?>
">
							<span>打开微信扫一扫关注</span>
						</div>
						<a class="wechart" href="javascript:void(0)"></a>
					</span>
                    <?php }?>
				</div>
                <div class="footer-links">
                    <p>
                        <?php  $_smarty_tpl->tpl_vars['rs'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['rs']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['shop_info']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['rs']->key => $_smarty_tpl->tpl_vars['rs']->value) {
$_smarty_tpl->tpl_vars['rs']->_loop = true;
?>
                        <!-- <a class="data-pjax" href="<?php echo $_smarty_tpl->tpl_vars['rs']->value['url'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['rs']->value['title'];?>
</a> -->
                        <?php } ?>
                    </p>
                </div>
                <p>版权所有 服务到家</p>
                <p>地址： 咨询热线：</p>
            </div>
        </div>
    </body>
</html>
<?php }} ?>
