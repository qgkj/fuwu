<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class stats_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'stats';
		parent::__construct();
	}

	public function stats_select($where, $field='*', $group=null, $order=null, $limit=null) {
		return $this->where($where)->field($field)->group($group)->order($order)->limit($limit)->select();
	}
}

// end