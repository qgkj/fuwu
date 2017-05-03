<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class email_sendlist_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'email_sendlist';
		parent::__construct();
	}
	
	public function email_sendlist_delete($id, $in=false) {
		if ($in) {
			return RC_DB::table('email_sendlist')->whereIn('id', $id)->delete();
		}
		return RC_DB::table('email_sendlist')->where('id', $id)->delete();
	}

	public function email_sendlist_find($id, $order=array()) {
		$db_email_sendlist = RC_DB::table('email_sendlist');
		if (!empty($order)) {
			foreach ($order as $key => $val) {
				$db_email_sendlist->orderBy($key, $val);
			}
		}
		return $db_email_sendlist->where('id', $id)->first();
	}
	
	public function email_sendlist_select($ids = array(), $order = array()) {
		$db_email_sendlist = RC_DB::table('email_sendlist');
		
		if (!empty($order)) {
			foreach ($order as $key => $val) {
				$db_email_sendlist->orderBy($key, $val);
			}
		}
		if (!empty($ids)) {
			$db_email_sendlist->whereIn('id', $ids);
		}
		return $db_email_sendlist->get();
	}
	
	public function email_sendlist_update($id, $data) {
		return RC_DB::table('email_sendlist')->where('id', $id)->update($data);
	}
}


// end