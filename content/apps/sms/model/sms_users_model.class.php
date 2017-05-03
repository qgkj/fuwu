<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class sms_users_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'users';
		parent::__construct();
	}
	
	public function user_select($where, $field, $in=false) {
	    if ($in) {
	        return $this->field($field)->in($where)->select();
	    }
	    return $this->field($field)->where($where)->select();
	}
}

// end