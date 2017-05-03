<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.widget.php
 * Type:     function
 * Name:     editor
 * Purpose:  editor标签
 * -------------------------------------------------------------
 */
function smarty_function_editor($params, Smarty_Internal_Template $template) {
	$post_content = isset($params['content']) ? $params['content'] : '';
	$textarea_name = isset($params['textarea_name']) ? $params['textarea_name'] : 'content';
	$editor_height = isset($params['editor_height']) ? $params['editor_height'] : '360';
	$teeny = (isset($params['is_teeny']) && $params['is_teeny'] == 0) ? false : true;
	$mode = isset($params['mode']) ? $params['mode'] : 'standard';
	
	return ecjia_editor::editor( $post_content, $textarea_name, array(
					'dfw' => true,
					'drag_drop_upload' => true,
					'tabfocus_elements' => 'insert-media-button,save-post',
					'editor_height' => $editor_height,
	                'teeny' => $teeny,
					'tinymce' => array('resize' => false, 'add_unload_trigger' => false),
	                'mode' => $mode,
				) 
			);
}


// end