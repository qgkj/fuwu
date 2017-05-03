<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商店帮助列表
 * @author royalwang
 */
class help_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$cache_article_key = 'article_list_';
    	$cache_id = sprintf('%X', crc32($cache_article_key));
    	$article_db = RC_Model::model('article/orm_article_model');
    	$out = $article_db->get_cache_item($cache_id);
    	if (empty($out)) {
    		$data = get_shop_help2();
    		$out = array();
    		foreach ($data as $value) {
    			$value['article'] && $value['article'] = array_values($value['article']);
    			$out[] = $value;
    		}
    		$article_db->set_cache_item($cache_id, $out);
    	}
		return $out;
	}
}

function get_shop_help2() {
	$data = RC_Model::model('article/article_viewmodel')->get_shop_help();
	return $data;
}

// end