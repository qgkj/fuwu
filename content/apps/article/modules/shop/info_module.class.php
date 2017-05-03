<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商店帮助列表
 * @author royalwang
 */
class info_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$article_db = RC_DB::table('article');
    	$article_db->where('cat_id' , '=', 0);
    	$article_db->where('content' , '<>', '');
    	$article_db->where('title' , '<>', '');
    	
    	$cat_id = 0;
    	$cache_article_key = 'article_list_'.$cat_id;
    	$cache_id = sprintf('%X', crc32($cache_article_key));
    	$orm_article_db = RC_Model::model('article/orm_article_model');
    	$list = $orm_article_db->get_cache_item($cache_id);
    	if (empty($list)) {
    		$res = $article_db->get();
    		if (!empty($res)) {
    			$list = array();
    			foreach ($res as $row) {
    				$list[] =  array(
    					'id'	=> $row['article_id'],
    					'image' => !empty($row['file_url']) ? RC_Upload::upload_url($row['file_url']) : '',
    					'title'	=> $row['title'],
    				);
    			}
    		}
    		$orm_article_db->set_cache_item($cache_id, $list);
    	}
    	return $list;
	}
}

// end