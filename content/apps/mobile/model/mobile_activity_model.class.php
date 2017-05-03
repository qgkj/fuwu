<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_activity_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'mobile_activity';
		parent::__construct();
	}
	
	public function activity_count($where) {
		$db_mobile_activity = RC_DB::table('mobile_activity');
		if (is_array($where)) {
			foreach ($where as $key => $val) {
				if (is_array($val)) {
					foreach ($val as $k => $v) {
						if ($k == 'neq') {
							$db_mobile_activity->where($key, '!=', $v);
						}
					}
				} else {
					$db_mobile_activity->where($key, $val);
				}
			}
		}
		return $db_mobile_activity->count();
	}
	
	public function mobile_activity_manage($parameter) {
		if (!isset($parameter['activity_id'])) {
			$id =  RC_DB::table('mobile_activity')->insertGetId($parameter);
		} else {
			RC_DB::table('mobile_activity')->where('activity_id', $parameter['activity_id'])->update($parameter);
			$id = $parameter['activity_id'];
		}
		return $id;
	}
	
	public function mobile_activity_find($id) {
		return RC_DB::table('mobile_activity')->where('activity_id', $id)->first();
	}
	
	public function mobile_activity_field($id, $field) {
		return RC_DB::table('mobile_activity')->where('activity_id', $id)->pluck($field);
	}
	
	public function mobile_activity_remove($id) {
		return RC_DB::table('mobile_activity')->where('activity_id', $id)->delete();
	}
}

// end