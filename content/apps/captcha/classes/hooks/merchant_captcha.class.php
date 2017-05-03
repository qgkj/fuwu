<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_config('constant', 'captcha', false);

class captcha_merchant_plugin {
	
	static public function merchant_login_captcha() {
		if (ecjia::config('captcha_style', ecjia::CONFIG_EXISTS) && 
			(intval(ecjia::config('captcha')) & CAPTCHA_ADMIN) && 
			RC_ENV::gd_version() > 0) {
			$captcha = RC_Loader::load_app_class('captcha_method', 'captcha');
			if ($captcha->check_activation_captcha()) {
			    $captcha_url =  $captcha->current_captcha_url(captcha_method::CAPTCHA_MERCHANT);
			    
			    $click_for_another = RC_Lang::get('captcha::captcha_manage.click_for_another');
			    $label_captcha = RC_Lang::get('captcha::captcha_manage.label_merchant_captcha');
			    $validate_length = 4;
			    $validate_url = RC_Uri::url('captcha/merchant_captcha/check_validate');
			    echo  <<<EOF
		<div class="hideimg" style="z-index: -1; position: absolute;"><a class='close'>×</a><img src='$captcha_url' title='$click_for_another' ></div>
		<div class="formRow">
			<div class="input-prepend">
				<input class="form-control"  type="text" maxlength="4" name="captcha" placeholder="$label_captcha" value=""  data-placement="top" />
			</div>
		<script>
			var validate_length = {$validate_length},
				validate_url = "{$validate_url}";
			$(window).load(function(){
				var obj_hideimg = $('.hideimg');
				var obj_img = obj_hideimg.find('img');
						
						
				$(document).on('click', '.popover img', function(){
					var newsrc = $(this).attr('src')+Math.random();
					$(this).attr('src',newsrc);
					$('.hideimg img').attr('src',newsrc);
				});
				$(document).on('click', '.close', function(){
					$('.popover').remove();
				});
	
				$('input[name="captcha"]').keyup(function(event){
					if(event.keyCode === 27 || event.keyCode === 13){
						$('.popover').remove();
						$(this).blur();
					}
						
					if(event.keyCode === 13){
						return;
					}
					var obj_this = $(this),
						obj_row = obj_this.parents('.formRow');
					obj_this.val(obj_this.val().toUpperCase());
					if (obj_this.val().length == validate_length) {
						$.post(validate_url, {'captcha': obj_this.val()}, function(data) {
							if (data.state == 'success') {
								$("input[name=captcha]").css('border-color','#468847');
								$('.popover').remove();
							} else {
								$("input[name=captcha]").css('border-color','#b94a48');
							}
						});
					}
				}).popover({
					html: true,
					animation: false,
					trigger: 'manual',
					content: function(){
						var width = obj_img.width()+15;
						var height = obj_img.height()+10;
						return obj_hideimg.clone().css({width : width, height: height, position : 'relative', zIndex : '9999'});
					}
				});
				$('input[name="captcha"]').focus(function(){
					if(!$('.popover').text()){
						$(this).popover('show');
					}
				});
	
			});
		</script>
EOF;
			}
		}
	}
	
	static public function merchant_login_validate($args) {
		if (ecjia::config('captcha_style', ecjia::CONFIG_EXISTS) && 
			!empty($_SESSION['captcha_word']) && 
			(intval(ecjia::config('captcha')) & CAPTCHA_ADMIN)) {
			/* 检查验证码是否正确 */
			RC_Loader::load_app_class('captcha_factory', 'captcha', false);
			$validator = new captcha_factory(ecjia::config('captcha_style'));
			if (isset($args['captcha']) && !$validator->verify_word($args['captcha'])) {
				return RC_Lang::get('captcha::captcha_manage.captcha_error');
			}
		}
	}
	
	static public function set_merchant_captcha_access($route) {
	    $route[] = 'captcha/merchant_captcha/init';
	    $route[] = 'captcha/merchant_captcha/check_validate';
	    return $route;
	}
}

RC_Hook::add_action('merchant_login_captcha', array('captcha_merchant_plugin', 'merchant_login_captcha'));
RC_Hook::add_filter('merchant_login_validate', array('captcha_merchant_plugin', 'merchant_login_validate'));
RC_Hook::add_filter('merchant_access_public_route', array('captcha_merchant_plugin', 'set_merchant_captcha_access'));

// end