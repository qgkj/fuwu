<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class role_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'role';
		parent::__construct();
	}


	/**
	 * 获取角色列表
	 * @return array
	 */
	public function get_role_list($where = array()) {
		$record_count = $this->where($where)->count();
		$page = new ecjia_page($record_count, 15, 6);
		
		$list = $this->order('role_id DESC')->limit($page->limit())->select();
		$lists = array('list' => $list, 'page' => $page->show(5));
		return $lists;
	}
}

// end