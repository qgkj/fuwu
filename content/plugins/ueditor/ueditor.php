<?php
  
/*
Plugin Name: UEditor富文本编辑器
Plugin URI: http://www.ecjia.com/plugins/ecjia.ueditor/
Description: UEditor富文本编辑器，来自百度编辑器
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: system
*/
defined('IN_ECJIA') or exit('No permission resources.');

require_once RC_Plugin::plugin_dir_path(__FILE__) . 'ueditor.class.php';


function set_ecjia_default_editor($name) {
    return new ueditor();
}
RC_Hook::add_filter('the_editor_instance', 'set_ecjia_default_editor');



// end