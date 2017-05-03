<?php 
  
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 载入ECjia Tag项目
 * @param string $source
 * @param object $smarty
 * @return mixed
 */
function smarty_prefilter_ecjia_tag($source, $smarty) {
	/* 解析ecjia标签 */
	$pattern = '/{ecjia:(\w+)\s+([^}]+)}/ie';
	if (preg_match_all($pattern, $source, $reg_match)) {
		foreach ($reg_match[0] as $key => $value) {
			$source = ecjia_tag_replace($reg_match[0][$key], $reg_match[1][$key], $reg_match[2][$key], $source, $smarty);
		}
	}
	
	$pattern = '/{ecjia:(\w+)}/ie';
	if (preg_match_all($pattern, $source, $reg_match)) {
		foreach ($reg_match[0] as $key => $value) {
			$source = ecjia_tag_replace($reg_match[0][$key], $reg_match[1][$key], null, $source, $smarty);
		}
	}
	
	return $source;
}

function ecjia_tag_replace($ecjia_tag, $tag, $params, $source, & $smarty) {
	if (!in_array($tag, array('hook', 'editor'))) {
		RC_Loader::load_app_class($tag . '_tag', $tag, false);
	}

	$source = str_replace('ecjia:'.$tag, $tag, $source);
	
	return $source;
}


// end