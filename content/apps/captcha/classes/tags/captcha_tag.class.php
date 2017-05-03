<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.captcha.php
 * Type:     function
 * Name:     captcha
 * Purpose:  验证码显示
 * -------------------------------------------------------------
 */
class captcha_tag {
	public static function ecjia_function_captcha($params, Smarty_Internal_Template $template) {
	
		$rand = rc_random(10);
		return "index.php?m=captcha&c=index&a=init&code=ecjia.captcha_royalcms&rand=" . $rand;
	}
}

ecjia::register_view_plugin('function', 'captcha', array('captcha_tag', 'ecjia_function_captcha'));

// end