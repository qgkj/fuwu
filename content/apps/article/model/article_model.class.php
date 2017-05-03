<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class article_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'article';
		parent::__construct();
	}
	
	/* 判断重复 */
	public function article_count($where = array()) {
		$db_article = RC_DB::table('article');
		if (is_array($where)) {
			foreach ($where as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $key => $val) {
						if ($key == 'neq') {
							$db_article->where($k, '!=', $val);
						}
					}
				} else {
					$db_article->where($k, $v);
				}
			}
		}
		return $db_article->count();
	}
	
	/* 文章管理 */
	public function article_manage($parameter) {
	    if (!isset($parameter['article_id'])) {
	        $id = RC_DB::table('article')->insertGetId($parameter);
	    } else {
	        RC_DB::table('article')->where('article_id', $parameter['article_id'])->update($parameter);
	        $id = $parameter['article_id'];
	    }
	    return $id;
	}
	
	/* 文章详情 */
	public function article_find($id) {
	    return RC_DB::table('article')->where('article_id', $id)->first();
	}
	
	/* 删除文章 */
	public function article_delete($id) {
	    return RC_DB::table('article')->where('article_id', $id)->delete();
	}
	
	/* 查询字段信息 */
	public function article_field($id, $field, $bool=false) {
		$db_article = RC_DB::table('article');
		if (!empty($id)) {
			$db_article->where('article_id', $id);
		}
		if ($bool) {
			return $db_article->lists($field);
		} else {
			return $db_article->pluck($field);
		}
	}
	
	/* 文章批量操作 */
	public function article_batch($ids, $type, $data=array()) {
		$db_article = RC_DB::table('article');
		if (!is_array($ids)) {
			$ids = explode(',', $ids);
		}
	    if ($type == 'select') {
			return $db_article->whereIn('article_id', $ids)->get();
	    } elseif ($type == 'delete') {
	    	return $db_article->whereIn('article_id', $ids)->delete();
	    } elseif ($type == 'update') {
	    	return $db_article->whereIn('article_id', $ids)->update($data);
	    }
	}
	
	public function article_select($where, $field, $in=false) {
	    if ($in) {
	        return $this->field($field)->in($where)->select();
	    }
	    return $this->field($field)->where($where)->select();
	}
	
	/**
	 * 网店帮助分类下的文章
	 */
	public function shophelp_article_select($option) {
		return $this->field($option['field'])->where($option['where'])->order($option['order'])->limit($option['limit'])->select();
	}
	
	/**
	 * 获取网店信息文章数据
	 */
	public function shopinfo_article_select($option) {
		return $this->field($option['field'])->where($option['where'])->order($option['order'])->select();
	}
}

// end