<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_goods_article_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'goods_article';
		parent::__construct();
	}
	
	public function goods_article_delete($where) {
		return $this->where($where)->delete();
	}
	
	public function goods_article_select($where) {
		return $this->where($where)->select();
	}
}

// end