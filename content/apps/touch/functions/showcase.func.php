<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 载入自定义橱窗模板
 * @access  public
 * @param   string  $curr_template  模版名称
 * @param   string  $lib_name       库项目名称
 * @return  array
 */
function load_library($lib_name) {
    $lib_name = str_replace("0xa", '', $lib_name); // 过滤 0xa 非法字符

    $curr_theme = ecjia::config('template') ? ecjia::config('template') : RC_Config::system('TPL_STYLE');
    $theme_dir = SITE_THEME_PATH . $curr_theme . DIRECTORY_SEPARATOR;
    $library_dir = $theme_dir. 'library' . DIRECTORY_SEPARATOR;
    $lib_file    = $library_dir . $lib_name . '.lbi.php';

    RC_Loader::load_sys_func('upload');

    $arr['mark'] = RC_File::file_mode_info($lib_file);
    $arr['html'] = str_replace("\xEF\xBB\xBF", '', file_get_contents($lib_file));
    return $arr;
}

/**
 * 读取自定义橱窗列表
 */
function get_libraries() {
    $arr_library   = array();

    $curr_theme = ecjia::config('template') ? ecjia::config('template') : RC_Config::system('TPL_STYLE');
    $theme_dir = SITE_THEME_PATH . $curr_theme . DIRECTORY_SEPARATOR;
    $library_dir = $theme_dir. 'library' . DIRECTORY_SEPARATOR;
    $library_handle = opendir($library_dir);
    if($library_handle){
        while (false !== ($file = readdir($library_handle))) {
            if (substr($file, -7) == 'lbi.php' && substr($file, 0, 8) == 'showcase') {
                $filename      			= substr($file, 0, -8);
                $library_data = get_library_info($library_dir . $file);
                $arr_library[$filename]['File'] = $file;
                $arr_library[$filename]['Name'] = $library_data['Name'];
                $arr_library[$filename]['Description'] = $library_data['Description'];
            }
        }
    }
    closedir($library_handle);
    return $arr_library;
}

function get_library_info($file) {
    $default_headers = array(
        'Name' => 'Name',
        'Description' => 'Description',
    );

    $library_data = RC_File::get_file_data( $file, $default_headers, 'library' );

    return $library_data;
}

/**
 * 更新自定义橱窗
 */
function update_library($lib_name, $content){

    $curr_theme = ecjia::config('template') ? ecjia::config('template') : RC_Config::system('TPL_STYLE');
    $theme_dir = SITE_THEME_PATH . $curr_theme . DIRECTORY_SEPARATOR;
    $library_dir = $theme_dir. 'library' . DIRECTORY_SEPARATOR;

    $lib_file = $library_dir. $lib_name . '.lbi.php';
    $lib_file = str_replace("0xa", '', $lib_file); // 过滤 0xa 非法字符
    $lib_file = str_replace("\\", '/', $lib_file); //windows兼容处理
    $org_html = str_replace("\xEF\xBB\xBF", '', file_get_contents($lib_file));
    $library_bak_dir = SITE_CACHE_PATH . 'backup' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR;
    if (file_exists($lib_file) === true && file_put_contents($lib_file, $content)) {
        file_put_contents($library_bak_dir . ecjia::config('template') . '-' . $lib_name . '.lbi.php', $org_html);
        return true;
    } else {
        return false;
    }
}

// end
