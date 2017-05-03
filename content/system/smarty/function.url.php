<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.url.php
 * Type:     function
 * Name:     url
 * Purpose:  url标签
 * -------------------------------------------------------------
 */
function smarty_function_url($params, Smarty_Internal_Template $template) {
	$path = isset($params['path']) ? $params['path'] : $params[0];
	$args = isset($params['args']) ? $params['args'] : $params[1];
	return RC_Uri::url($path, $args);
}

// end