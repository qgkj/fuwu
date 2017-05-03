<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class crons_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'crons';
		parent::__construct();
	}
	
	public function crons_select() {
		return $this->select();
	}
	
	public function crons_update($where, $data) {
		return $this->where($where)->update($data);
	}
	
	public function crons_field($where, $field) {
		return $this->where($where)->get_field($field);
	}
	
	public function crons_find($where) {
		return $this->find($where);
	}
}

// end