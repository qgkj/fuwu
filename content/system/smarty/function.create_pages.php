<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.create_pages.php
 * Type:     function
 * Name:     create_pages
 * Purpose:  创建页面
 * -------------------------------------------------------------
 */
function smarty_function_create_pages($params, Smarty_Internal_Template $template) {
    extract($params);
    
    if (empty($page)) {
        $page = 1;
    }

    if (!empty($count)) {
        $str = "<option value='1'>1</option>";
        $min = min($count - 1, $page + 3);
        for ($i = $page - 3 ; $i <= $min ; $i++) {
            if ($i < 2) {
                continue;
            }
            $str .= "<option value='$i'";
            $str .= $page == $i ? " selected='true'" : '';
            $str .= ">$i</option>";
        }
        if ($count > 1) {
            $str .= "<option value='$count'";
            $str .= $page == $count ? " selected='true'" : '';
            $str .= ">$count</option>";
        }
    } else {
        $str = '';
    }

    return $str;
}

// end