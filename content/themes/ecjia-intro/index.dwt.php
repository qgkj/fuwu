<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui">
        <title>{$page_title}</title>
        <link rel="stylesheet" href="{$theme_url}/js/swiper/swiper.css">
        <link rel="stylesheet" href="{$theme_url}/css/style.css?16">
        <script type="text/javascript" src="{$theme_url}/js/swiper/swiper.js"></script>
        <script type="text/javascript" src="{$theme_url}/js/jquery.min.js"></script>
    </head>
    <body>
        <div class="ecjia-header fixed">
            <div class="ecjia-content">
                <div class="ecjia-fl ecjia-logo wt-10"><img src="{if $shop_logo}{$shop_logo}{else}{$theme_url}images/logo.png{/if}"></div>
                <div class="ecjia-fr">
                    <ul class="nav">
                        <li><a href="#">首页</a></li>
                        <li><a href="{$merchant_url}" target="_blank">商家入驻</a></li>
                        <li><a href="{$merchant_login}" target="_blank">商家登录</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="ecjia-container">
            <div class="ecjia-content">
                <div class="ecjia-fl wt-phone">
                    <div class="project-view ecjia-fl m-t-50">
                    {if $mobile_touch_url}
                        <iframe src="http://jd.diankai.me/sites/m/" frameborder="0" scrolling="auto"></iframe>
                        <div class="ecjia-fl phone-tips">鼠标点击手机体验</div>
                    {else} 
                    <!-- 62 77 -->
                        <div class="swiper-container-phone">
                            <div class="swiper-wrapper">
                                {if $mobile_app_privew1}
                                <div class="swiper-slide">
                                    <img src="{$mobile_app_privew1}" alt="" width="320" height="567">
                                </div>
                                {/if}
                                {if $mobile_app_privew2}
                                <div class="swiper-slide">
                                    <img src="{$mobile_app_privew2}" alt="" width="320" height="567">
                                </div>
                                {/if}
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
                    {/if}
                    </div>
                </div>
                <div class="ecjia-fl wt-135">
                    <div class="ecjia-desc">
                        <span class="ecjia-text-name fsize-36">{$mobile_app_name}</span>
						<span class="arrow-left edition-icon"></span>
                        <span class="ecjia-edition">{if $mobile_app_version}{$mobile_app_version}{else}1.0.0{/if}</span>
                        <h2 class="fsize-48 ecjia-truncate"><!-- #BeginLibraryItem "/library/shop_subtitle.lbi" --><!-- #EndLibraryItem --></h2>
                        <p class="fsize-24 ecjia-truncate"><!-- #BeginLibraryItem "/library/brief_intro.lbi" --><!-- #EndLibraryItem --></p>
                        <div class="two-btn wt-30 hover-font">
                            {if $mobile_iphone_download}<a class="ecjia-btn icon-btn" href="{$mobile_iphone_download}" target="_blank"><i class="iphone icon"></i>iPhone端下载</a>{/if}
                            {if $mobile_android_download}<a class="ecjia-btn icon-btn" href="{$mobile_android_download}" target="_blank"><i class="android icon"></i>Android端下载</a>{/if}
                        </div>
                        <div class="ecjia-code wt-50">
                            {if $mobile_iphone_qrcode}
                            <span class="mr-20">
                                <img src="{$mobile_iphone_qrcode}" alt="" width="200" height="200">扫一扫，体验APP
                            </span>
                            {/if}
                            {if $touch_qrcode}
                            <span style="margin-right:32px;">
                                <img src="{$touch_qrcode}" alt="" width="200" height="200">扫一扫，体验微信H5界面
                            </span>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-footer">
				<div class="outlink">
					{if $shop_weibo_url}
                    <span>
                        <a class="blog-ico" href="{$shop_weibo_url}" target="_blank"></a>
                    </span>
                    {/if}
                    {if $shop_wechat_qrcode}
					<span class="outlink-qrcode">
                        <div class="wechar-code">
							<img src="{$shop_wechat_qrcode}">
							<span>打开微信扫一扫关注</span>
						</div>
						<a class="wechart" href="javascript:void(0)"></a>
					</span>
                    {/if}
				</div>
                <div class="footer-links">
                    <p>
                        <!-- {foreach from=$shop_info item=rs} -->
                        <!-- <a class="data-pjax" href="{$rs.url}" target="_blank">{$rs.title}</a> -->
                        <!-- {/foreach} -->
                    </p>
                </div>
                <p>版权所有 服务到家</p>
                <p>地址： 咨询热线：</p>
            </div>
        </div>
    </body>
</html>
