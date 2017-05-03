<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/*
Plugin Name: 计算器
Plugin URI: http://www.ecjia.com/plugins/ecjia.calculator/
Description: 小巧、方便、功能强大的后台管理员使用的计算器。
Author: ECJIA TEAM
Version: 1.0.0
Author URI: http://www.ecjia.com/
Plugin App: system
*/
require_once RC_Plugin::plugin_dir_path(__FILE__) . 'calculator.class.php';

$calculator = new calculator();

RC_Hook::add_action( 'admin_sidebar_collapse', array($calculator, 'display') );

// end