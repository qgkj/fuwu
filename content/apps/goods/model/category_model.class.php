<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class category_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'category';
		parent::__construct();
	}
	
	public function category_manage($parameter) {
		if (!isset($parameter['cat_id'])) {
			$id = $this->insert($parameter);
		} else {
			$where = array('cat_id' => $parameter['cat_id']);
		
			$this->where($where)->update($parameter);
			$id = $parameter['cat_id'];
		}
		return $id;
	}
	
	public function category_find($id, $field='*') {
		return $this->field($field)->where(array('cat_id' => $id))->find();
	}
	
	public function category_count($where) {
		return $this->where($where)->count();
	}
	
	public function category_delete($id) {
		return $this->where(array('cat_id' => $id))->delete();
	}
	
	public function category_field($where, $field, $bool=false) {
		return $this->where($where)->get_field($field, $bool);
	}
}

// end