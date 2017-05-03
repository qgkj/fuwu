<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_news_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'mobile_news';
		parent::__construct();
	}

	public function mobile_news_manage($data, $where=array()) {
		$db_mobile_news = RC_DB::table('mobile_news');
		if (!empty($where)) {
			foreach ($where as $k => $v) {
				$db_mobile_news->where($k, $v);
			}
			return $db_mobile_news->update($data);
		}
		return RC_DB::table('mobile_news')->insertGetId($data);
	}
	
	public function mobile_news_field($where, $field) {
		$db_mobile_news = RC_DB::table('mobile_news');
		if (!empty($where)) {
			foreach ($where as $k => $v) {
				$db_mobile_news->where($k, $v);
			}
		}
		return $db_mobile_news->pluck($field);
	}
	
	public function mobile_news_count($where) {
		return $this->where($where)->count();
	}
	
	public function mobile_news_list($option) {
		return $this->where($option['where'])->limit($option['limit'])->order($option['order'])->select();
	}
}

// end