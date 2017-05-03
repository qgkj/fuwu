<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class shipping_area_region_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'area_region';
		parent::__construct();
	}
	
	public function shipping_area_region_insert($data) {
		return RC_DB::table('area_region')->insert($data);
	}
	
	public function shipping_area_region_remove($ids, $in=false) {
		$db_area_region = RC_DB::table('area_region');
		if ($in) {
			return $db_area_region->whereIn('shipping_area_id', $ids)->delete();
		}
		return $db_area_region->where('shipping_area_id', $ids)->delete();
	}
}

// end