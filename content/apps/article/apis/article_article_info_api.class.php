<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 文章信息接口
 * @author will.chen
 */
class article_article_info_api extends Component_Event_Api {
	
    /**
     * @param  array $options	条件参数
     * @return array
     */
	public function call(&$options) {
		if (!is_array($options)
		|| !isset($options['id'])) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('article::article.invalid_parameter'));
		}
		return $this->article_info($options);
	}
	
	/**
	 * 取得文章信息
	 * @param   array $options	条件参数
	 * @return  array   文章列表
	 */
	
	private function article_info($options) {
		$article_id = intval($options['id']);
		$is_open = empty($options['is_open']) ? 1 : intval($options['is_open']);
		
		$db = RC_DB::table('article');
		
		$db->where('article_id', '=', $article_id);
		$db->where('is_open', '=', $is_open);
		$info = $db->first();
		return $info;
	}
}

// end