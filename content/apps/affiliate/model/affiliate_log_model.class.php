<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class affiliate_log_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'affiliate_log';
		parent::__construct();
	}
	
	/*记录分成日志*/
	public function write_affiliate_log($oid, $uid, $username, $money, $point, $separate_by) {
	    $time = RC_Time::gmtime();
	    $data = array(
	        'order_id' 		=> $oid,
	        'user_id' 		=> $uid,
	        'user_name' 	=> $username,
	        'time' 			=> $time,
	        'money' 		=> $money,
	        'point' 		=> $point,
	        'separate_type' => $separate_by
	    );
	    if ($oid) {
	        $this->insert($data);
	    }
	}
	
	public function affiliate_log_find($where, $field='*') {
		return $this->where($where)->field($field)->find();
	}
	
	public function affiliate_log_update($where, $data) {
		return $this->where($where)->update($data);
	}
}

// end