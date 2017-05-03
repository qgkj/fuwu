<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class virtual_card_model extends Component_Model_View {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'virtual_card';
		parent::__construct();
	}
	
	public function virtual_card_count($where) {
		return $this->where($where)->count();
	}
	
	public function virtual_card_manage($parameter) {
		if (!isset($parameter['card_id'])) {
			$id = $this->insert($parameter);
		} else {
			$where = array('card_id' => $parameter['card_id']);
	
			$this->where($where)->update($parameter);
			$id = $parameter['card_id'];
		}
		return $id;
	}
	
	/* 查询字段信息 */
	public function virtual_card_field($where, $field, $bool=false) {
		return $this->where($where)->get_field($field, $bool);
	}
	
	public function virtual_card_find($field = '*', $where) {
		return $this->field($field)->where($where)->find();
	}
	
	public function virtual_card_delete($where) {
		return $this->where($where)->delete();
	}
}

// end