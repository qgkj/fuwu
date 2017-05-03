<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 默认插件处理器
 *
 * 当Smarty在编译过程中遇到未定义的标签时调用
 *
 * @param string                     $name      未定义标签的名称
 * @param string                     $type     标签类型 (比如： Smarty::PLUGIN_FUNCTION，Smarty::PLUGIN_BLOCK，
 Smarty::PLUGIN_COMPILER，Smarty::PLUGIN_MODIFIER，Smarty::PLUGIN_MODIFIERCOMPILER)
 * @param Smarty_Internal_Template   $template     模板对象
 * @param string                     &$callback    返回 回调函数名
 * @param string                     &$script      当回调函数是外部的，可返回 函数所在脚本的路径。
 * @param bool                       &$cacheable    默认true， 如果插件是不可缓存的设置成false (Smarty >= 3.1.8)
 * @return bool                      成功返回true
 */
function smarty_plugin_handler ($name, $type, $template, &$callback, &$script, &$cacheable)
{
	switch ($type) {
		case Smarty::PLUGIN_FUNCTION:
			switch ($name) {
				case 'scriptfunction':
					$script = './scripts/script_function_tag.php';
					$callback = 'default_script_function_tag';
					return true;
				case 'localfunction':
					$callback = 'default_local_function_tag';
					return true;
				default:
					
					return false;
			}
		case Smarty::PLUGIN_COMPILER:
			switch ($name) {
				case 'scriptcompilerfunction':
					$script = './scripts/script_compiler_function_tag.php';
					$callback = 'default_script_compiler_function_tag';
					return true;
				default:
					return false;
			}
		case Smarty::PLUGIN_BLOCK:
			switch ($name) {
				case 'scriptblock':
					$script = './scripts/script_block_tag.php';
					$callback = 'default_script_block_tag';
					return true;
				default:
					return false;
			}
		default:
			return false;
	}
}

// end