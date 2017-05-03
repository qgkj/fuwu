<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class email_list_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'email_list';
		parent::__construct();
	}
	
	public function email_list_select($stat, $field='*') {
		return RC_DB::table('email_list')
			->where('stat', $stat)
			->select($field)
			->get();
	}
	
	public function email_list_batch($ids, $type, $data=array()) {
		$db_email_list = RC_DB::table('email_list');
		if ($type == 'select') {
			return $db_email_list->whereIn('id', $ids)->get();
		} elseif ($type == 'delete') {
			return $db_email_list->whereIn('id', $ids)->delete();
		} elseif ($type == 'update') {
			return $db_email_list->whereIn('id', $ids)->update($data);
		}
	}
}

// end