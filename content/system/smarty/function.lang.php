<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.lang.php
 * Type:     function
 * Name:     lang
 * Purpose:  lang标签
 * -------------------------------------------------------------
 */
function smarty_function_lang($params, Smarty_Internal_Template $template) {
	$key = isset($params['key']) ? $params['key'] : '';
	$lang = $key ? RC_Lang::get($key) : '';
	return $lang;
}

// end