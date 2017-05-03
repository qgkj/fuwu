<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_activity_log_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'mobile_activity_log';
		parent::__construct();
	}	
	
	public function activity_log_count($where) {
		return RC_DB::table('mobile_activity_log')->where('activity_id', $where)->count();
	}
	
	/**
	 * 获取活动记录列表数据
	 * @return array
	 */
	public function activity_record_list($option) {
		return $this->where($option['where'])->order($option['order'])->limit($option['limit'])->select();
	}
}

// end