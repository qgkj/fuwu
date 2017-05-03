<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class article_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'article';
		$this->table_alias_name = 'a';

		$this->view = array(
			'article_cat' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'ac',
				'on'    => 'ac.cat_id = a.cat_id',
			),
			'auto_manage' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'am',
				'on'    => 'a.article_id = am.item_id AND am.type = "article"',
			),
		);
		parent::__construct();
	}
	
	public function article_count($where = array(), $table = null, $field = '*') {
		return $this->join($table)->where($where)->count($field);
	}
	
	public function article_select($option) {
		return $this->join($option['table'])->field($option['field'])->where($option['where'])->order($option['order'])->limit($option['limit'])->select();
	}
	
	public function get_shop_help() {
	    $res = RC_DB::table('article')
    	    ->leftJoin('article_cat', 'article.cat_id', '=', 'article_cat.cat_id')
    	    ->where('cat_type', 5)->where('parent_id', 3)->where('is_open', 1)->where('open_type', 0)->whereNotNull('cat_name')
    	    ->orderBy('sort_order', 'ASC')->orderBy('article_id', 'ASC')
    	    ->get();
	    
	    $arr = array();
	    if (!empty($res)) {
	        foreach ($res AS $key => $row) {
	            if (!empty($row['link']) && $row['link'] != 'http://' && $row['link'] != 'https://') {
	                continue;
	            }
	            if (empty($row['content']) || empty($row['cat_name'])) {
	                continue;
	            }
	    
	            $arr[$row['cat_id']]['name']                     	 = $row['cat_name'];
	            $arr[$row['cat_id']]['article'][$key]['id']  		 = $row['article_id'];
	            $arr[$row['cat_id']]['article'][$key]['title']       = $row['title'];
	            $arr[$row['cat_id']]['article'][$key]['short_title'] = ecjia::config('article_title_length') > 0 ?
	            RC_String::sub_str($row['title'], ecjia::config('article_title_length')) : $row['title'];
	        }
	    }
	    return $arr;
	}
}

// end