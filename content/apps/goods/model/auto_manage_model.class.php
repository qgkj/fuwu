<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class auto_manage_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
// 		$this->db_config = RC_Config::load_config('database');
// 		$this->db_setting = 'default';
		$this->table_name = 'auto_manage';
		parent::__construct();
	}
	
	public function auto_manage($parameter, $where='') {
	    if (empty($where)) {
	        return $this->insert($parameter);
	    } else {
	        $this->where($where)->update($parameter);
	        return $parameter['item_id'];
	    }
	}
	
	public function auto_manage_delete($where) {
	    return $this->delete($where);
	}
	
	public function is_only($where) {
	    return $this->where($where)->count();
	}
	
	public function auto_manage_field($where, $field, $bool=false) {
		return $this->where($where)->get_field($field, $bool);
	}

}

// end