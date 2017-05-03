<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_device_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'mobile_device';
		parent::__construct();
	}
	
	/**
	 * 取得设备列表
	 *
	 * @return  array
	 */
	public function device_list($option) {
		return $this->where($option['where'])->order($option['order'])->limit($option['limit'])->select();
	}
	
	public function device_update($ids, $data=array(), $in=false) {
		$db_mobile_device = RC_DB::table('mobile_device');
		if ($in) {
			return $db_mobile_device->whereIn('id', $ids)->update($data);
		}
		$db_mobile_device->where('id', $ids)->update($data);
		return true;
	}
	
	public function device_find($id) {
		return RC_DB::table('mobile_device')->where('id', $id)->first();
	}
	
	public function device_delete($id, $in=false) {
		if ($in) {
			return RC_DB::table('mobile_device')->whereIn(id, $id)->delete();
		}
		return RC_DB::table('mobile_device')->where('id', $id)->delete();
	}
	
	public function device_select($where, $in=false) {
		$db_mobile_device = RC_DB::table('mobile_device');

		if ($in) {
			$db_mobile_device->whereIn('id', $where);
		} else {
			$db_mobile_device->where('id', $where);
		}
		return $db_mobile_device->get();
	}
}

// end