<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.insert_scripts.php
 * Type:     function
 * Name:     insert_scripts
 * Purpose:  插入前台JS脚本
 * -------------------------------------------------------------
 */
function smarty_function_insert_scripts($params, Smarty_Internal_Template $template) {
    static $scripts = array();
        
	$arr = explode(',', str_replace(' ', '', $params['files']));

	$str = '';
	foreach ($arr AS $val) {
		if (in_array($val, $scripts) == false) {
			$scripts[] = $val;
			if ($val{0} == '.') {
				$str .= '<script type="text/javascript" src="' . $val . '"></script>';
			} else {
				//$str .= '<script type="text/javascript" src="' . _FILE_TPL() . 'js/' . $val . '"></script>';
				$str .= '<script type="text/javascript" src="' . RC_Theme::get_template_directory_uri(). '/js/' . $val . '"></script>';
				
			}
		}
	}

	return $str;
}

// end