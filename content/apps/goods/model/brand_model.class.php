<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class brand_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'brand';
		parent::__construct();
	}
	
	public function brand_count($where) {
		return $this->where($where)->count();
	}
	
	public function brand_find($id) {
		return $this->where(array('brand_id' => $id))->find();
	}
	
	public function brand_manage($parameter) {
		if (!isset($parameter['brand_id'])) {
			$id = $this->insert($parameter);
		} else {
			$where = array('brand_id' => $parameter['brand_id']);
	
			$this->where($where)->update($parameter);
			$id = $parameter['brand_id'];
		}
		return $id;
	}
	
	public function brand_remove($id) {
		return $this->where(array('brand_id' => $id))->delete();
	}
	
	public function brand_field($where, $field, $bool=false) {
		return $this->where($where)->get_field($field, $bool);
	}
}

// end