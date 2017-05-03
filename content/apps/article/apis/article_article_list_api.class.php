<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 文章列表接口
 * @author will.chen
 */
class article_article_list_api extends Component_Event_Api {
	
    /**
     * @param  array $options	条件参数
     * @return array
     */
	public function call(&$options) {
		if (!is_array($options)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('article::article.invalid_parameter'));
		}
		return $this->articleslist($options);
	}
	
	/**
	 * 取得文章信息
	 * @param   array $options	条件参数
	 * @return  array   文章列表
	 */
	
	private function articleslist($options) {
		RC_Loader::load_app_class('article_cat', 'article', false);
		
		$dbview = RC_DB::table('article as a')->leftJoin('article_cat as ac', RC_DB::raw('ac.cat_id'), '=', RC_DB::raw('a.cat_id'));
		
		$filter = array();
		$filter['keywords']	  = empty($options['keywords']) 	? '' : trim($options['keywords']);
		$filter['cat_id']     = empty($options['cat_id']) 		? 0 : intval($options['cat_id']);
		$filter['sort_by']    = empty($options['sort_by']) 		? 'a.article_id' : trim($options['sort_by']);
		$filter['sort_order'] = empty($options['sort_order']) 	? 'DESC' : trim($options['sort_order']);
		$filter['is_open']	  = empty($options['is_open']) 		? 1 : intval($options['is_open']);
		$filter['page_size']  = empty($options['page_size']) 	? 15 : intval($options['page_size']);
		$filter['current_page'] = empty($options['current_page']) ? 1 : intval($options['current_page']);
		//不获取系统帮助文章的过滤
		if (!empty($filter['keywords'])) {
			$dbview->where(RC_DB::raw('a.title'), 'like', '%' .$filter['keywords']. '%');

		}
		if ($filter['cat_id'] && ($filter['cat_id'] > 0)) {
			$dbview->whereIn(RC_DB::raw('a.cat_id'),article_cat::get_children_list($filter['cat_id']));
		}
		/* 是否显示 will.chen*/
		$dbview->where(RC_DB::raw('a.is_open'), '=', $filter['is_open']);
		
		/* 文章总数 */
		$filter['record_count'] = '';
		$count = $dbview->select('article_id')->count();

		$page = new ecjia_page($count, $filter['page_size'], 5, '', $filter['current_page']);
		$filter['record_count'] = $count;
		
		$result = $dbview->select(RC_DB::raw('a.*'), RC_DB::raw('ac.cat_name'), RC_DB::raw('ac.cat_type'), RC_DB::raw('ac.sort_order'))
				  ->orderby(RC_DB::raw($filter['sort_by']), $filter['sort_order'])->take(15)->skip($page->start_id-1)->get();
			  
		$arr = array();
		if(!empty($result)) {
			foreach ($result as $rows) {
				$rows['date'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
				$arr[] = $rows;
			}
		}
		return array('arr' => $arr, 'page' => $page->show(15), 'desc' => $page->page_desc());
	}
}

// end