<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.hook.php
 * Type:     function
 * Name:     hook
 * Purpose:  hook标签
 * -------------------------------------------------------------
 */
function smarty_function_hook($params, Smarty_Internal_Template $template) {
	$hookid = isset($params['hookid']) ? $params['hookid'] : $params['id'];
	
	unset($params['hookid']);
	unset($params['id']);
	
	// RC_Hook::do_action($hookid);
	
	$params = array_values($params);
	array_unshift($params, $hookid);
	return call_user_func_array(array('RC_Hook', 'do_action'), $params);
}

// end