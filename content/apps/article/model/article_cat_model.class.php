<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class article_cat_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'article_cat';
		parent::__construct();
	}

	/* 判断重复 */
	public function article_cat_count($where) {
	    $db_article_cat = RC_DB::table('article_cat');
	    if (is_array($where)) {
	    	foreach ($where as $k => $v) {
	    		if (is_array($v)) {
	    			foreach ($v as $key => $val) {
	    				if ($key == 'neq') {
	    					$db_article_cat->where($k, '!=', $val);
	    				}
	    			}
	    		} else {
	    			$db_article_cat->where($k, $v);
	    		}
	    	}
	    }
	    return $db_article_cat->count();
	}
	
	/* 文章分类管理 */
	public function article_cat_manage($parameter, $where='') {
		$db_article_cat = RC_DB::table('article_cat');
	    if (empty($where)) {
	    	return $db_article_cat->insertGetId($parameter);
	    } else {
	    	if (!empty($where)) {
    			if (is_array($where)) {
    				foreach ($where as $k => $v) {
    					$db_article_cat->where($k, $v);
    				}
    			}
	    	}
	    	$db_article_cat->update($parameter);
	    	return true;
	    }
	}
	
	/* 查询分类信息 */
	public function article_cat_info($id) {
	    return RC_DB::table('article_cat')->where('cat_id', $id)->first();
	}
	
	/* 删除文章分类 */
	public function article_cat_delete($id) {
		return RC_DB::table('article_cat')->where('cat_id', $id)->delete();
	}
	
	/* 查询字段信息 */
	public function article_cat_field($cat_id, $field) {
		return RC_DB::table('article_cat')->where('cat_id', $cat_id)->pluck($field);
	}

	/**
	 * 获得网店帮助文章分类
	 * @return array
	 */
	public function shophelp_select($option) {
		return $this->field($option['field'])->where($option['where'])->order($option['order'])->select();
	}
}

// end