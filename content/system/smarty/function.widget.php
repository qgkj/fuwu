<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.widget.php
 * Type:     function
 * Name:     widget
 * Purpose:  widget标签
 * -------------------------------------------------------------
 */
function smarty_function_widget($params, Smarty_Internal_Template $template) {
	return '<?php display_widgets(' . $params . '); ?>';
}

function display_widgets($arr) {
	/* 请求控制器 */
	ecjia_admin::$controller->display_widgets($arr);
}

// end