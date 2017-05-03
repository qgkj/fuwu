<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.insert_sys_scripts.php
 * Type:     function
 * Name:     insert_sys_scripts
 * Purpose:  插入后台JS脚本
 * -------------------------------------------------------------
 */
function smarty_function_insert_sys_scripts($params, Smarty_Internal_Template $template) {
    static $scripts = array();

    $arr = explode(',', str_replace(' ', '', $params['files']));

    $str = '';
    foreach ($arr AS $val) {
        if (in_array($val, $scripts) == false) {
            $scripts[] = $val;
            if ($val{0} == '.') {
                //$str .= '<script src="' . _FILE_STATIC() . $val . '" type="text/javascript"></script>';
				$str .= '<script src="' . RC_Uri::admin_url('statics/'. $val)  . '" type="text/javascript"></script>';
            } else {
                //$str .= '<script src="'. _FILE_STATIC() . 'lib/ecjia-js/' . $val . '" type="text/javascript"></script>';
				$str .= '<script src="'. RC_Uri::admin_url('statics/lib/ecjia-js/'. $val). '" type="text/javascript"></script>';
            }

            $str .= "\n";
        }
    }

    return $str;
}

// end
