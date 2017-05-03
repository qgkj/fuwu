<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class detail_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
		$id = $this->requestData('article_id', 0);
		if ($id <= 0) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}
		
		$cache_article_key = 'article_info_'.$id;
		$cache_id = sprintf('%X', crc32($cache_article_key));
		
		$article_db = RC_Model::model('article/orm_article_model');
		$html = $article_db->get_cache_item($cache_id);
		if (empty($html)) {
			$article_info = get_article_info($id);
			if (empty($article_info)) {
				return new ecjia_error('does not exist', '不存在的信息');
			}
			$base = sprintf('<base href="%s/" />', dirname(SITE_URL));
			$html['data'] = '<!DOCTYPE html><html><head><title>'.$article_info['title'].'</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="viewport" content="initial-scale=1.0"><meta name="viewport" content="initial-scale = 1.0 , minimum-scale = 1.0 , maximum-scale = 1.0" /><style>img {width: auto\9;height: auto;vertical-align: middle;border: 0;-ms-interpolation-mode: bicubic;max-width: 100%; }html { font-size:100%; }p{word-wrap : break-word ;word-break:break-all;} </style>'.$base.'</head><body>'.$article_info['content'].'</body></html>';
			$article_db->set_cache_item($cache_id, $html);
		}
		return $html;
	}
}

function get_article_info($article_id) {
	/* 获得文章的信息 */
	$db = RC_Loader::load_app_model('article_model', 'article');
    $row = $db->field('article_id as id, title, content')->find(array('is_open' => 1, 'article_id' => $article_id));
    return $row;
}

// end