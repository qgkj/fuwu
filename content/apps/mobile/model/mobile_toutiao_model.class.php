<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_toutiao_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'mobile_toutiao';
		parent::__construct();
	}

	public function toutiao_manage($parameter) {
		if (!isset($parameter['id'])) {
			$id = RC_DB::table('mobile_toutiao')->insertGetId($parameter);
		} else {
			RC_DB::table('mobile_toutiao')->where('id', $parameter['id'])->update($parameter);
			$id = $parameter['id'];
		}
		return $id;
	}
	
	public function toutiao_find($id) {
		return RC_DB::table('mobile_toutiao')->where('id', $id)->first();
	}
	
	public function toutiao_remove($id) {
		return RC_DB::table('mobile_toutiao')->where('id', $id)->delete();
	}
	
	public function toutiao_batch($ids, $type) {
		if ($type == 'select') {
			return RC_DB::table('mobile_toutiao')->whereIn('id', $ids)->get();
		} elseif ($type == 'delete') {
			return RC_DB::table('mobile_toutiao')->whereIn('id', $ids)->delete();
		}
	}
}

// end