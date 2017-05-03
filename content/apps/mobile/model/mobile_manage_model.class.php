<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_manage_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'mobile_manage';
		parent::__construct();
	}
	
	public function mobile_manage($parameter) {
		$db_mobile_manage = RC_DB::table('mobile_manage');
		if (!isset($parameter['app_id'])) {
			$id = $db_mobile_manage->insertGetid($parameter);
		} else {
			$db_mobile_manage->where(app_id, $parameter['app_id'])->update($parameter);
			
			$id = $parameter['app_id'];
		}
		return $id;
	}
	
	public function mobile_manage_find($id) {
		return RC_DB::table('mobile_manage')->where('app_id', $id)->first();
	}
	
	public function mobile_manage_count() {
		return RC_DB::table('mobile_manage')->count();
	}
}

// end